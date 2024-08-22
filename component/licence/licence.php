<?php
/**
 * Created by PhpStorm.
 * User: malek
 * Date: 3/16/2016
 * Time: 3:21 AM
 */
include_once(dirname(__FILE__). "/model/licence.controller.php");

global $PARAM;

$licenceController = new licenceController();
if(isset($exportType))
{
    $licenceController->exportType=$exportType;
}

//print_r($PARAM);
//die();
$licenceController->showLicenceDetail($PARAM[2]);

?>
