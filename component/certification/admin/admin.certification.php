<?php

/**
 * Created by PhpStorm.
 * User: malekloo
 * Date: 2/27/2016
 * Time: 9:21 AM.
 */
include_once dirname(__FILE__).'/model/admin.certification.controller.php';

global $admin_info,$PARAM;

$certificationController = new adminCertificationController();
if (isset($exportType)) {
    $certificationController->exportType = $exportType;
}

switch ($_GET['action']) {
    case 'showMore':
        $newsController->showMore($_GET['id']);
        break;
    case 'add':

        if (isset($_POST['action']) & $_POST['action'] == 'add') {
            $certificationController->addCertification($_POST);
        } else {
            $certificationController->showCertificationAddForm('', '');
        }
        break;
    case 'edit':
        if (isset($_POST['action']) & $_POST['action'] == 'edit') {
            $certificationController->editCertification($_POST);
        } else {
            $input['Certification_id'] = $_GET['id'];
            $certificationController->showCertificationEditForm($input, '');
        }
        break;
    case 'delete':
        $certificationController->deleteCertification($_GET['id']);
        break;
    default:
        $certificationController->showList();
        break;
}
