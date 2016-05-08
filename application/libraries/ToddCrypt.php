<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * simple encryption class
 * gets key from /application/config.php
 */
class ToddCrypt
{
    var $key;

    public function __construct()
    {
        $ci = &get_instance();
        $this->key = str_replace(" ", "", $ci->config->item("encryption_key"));
    }

    public function cryptOneWay($toCrypt)
    {
        //usage of Blowfish as found on:
        //http://php.net/manual/en/function.crypt.php
        return crypt($toCrypt, '$2a$07$' . $this->key . '$');
    }
} // end of class