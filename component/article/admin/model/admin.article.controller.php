<?php
/**
 * Created by PhpStorm.
 * User: malek
 * Date: 2/20/2016
 * Time: 4:24 PM
 */

include_once(dirname(__FILE__)."/admin.article.model.php");

/**
 * Class articleController
 */
class adminArticleController
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
     * @param string $list
     * @param $msg
     * @return string
     */
    function template($list=[],$msg)
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
        $article=new adminArticleModel();
        $result=$article->getArticleById($_input);

        if($result['result']!=1)
        {
            die();
        }

        $this->template($article->fields);
        die();
    }


    /**
     * @param $fields
     */
    public function showList($fields)
    {
        $article=new adminArticleModel();
        $result=$article->getArticle($fields);
        if($result['result']!='1')
        {
            $this->fileName='admin.article.showList.php';
            $this->template('',$result['msg']);
            die();
        }
        $export['list']=$article->list;
        $export['recordsCount']=$article->recordsCount;
        $this->fileName='admin.article.showList.php';


        $this->template($export);
        die();
    }

    /**
     * @param $fields
     * @param $msg
     */
    public function showArticleAddForm($fields,$msg)
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

        $this->fileName='admin.article.addForm.php';
        $this->template($fields,$msg);
        die();
    }

    /**
     * @param $fields
     * @return mixed
     */
    public function addArticle($fields)
    {
        $article=new adminArticleModel();

        $result=$article->setFields($fields);

        if($result['result']==-1)
        {
            return $result;
        }
        $result=$article->add();

        if($result['result']!='1')
        {
            $this->showArticleAddForm($fields,$result['msg']);
        }
        $msg='عملیات با موفقیت انجام شد';
        redirectPage(RELA_DIR . "zamin/index.php?component=article", $msg);
        die();
    }

    /**
     * @param $fields
     * @param $msg
     */
    public function showArticleEditForm($fields,$msg)
    {

        $article=new adminArticleModel();


        if(!validator::required($fields['Article_id']) and !validator::Numeric($fields['Article_id']))
        {
            $msg= 'یافت نشد';
            redirectPage(RELA_DIR . "zamin/index.php?component=article", $msg);
        }
        $result    = $article->getArticleById($fields['Article_id']);

        if($result['result']!='1')
        {
            $msg=$result['msg'];
            redirectPage(RELA_DIR . "zamin/index.php?component=article", $msg);
        }



        $export=$article->fields;

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


        $this->fileName='admin.article.editForm.php';
        $this->template($export,$msg);
        die();
    }

    /**
     * @param $fields
     */
    public function editArticle($fields)
    {
        $article=new adminArticleModel();

        if(!validator::required($fields['Article_id']) and !validator::Numeric($fields['Article_id']))
        {
            $msg= 'یافت نشد';
            redirectPage(RELA_DIR . "zamin/index.php?component=article", $msg);
        }
        $result    = $article->getArticleById($fields['Article_id']);
        if($result['result']!='1')
        {
            $msg=$result['msg'];
            redirectPage(RELA_DIR . "zamin/index.php?component=article", $msg);
        }


        $result=$article->setFields($fields);


        if($result['result']!=1)
        {
            $this->showArticleEditForm($fields,$result['msg']);
        }

        $result=$article->edit();

        if($result['result']!='1')
        {
            $this->showArticleEditForm($fields,$result['msg']);
        }
        $msg='عملیات با موفقیت انجام شد';
        redirectPage(RELA_DIR . "zamin/index.php?component=article", $msg);
        die();
    }

    /**
     * delete article by article_id
     *
     * @param $fields
     * @author malekloo,marjani
     * @date 2/24/2015
     * @version 01.01.01
     */
    public function deleteArticle($fields)
    {
        $article=new adminArticleModel();

        if(!validator::required($fields['Article_id']) and !validator::Numeric($fields['Article_id']))
        {
            $msg= 'یافت نشد';
            redirectPage(RELA_DIR . "zamin/index.php?component=article", $msg);
        }
        $result    = $article->getArticleById($fields['Article_id']);
        if($result['result']!='1')
        {
            $msg=$result['msg'];
            redirectPage(RELA_DIR . "zamin/index.php?component=article", $msg);
        }
        $result=$article->setFields($fields);

        if($result['result']!=1)
        {
            $this->showArticleEditForm($fields,$result['msg']);
        }
        $result=$article->delete();

        if($result['result']!='1')
        {
            $this->showArticleEditForm($fields,$result['msg']);
        }
        $msg='عملیات با موفقیت انجام شد';
        redirectPage(RELA_DIR . "zamin/index.php?component=article", $msg);
        die();
    }
}
?>