<?php
/**
 * Created by PhpStorm.
 * User: malek
 * Date: 2/20/2016
 * Time: 4:24 PM.
 */
include_once dirname(__FILE__).'/article.model.php';

/**
 * Class articleController.
 */
class articleController
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
    public function showMore($_input)
    {
        if (!is_numeric($_input)) {
            $msg = 'یافت نشد';
            $this->fileName = 'article.showList.php';
            $this->template('', $msg);
            die();
        }
        $article = new articleModel();
        $result = $article->getArticleById($_input);

        if ($result['result'] != 1) {
            $this->fileName = 'article.showList.php';
            $this->template('', $result['msg']);
            die();
        }

        $export['list'] = $article->fields;

        // breadcrumb
        global $breadcrumb;
        $breadcrumb->reset();
        $breadcrumb->add('مقالات', 'article', true);
        $breadcrumb->add($article->fields['title']);
        $export['breadcrumb'] = $breadcrumb->trail();

        $this->fileName = 'article.showMore.php';
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
        $article = new articleModel();

        $result = $article->getArticle($fields);
        if ($result['result'] != '1') {
            die();
        }
        $export['list'] = $article->list;
        $export['recordsCount'] = $article->recordsCount;
        $export['pagination'] = $article->pagination;

        // breadcrumb
        global $breadcrumb;
        $breadcrumb->reset();
        $breadcrumb->add('مقالات');
        $export['breadcrumb'] = $breadcrumb->trail();

        $this->fileName = 'article.showList.php';
        $this->template($export);
        die();
    }
}
