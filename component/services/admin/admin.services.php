<?php
/**
 * Created by PhpStorm.
 * User: marjani
 * Date: 2/28/2016
 * Time: 4:21 AM
 */
include_once(dirname(__FILE__). "/model/admin.services.controller.php");

global $admin_info,$PARAM;


$servicesController = new adminServicesController();
if(isset($exportType))
{
    $servicesController->exportType=$exportType;
}

if(isset($_POST['action']) & $_POST['action']=='edit')
{

    $servicesController->editServices($_POST);
}
else
{

    $servicesController->showServicesEditForm('');
}



?>