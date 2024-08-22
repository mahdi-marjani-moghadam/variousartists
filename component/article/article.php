<?php
/**
 * Created by PhpStorm.
 * User: marjani
 * Date: 2/28/2016
 * Time: 3:21 AM
 */
include_once(dirname(__FILE__). "/model/article.controller.php");

global $admin_info,$PARAM;

$articleController = new articleController();
if(isset($exportType))
{
    $articleController->exportType=$exportType;
}

if(isset($PARAM[1]))
{
    $articleController->showMore($PARAM[1]);
    die();
}else
{

    //$fields['filter']['title']='sdf';



    $fields['limit']['start']=(isset($page))?($page-1)*PAGE_SIZE:'0';
    $fields['limit']['length']=PAGE_SIZE;
    $fields['order']['Article_id']='DESC';
    $articleController->showALL($fields);
    die();
}


?>