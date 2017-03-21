<?php
/**
 * Created by PhpStorm.
 * User: malek
 * Date: 2/20/2016
 * Time: 4:24 PM.
 */
include_once dirname(__FILE__).'/company.model.php';

/**
 * Class articleController.
 */
class companyController
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
     * articleController constructor.
     */
    public function __construct()
    {
        $this->exportType = 'html';
    }

    /**
     * call template.
     *
     * @param string $list
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
     * show all article.
     *
     * @param $_input
     *
     * @author marjani
     * @date 2/28/2016
     *
     * @version 01.01.01
     */
    public function showDetail($id)
    {

        // get company
        $company = new companyModel();
        $result = $company->getCompanyById($id);

        if ($result['result'] == '1') {
            $export['list'] = $company->fields;
        } else {
            $msg = 'not found';
            redirectPage(RELA_DIR, $msg);
        }

        // get company certifications
        include_once ROOT_DIR.'component/certification/admin/model/admin.certification.model.php';
        $certification = new adminCertificationModel();
        $resultCertification = $certification->getCertificationByIdArray($export['list']['certification_id']);
        if ($resultCertification['result'] == 1) {
            $export['certification_list'] = $resultCertification['export']['list'];
        }

        // get related companies
        $resultRelatedCompanies = $company->getRelatedCompanies($id);
        if ($resultRelatedCompanies['result'] == 1) {
            $export['related_companies_list'] = $resultRelatedCompanies['export']['list'];
        }

        // get company products
        include_once ROOT_DIR.'component/product/model/product.model.php';
        $product = new productModel();
        $resultProduct = $product->getProductByCompanyId($id);
        if ($resultProduct['result'] == 1) {
            $export['product_list'] = $resultProduct['export']['list'];
        }

        //use category model func by getCategoryUlLi
        include_once ROOT_DIR.'component/category/model/category.model.php';
        $category = new categoryModel();
        $resultCategory = $category->getCategoryUlLi();
        if ($resultCategory['result'] == 1) {
            $export['category_list'] = $resultCategory['export']['list'];
        }

        // include company licences
        include_once ROOT_DIR.'component/licence/admin/model/admin.licence.model.php';
        $licence = new adminLicenceModel();
        $resultLicence = $licence->getLicenceByCompanyId($id);
        if ($resultLicence['result'] == 1) {
            $export['licence_list'] = $resultLicence['export']['list'];
        }

        // include company honour
        include_once ROOT_DIR.'component/honour/admin/model/admin.honour.model.php';
        $honour = new adminHonourModel();
        $resultHonour = $honour->getHonourByCompanyId($id);
        if ($resultHonour['result'] == 1) {
            $export['honour_list'] = $resultHonour['export']['list'];
        }

        // breadcrumb
        global $breadcrumb;
        $breadcrumb->reset();
        $reqReferer = urldecode($_SERVER['HTTP_REFERER']);
        $reqRefererArray = explode('/', urldecode($_SERVER['HTTP_REFERER']));
        $searchIndex = array_search('search', $reqRefererArray);
        if ($searchIndex) {
            $qIndex = array_search('q', $reqRefererArray);
            if ($qIndex) {
                $breadcrumb->add('جست و جوی : '.$reqRefererArray[$qIndex + 1], $reqReferer, true);
            } else {
                $breadcrumb->add('جست و جو', $reqReferer, true);
            }
            $breadcrumb->add('تولیدی : '.$company->fields['company_name'], 'company/Detail/'.$company->fields['Company_id'].'/'.$company->fields['company_name'], true);
            unset($_SESSION['companyBreadcrumb']);
            $_SESSION['companyBreadcrumb'] = serialize($breadcrumb);
            $breadcrumb->pop();
        } else {
            unset($_SESSION['companyBreadcrumb']);
            // get company categories
            include_once ROOT_DIR.'component/category/model/category.model.db.php';
            $categoryResult = categoryModelDb::getCategoryByIdString($company->fields['category_id']);
            $categories = $categoryResult['export']['list'];
            foreach ($categories as $key => $value) {
                $breadcrumb->add($value['title'], 'company/'.$value['Category_id'], true);
            }
        }
        $breadcrumb->add('تولیدی : '.$company->fields['company_name']);
        $export['breadcrumb'] = $breadcrumb->trail();

        $this->fileName = 'company.showDetail.php';
        $this->template($export);
        die();
    }

    /**
     * get all article and  show in list.
     *
     * @param $fields
     *
     * @author marjani
     * @date 2/28/2016
     *
     * @version 01.01.01
     */
    public function showALL($fields)
    {
        global $PARAM;

        include_once ROOT_DIR.'component/category/model/category.model.php';
        $category = new categoryModel();
        $category_id = $fields['chose']['category_id'];
        $resultCategory = $category->getCategoryChildes($category_id);
        if ($resultCategory['result'] != 1 and $resultCategory['no'] != '100') {
            $msg = 'not found';
            redirectPage(RELA_DIR, $msg);
        }
        foreach ($resultCategory['export']['list'] as $key => $value) {
            $category_id .= ','.$key;
        }

        $fields['condition']['category_id'] = $category_id;
        $fields['condition']['city_id'] = $fields['chose']['city_id'];

        $company = new companyModel();
        $result = $company->getCompany($fields);
        if ($result['result'] != '1') {
            $msg = 'not found';
            redirectPage(RELA_DIR, $msg);
        }
        $export['list'] = $company->list;
        $export['recordsCount'] = $company->recordsCount;
        $export['pagination'] = $company->pagination;
        if ($company->recordsCount == '0') {
            $msg = 'رکوردی یافت نشد.';
        }

        ///////////////// article
        include_once ROOT_DIR.'/component/article/model/article.model.php';
        $article = new articleModel();

        $result = $article->getArticleByCategoryId($category_id);
        //echo "<pre>"; print_r($result); die();
        $export['article_list'] = $result['export']['list'];
        /////////////////////////

        // breadcrumb
        global $breadcrumb;
        $breadcrumb->reset();
        $resultCategoryParents = $category->getCategoryParents($fields['chose']['category_id']);
        if ($resultCategoryParents['result'] == 1) {
            foreach ($category->list as $key => $value) {
                $breadcrumb->add($value['title'], 'company/'.$value['Category_id'].'/1', true);
            }
        }
        // print_r_debug($resultCategoryParents);
        // $breadcrumb->add($resultCategory['list']['title']);
        $export['breadcrumb'] = $breadcrumb->trail();

        $this->fileName = 'company.showList.php';
        $this->template($export, $msg);
        die();
    }
}
