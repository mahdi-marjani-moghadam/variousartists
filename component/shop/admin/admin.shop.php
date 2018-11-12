<?php
/**
 * Created by PhpStorm.
 * User: marjani
 * Date: 2/27/2016
 * Time: 4:21 PM
 */
include_once(ROOT_DIR. "component/shop/admin/model/admin.shop.controller.php");

global $admin_info,$PARAM;

$shopController = new shopController();
if(isset($exportType))
{
    $shopController->exportType=$exportType;
}

if($_REQUEST['action'] == 'shopListAjax'){
    $shopController->shopListAjax($_GET);
}

$shopController->showALL('');
die();


?>