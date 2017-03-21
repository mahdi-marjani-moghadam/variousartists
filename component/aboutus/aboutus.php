<?php
/**
 * Created by PhpStorm.
 * User: marjani
 * Date: 2/27/2016
 * Time: 4:21 PM
 */
include_once(dirname(__FILE__). "/model/aboutus.controller.php");

global $admin_info,$PARAM;

$aboutusController = new aboutusController();
if(isset($exportType))
{
    $aboutusController->exportType=$exportType;
}

$field['filter']['lang'] = $lang;
$aboutusController->showALL($field);
die();


?>