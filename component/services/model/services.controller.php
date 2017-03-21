<?php
/**
 * Created by PhpStorm.
 * User: marjani
 * Date: 2/27/2016
 * Time: 4:24 PM
 */

include_once(dirname(__FILE__)."/services.model.php");

/**
 * Class servicesController
 */
class servicesController
{

    /**
     * Contains file type
     * @var
     */
    public $exportType;

    /**
     * Contains file name
     * @var
     */
    public $fileName;

    /**
     * servicesController constructor.
     */
    public function __construct()
    {
        $this->exportType='html';

    }

    /**
     * call tempate
     *
     * @param string $list
     * @param $msg
     * @return string
     */
    function template($list=array(), $msg)
    {
        global $PARAM, $member_info;

        switch($this->exportType)
        {

            case 'html':

                include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/title.inc.php");

                include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/$this->fileName");

                include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/tail.inc.php");
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
     * @param $fields
     * @author marjani
     * @date 2/27/2015
     * @version 01.01.01
     */
    public function showALL($fields)
    {
        $services=new servicesModel;
        $result=$services->getServices($fields);

        if($result['result']!='1')
        {
            $this->fileName = "services.php";
            $this->template('',$result['msg']);
            die();
        }
        $export['list']=$services->list;
        $export['recordsCount']=$services->recordsCount;
        $export['pagination']=$services->pagination;

        // breadcrumb
        global $breadcrumb;
        $breadcrumb->reset();
        $breadcrumb->add('درباره ما');
        $export['breadcrumb'] = $breadcrumb->trail();

        $this->fileName = "services.php";


        $this->template($export);
        die();
    }

}
?>
