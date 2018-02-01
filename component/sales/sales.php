<?php
/**
 * Created by PhpStorm.
 * User: marjani
 * Date: 3/10/2016
 * Time: 10:21 AM
 */

include_once(dirname(__FILE__). "/model/sales.controller.php");

global $admin_info,$PARAM;
//ana.ir/sales/2
$salesController = new salesController();
if(isset($exportType))
{
    $salesController->exportType=$exportType;
}

if(isset($PARAM[1]))
{
    $salesController->showMore($PARAM[1]);
    die();
}else
{

    //$fields['filter']['title']='sdf';

    $fields['limit']['start']=(isset($page))?($page-1)*PAGE_SIZE:'0';
    $fields['limit']['length']=PAGE_SIZE;
    $fields['order']['Sales_id']='DESC';
    $salesController->showALL($fields);
    die();
}


?>