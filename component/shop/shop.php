<?php
/**
 * Created by PhpStorm.
 * User: marjani
 * Date: 2/27/2016
 * Time: 4:21 PM
 */
include_once(dirname(__FILE__). "/model/shop.controller.php");

global $admin_info,$PARAM;

$shopController = new shopController();
if(isset($exportType))
{
    $shopController->exportType=$exportType;
}


$shopController->showALL('');
die();


?>