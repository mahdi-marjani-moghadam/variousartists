<?php
/**
 * Created by PhpStorm.
 * User: marjani
 * Date: 3/10/2016
 * Time: 10:21 AM.
 */
include_once dirname(__FILE__).'/sales.model.php';

/**
 * Class salesController.
 */
class salesController
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
     * salesController constructor.
     */
    public function __construct()
    {
        $this->exportType = 'html';
    }

    /**
     * call tempate.
     *
     * @param array $list
     * @param $msg
     *
     * @return string
     */
    public function template($list = [], $msg)
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
     * show all sales.
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
            $this->fileName = 'sales.showList.php';
            $this->template('', $msg);
            die();
        }
        $sales = new salesModel();
        $result = $sales->getSalesById($_input);

        if ($result['result'] != 1) {
            $this->fileName = 'sales.showList.php';
            $this->template('', $result['msg']);
            die();
        }

        // breadcrumb
        global $breadcrumb;
        $breadcrumb->reset();
        $breadcrumb->add('بنر');
        $breadcrumb->add($sales['list']['title']);
        $export['breadcrumb'] = $breadcrumb->trail();

        $this->fileName = 'sales.showMore.php';
        $this->template($sales->fields);
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
        //$sales = new salesModel();
        include_once ROOT_DIR.'component/salon/model/salon.model.php';
        $salon = new salonModel();
        $resultSalon = $salon->getSalonByparent($_POST['place']);
/*        print_r_debug($resultSalon);*/

        if ($resultSalon['result'] == 1) {
            $export['salon_list'] = $resultSalon['export']['list'];
        }
        $sales = salesModel::getAll()->getList();




        $export['list'] = $sales->list;
        $export['recordsCount'] = $sales->recordsCount;
        $export['pagination'] = $sales->pagination;
        $export['list']['event_name']=$_POST['event_name'];
        $export['list']['event_time']=$_POST['time'];
        $export['list']['event_place']=$_POST['place'];
        // breadcrumb
        global $breadcrumb;
        $breadcrumb->reset();
        $breadcrumb->add('بنر');
        $export['breadcrumb'] = $breadcrumb->trail();
/*print_r_debug($export);*/
        $this->fileName = 'sales.php';
        $this->template($export);
        die();
    }
}
