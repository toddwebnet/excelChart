<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * class to interpret excel file
 * PHPExcel dependancy is loaded
 * system
 */
require_once __DIR__ . "/../third_party/PHPExcel/Classes/PHPExcel/IOFactory.php";

class ToddExcelInterpreter
{
    public $errFlag = 0;
    public $error = "";
    public $collection;


    public function interpretExcel($inputFileName)
    {
        $inputFileType = 'Excel5';


        /**  Create a new Reader of the type defined in $inputFileType  **/
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        /**  Read the list of worksheet names and select the one that we want to load  **/
        $worksheetList = $objReader->listWorksheetNames($inputFileName);
        $objPHPExcel = $objReader->load($inputFileName);
        $product = array();

        //array_flip could work, but need to adjust the keys to be all lower case (and trimmed)
        $worksheets = array();
        foreach ($worksheetList as $key => $value)
        {
            $worksheets[trim(strtolower($value))] = $key;
        }

        if (!array_key_exists("data", $worksheets))
        {
            $this->errFlag = 1;
            $this->error = "Worksheet with Title &quot;Data&quot; not found.";
            return;
        }
        if (!array_key_exists("title", $worksheets))
        {
            $this->errFlag = 1;
            $this->error = "Worksheet with Title &quot;Title&quot; not found.";
            return;
        }
        $objWorksheet = $objPHPExcel->setActiveSheetIndex($worksheets["title"]);
        $titleObj = $objWorksheet->toArray(null, true, true, true);
        $title = $titleObj[1]["A"];
        if(strlen(trim($title))==0)
        {
            $this->errFlag = 1;
            $this->error = "Invalid value for title in worksheet[Title]";
            return;
        }



        $objWorksheet = $objPHPExcel->setActiveSheetIndex($worksheets["data"]);
        $data = $objWorksheet->toArray(null, true, true, true);
        $headerNumber = $data[1]["A"];
        $headerLabel = $data[1]["B"];
        $total = 0;
        if (strlen(trim($headerNumber)) == 0 || strlen(trim($headerLabel)) == 0)
        {
            $this->errFlag = 1;
            $this->error = "Worksheet Headings incompatible (empty) in worksheet[Data]";
            return;
        }
        $operantData = array();
        for ($x = 2; $x <= count($data); $x++)
        {
            if (strlen(trim($data[$x]["A"])) == 0)
            {
                break;
            }
            if (is_numeric($data[$x]["A"]) && strlen(trim($data[$x]["B"])) > 0)
            {
                $total += $data[$x]["A"];
                $operantData[] = array(
                    "value" => $data[$x]["A"],
                    "label" => $data[$x]["B"],
                );
            }
        }
        if (count($operantData) == 0)
        {
            $this->errFlag = 1;
            $this->error = "No data to work with.";
            return;
        }
        $this->collection = array(
            "operantData" => $operantData,
            "total" => $total,
            "headerNumber" => $headerNumber,
            "headerLabel" => $headerLabel,
            "title" => $title
        );

    }


}