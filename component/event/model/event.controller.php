<?php
/**
 * Created by PhpStorm.
 * User: malek
 * Date: 2/20/2016
 * Time: 4:24 PM.
 */
include_once dirname(__FILE__).'/event.model.php';

/**
 * Class articleController.
 */
class eventController
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
    public function template($list = array(), $msg='')
    {

        // global $conn, $lang;
        global $PARAM,$member_info;
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
     *
     * @author marjani
     * @date 2/28/2016
     *
     * @version 01.01.01
     * @param $id
     */
    public function showDetail($id)
    {
        global $lang;

        // get event
        $event = new eventModel();
        $result = $event->getEventById($id);

        if ($result['result'] == '1') {
            $export['list'] = $event->fields;
        } else {
            $msg = 'not found';
            redirectPage(RELA_DIR, $msg);
        }

        $resultProduct = $event->getEventById($id);

        if ($resultProduct['result'] == 1) {
            $export['product_list'] = $resultProduct['export']['list'];
        }

        $resultEventGallery = $event->getEventGalleryById($id);
        if ($resultEventGallery['result'] == 1) {
            $export['event_gallery'] = $resultEventGallery['export']['list'];
        }


        //use category model func by getCategoryUlLi
        include_once ROOT_DIR.'component/category/model/category.model.php';
        $category = new categoryModel();
        $resultCategory = $category->getCategoryUlLi();
        if ($resultCategory['result'] == 1) {
            $export['category_list'] = $resultCategory['export']['list'];
        }
        $salon_id=substr(substr($export['list']['salon_id'],1),0,-1);

        include_once ROOT_DIR.'component/salon/model/salon.model.php';
        $salon = new salonModel();
        $resultSalon = $salon->getSalonById($salon_id);

        if ($resultSalon['result'] == 1) {
            $export['salon_list'] = $resultSalon['list'];
        }

        ///////////////////////////
        include_once ROOT_DIR.'component/province/model/province.model.php';
        $obj = province::find($export['list']['city_id']);
        $export['list']['city'] = $obj->fields["name_$lang"];

        $this->fileName = 'event.showDetail.php';

/*print_r_debug($export);*/

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
        global $PARAM,$lang;


        include_once ROOT_DIR.'component/category/model/category.model.php';
        $category = new categoryModel();
         $category_id = $fields['chose']['category_id'];

        $resultCategory = $category->getCategoryChildes($category_id);
        //print_r_debug($resultCategory);
        if ($resultCategory['result'] != 1 and $resultCategory['no'] != '100') {
            $msg = 'not found';
            redirectPage(RELA_DIR, $msg);
        }
        $resultCategory2 = $category->getCategoryUlLi(0);

        $export['export']['category'] = $resultCategory2['export']['list'];
        //print_r_debug($resultCategory2);

        foreach ($resultCategory['export']['list'] as $key => $value) {
            $category_id .= ','.$key;
        }



        $fields['condition']['category_id'] = $category_id;
        //$fields['condition']['city_id'] = $fields['chose']['city_id'];

        $event = new eventModel();
        $result = $event->getEvent($fields);
        if ($result['result'] != '1') {
            $msg = 'not found';
            redirectPage(RELA_DIR, $msg);
        }



        $export['list'] = $event->list;
        $export['recordsCount'] = $event->recordsCount;
        $export['pagination'] = $event->pagination;
        if ($event->recordsCount == '0') {
            $msg = 'رکوردی یافت نشد.';
        }

        $obj = new eventModel();
        $fields2['where'] = ' status =1 ';
        $res = $obj->getByFilter($fields2);

        //$calendar  = eventModel::getAll()->getList();
        $calendar  = $res;

        $count = 0;
        $temp=array();

        foreach ($calendar['export']['list'] as $k => $v)
        {
            if($v['date']!='0000-00-00')
            {
                $temp[$count]['start'] = $v["date"];
                $temp[$count]['title'] = $v["event_name_$lang"];
                $temp[$count]['color'] = '#ffad33';
                $temp[$count]['url'] = RELA_DIR . 'event/Detail/' . $v['Event_id'] . '/' . $v["event_name_$lang"];
                $count =$count+1;
            }
            if( $v['date2']!='0000-00-00' && $v['date2'] != $v['date'])
            {
                $temp[$count]['start'] = $v["date2"];
                $temp[$count]['title'] = $v["event_name_$lang"];
                $temp[$count]['color'] = '#ffad33';
                $temp[$count]['url'] = RELA_DIR . 'event/Detail/' . $v['Event_id'] . '/' . $v["event_name_$lang"];
                $count =$count+1;
            }
            if( $v['date3']!='0000-00-00' && $v['date3'] != $v['date'] && $v['date3'] != $v['date2'])
            {
                $temp[$count]['start'] = $v["date3"];
                $temp[$count]['title'] = $v["event_name_$lang"];
                $temp[$count]['color'] = '#ffad33';
                $temp[$count]['url'] = RELA_DIR . 'event/Detail/' . $v['Event_id'] . '/' . $v["event_name_$lang"];
                $count = $count + 1;
            }
        }

        $export['calendar'] = json_encode($temp);
        //print_r_debug($export['calendar']);

        ///////////////// article
        /*include_once ROOT_DIR.'/component/article/model/article.model.php';
        $article = new articleModel();

        $result = $article->getArticleByCategoryId($category_id);
        //echo "<pre>"; print_r($result); die();
        $export['article_list'] = $result['export']['list'];*/
        /////////////////////////

        // breadcrumb
        global $breadcrumb;
        $breadcrumb->reset();
        $resultCategoryParents = $category->getCategoryParents($fields['chose']['category_id']);


        if ($resultCategoryParents['result'] == 1) {
            foreach ($category->list as $key => $value) {
                $breadcrumb->add($value['title'], 'event/'.$value['Category_id'].'/1', true);
            }
        }
        // print_r_debug($resultCategoryParents);
        // $breadcrumb->add($resultCategory['list']['title']);
        $export['breadcrumb'] = $breadcrumb->trail();

        //print_r_debug($export);
        $this->fileName = 'event.showList.php';

        $this->template($export, $msg);
        die();
    }
}
