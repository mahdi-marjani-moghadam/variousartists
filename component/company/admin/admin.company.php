<?php

/**
 * Created by PhpStorm.
 * User: malekloo
 * Date: 2/27/2016
 * Time: 9:21 AM.
 */
include_once dirname(__FILE__).'/model/admin.company.controller.php';

global $admin_info,$PARAM;
$companyController = new adminCompanyController();
if (isset($exportType)) {
    $companyController->exportType = $exportType;
}

switch ($_GET['action']) {
    case 'expired':
        $companyController->showExpiredList();
        break;
    case 'unverified':
        $companyController->showUnverifiedList();
        break;
    case 'add':
        if (isset($_POST['action']) & $_POST['action'] == 'add') {
            $companyController->addCompany($_POST);
        } else {
            $companyController->showCompanyAddForm('', '');
        }
        break;
    case 'edit':
        if (isset($_POST['action']) & $_POST['action'] == 'edit') {
            $companyController->editCompany($_POST);
        } else {
            $input['Company_id'] = $_GET['id'];
            $input['showStatus'] = $_GET['showStatus'];
            $companyController->showCompanyEditForm($input, '');
        }
        break;
    case 'delete':
        $companyController->deleteCompany($_GET['id']);
        break;
    case 'call':
        $companyController->call($_POST);
        break;
    case 'importCompanies':
        $companyController->importCompanies();
        break;
    case 'updateCity':
        $companyController->updateCity();
        break;    
    case 'importCompanyPhones':
        $companyController->importCompanyPhones();
        break;
    case 'importCompanyEmails':
        $companyController->importCompanyEmails();
        break;
    case 'importCompanyAddresses':
        $companyController->importCompanyAddresses();
        break;
    case 'importCompanyWebsites':
        $companyController->importCompanyWebsites();
        break;
    case 'search':
        $companyController->search($_GET);
        break;
    case 'searchExpire':
        $companyController->searchExpire($_GET);
        break;
    case 'getCompanyPhone':

        $companyController->getCompanyphone($_POST);
        break;
    case 'searchUnverified':
        $companyController->searchUnverified($_GET);
        break;
    case 'getCityAjax':
        $companyController->getCityAjax($_POST);
        break;
    default:
        $companyController->showList($msg);
        break;
}
