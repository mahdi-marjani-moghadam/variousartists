<?php
use Component\contactus\model\contactusController;


global $admin_info,$PARAM;

$contactusController = new contactusController();
if(isset($exportType))
{
    $contactusController->exportType=$exportType;
}


if(isset($_POST['action']) & $_POST['action']=='send')
{
    $contactusController->addContactus($_POST);
}
else
{
    $contactusController->showContactusForm();
}
die();



?>