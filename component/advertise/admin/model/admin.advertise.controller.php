<?php
/**
 * Created by PhpStorm.
 * User: marjani
 * Date: 3/06/2016
 * Time: 12:08 AM
 */

include_once(dirname(__FILE__)."/admin.advertise.model.php");

/**
 * Class advertiseController
 */
class adminAdvertiseController
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
     *
     */
    public function __construct()
    {
        $this->exportType='html';

    }

    /**
     * @param array $list
     * @param $msg
     * @return string
     */
    function template($list=array(),$msg='')
    {
        // global $conn, $lang;


        switch($this->exportType)
        {
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
     *
     */
    public function showMore($_input)
    {
        if(!is_numeric($_input))
        {
            $msg= 'یافت نشد';
            $this->template($msg);
        }
        $advertise=new adminAdvertiseModel();
        $result=$advertise->getAdvertiseById($_input);

        if($result['result']!=1)
        {
            die();
        }

        $this->template($advertise->fields);
        die();
    }


    /**
     * @param $fields
     */
    public function showList($fields)
    {

        $advertise=new adminAdvertiseModel();
        $result=$advertise->getAdvertise($fields);
        if($result['result']!='1')
        {
            $this->fileName='admin.advertise.showList.php';
            $this->template('',$result['msg']);
            die();
        }

        $export['list']=$advertise->list;

        $export['recordsCount']=$advertise->recordsCount;
        $this->fileName='admin.advertise.showList.php';
        $this->template($export);
        die();
    }

    /**
     * @param $fields
     * @param $msg
     */
    public function showAdvertiseAddForm($fields,$msg)
    {
        /////// category
        include_once(ROOT_DIR."component/category/admin/model/admin.category.model.php");
        $category = new adminCategoryModel();

        $resultCategory = $category->getCategoryOption();
        if($resultCategory['result'] == 1)
        {
            $fields['category'] = $category->list;
        }
        //echo "<pre>";print_r($resultCategory);die();
        ///////

        $this->fileName='admin.advertise.addForm.php';
        $this->template($fields,$msg);
        die();
    }

    /**
     * @param $fields
     * @return mixed
     */
    public function addAdvertise($fields)
    {

        $advertise=new adminAdvertiseModel();

        $result=$advertise->setFields($fields);

        if($result['result']==-1)
        {
            $this->showAdvertiseAddForm($fields,$result['msg']);
            //return $result;
        }

        $result=$advertise->add();

        if($result['result']!='1')
        {
            $this->showAdvertiseAddForm($fields,$result['msg']);
        }
        $msg='عملیات با موفقیت انجام شد';
        redirectPage(RELA_DIR . "zamin/index.php?component=advertise", $msg);
        die();
    }

    /**
     * @param $fields
     * @param $msg
     */
    public function showAdvertiseEditForm($fields,$msg)
    {

        $advertise=new adminAdvertiseModel();


        if(!validator::required($fields['Advertise_id']) and !validator::Numeric($fields['Advertise_id']))
        {
            $msg= 'یافت نشد';
            redirectPage(RELA_DIR . "zamin/index.php?component=advertise", $msg);
        }
        $result    = $advertise->getAdvertiseById($fields['Advertise_id']);

        if($result['result']!='1')
        {
            $msg=$result['msg'];
            redirectPage(RELA_DIR . "zamin/index.php?component=advertise", $msg);
        }


        $export=$advertise->fields;
        $export['category_id'] = explode(',',substr($export['category_id'],1));
        unset($export['category_id'][count($export['category_id'])-1]);


        /////// category
        include_once(ROOT_DIR."component/category/admin/model/admin.category.model.php");
        $category = new adminCategoryModel();

        $resultCategory = $category->getCategoryOption();

        if($resultCategory['result'] == 1)
        {
            $export['category'] = $category->list;
        }
        //echo "<pre>";print_r($resultCategory);die();
        ///////

        //echo "<pre>"; print_r($export);die();

        $this->fileName='admin.advertise.editForm.php';
        $this->template($export,$msg);
        die();
    }

    /**
     * @param $fields
     */
    public function editAdvertise($fields)
    {
        $advertise=new adminAdvertiseModel();

        if(!validator::required($fields['Advertise_id']) and !validator::Numeric($fields['Advertise_id']))
        {
            $msg= 'یافت نشد';
            redirectPage(RELA_DIR . "zamin/index.php?component=advertise", $msg);
        }
        $result    = $advertise->getAdvertiseById($fields['Advertise_id']);
        if($result['result']!='1')
        {
            $msg=$result['msg'];
            redirectPage(RELA_DIR . "zamin/index.php?component=advertise", $msg);
        }


        $result=$advertise->setFields($fields);


        if($result['result']!=1)
        {
            $this->showAdvertiseEditForm($fields,$result['msg']);
        }



        $result=$advertise->edit();

        if($result['result']!='1')
        {
            $this->showAdvertiseEditForm($fields,$result['msg']);
        }
        $msg='عملیات با موفقیت انجام شد';
        redirectPage(RELA_DIR . "zamin/index.php?component=advertise", $msg);
        die();
    }

    /**
     * delete advertise by advertise_id
     *
     * @param $fields
     * @author marjani
     * @date 3/06/2015
     * @version 01.01.01
     */
    public function deleteAdvertise($fields)
    {
        $advertise=new adminAdvertiseModel();

        if(!validator::required($fields['Advertise_id']) and !validator::Numeric($fields['Advertise_id']))
        {
            $msg= 'یافت نشد';
            redirectPage(RELA_DIR . "zamin/index.php?component=advertise", $msg);
        }
        $result    = $advertise->getAdvertiseById($fields['Advertise_id']);
        if($result['result']!='1')
        {
            $msg=$result['msg'];
            redirectPage(RELA_DIR . "zamin/index.php?component=advertise", $msg);
        }
        $result=$advertise->setFields($fields);

        if($result['result']!=1)
        {
            $this->showAdvertiseEditForm($fields,$result['msg']);
        }
        $result=$advertise->delete();

        if($result['result']!='1')
        {
            $this->showAdvertiseEditForm($fields,$result['msg']);
        }
        $msg='عملیات با موفقیت انجام شد';
        redirectPage(RELA_DIR . "zamin/index.php?component=advertise", $msg);
        die();
    }
}
?>