<?php
/**
 * Created by PhpStorm.
 * User: malek
 * Date: 2/20/2016
 * Time: 4:24 PM
 */

include_once(dirname(__FILE__)."/product.model.php");

/**
 * Class articleController
 */
class productController
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
     * articleController constructor.
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
        // global $conn, $lang;

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
     *  get Product By Company Id
     *
     * @param $id
     * @author malekloo
     * @date 3/29/2016
     * @version 01.01.01
     */
    public function getProductByCompanyId($id)
    {


        $product=new productModel;
        $result=$product->getProductByCompanyId($id);

        if($result['result']!='1')
        {
            $msg='not found';
            redirectPage(RELA_DIR , $msg);
        }

        //echo '<pre/>';
        //print_r($result);
        //die();

        $this->fileName = "product.showMore.php";
        $this->template($product->fields);
        die();
    }
    /**
     * show all article
     *
     * @param $_input
     * @author marjani
     * @date 2/28/2016
     * @version 01.01.01
     */
    public function showProductDetail($id)
    {

        $product=new productModel;
        $result=$product->getProductById($id);

        if($result['result']!='1')
        {
            $msg='not found';
            redirectPage(RELA_DIR , $msg);
        }


        include_once(ROOT_DIR."component/company/model/company.model.php");
        $company    = new companyModel();
        $rs_getCompanyById=$company->getCompanyById($result['list']['company_id']);
        $export['company_name']=$rs_getCompanyById['list']['company_name'];




        $resultProduct = $product->getProductByCompanyId($result['list']['company_id']);

        if($resultProduct['result'] != 1 and $resultProduct['no'] != '100' )
        {
            $msg='not found';
            redirectPage(RELA_DIR , $msg);
        }

        $export['list'] = $product->fields;
        $export['product_list']=$resultProduct['export']['list'];
        unset($export['product_list'][$result['list']['Company_products_id']]);

        //echo '<pre/>';
        //print_r($export);
        //die();

        $this->fileName = "product.showDetail.php";
        $this->template($export);
        die();
    }


    /**
     * get all Product  and  show in list
     *
     * @param $fields
     * @author marjani
     * @date 2/28/2016
     * @version 01.01.01
     */
    public function showALL($fields)
    {
        global $PARAM;

        include_once(ROOT_DIR."component/category/model/category.model.php");
        $category = new categoryModel();

        $resultCategory = $category->getCategoryByUrl($PARAM['1']);

        if($resultCategory['result'] != 1)
        {
            $msg='not found';
            redirectPage(RELA_DIR , $msg);
        }
        $category_id = $resultCategory['list']['Category_id'];
        $fields['condition']['category_id']=$category_id;

        $product    =   new productModel;

        $result     =   $product->getProductByCategoryId($fields);
        if($result['result']!='1')
        {
            $msg='not found';
            redirectPage(RELA_DIR , $msg);
        }

        $export['list']=$product->list;
        $export['recordsCount']=$product->recordsCount;
        $export['pagination']=$product->pagination;
        if($product->recordsCount=='0')
        {
            $msg='رکوردی یافت نشد.';
        }


        ///////////////// article
        include_once(ROOT_DIR.'/component/article/model/article.model.php');
        $article = new articleModel();

        $result = $article->getArticleByCategoryId($category_id);
        //echo "<pre>"; print_r($result); die();
        $export['article_list'] = $result['export']['list'];
        /////////////////////////



        $this->fileName = "product.showList.php";
        $this->template($export,$msg);
        die();
    }

}
?>