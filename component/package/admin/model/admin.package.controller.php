<?php
/**
 * Created by PhpStorm.
 * User: daba
 * Date: 08-Sep-16
 * Time: 9:23 AM
 */

include_once dirname(__FILE__).'/admin.package.model.php';

class adminPackageController
{


    public $exportType;


    public $fileName;


    public function __construct()
    {
        $this->exportType = 'html';
    }

    public function template($list = array(), $msg)
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

        public function showList($fields)
    {
        $package = new adminpackageModel();
        $result =$package->getByFilter();
        if ($result['result'] != '1') {
            $this->fileName = 'admin.package.showList.php';
            $this->template('', $result['msg']);
            die();
        }
        $export['list'] = $result['export']['list'];
        $export['recordsCount'] =  $result['export']['recordsCount'];
        $this->fileName = 'admin.package.showList.php';
        $this->template($export);
        die();
    }

    public function showPackageAddForm($fields, $msg)
    {
        $this->fileName = 'admin.package.addForm.php';
        $this->template($fields, $msg);
        die();
    }

    public function addPackage($fields)
    {
        $package = new adminpackageModel();
        $result =$package->setFields($fields);
        $package->save();
        if ($result['result'] == -1) {
            return $result;
        }
        if ($result['result'] != '1') {
            $this->showPackageAddForm($fields, $result['msg']);
        }
        $msg = 'عملیات با موفقیت انجام شد';
        redirectPage(RELA_DIR . 'admin/index.php?component=package', $msg);
        die();
    }

    public function showPackageEditForm($fields, $msg)
    {
        $package=adminpackageModel::find($fields['Package_id']);
        if(!is_object($package))
        {
            $msg = 'صفحه مورد نظر یافت نشد';
            redirectPage(RELA_DIR.'admin/index.php?component=package', $msg);
        }
        $export = $package->fields;
        $this->fileName = 'admin.package.editForm.php';
        $this->template($export, $msg);
        die();
    }

    public function editPackage($fields)
    {
        $Package=adminpackageModel::find($fields['Package_id']);
        $Package->setFields($fields);
        $Package->save();
        $msg = 'عملیات با موفقیت انجام شد';
        redirectPage(RELA_DIR.'admin/index.php?component=package', $msg);
        die();
    }
    
    public function deletePackage($fields)
    {
        $Package=adminpackageModel::find($fields['Package_id']);
        $result=$Package->delete();
        if ($result['result'] != '1') {
            $this->showPackageEditForm($fields, $result['msg']);
        }
        $msg = 'عملیات با موفقیت انجام شد';
        redirectPage(RELA_DIR.'admin/index.php?component=package', $msg);
        die();
    }
}
