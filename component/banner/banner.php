<?php
/**
 * Created by PhpStorm.
 * User: marjani
 * Date: 3/10/2016
 * Time: 10:21 AM
 */

include_once(dirname(__FILE__). "/model/banner.controller.php");

global $admin_info,$PARAM;
//ana.ir/banner/2

$bannerController = new bannerController();
if(isset($exportType))
{
    $bannerController->exportType=$exportType;
}

if(isset($PARAM[1]))
{
    $bannerController->showMore($PARAM[1]);
    die();
}else
{

    //$fields['filter']['title']='sdf';

    $fields['limit']['start']=(isset($page))?($page-1)*PAGE_SIZE:'0';
    $fields['limit']['length']=PAGE_SIZE;
    $fields['order']['Banner_id']='DESC';
    $bannerController->showALL($fields);
    die();
}


?>