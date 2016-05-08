<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App extends CI_Controller
{

    /*
     * Main page
     * if not logged in, go to login page
     * if logged in, go to form
     */
    public function index()
    {
        $userID = GetSessionVariable("UserID");
        if ((!is_numeric($userID)) || $userID == 0)
        {
            $this->login();
        }
        else
        {
            $this->form();
        }

    }

    /*
     * login form shows message (usually invalid credentials)
     */
    public function login($message = "")
    {

        $this->load->view("login", array("message" => $message));
    }

    /*
     * post process for login
     */
    public function loginProc()
    {
        $this->load->model("LoginModel");
        $username = $this->input->post("username");
        $password = $this->input->post("password");
        $userObj = $this->LoginModel->getLoginWithCredentials($username, $password);
        if ($userObj->UserID == 0)
        {
            //redraw login page with error message
            $this->login("Invalid Login");
            return;
        }
        else
        {
            //stores session variables
            SetSessionVarriableArray((array)$userObj);
            //redirect to reinterpret index page
            redirect("app");
            return;
        }
    }

    /*
     * main form
     * form consists of outside container with file submission inside a frame to allow for ajax-style loding bar
     * (smoke and mirrors)
     */
    public function form()
    {
        $this->load->view("form");
    }

    /*
     * simple upload form housed inside an iframe
     */
    public function uploadForm()
    {
        $data = array("output" => "");
        $this->load->view("uploadForm", $data);
    }

    /*
     * upload the file
     */
    public function uploadProc()
    {
        $config = array(
            'upload_path' => './uploads/',
            'allowed_types' => 'xls',
            'max_size' => 100000
        );
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('fileUpload'))
        {
            $error = array('error' => $this->upload->display_errors());
            $output = array(
                "error" => "An error occurred saving the file."
            );
        }
        else
        {
            $data = array('upload_data' => $this->upload->data());
            $output = array(
                "filename" => $data["upload_data"]["file_name"]
            );

        }
        //system renders output as json which is then
        //interpreted by parent javascript as to how to handle
        //the rendering post back of the chart drawing
        $data = array("output" => $output);
        $this->load->view("uploadForm", $data);


    }

    public function processNewFile()
    {
        //loads custom library to interpret excel
        $this->load->library("ToddExcelInterpreter");
        $filename = $this->input->post("filename");

        $filePath = __DIR__ . "/../../uploads/" . $filename;
        //can't do anything if the file doesn't exist - under most circumstances, this should never be the case
        if (!file_exists($filePath))
        {
            $this->showErrorFeedback("Could not locate file (internal error)");
        }
        else
        {
            //interpret the file
            $toddExcel = new ToddExcelInterpreter();
            $toddExcel->interpretExcel($filePath);

            //interpreter process if errors
            //if no errors then we should have a valid collection of data
            //consisting of, title, headers, and data
            if ($toddExcel->errFlag)
            {
                $this->showErrorFeedback($toddExcel->error);
            }
            else
            {
                //present the view
                $data = array(
                    "collection" => $toddExcel->collection
                );
                $this->load->view("data_results", $data);
            }
            //delete the file, we don't need it anymore
            unlink($filePath);
        }

    }

    /*
     * common error formatting.
     */
    private function showErrorFeedback($error)
    {
        print "<div class=\"col-md-12 formErr\">" . $error . "</div>";
    }
}
