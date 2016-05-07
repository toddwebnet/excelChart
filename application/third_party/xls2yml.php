<?php
$fileName = $argv[1];
require_once dirname(__FILE__) . '/PHPExcel/Classes/PHPExcel/IOFactory.php';

$tables = ExcelProductArray($fileName);
$op = "";
foreach($tables as $tableName=>$data)
{
    $op .= $tableName . ":\n";
    foreach($data as $element)
    {
        $op .= "  -\n";
        $op .= "    values:\n";
        foreach($element as $key=>$value)
        {
            if(strlen(trim($value))>0)
            {
            $op .="      " . $key . ": " . $value . "\n";
            }
        }        
    }
    $op .= "\n";
}
print $op;


function ExcelProductArray($inputFileName)
{
    $inputFileType = 'Excel5'; 


    /**  Create a new Reader of the type defined in $inputFileType  **/ 
    $objReader = PHPExcel_IOFactory::createReader($inputFileType); 
    /**  Read the list of worksheet names and select the one that we want to load  **/
    $worksheetList = $objReader->listWorksheetNames($inputFileName);
    $objPHPExcel = $objReader->load($inputFileName); 
    $product = array();
    
    foreach($worksheetList as $index=>$table)
    {
        $table = strtoupper($table);
        $data = GetSheetArray($objPHPExcel, $index);
        if(strlen(trim($data[1]["A"]))>0)
        {
            $h = getHeaders($data[1]);
            $headers = $h["headers"];
            $items = array();
            foreach($data as $index=>$row)
            {    
                if($index > 1)
                {
                   $obj = array();
                   foreach($headers as $key=>$value)
                   {
                    $obj[$value] = $row[$key];
                   }
                   $items[] = $obj;
                }
                
            }
            $product[$table] = $items;
        }
    }    
    return $product;
}


function GetSheetArray($objPHPExcel, $index)
{
    $objWorksheet = $objPHPExcel->setActiveSheetIndex($index);
    return $objWorksheet->toArray(null,true,true,true);
}


function getNameFromNumber($num) {
    $numeric = ($num - 1) % 26;
    $letter = chr(65 + $numeric);
    $num2 = intval(($num - 1) / 26);
    if ($num2 > 0) {
        return getNameFromNumber($num2) . $letter;
    } else {
        return $letter;
    }
}

function getHeaders($array)
{
    $headers = array();
    for($x=1;$x<1000;$x++)
    {
        $a = getNameFromNumber($x);
        if(isset($array[$a]))
        {$headers[$a] = $array[$a];}
        else 
        {break;}
    }
    return array(
        "headers"=>$headers,
        "numCols"=> $x-1
        );
}