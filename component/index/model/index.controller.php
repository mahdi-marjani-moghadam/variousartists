<?php

use Component\article\model\articleModel;
use Component\banner\model\bannerModel;
use Component\category\model\categoryModel;
use Component\event\model\eventModel;
use Component\soundcloud\model\soundcloud;


class indexController
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
        $this->exportType = 'html';
    }

    public function template($list = [], $msg = ''): void
    {
        global $PARAM, $member_info, $lang;

        switch ($this->exportType) {

            case 'html':
                include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/title.inc.php");

                include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/$this->fileName");
                include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/tail.inc.php");
                break;

            case 'json':
                echo json_encode($list);
                break;
            case 'array':
                print_r_debug($list);
                break;

            case 'serialize':
                echo serialize($list);
                break;
            default:
                break;
        }
    }

    public function showMore($_input)
    {
        if (!is_numeric($_input)) {
            $msg = 'یافت نشد';
            $this->fileName = "article.showList.php";
            $this->template('', $msg);
            die();
        }
        $article = new articleModel;
        $result = $article->getArticleById($_input);

        if ($result['result'] != 1) {
            $this->fileName = "article.showList.php";
            $this->template('', $result['msg']);
            die();
        }
        $this->fileName = "article.showMore.php";
        $this->template($article->fields);
        die();
    }


    public function showALL($fields)
    {

        //use category model func by getCategoryUlLi
        $category = new categoryModel();

        $resultCategory = $category->getCategoryUlLi();


        if ($resultCategory['result'] == 1) {
            $export['category_list'] = $resultCategory['export']['list'];
        }

        $event = new eventModel();
        $limit['limit']['start'] = 0;
        $limit['limit']['length'] = 18;
        $limit['order']['date'] = 'DESC';
        $limit['where'] = 'status = 1 and (`date` >= date_sub(now(),interval 1 day) or date2 >= date_sub(now(),interval 1 day) or date3 >= date_sub(now(),interval 1 day))';
        $result = $event->getByFilter($limit);

        $export['lastEvent'] = $result['export']['list'];

        $resultCategoryAll = $category->allCategory();
        if ($resultCategoryAll['result'] == 1) {
            $export['category_list_all'] = $resultCategoryAll['export']['list'];
        }


        $banner = new bannerModel();

        $fields['order']['priority'] = 'ASC';
        $banner = $banner->getByFilter($fields);
        $export['banner'] = $banner['export']['list'];



        /** sound cloud */
        $soundcloud = new soundcloud();
        $sc_rs = $soundcloud->getByFilter();
        $export['soundcloud'] = $sc_rs['export']['list'];



        $this->fileName = "index.php";
        //print_r_debug($export);

        $this->template($export);
        die();
    }
}
