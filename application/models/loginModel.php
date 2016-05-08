<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LoginModel extends CI_Model
{

    public function getLoginWithCredentials($username, $password)
    {
        $this->load->library("ToddCrypt");
        $toddCrypt = new ToddCrypt();
        $encryptedPassword = $toddCrypt->cryptOneWay($password);

        $deadReturn = (object)array(
            "UserID" => 0,
        );

        $sql = "SELECT u.UserID, u.UserName, u.Password
        FROM Users u
        WHERE u.ActiveInd = 1 AND lower(u.UserName) = ?";
        $params = array(strtolower($username));

        $ar = GetResultsFromQuery($sql, $params);
        if (count($ar) == 0)
        {
            return $deadReturn;
        }
        $user = $ar[0];

        if ($password == $user->Password)
        {
            unset ($user->Password);
            return $user;
        }
        elseif ($encryptedPassword == $user->Password)
        {
            unset ($user->Password);
            return $user;
        }
        else
        {
            return $deadReturn;
        }

    }
}