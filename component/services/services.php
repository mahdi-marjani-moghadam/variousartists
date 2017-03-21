<?php
/**
 * Created by PhpStorm.
 * User: marjani
 * Date: 2/27/2016
 * Time: 4:21 PM
 */
include_once(dirname(__FILE__). "/model/services.controller.php");

global $admin_info,$PARAM;

$servicesController = new servicesController();
if(isset($exportType))
{
    $servicesController->exportType=$exportType;
}


$servicesController->showALL('');
die();


?>