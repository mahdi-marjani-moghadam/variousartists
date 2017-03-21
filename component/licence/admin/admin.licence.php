<?php

/**
 * Created by PhpStorm.
 * User: malekloo
 * Date: 3/28/2016
 * Time: 9:21 AM.
 */
include_once dirname(__FILE__).'/model/admin.licence.controller.php';

global $admin_info,$PARAM;

$licenceController = new adminLicenceController();
if (isset($exportType)) {
    $licenceController->exportType = $exportType;
}

switch ($_GET['action']) {
    case 'showMore':
        $licenceController->showMore($_GET['id']);
        break;
    case 'add':
        if (isset($_POST['action']) & $_POST['action'] == 'add') {
            $licenceController->addLicence($_POST);
        } else {
            $fields['company_id'] = $_GET['company_id'];
            $licenceController->showLicenceAddForm($fields, '');
        }
        break;
    case 'edit':
        if (isset($_POST['action']) & $_POST['action'] == 'edit') {
            $licenceController->editLicence($_POST);
        } else {
            $input['Company_licences_id'] = $_GET['id'];
            $licenceController->showLicenceEditForm($input, '');
        }
        break;
    case 'deleteLicence':
        $licenceController->deleteLicence($_GET['id']);
        break;
    default:
        $fields['choose']['company_id'] = $_GET['id'];
        $licenceController->showList($fields);
        break;
}
