<?php
namespace Component\contactus\model;
use Component\contactus\model\contactusModel;
use Component\vontactus\admin\model\adminContactusModel;

class contactusController
{
    
    public $exportType;

    public $fileName;

    public function __construct()
    {
        $this->exportType = 'html';
    }


    public function template($list = array(), $msg = ''): void
    {
        global $messageStack, $member_info;

        switch ($this->exportType) {
            case 'html':
                include ROOT_DIR . 'templates/' . CURRENT_SKIN . '/title.inc.php';
                include ROOT_DIR . 'templates/' . CURRENT_SKIN . "/$this->fileName";
                include ROOT_DIR . 'templates/' . CURRENT_SKIN . '/tail.inc.php';
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

    /**
     * add contactus.
     *
     * @param $_input
     *
     * @return int|mixed
     *
     * @author marjani
     * @date 2/27/2015
     *
     * @version 01.01.01
     */
    public function addContactus($_input)
    {
        global $messageStack;

        $contactus = new contactusModel();
        $result = $contactus->setFields($_input);
        if ($result['result'] == -1) {
            //$messageStack->add_session('contactus',$result['msg'] , 'error');
            $this->showContactusForm($_input, $result['msg']);
        }

        $result = $contactus->addContactus();

        if ($result['result'] != '1') {
            $this->showContactusForm($_input, $result['msg']);
        }
        $msg = 'عملیات با موفقیت انجام شد';
        $messageStack->add_session('contactus', $msg, 'success');
        redirectPage(RELA_DIR . 'contactus', $msg);
        die();
    }

    /**
     * call contact us form.
     *
     * @author marjani
     * @date 2/27/2015
     *
     * @version 01.01.01
     */
    public function showContactusForm($_input = array(), $msg = '')
    {
        // breadcrumb
        global $breadcrumb, $lang;

        // include_once ROOT_DIR.'component/contactus/admin/model/admin.contactus_content.model.php';
        $obj = adminContactusModel::getAll()->where('lang', '=', $lang)->getList()['export']['list'][0];

        $breadcrumb->reset();
        $breadcrumb->add('تماس با ما');
        $export['list'] = $_input;
        $export['breadcrumb'] = $breadcrumb->trail();

        $this->fileName = 'contactus.form.php';
        $this->template($obj, $msg);
        die();
    }
}
