<?php
/**
 * Created by PhpStorm.
 * User: marjani
 * Date: 3/10/2016
 * Time: 10:21 AM
 */

include_once(dirname(__FILE__). "/model/advertise.controller.php");

global $admin_info,$PARAM;

$advertiseController = new advertiseController();
if(isset($exportType))
{
    $advertiseController->exportType=$exportType;
}

if(isset($PARAM[1]))
{
    $advertiseController->showMore($PARAM[1]);
    die();
}else
{

    //$fields['filter']['title']='sdf';

    $fields['limit']['start']=(isset($page))?($page-1)*PAGE_SIZE:'0';
    $fields['limit']['length']=PAGE_SIZE;
    $fields['order']['Advertise_id']='DESC';
    $advertiseController->showALL($fields);
    die();
}


?>