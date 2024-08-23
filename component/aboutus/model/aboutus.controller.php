<?php
/**
 * Created by PhpStorm.
 * User: marjani
 * Date: 2/27/2016
 * Time: 4:24 PM
 */

include_once(dirname(__FILE__)."/aboutus.model.php");

/**
 * Class aboutusController
 */
class aboutusController
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
     * aboutusController constructor.
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
    function template($list=array(), $msg='')
    {
         global $member_info, $lang;

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
        $aboutus=new aboutusModel;
        $result=$aboutus->getAboutus($fields);

        if($result['result']!='1')
        {
            $this->fileName = "aboutus.php";
            $this->template('',$result['msg']);
            die();
        }
        $export['list']=$aboutus->list;
        $export['recordsCount']=$aboutus->recordsCount;
        $export['pagination']=$aboutus->pagination;

        // breadcrumb
        global $breadcrumb;
        $breadcrumb->reset();
        $breadcrumb->add('درباره ما');
        $export['breadcrumb'] = $breadcrumb->trail();

        $this->fileName = "aboutus.php";

        $this->template($export);
        die();
    }

}
?>
