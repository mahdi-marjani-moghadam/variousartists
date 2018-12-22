<?php
/**
 * Created by PhpStorm.
 * User: malekloo
 * Date: 3/6/2016
 * Time: 11:21 AM
 */

include_once(dirname(__FILE__)."/admin.licence.model.php");

/**
 * Class registerController
 */
class adminLicenceController
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
    function template($list=array(), $msg='')
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
     * add Licence
     *
     * @param $_input
     * @return int|mixed
     * @author marjani
     * @date 2/27/2015
     * @version 01.01.01
     */
    public function addLicence($_input)
    {
        global $messageStack;


        $licence=new adminLicenceModel;
        $result=$licence->setFields($_input);


        if($result['result']==-1)
        {
            $this->showLicenceAddForm($_input,$result['msg']);
        }

        $result=$licence->addLicence();

        if($result['result']!='1')
        {
            $messageStack->add_session('register',$result['msg']);
            $this->showLicenceAddForm($_input,$result['msg']);
        }
        $msg='عملیات با موفقیت انجام شد';
        $messageStack->add_session('register',$msg);

        redirectPage(RELA_DIR . "zamin/?component=licence&id={$_input['company_id']}", $msg);
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

    public function showLicenceAddForm($fields,$msg)
    {

        include_once(ROOT_DIR."component/category/admin/model/admin.category.model.php");
        $category = new adminCategoryModel();

        $resultCategory = $category->getCategoryOption();

        if($resultCategory['result'] == 1)
        {
            $fields['category'] = $category->list;
        }


        $this->fileName='admin.licence.addForm.php';
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
    public function editLicence($fields)
    {
        $licence=new adminLicenceModel();

        $result    = $licence->getLicenceById($fields['Company_licences_id']);


        if($result['result']!=1)
        {
            redirectPage(RELA_DIR . "zamin/index.php?component=licence", $result['msg']);
        }

        $result=$licence->setFields($fields);

        if($result['result']!=1)
        {
            $this->showLicenceEditForm($fields,$result['msg']);
        }

        $result=$licence->edit();
        $fields=$licence->fields;
        if($result['result']!='1')
        {
            $this->showLicenceEditForm($fields,$result['msg']);
        }

        $msg='عملیات با موفقیت انجام شد';
        redirectPage(RELA_DIR . "zamin/index.php?component=licence&id={$fields['company_id']}", $msg);
        die();
    }


    /**
     * @param $fields
     * @return mixed
     * @author malekloo
     * @date 3/6/2015
     * @version 01.01.01
     */
    public function showLicenceEditForm($fields,$msg)
    {

        $licence=new adminLicenceModel();
        $result=$licence->getLicenceById($fields['Company_licences_id']);

        if($result['result']!='1')
        {
            $msg=$result['msg'];
            redirectPage(RELA_DIR . "zamin/index.php?component=licence", $msg);
        }

        $export=$licence->fields;

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

        $this->fileName='admin.licence.editForm.php';
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
        $licence=new adminLicenceModel();
        $result=$licence->getLicence($fields);
        if($result['result']!='1')
        {
            $this->fileName='admin.licence.showList.php';
            $this->template('',$result['msg']);
            die();
        }
        $export['list']=$licence->list;
        $export['company_id']=$fields['choose']['company_id'];

        $export['recordsCount']=$licence->recordsCount;
        $this->fileName='admin.licence.showList.php';
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
    public function deleteLicence($id)
    {
        $licence = new adminLicenceModel();

        if(!validator::required($id) and !validator::Numeric($id))
        {
            $msg= 'یافت نشد';
            redirectPage(RELA_DIR . "admin/index.php", $msg);
        }
        $resultGetLicence = $licence->getLicenceById($id);

        if($resultGetLicence['result']!='1')
        {
            $msg=$resultGetLicence['msg'];
            redirectPage(RELA_DIR . "admin/index.php", $msg);
        }
        $company_id=$resultGetLicence['export']['list']['company_id'];


        $result=$licence->delete();

        if($result['result']!='1')
        {
            redirectPage(RELA_DIR . "zamin/index.php?component=licence&id=$company_id", $msg);
        }

        $msg='عملیات با موفقیت انجام شد';
        redirectPage(RELA_DIR . "zamin/index.php?component=licence&id=$company_id", $msg);
        die();
    }

}
?>
