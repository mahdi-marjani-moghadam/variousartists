<?php
/**
 * Created by PhpStorm.
 * User: marjani
 * Date: 3/10/2016
 * Time: 10:21 AM.
 */
include_once dirname(__FILE__).'/advertise.model.php';

/**
 * Class advertiseController.
 */
class advertiseController
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
     * advertiseController constructor.
     */
    public function __construct()
    {
        $this->exportType = 'html';
    }

    /**
     * call tempate.
     *
     * @param string $list
     * @param $msg
     *
     * @return string
     */
    public function template($list = array(), $msg='')
    {
        // global $conn, $lang;

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

    /**
     * show all advertise.
     *
     * @param $_input
     *
     * @author marjani
     * @date 3/10/2015
     *
     * @version 01.01.01
     */
    public function showMore($_input)
    {
        if (!is_numeric($_input)) {
            $msg = 'یافت نشد';
            $this->fileName = 'advertise.showList.php';
            $this->template('', $msg);
            die();
        }
        $advertise = new advertiseModel();
        $result = $advertise->getAdvertiseById($_input);

        if ($result['result'] != 1) {
            $this->fileName = 'advertise.showList.php';
            $this->template('', $result['msg']);
            die();
        }

        // breadcrumb
        global $breadcrumb;
        $breadcrumb->reset();
        $breadcrumb->add('تبلیغات');
        $breadcrumb->add($advertise['list']['title']);
        $export['breadcrumb'] = $breadcrumb->trail();

        $this->fileName = 'advertise.showMore.php';
        $this->template($advertise->fields);
        die();
    }

    /**
     * @param $fields
     *
     * @author marjani
     * @date 3/10/2015
     *
     * @version 01.01.01
     */
    public function showALL($fields)
    {
        $advertise = new advertiseModel();
        $result = $advertise->getAdvertise($fields);
        if ($result['result'] != '1') {
            die();
        }
        $export['list'] = $advertise->list;
        $export['recordsCount'] = $advertise->recordsCount;
        $export['pagination'] = $advertise->pagination;

        // breadcrumb
        global $breadcrumb;
        $breadcrumb->reset();
        $breadcrumb->add('تبلیغات');
        $export['breadcrumb'] = $breadcrumb->trail();

        $this->fileName = 'advertise.showList.php';
        $this->template($export);
        die();
    }
}
