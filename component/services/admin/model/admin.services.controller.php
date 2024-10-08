<?php

use Component\services\admin\model\adminServicesModel;




/**
 * Class aboutusController
 */
class adminServicesController
{


    public $exportType;


    public $fileName;


    public function __construct()
    {
        $this->exportType = 'html';
    }

    function template($list = [], $msg = ''): void
    {

        switch ($this->exportType) {
            case 'html':

                include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_start.php");
                include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_header.php");
                include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_rightMenu_admin.php");
                include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/$this->fileName");
                include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_footer.php");
                include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_end.php");
                break;

            case 'json':
                echo json_encode($list);
                break;

            case 'serialize':
                echo serialize($list);
                break;
            default:
                break;
        }
    }



    public function showServicesEditForm($msg)
    {

        $obj = adminServicesModel::getAll()->getList();

        if ($obj['result'] != '1') {
            $msg = $obj['msg'];
            redirectPage(RELA_DIR . "zamin/index.php?component=aboutus", $msg);
        }

        foreach ($obj['export']['list'] as $k => $va) {
            $export[$va['lang']] = $va;
        }



        $this->fileName = 'admin.services.editForm.php';
        $this->template($export, $msg);
        die();
    }


    public function editServices($fields)
    {
        $obj = adminServicesModel::getBy_lang($fields['lang'])->get();

        if ($obj['result'] != '1') {
            $msg = $obj['msg'];
            redirectPage(RELA_DIR . "zamin/index.php?component=aboutus", $msg);
        }

        $services = $obj['export']['list'][0];
        $servicesR = $services->setFields($fields);
        if ($servicesR['result'] != 1) {
            $this->showServicesEditForm($servicesR['msg']);
        }

        $result = $services->save();

        if ($result['result'] != '1') {
            $this->showServicesEditForm($result['msg']);
        }
        $msg = 'عملیات با موفقیت انجام شد';
        redirectPage(RELA_DIR . "zamin/index.php?component=services", $msg);
        die();
    }
}
