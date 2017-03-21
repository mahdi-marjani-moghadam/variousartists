<?php
/**
 * Created by PhpStorm.
 * User: daba
 * Date: 08-Sep-16
 * Time: 9:23 AM
 */

include_once dirname(__FILE__).'/model/admin.packageusage.controller.php';

global $admin_info,$PARAM;

$packageUsageController = new adminpackageUsageController();

if (isset($exportType))
{
    $packageUsageController->exportType = $exportType;
}

switch ($_GET['action'])
{

    case 'editPackageUsage':
        if (isset($_POST['action']) & $_POST['action'] == 'edit')
        {
            $packageUsageController->editPackageUsage($_POST);
        }
        else
        {
            $input['PackageUsage_id']=$_GET['id'];
            $packageUsageController->showPackageUsageEditForm($input, '');
        }
        break;

    default:
        $fields['order']['PackageUsage_id'] = 'DESC';
        $packageUsageController->showList();
        break;
}



