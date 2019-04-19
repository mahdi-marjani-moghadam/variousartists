<?php

include_once dirname(__FILE__).'/register.model.php';

/**
 * Class registerController.
 */
class registerController
{
    /**
     * Contains file type.
     *
     * @var
     */
    public $exportType;

    /**
     * Contains file name.
     *
     * @var
     */
    public $fileName;

    /**
     * registerController constructor.
     */
    public function __construct()
    {
        $this->exportType = 'html';
    }

    /**
     * call template.
     *
     * @param string $list
     * @param $msg
     *
     * @return string
     */
    public function template($list = array(), $msg='')
    {
        global $messageStack;

        switch ($this->exportType) {
            case 'html':
                include ROOT_DIR.'templates/'.CURRENT_SKIN.'/title.inc.php';
                include ROOT_DIR.'templates/'.CURRENT_SKIN."/$this->fileName";
                include ROOT_DIR.'templates/'.CURRENT_SKIN.'/tail.inc.php';
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


//    public function addregister222222($_input)
//    {
//        global $messageStack,$dataStack;
//
//
//        $register = new registerModel();
//        $result = $register->setFields($_input);
//
//
//        if ($result['result'] == -1) {
//            $messageStack->add_session('register', $result['msg']);
//
//            $dataStack->add_session('register', $_input);
//
//            redirectPage(RELA_DIR.'register', $result['msg']);
//        }
//
//        $result = $register->addRegister();
//
//        if ($result['result'] != '1') {
//            $messageStack->add_session('register', $result['msg']);
//
//            $dataStack->add_session('register', $_input);
//
//            redirectPage(RELA_DIR.'register', $result['msg']);
//        }
//
//        $msg = 'ثبت نام با موفقیت انجام شد.';
//        $messageStack->add_session('register', $msg, 'success');
//
//        redirectPage(RELA_DIR.'register', $msg);
//        die();
//    }


//    public function showRegisterForm222($_input, $msg)
//    {
//        global $dataStack;
//
//
//        $export['list'] = $dataStack->output('register');
//
//        // breadcrumb
//        global $breadcrumb;
//        $breadcrumb->reset();
//        $breadcrumb->add('درخواست ثبت تولیدی');
//        $export['breadcrumb'] = $breadcrumb->trail();
//
//        $this->fileName = 'register.form.php';
//        $this->template($export, $msg);
//        die();
//    }
}
