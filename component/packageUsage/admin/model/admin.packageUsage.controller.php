<?php
/**
 * Created by PhpStorm.
 * User: daba
 * Date: 08-Sep-16
 * Time: 9:23 AM
 */

include_once dirname(__FILE__).'/admin.packageUsage.model.php';

/**
 * Class packageUsageController.
 */
class adminPackageUsageController
{

    public $exportType;

    public $fileName;

    public function __construct()
    {
        $this->exportType = 'html';
    }

    public function template($list = array(), $msg='')
    {
        switch ($this->exportType) {
            case 'html':
                include ROOT_DIR . 'templates/' . CURRENT_SKIN . '/template_start.php';
                include ROOT_DIR . 'templates/' . CURRENT_SKIN . '/template_header.php';
                include ROOT_DIR . 'templates/' . CURRENT_SKIN . '/template_rightMenu_admin.php';
                include ROOT_DIR . 'templates/' . CURRENT_SKIN . "/$this->fileName";
                include ROOT_DIR . 'templates/' . CURRENT_SKIN . '/template_footer.php';
                include ROOT_DIR . 'templates/' . CURRENT_SKIN . '/template_end.php';
                break;

            case 'json':
                echo json_encode($list);
                break;
            case 'array':
                return $list;
                break;

            case 'serialize':
                echo serialize($list);
                break;
            default:
                break;
        }
    }

    public function showList()
    {
        $packageUsage = new adminPackageUsageModel();
        $result =$packageUsage->getByFilter();
        if ($result['result'] != '1') {
            $this->fileName = 'admin.packageUsage.showList.php';
            $this->template('', $result['msg']);
            die();
        }
        $export['list'] = $result['export']['list'];
        $export['recordsCount'] =  $result['export']['recordsCount'];
        $this->fileName = 'admin.packageUsage.showList.php';
        $this->template($export);
        die();
    }

    public function showPackageUsageEditForm($fields, $msg)
    {
        $packageUsage=adminPackageUsageModel::find($fields['PackageUsage_id']);
        if(!is_object($packageUsage))
        {
            $msg = 'صفحه مورد نظر یافت نشد';
            redirectPage(RELA_DIR.'zamin/index.php?component=packageUsage', $msg);
        }
        $export = $packageUsage->fields;
        $this->fileName = 'admin.packageUsage.editForm.php';
        $this->template($export, $msg);
        die();
    }

    public function editPackageUsage($fields)
    {
        $PackageUsage=adminPackageUsageModel::find($fields['PackageUsage_id']);
        $PackageUsage->setFields($fields);
        $PackageUsage->save();
        $msg = 'عملیات با موفقیت انجام شد';
        redirectPage(RELA_DIR.'zamin/index.php?component=packageUsage', $msg);
        die();
    }

    public function deletePackageUsage($fields)
    {
        $PackageUsage=adminPackageUsageModel::find($fields['PackageUsage_id']);
        $result=$PackageUsage->delete();
        if ($result['result'] != '1') {
            $this->showPackageUsageEditForm($fields, $result['msg']);
        }
        $msg = 'عملیات با موفقیت انجام شد';
        redirectPage(RELA_DIR.'zamin/index.php?component=packageUsage', $msg);
        die();
    }
    
}
