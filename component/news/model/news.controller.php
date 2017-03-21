<?php
/**
 * Created by PhpStorm.
 * User: malek
 * Date: 2/20/2016
 * Time: 4:24 PM.
 */
include_once dirname(__FILE__).'/news.model.php';

/**
 * Class newsController.
 */
class newsController
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
     * newsController constructor.
     */
    public function __construct()
    {
        $this->exportType = 'html';
    }

    /**
     * call tempate.
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
                $list['msg'] = $msg;
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
     * show all news.
     *
     * @param $_input
     *
     * @author malekloo,marjani
     * @date 2/24/2015
     *
     * @version 01.01.01
     */
    public function showMore($_input)
    {
        if (!is_numeric($_input)) {
            $msg = 'یافت نشد';
            $this->fileName = 'news.showList.php';
            $this->template('', $msg);
            die();
        }
        $news = new newsModel();
        $result = $news->getNewsById($_input);

        if ($result['result'] != 1) {
            $this->fileName = 'news.showList.php';
            $this->template('', $result['msg']);
            die();
        }

        $export['list'] = $news->fields;

        // breadcrumb
        global $breadcrumb;
        $breadcrumb->reset();
        $breadcrumb->add('اخبار', 'news', true);
        $breadcrumb->add($news->fields['title']);
        $export['breadcrumb'] = $breadcrumb->trail();

        $this->fileName = 'news.showMore.php';
        $this->template($export);
        die();
    }

    /**
     * @param $fields
     *
     * @author malekloo,marjani
     * @date 2/24/2015
     *
     * @version 01.01.01
     */
    public function showALL($fields)
    {
        $news = new newsModel();
        $result = $news->getNews($fields);
        if ($result['result'] != '1') {
            $this->fileName = 'news.showList.php';
            $this->template('', $result['msg']);
        }
        $export['list'] = $news->list;
        $export['recordsCount'] = $news->recordsCount;
        $export['pagination'] = $news->pagination;

        // breadcrumb
        global $breadcrumb;
        $breadcrumb->reset();
        $breadcrumb->add('اخبار');
        $export['breadcrumb'] = $breadcrumb->trail();

        $this->fileName = 'news.showList.php';
        $this->template($export);
        die();
    }

    /**
     * @param $fields
     *
     * @author malekloo,marjani
     * @date 2/24/2015
     *
     * @version 01.01.01
     */
    public function showAllRss()
    {
        $export['list'] = $this->rssRead();

        // breadcrumb
        global $breadcrumb;
        $breadcrumb->reset();
        $breadcrumb->add('اخبار');
        $export['breadcrumb'] = $breadcrumb->trail();

        $this->fileName = 'news.showListRss.php';
        $this->template($export);
        die();
    }

    /**
     * @param $_input
     */
    public function rssRead()
    {
        $xml = ('http://mehrnews.com/rss/tp/25');
        $xmlDoc = new DOMDocument();
        $xmlDoc->load($xml);
        $channel = $xmlDoc->getElementsByTagName('channel')->item(0);
        $items = $channel->getElementsByTagName('item');

        $fields = array();


        foreach ($items as $key => $value) {
            $fields[$key]['title'] = $value->getElementsByTagName('title')->item(0)->nodeValue;
            $fields[$key]['description'] = $value->getElementsByTagName('description')->item(0)->nodeValue;
            $url_obj=  $value->getElementsByTagName('enclosure')->item(0);
            $attributes=$url_obj->attributes;
            $fields[$key]['image'] =$attributes->item(0)->nodeValue;
            // $fields[$key]['image'] = $value->getElementsByTagName('enclosure')->item(0)->attributes['url']->value;
            $fields[$key]['link'] = $value->getElementsByTagName('guid')->item(0)->nodeValue;
        }
        return $fields;
    }
}
