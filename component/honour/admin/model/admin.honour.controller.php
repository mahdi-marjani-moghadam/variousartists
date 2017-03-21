<?php
/**
 * Created by PhpStorm.
 * User: malekloo
 * Date: 3/6/2016
 * Time: 11:21 AM
 */

include_once(dirname(__FILE__)."/admin.honour.model.php");

/**
 * Class registerController
 */
class adminHonourController
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
     * registerController constructor.
     */
    public function __construct()
    {
        $this->exportType='html';

    }

    /**
     * call template
     *
     * @param string $list
     * @param $msg
     * @return string
     */
    function template($list=[], $msg)
    {
        global $messageStack;

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
     * add honour
     *
     * @param $_input
     * @return int|mixed
     * @author marjani
     * @date 2/27/2015
     * @version 01.01.01
     */
    public function addHonour($_input)
    {
        global $messageStack;


        $honour=new adminHonourModel;
        $result=$honour->setFields($_input);


        if($result['result']==-1)
        {
            $this->showHonourAddForm($_input,$result['msg']);
        }

        $result=$honour->addHonour();

        if($result['result']!='1')
        {
            $messageStack->add_session('register',$result['msg']);
            $this->showHonourAddForm($_input,$result['msg']);
        }
        $msg='عملیات با موفقیت انجام شد';
        $messageStack->add_session('register',$msg);

        redirectPage(RELA_DIR . "admin/?component=honour&id={$_input['company_id']}", $msg);
        die();


    }


    /**
     * call register form
     *
     * @param $fields
     * @param $msg
     * @return mixed
     * @author malekloo
     * @date 14/03/2016
     * @version 01.01.01
     */

    public function showHonourAddForm($fields,$msg)
    {

        include_once(ROOT_DIR."component/category/admin/model/admin.category.model.php");
        $category = new adminCategoryModel();

        $resultCategory = $category->getCategoryOption();

        if($resultCategory['result'] == 1)
        {
            $fields['category'] = $category->list;
        }


        $this->fileName='admin.honour.addForm.php';
        $this->template($fields,$msg);
        die();
    }


    /**
     * @param $fields
     * @return mixed
     * @author malekloo
     * @date 3/16/2015
     * @version 01.01.01
     */
    public function editHonour($fields)
    {
        $honour=new adminHonourModel();

        $result    = $honour->getHonourById($fields['Company_honours_id']);


        if($result['result']!=1)
        {
            redirectPage(RELA_DIR . "admin/index.php?component=honour", $result['msg']);
        }

        $result=$honour->setFields($fields);

        if($result['result']!=1)
        {
            $this->showHonourEditForm($fields,$result['msg']);
        }

        $result=$honour->edit();
        $fields=$honour->fields;
        if($result['result']!='1')
        {
            $this->showHonourEditForm($fields,$result['msg']);
        }

        $msg='عملیات با موفقیت انجام شد';
        redirectPage(RELA_DIR . "admin/index.php?component=honour&id={$fields['company_id']}", $msg);
        die();
    }


    /**
     * @param $fields
     * @return mixed
     * @author malekloo
     * @date 3/6/2015
     * @version 01.01.01
     */
    public function showHonourEditForm($fields,$msg)
    {

        $honour=new adminHonourModel();
        $result=$honour->getHonourById($fields['Company_honours_id']);

        if($result['result']!='1')
        {
            $msg=$result['msg'];
            redirectPage(RELA_DIR . "admin/index.php?component=honour", $msg);
        }

        $export=$honour->fields;

        include_once(ROOT_DIR."component/category/admin/model/admin.category.model.php");
        $category = new adminCategoryModel();

        $resultCategory = $category->getCategoryOption();

        if($resultCategory['result'] == 1)
        {
            $export['category'] = $category->list;
        }
        /*echo '<pre/>';
        print_r($export);
        die();*/

        $this->fileName='admin.honour.editForm.php';
        $this->template($export,$msg);
        die();
    }



    /**
     * @param $fields
     * @return mixed
     * @author malekloo
     * @date 3/6/2015
     * @version 01.01.01
     */
    public function showList($fields)
    {
        $honour=new adminHonourModel();
        $result=$honour->getHonour($fields);
        if($result['result']!='1')
        {
            $this->fileName='admin.honour.showList.php';
            $this->template('',$result['msg']);
            die();
        }
        $export['list']=$honour->list;
        $export['company_id']=$fields['choose']['company_id'];

        $export['recordsCount']=$honour->recordsCount;
        $this->fileName='admin.honour.showList.php';
        $this->template($export);
        die();
    }
    /**
     * delete deleteCompany by company_id
     *
     * @param $id
     * @author malekloo
     * @date 2/24/2015
     * @version 01.01.01
     */
    public function deleteHonour($id)
    {
        $honour = new adminHonourModel();

        if(!validator::required($id) and !validator::Numeric($id))
        {
            $msg= 'یافت نشد';
            redirectPage(RELA_DIR . "admin/index.php", $msg);
        }
        $resultGetHonour = $honour->getHonourById($id);

        if($resultGetHonour['result']!='1')
        {
            $msg=$resultGetHonour['msg'];
            redirectPage(RELA_DIR . "admin/index.php", $msg);
        }
        $company_id=$resultGetHonour['export']['list']['company_id'];


        $result=$honour->delete();

        if($result['result']!='1')
        {
            redirectPage(RELA_DIR . "admin/index.php?component=honour&id=$company_id", $msg);
        }

        $msg='عملیات با موفقیت انجام شد';
        redirectPage(RELA_DIR . "admin/index.php?component=honour&id=$company_id", $msg);
        die();
    }

}
?>
