<?php
/**
 * Created by PhpStorm.
 * User: malek
 * Date: 2/20/2016
 * Time: 4:24 PM.
 */
include_once dirname(__FILE__).'/admin.news.model.php';

/**
 * Class newsController.
 */
class adminNewsController
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
     *
     */
    public function __construct()
    {
        $this->exportType = 'html';
    }

    /**
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
                include ROOT_DIR.'templates/'.CURRENT_SKIN.'/template_start.php';
                include ROOT_DIR.'templates/'.CURRENT_SKIN.'/template_header.php';
                include ROOT_DIR.'templates/'.CURRENT_SKIN.'/template_rightMenu_admin.php';
                include ROOT_DIR.'templates/'.CURRENT_SKIN."/$this->fileName";
                include ROOT_DIR.'templates/'.CURRENT_SKIN.'/template_footer.php';
                include ROOT_DIR.'templates/'.CURRENT_SKIN.'/template_end.php';
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
     */
    public function showMore($_input)
    {
        if (!is_numeric($_input)) {
            $msg = 'یافت نشد';
            $this->template($msg);
        }
        $news = new adminNewsModel();
        $result = $news->getNewsById($_input);

        if ($result['result'] != 1) {
            die();
        }

        $this->template($news->fields);
        die();
    }

    /**
     * @param $_input
     */
    public function rssRead()
    {
        include_once dirname(__FILE__).'/admin.news.model.db.php';
        $xml = ('http://mehrnews.com/rss/tp/25');
        $xmlDoc = new DOMDocument();
        $xmlDoc->load($xml);
        $channel = $xmlDoc->getElementsByTagName('channel')->item(0);
        $items = $channel->getElementsByTagName('item');
        foreach ($items as $key => $value) {
            $fields = array();
            $fields['title'] = $value->getElementsByTagName('title')[0]->nodeValue;
            $fields['brif_description'] = $value->getElementsByTagName('title')[0]->nodeValue;
            $fields['description'] = $value->getElementsByTagName('description')[0]->nodeValue;
            $fields['image'] = $value->getElementsByTagName('enclosure')[0]->attributes['url']->value;
            $result = adminNewsModelDb::insert($fields);
            if ($result['result'] != '1') {
                $msg = 'خطا در عملیات ایمپورت RSS';
                redirectPage(RELA_DIR.'zamin/index.php?component=news', $msg);
                die();
            }
        }
        $msg = 'انجام شد';
        redirectPage(RELA_DIR.'zamin/index.php?component=news', $msg);
        die();
    }

    /**
     * @param $fields
     */
    public function showList($fields)
    {
        $news = new adminNewsModel();
        $result = $news->getNews($fields);
        if ($result['result'] != '1') {
            $this->fileName = 'admin.news.showList.php';
            $this->template('', $result['msg']);
            die();
        }
        $export['list'] = $news->list;
        $export['recordsCount'] = $news->recordsCount;
        $this->fileName = 'admin.news.showList.php';
        $this->template($export);
        die();
    }

    /**
     * @param $fields
     * @param $msg
     */
    public function showNewsAddForm($fields, $msg)
    {
        $this->fileName = 'admin.news.addForm.php';
        $this->template($fields, $msg);
        die();
    }

    /**
     * @param $fields
     *
     * @return mixed
     */
    public function addNews($fields)
    {
        $news = new adminNewsModel();

        $result = $news->setFields($fields);

        if ($result['result'] == -1) {
            return $result;
        }
        $result = $news->add();

        if ($result['result'] != '1') {
            $this->showNewsAddForm($fields, $result['msg']);
        }
        $msg = 'عملیات با موفقیت انجام شد';
        redirectPage(RELA_DIR.'zamin/index.php?component=news', $msg);
        die();
    }

    /**
     * @param $fields
     * @param $msg
     */
    public function showNewsEditForm($fields, $msg)
    {
        $news = new adminNewsModel();

        if (!validator::required($fields['News_id']) and !validator::Numeric($fields['News_id'])) {
            $msg = 'یافت نشد';
            redirectPage(RELA_DIR.'zamin/index.php?component=news', $msg);
        }
        $result = $news->getNewsById($fields['News_id']);

        if ($result['result'] != '1') {
            $msg = $result['msg'];
            redirectPage(RELA_DIR.'zamin/index.php?component=news', $msg);
        }

        $export = $news->fields;

        $this->fileName = 'admin.news.editForm.php';
        $this->template($export, $msg);
        die();
    }

    /**
     * @param $fields
     */
    public function editNews($fields)
    {
        $news = new adminNewsModel();

        if (!validator::required($fields['News_id']) and !validator::Numeric($fields['News_id'])) {
            $msg = 'یافت نشد';
            redirectPage(RELA_DIR.'zamin/index.php?component=news', $msg);
        }
        $result = $news->getNewsById($fields['News_id']);
        if ($result['result'] != '1') {
            $msg = $result['msg'];
            redirectPage(RELA_DIR.'zamin/index.php?component=news', $msg);
        }

        $result = $news->setFields($fields);

        if ($result['result'] != 1) {
            $this->showNewsEditForm($fields, $result['msg']);
        }

        $result = $news->edit();

        if ($result['result'] != '1') {
            $this->showNewsEditForm($fields, $result['msg']);
        }
        $msg = 'عملیات با موفقیت انجام شد';
        redirectPage(RELA_DIR.'zamin/index.php?component=news', $msg);
        die();
    }

    /**
     * delete news by news_id.
     *
     * @param $fields
     *
     * @author malekloo,marjani
     * @date 2/24/2015
     *
     * @version 01.01.01
     */
    public function deleteNews($fields)
    {
        $news = new adminNewsModel();

        if (!validator::required($fields['News_id']) and !validator::Numeric($fields['News_id'])) {
            $msg = 'یافت نشد';
            redirectPage(RELA_DIR.'zamin/index.php?component=news', $msg);
        }
        $result = $news->getNewsById($fields['News_id']);
        if ($result['result'] != '1') {
            $msg = $result['msg'];
            redirectPage(RELA_DIR.'zamin/index.php?component=news', $msg);
        }
        $result = $news->setFields($fields);

        if ($result['result'] != 1) {
            $this->showNewsEditForm($fields, $result['msg']);
        }
        $result = $news->delete();

        if ($result['result'] != '1') {
            $this->showNewsEditForm($fields, $result['msg']);
        }
        $msg = 'عملیات با موفقیت انجام شد';
        redirectPage(RELA_DIR.'zamin/index.php?component=news', $msg);
        die();
    }
}
