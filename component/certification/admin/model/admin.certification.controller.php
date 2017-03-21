<?php
/**
 * Created by PhpStorm.
 * User: malekloo
 * Date: 3/6/2016
 * Time: 11:21 AM.
 */
include_once dirname(__FILE__).'/admin.certification.model.php';

/**
 * Class registerController.
 */
class adminCertificationController
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
    public function template($list = array(), $msg)
    {
        global $messageStack;

        switch ($this->exportType) {
            case 'html':
                include ROOT_DIR.'templates/'.CURRENT_SKIN.'/template_start.php';
                include ROOT_DIR.'templates/'.CURRENT_SKIN.'/template_header.php';
                include ROOT_DIR.'templates/'.CURRENT_SKIN.'/template_rightMenu_admin.php';
                include ROOT_DIR.'templates/'.CURRENT_SKIN."/$this->fileName";
                include ROOT_DIR.'templates/'.CURRENT_SKIN.'/template_footer.php';
                include ROOT_DIR.'templates/'.CURRENT_SKIN.'/template_end.php';
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

    /**
     * add Certification.
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
    public function addCertification($_input)
    {
        global $messageStack;

        $certification = new adminCertificationModel();

        $result = $certification->setFields($_input);
        if ($result['result'] == -1) {
            $this->showCertificationAddForm($_input, $result['msg']);
        }

        $result = $certification->addCertification();

        if ($result['result'] != '1') {
            $messageStack->add_session('register', $result['msg']);
            $this->showCertificationAddForm($_input, $result['msg']);
        }
        $msg = 'ثبت نام با موفقیت انجام شد.';
        $messageStack->add_session('register', $msg);

        redirectPage(RELA_DIR.'admin/?component=certification', $msg);
        die();
    }

    /**
     * call register form.
     *
     * @param $fields
     * @param $msg
     *
     * @return mixed
     *
     * @author malekloo
     * @date 14/03/2016
     *
     * @version 01.01.01
     */
    public function showCertificationAddForm($fields, $msg)
    {
        $this->fileName = 'admin.certification.addForm.php';
        $this->template($fields, $msg);
        die();
    }

    /**
     * @param $fields
     *
     * @return mixed
     *
     * @author malekloo
     * @date 3/16/2015
     *
     * @version 01.01.01
     */
    public function editCertification($fields)
    {
        $certification = new adminCertificationModel();

        $result = $certification->getCertificationById($fields['Certification_id']);

        $result = $certification->setFields($fields);

        if ($result['result'] != 1) {
            $this->showCertificationEditForm($fields, $result['msg']);
        }

        $result = $certification->edit();

        if ($result['result'] != '1') {
            $this->showCertificationEditForm($fields, $result['msg']);
        }
        $msg = 'عملیات با موفقیت انجام شد';
        redirectPage(RELA_DIR.'admin/index.php?component=certification', $msg);
        die();
    }

    /**
     * @param $fields
     *
     * @return mixed
     *
     * @author malekloo
     * @date 3/6/2015
     *
     * @version 01.01.01
     */
    public function showCertificationEditForm($fields, $msg)
    {
        if (strtoupper($_SERVER['REQUEST_METHOD']) != 'POST') {
            $certification = new adminCertificationModel();
            $result = $certification->getCertificationById($fields['Certification_id']);
            if ($result['result'] != '1') {
                $msg = $result['msg'];
                redirectPage(RELA_DIR.'admin/index.php?component=certification', $msg);
            }
            $export = $certification->fields;
        } else {
            $export = $fields;
        }

        $this->fileName = 'admin.certification.editForm.php';
        $this->template($export, $msg);
        die();
    }

    /**
     * @param $fields
     *
     * @return mixed
     *
     * @author malekloo
     * @date 3/6/2015
     *
     * @version 01.01.01
     */
    public function showList($fields)
    {
        $certification = new adminCertificationModel();
        $result = $certification->getCertification($fields);
        if ($result['result'] != '1') {
            $this->fileName = 'admin.certification.showList.php';
            $this->template('', $result['msg']);
            die();
        }

        $export['list'] = $certification->list;
        $export['recordsCount'] = $certification->recordsCount;
        $this->fileName = 'admin.certification.showList.php';
        $this->template($export);
        die();
    }

    /**
     * delete deleteCertification by certification_id.
     *
     * @param $id
     *
     * @author malekloo
     * @date 2/24/2015
     *
     * @version 01.01.01
     */
    public function deleteCertification($id)
    {
        $certification = new adminCertificationModel();

        if (!validator::required($id) and !validator::Numeric($id)) {
            $msg = 'یافت نشد';
            redirectPage(RELA_DIR.'admin/index.php?component=certification', $msg);
        }
        $result = $certification->getCertificationById($id);
        if ($result['result'] != '1') {
            $msg = $result['msg'];
            redirectPage(RELA_DIR.'admin/index.php?component=certification', $msg);
        }

        $result = $certification->delete();

        if ($result['result'] != '1') {
            redirectPage(RELA_DIR.'admin/index.php?component=certification', $msg);
        }

        $msg = 'عملیات با موفقیت انجام شد';
        redirectPage(RELA_DIR.'admin/index.php?component=certification', $msg);
        die();
    }
}
