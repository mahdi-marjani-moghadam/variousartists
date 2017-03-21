<?php

/**
 * Created by PhpStorm.
 * User: malekloo
 * Date: 3/28/2016
 * Time: 9:21 AM.
 */
include_once dirname(__FILE__).'/model/admin.honour.controller.php';

global $admin_info,$PARAM;

$honourController = new adminHonourController();
if (isset($exportType)) {
    $honourController->exportType = $exportType;
}

switch ($_GET['action']) {
    case 'showMore':
        $honourController->showMore($_GET['id']);
        break;
    case 'add':
        if (isset($_POST['action']) & $_POST['action'] == 'add') {
            $honourController->addHonour($_POST);
        } else {
            $fields['company_id'] = $_GET['company_id'];
            $honourController->showHonourAddForm($fields, '');
        }
        break;
    case 'edit':
        if (isset($_POST['action']) & $_POST['action'] == 'edit') {
            $honourController->editHonour($_POST);
        } else {
            $input['Company_honours_id'] = $_GET['id'];
            $honourController->showHonourEditForm($input, '');
        }
        break;
    case 'deleteHonour':
        $honourController->deleteHonour($_GET['id']);
        break;
    default:
        $fields['choose']['company_id'] = $_GET['id'];
        $honourController->showList($fields);
        break;
}
