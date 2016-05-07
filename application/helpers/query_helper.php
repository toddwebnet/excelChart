<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
// Query Helper should be only be used in Models with such syntax:
// class Examples_model extends CI_Model {
//     public function __construct() {
//         parent::__construct();
//         // Loading QueryHelper
//         get_instance()->load->helper('query');
//     }
// }
// This is a flag to prevent infinite loops of crashes.
$hasCrashed = false;
// Executes a query, checks if there's results and returns them or NULL
function getResultsFromQuery($sql, $params = array()) {
    $ci=& get_instance();
    $ci->load->database();
    $query = $ci->db->query($sql, $params);

    // if it's an object (SELECT)
    if (is_object($query)) {
        $results = $query->result();

        if (count($results) > 0) {
            return $results;
        } else {
            // if there's no result, return an empty array to prevent errors
            return array();
        }
        // if it's a bool (INSERT/UPDATE)
    } else if ($query) {
        return TRUE;
        // else it's a SQL error
    } else {
        // If the query is null, then there's something wrong with field names or something
        catchSqlError($ci, $sql);
        return FALSE;
    }
}

// Executes a query, checks if there's results and returns the one of them or NULL
function getFirstResultFromQuery($sql, $params = array()) {
    $results = getResultsFromQuery($sql, $params);
    if (count($results) > 0) {
        return $results[0];
    } else {
        return NULL;
    }
}

function getOneField($field, $table="", $where="", $value="") {
    $params = array();
    if ($value!="null")
    {
        $params[":value"] = $value;

    }
    if($table!="")
    {
        $sql = "SELECT " . $field . " Field FROM " . $table . " ";
        if ($where != '') {
            $sql .= " WHERE " . $where . " = :value";
        }
    }
    else
    {
        $sql = $field;
    }
    $return = getFirstResultFromQuery($sql);
    return (isset($return->Field) ? $return->Field : null);
}
function dbText($text, $length = null)
{
    return "'" . dbQuote($text, $length) . "'";
}
function dbQuote($text, $length = null)
{
    if($length != null)
    {
        if(strlen($text)> $length)
        {$text = substr($text, $length);}
    }
    return str_replace("'", "''", $text);
}