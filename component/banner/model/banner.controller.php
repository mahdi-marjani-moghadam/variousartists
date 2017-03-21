<?php
/**
 * Created by PhpStorm.
 * User: marjani
 * Date: 3/10/2016
 * Time: 10:21 AM.
 */
include_once dirname(__FILE__).'/banner.model.php';

/**
 * Class bannerController.
 */
class bannerController
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
     * bannerController constructor.
     */
    public function __construct()
    {
        $this->exportType = 'html';
    }

    /**
     * call tempate.
     *
     * @param array $list
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
     * show all banner.
     *
     * @param $_input
     *
     * @author marjani
     * @date 3/10/2015
     *
     * @version 01.01.01
     */
    public function showMore($_input)
    {
        if (!is_numeric($_input)) {
            $msg = 'یافت نشد';
            $this->fileName = 'banner.showList.php';
            $this->template('', $msg);
            die();
        }
        $banner = new bannerModel();
        $result = $banner->getBannerById($_input);

        if ($result['result'] != 1) {
            $this->fileName = 'banner.showList.php';
            $this->template('', $result['msg']);
            die();
        }

        // breadcrumb
        global $breadcrumb;
        $breadcrumb->reset();
        $breadcrumb->add('بنر');
        $breadcrumb->add($banner['list']['title']);
        $export['breadcrumb'] = $breadcrumb->trail();

        $this->fileName = 'banner.showMore.php';
        $this->template($banner->fields);
        die();
    }

    /**
     * @param $fields
     *
     * @author marjani
     * @date 3/10/2015
     *
     * @version 01.01.01
     */
    public function showALL($fields)
    {
        //$banner = new bannerModel();

        $banner = bannerModel::getAll()->getList();

        print_r_debug($banner);





        $result = $banner->getBanner($fields);
        if ($result['result'] != '1') {
            die();
        }
        $export['list'] = $banner->list;
        $export['recordsCount'] = $banner->recordsCount;
        $export['pagination'] = $banner->pagination;

        // breadcrumb
        global $breadcrumb;
        $breadcrumb->reset();
        $breadcrumb->add('بنر');
        $export['breadcrumb'] = $breadcrumb->trail();

        $this->fileName = 'banner.showList.php';
        $this->template($export);
        die();
    }
}
