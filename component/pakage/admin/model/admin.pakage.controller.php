<?php
/**
 * Created by PhpStorm.
 * User: daba
 * Date: 08-Sep-16
 * Time: 9:23 AM
 */

include_once dirname(__FILE__).'/admin.pakage.model.php';

/**
 * Class pakageController.
 */
class adminPakageController
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
     *
     */
    public function __construct()
    {
        $this->exportType = 'html';
    }

    /**
     * @param string $list
     * @param $msg
     *
     * @return string
     */
    public function template($list = [], $msg='')
    {
        // global $conn, $lang;

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

    /**
     * @param $_input
     */
    public function showMore($_input)
    {
        if (!is_numeric($_input)) {
            $msg = 'یافت نشد';
            $this->template($msg);
        }
        $pakage = new adminPakageModel();
        $result = $pakage->getPakageById($_input);

        if ($result['result'] != 1) {
            die();
        }

        $this->template($pakage->fields);
        die();
    }


    /**
     * @param $fields
     */

    public function showList($fields)
    {
        $pakage = new adminPakageModel();
        $result = $pakage->getPakage($fields);
        // print_r_debug($fields);
        if ($result['result'] != '1') {
            $this->fileName = 'admin.pakage.showList.php';
            $this->template('', $result['msg']);
            die();
        }
        $export['list'] = $pakage->list;
        $export['recordsCount'] = $pakage->recordsCount;
        $this->fileName = 'admin.pakage.showList.php';
        $this->template($export);
        die();
    }

    /**
     * @param $fields
     * @param $msg
     */
    public function showPakageAddForm($fields, $msg)
    {

        $this->fileName = 'admin.pakage.addForm.php';
        $this->template($fields, $msg);
        die();
    }

    /**
     * @param $fields
     *
     * @return mixed
     */

    public function addPakage($fields)
    {
        $pakage = new adminPakageModel();

        $result = $pakage->setFields($fields);

        if ($result['result'] == -1) {
            return $result;
        }
        $result = $pakage->add();

        if ($result['result'] != '1') {
            $this->showPakageAddForm($fields, $result['msg']);
        }

        $msg = 'عملیات با موفقیت انجام شد';
        redirectPage(RELA_DIR . 'zamin/index.php?component=pakage', $msg);
        die();
    }

    /**
     * @param $fields
     * @param $msg
     */
    public function showPakageEditForm($fields, $msg)
    {
        $pakage = new adminPakageModel();
        if (!validator::required($fields['Pakage_id']) and !validator::Numeric($fields['Pakage_id'])) {

            $msg = 'یافت نشد';
            redirectPage('');
            redirectPage(RELA_DIR . 'zamin/index.php?component=pakage', $msg);
        }
        $result = $pakage->getPakageById($fields['Pakage_id']);

        if ($result['result'] != '1') {
            $msg = $result['msg'];
            redirectPage(RELA_DIR . 'zamin/index.php?component=pakage', $msg);
        }

        $export = $pakage->fields;

        $this->fileName = 'admin.pakage.editForm.php';
        $this->template($export, $msg);
        die();
    }


    /**
     * @param $fields
     */
   
   public function editPakage($fields)
    {

        $pakage = new adminPakageModel();

        if (!validator::required($fields['Pakage_id']) and !validator::Numeric($fields['Pakage_id'])) {

            $msg = 'یافت نشد';
            redirectPage(RELA_DIR.'zamin/index.php?component=pakage', $msg);
        }

        $result = $pakage->getPakageById($fields['Pakage_id']);
        if ($result['result'] != '1') {
            $msg = $result['msg'];
            redirectPage(RELA_DIR.'zamin/index.php?component=pakage', $msg);
        }

        $result = $pakage->setFields($fields);

        if ($result['result'] != 1) {
            $this->showPakageEditForm($fields, $result['msg']);
        }

        $result = $pakage->edit();

        if ($result['result'] != '1') {
            $this->showPakageEditForm($fields, $result['msg']);
        }
        $msg = 'عملیات با موفقیت انجام شد';
        redirectPage(RELA_DIR.'zamin/index.php?component=pakage', $msg);
        die();
    }


    /**
     * delete pakage by pakage_id.
     *
     * @param $fields
     *
     * @author malekloo,marjani
     * @date 2/24/2015
     *
     * @version 01.01.01
     */
    
    public function deletePakage($fields)
    {
        $pakage = new adminPakageModel();

        if (!validator::required($fields['Pakage_id']) and !validator::Numeric($fields['Pakage_id'])) {
            $msg = 'یافت نشد';
            redirectPage(RELA_DIR.'zamin/index.php?component=pakage', $msg);
        }
        $result = $pakage->getPakageById($fields['Pakage_id']);
     //   print_r_debug($result);
        if ($result['result'] != '1') {
            $msg = $result['msg'];
            redirectPage(RELA_DIR.'zamin/index.php?component=pakage', $msg);
        }
        $result = $pakage->setFields($fields);
//print_r_debug($result);
        if ($result['result'] != 1) {
            $this->showPakageEditForm($fields, $result['msg']);
        }
        $result = $pakage->delete();

        if ($result['result'] != '1') {
            $this->showPakageEditForm($fields, $result['msg']);
        }
        $msg = 'عملیات با موفقیت انجام شد';
        redirectPage(RELA_DIR.'zamin/index.php?component=pakage', $msg);
        die();
    }
}
