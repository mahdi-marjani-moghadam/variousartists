<?php


include_once(dirname(__FILE__) . "/model/admin.aboutus.controller.php");

global $admin_info, $PARAM;

$aboutusController = new adminAboutusController();
if (isset($exportType)) {
    $aboutusController->exportType = $exportType;
}

if (isset($_POST['action']) & $_POST['action'] == 'edit') {

    $aboutusController->editAboutus($_POST);
} else {

    $aboutusController->showAboutusEditForm('');
}
