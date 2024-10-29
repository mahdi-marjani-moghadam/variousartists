<?php

use Common\dbConn;
use Common\validators;
use Component\category\admin\model\adminCategoryModel;
use Component\city\admin\model\adminCityModel;
use Component\city\admin\model\adminCityModelDb;
use Component\country\model\country;
use Component\event\admin\model\adminEventDraftModel;
use Component\event\admin\model\adminEventModel;
use Component\event\admin\model\adminEventModelDb;
use Component\event_gallery\admin\model\adminEvent_galleryModel;
use Component\genre\admin\model\adminGenreModel;
use Component\province\admin\model\adminProvinceModel;
use Component\salon\admin\model\adminSalonModel;
use Model\convertDatatableIO;



class adminEventController
{

    public $exportType;


    public $fileName;


    public function __construct()
    {
        $this->exportType = 'html';
    }


    public function template($list = array(), $msg = '')
    {
        global $messageStack, $admin_info, $lang;

        switch ($this->exportType) {
            case 'html':
                include ROOT_DIR . 'templates/' . CURRENT_SKIN . '/template_start.php';
                include ROOT_DIR . 'templates/' . CURRENT_SKIN . '/template_header.php';
                include ROOT_DIR . 'templates/' . CURRENT_SKIN . '/template_rightMenu_admin.php';
                include ROOT_DIR . 'templates/' . CURRENT_SKIN . "/$this->fileName";
                include ROOT_DIR . 'templates/' . CURRENT_SKIN . '/template_footer.php';
                include ROOT_DIR . 'templates/' . CURRENT_SKIN . '/template_end.php';
                break;

            case 'json':
                echo json_encode($list);
                break;
            case 'serialize':
                echo serialize($list);
                break;

            default:
                break;
        }
    }



    public function showEventAddForm($fields = array(), $msg = '')
    {
        /** category */
        $category = new adminCategoryModel();

        $resultCategory = $category->getCategoryOption();
        if ($resultCategory['result'] == 1) {

            //$fields['category'] = $category->list;
            $export['category'] = $category->list;
        }

        /** genre */
        $genre = new adminGenreModel();

        $resultGenre = $genre->getGenreOption();
        if ($resultGenre['result'] == 1) {
            $export['genre'] = $genre->list;
        }

        /** salon */

        $salon = new adminSAlonModel();
        $obj = $salon->getAll()
            ->where('parent_id', '=', 0)
            ->getList();

        if ($obj['result'] == 1) {
            $export['salon'] = $obj['export']['list'];
        }


        /*include_once ROOT_DIR.'component/city/admin/model/admin.city.model.php';
        $city = new adminCityModel();
        $resultCity = $city->getCities();
        if ($resultCity['result'] == 1) {
            $fields['cities'] = $city->list;
        }*/
        /** city */
        /*include_once ROOT_DIR.'component/state/admin/model/admin.state.model.php';
        $province = new adminStateModel();
        $resultProvince = $province->getStates();
        if ($resultProvince['result'] == 1) {
            $export['provinces'] = $province->list;
        }*/

        /** country */
        $country = new country();
        $resultCountry = $country::getAll()->getList();
        if ($resultCountry['result'] == 1) {
            $export['country'] = $resultCountry['export']['list'];
        }

        /*include_once ROOT_DIR.'component/certification/admin/model/admin.certification.model.php';
        $certification = new adminCertificationModel();

        $resultCertification = $certification->getCertification();
        if ($resultCity['result'] == 1) {
            $fields['certifications'] = $certification->list;
        }*/

        $this->fileName = 'admin.event.addForm.php';
        $this->template($export, $msg);
        die();
    }
    public function addEvent($_input)
    {
        global $messageStack;


        $event = new adminEventModel();
        $_input['date'] = ($_input['date'] != '' ? convertJToGDate($_input['date']) : '0000-00-00');
        $_input['date2'] = ($_input['date2'] != '' ? convertJToGDate($_input['date2']) : '0000-00-00');
        $_input['date3'] = ($_input['date3'] != '' ? convertJToGDate($_input['date3']) : '0000-00-00');
        $_input['category_id'] = ',' . implode(',', $_input['category_id']) . ',';
        $_input['genre_id'] = ',' . implode(',', $_input['genre_id']) . ',';
        $_input['salon_id'] = ("," . (implode(",", $_input['salon_id'])) . "," == ',,') ? '' : "," . (implode(",", $_input['salon_id'])) . ",";


        $result = $event->setFields($_input);


        if ($result['result'] == -1) {
            $this->showEventAddForm($_input, $result['msg']);
        }
        $event->save();


        if (file_exists($_FILES['logo']['tmp_name'])) {

            $input['upload_dir'] = ROOT_DIR . 'statics/event/';
            $result = fileUploader($input, $_FILES['logo']);
            //fileRemover($input['upload_dir'],$product->fields['image']);
            $event->logo = $result['image_name'];
            $result = $event->save();
        }


        //$result = $event->addEvent();

        if ($result['result'] != '1') {
            $messageStack->add_session('register', $result['msg']);
            $this->showEventAddForm($_input, $result['msg']);
        }
        $msg = ' با موفقیت انجام شد.';
        $messageStack->add_session('register', $msg);

        redirectPage(RELA_DIR . 'zamin/?component=event', $msg);
        die();
    }

    public function addEventDraft($_input)
    {
        global $messageStack;


        $event = new adminEventDraftModel();

        $_input['date'] = ($_input['date'] != '' ? convertJToGDate($_input['date']) : '0000-00-00');
        $_input['date2'] = ($_input['date2'] != '' ? convertJToGDate($_input['date2']) : '0000-00-00');
        $_input['date3'] = ($_input['date3'] != '' ? convertJToGDate($_input['date3']) : '0000-00-00');
        $_input['category_id'] = ',' . implode(',', $_input['category_id']) . ',';
        $_input['salon_id'] = ',' . implode(',', $_input['salon_id']) . ',';


        $result = $event->setFields($_input);
        if ($result['result'] == -1) {
            $this->showEventAddForm($_input, $result['msg']);
        }

        $event->save();


        if (file_exists($_FILES['logo']['tmp_name'])) {

            $input['upload_dir'] = ROOT_DIR . 'statics/event/';
            $result = fileUploader($input, $_FILES['logo']);
            //fileRemover($input['upload_dir'],$product->fields['image']);
            $event->logo = $result['image_name'];
            $result = $event->save();
        }


        //$result = $event->addEvent();

        if ($result['result'] != '1') {
            $messageStack->add_session('register', $result['msg']);
            $this->showEventAddForm($_input, $result['msg']);
        }
        $msg = ' با موفقیت انجام شد.';
        $messageStack->add_session('register', $msg);

        redirectPage(RELA_DIR . 'zamin/?component=event', $msg);
        die();
    }


    public function addGallery($_input)
    {
        global $messageStack;


        $event = new adminEvent_galleryModel();

        $result = $event->setFields($_input);

        if ($result['result'] == -1) {
            $this->showEventAddForm($_input, $result['msg']);
        }
        $event->save();


        if (file_exists($_FILES['image']['tmp_name'])) {

            $input['upload_dir'] = ROOT_DIR . 'statics/event/';
            $result = fileUploader($input, $_FILES['image']);

            //fileRemover($input['upload_dir'],$product->fields['image']);
            $event->image = $result['image_name'];
            $result = $event->save();
        }


        //$result = $event->addEvent();

        if ($result['result'] != '1') {
            $messageStack->add_session('register', $result['msg']);
            $this->showEventAddForm($_input, $result['msg']);
        }
        $msg = 'ثبت نام با موفقیت انجام شد.';
        $messageStack->add_session('register', $msg);

        redirectPage(RELA_DIR . 'zamin/?component=event&action=gallery&id=' . $_input['event_id'], $msg);
        die();
    }

    public function showGalleryAddForm($fields, $msg)
    {

        $this->fileName = 'admin.gallery.addForm.php';
        $this->template($fields, $msg);
        die();
    }

    public function showEventEditForm($fields, $msg)
    {
        $showStatus = $fields['showStatus'];
        if (strtoupper($_SERVER['REQUEST_METHOD']) != 'POST') {
            $event = new adminEventModel();
            $result = $event->getEventById($fields['Event_id']);
            if ($result['result'] != '1') {
                $msg = $result['msg'];
                redirectPage(RELA_DIR . 'zamin/index.php?component=event', $msg);
            }
            $export = $event->fields;
        } else {
            $export = $fields;
        }

        /** category */
        $category = new adminCategoryModel();

        $resultCategory = $category->getCategoryOption();

        if ($resultCategory['result'] == 1) {
            $export['category'] = $category->list;
        }
        /** genre */
        $genre = new adminGenreModel();

        $resultGenre = $genre->getGenreOption();

        if ($resultGenre['result'] == 1) {
            $export['genre'] = $genre->list;
        }

        $salon = new adminSalonModel();
        $obj = $salon->getAll()
            ->where('parent_id', '=', 0)
            ->getList();

        if ($obj['result'] == 1) {
            $export['salon'] = $obj['export']['list'];
        }

        //$city = new adminCityModel();
        $province = adminProvinceModel::getAll()->getList();

        //$resultCity = $city->getCities();
        if ($province['result'] == 1) {
            $export['provinces'] = $province['export']['list'];
        }



        /** country */
        $country = new country();
        $resultCountry = $country::getAll()->getList();
        if ($resultCountry['result'] == 1) {
            $export['country'] = $resultCountry['export']['list'];
        }

        $export['showStatus'] = $showStatus;
        $this->fileName = 'admin.event.editForm.php';
        $this->template($export, $msg);
        die();
    }


    /**
     * @param $fields
     *
     * @return mixed
     *
     * @author malekloo
     * @date 3/16/2015
     *
     * @version 01.01.01
     */
    public function editEvent($fields)
    {
        $event = adminEventModel::find($fields['Event_id']);
        //$result = $event->getEventById($fields['Event_id']);

        $fields['date'] = ($fields['date'] != '' ? convertJToGDate($fields['date']) : '0000-00-00');
        $fields['date2'] = ($fields['date2'] != '' ? convertJToGDate($fields['date2']) : '0000-00-00');
        $fields['date3'] = ($fields['date3'] != '' ? convertJToGDate($fields['date3']) : '0000-00-00');
        $fields['category_id'] = "," . (implode(",", $fields['category_id'])) . ",";
        $fields['genre_id'] = "," . (implode(",", $fields['genre_id'])) . ",";

        $fields['salon_id'] = ("," . (implode(",", $fields['salon_id'])) . "," == ',,') ? '' : "," . (implode(",", $fields['salon_id'])) . ",";

        $event->setFields($fields);
        $event->update_date = date('Y-m-d H:i:s');
        $result = $event->save();

        $fields = $event->fields;
        if ($result['result'] != '1') {
            $this->showEventEditForm($fields, $result['msg']);
        }



        if (file_exists($_FILES['logo']['tmp_name'])) {

            $input['upload_dir'] = ROOT_DIR . 'statics/event/';
            $result = fileUploader($input, $_FILES['logo']);

            fileRemover($input['upload_dir'], $event->fields['logo']);
            $event->logo = $result['image_name'];

            $result = $event->save();
        }



        $msg = 'عملیات با موفقیت انجام شد';
        redirectPage(RELA_DIR . 'zamin/index.php?component=event', $msg);
        die();
    }

    /**
     * @param $fields
     *
     * @return mixed
     *
     * @author malekloo
     * @date 3/6/2015
     *
     * @version 01.01.01
     */


    public function showEventEditFormDraft($fields, $msg)
    {
        $showStatus = $fields['showStatus'];
        if (strtoupper($_SERVER['REQUEST_METHOD']) != 'POST') {
            $event = new adminEventDraftModel();
            $result = $event::find($fields['Event_id']);
            $export = $result->fields;
        } else {
            $export = $fields;
        }

        /** category */
        $category = new adminCategoryModel();

        $resultCategory = $category->getCategoryOption();

        if ($resultCategory['result'] == 1) {
            $export['category'] = $category->list;
        }
        /** genre */
        $genre = new adminGenreModel();

        $resultGenre = $genre->getGenreOption();

        if ($resultGenre['result'] == 1) {
            $export['genre'] = $genre->list;
        }

        /** salon */
        $salon = new adminSAlonModel();
        $obj = $salon->getAll()
            ->where('parent_id', '=', 0)
            ->getList();

        if ($obj['result'] == 1) {
            $export['salon'] = $obj['export']['list'];
        }


        //$city = new adminCityModel();
        $province = adminProvinceModel::getAll()->getList();

        //$resultCity = $city->getCities();
        if ($province['result'] == 1) {
            $export['provinces'] = $province['export']['list'];
        }




        $export['showStatus'] = $showStatus;
        $this->fileName = 'admin.event.editForm.draft.php';
        $this->template($export, $msg);
        die();
    }
    public function editEventDraft($fields)
    {


        //$event = new adminEventModel();
        $event = adminEventDraftModel::find($fields['Event_id']);
        //$result = $event->getEventById($fields['Event_id']);
        $fields['date'] = ($fields['date'] != '' ? convertJToGDate($fields['date']) : '0000-00-00');
        $fields['date2'] = ($fields['date2'] != '' ? convertJToGDate($fields['date2']) : '0000-00-00');
        $fields['date3'] = ($fields['date3'] != '' ? convertJToGDate($fields['date3']) : '0000-00-00');
        $fields['category_id'] = "," . (implode(",", $fields['category_id'])) . ",";
        $fields['genre_id'] = "," . (implode(",", $fields['genre_id'])) . ",";
        $fields['salon_id'] = "," . (implode(",", $fields['salon_id'])) . ",";


        $result = $event->setFields($fields);

        $event->update_date = date('Y-m-d H:i:s');

        $result = $event->save();
        //        print_r_debug($event);

        $fields = $event->fields;
        if ($result['result'] != '1') {
            $this->showEventEditFormDraft($fields, $result['msg']);
        }



        if (file_exists($_FILES['logo']['tmp_name'])) {

            $input['upload_dir'] = ROOT_DIR . 'statics/event/';
            $result = fileUploader($input, $_FILES['logo']);

            fileRemover($input['upload_dir'], $event->fields['logo']);
            $event->logo = $result['image_name'];

            $result = $event->save();
        }



        $msg = 'عملیات با موفقیت انجام شد';
        redirectPage(RELA_DIR . 'zamin/index.php?component=event&action=draft', $msg);
        die();
    }


    public function showList($msg)
    {

        $export['status'] = 'showAll';
        $this->fileName = 'admin.event.showList.php';
        $this->template($export);
        die();
    }
    public function showListDraft($msg)
    {

        $export['status'] = 'showAll';
        $this->fileName = 'admin.event.showList.draft.php';
        $this->template($export);
        die();
    }


    public function showListGallery($msg)
    {
        $export['status'] = 'showAll';
        $this->fileName = 'admin.event.gallery.showList.php';
        $this->template($export);
        die();
    }


    public function search($fields)
    {

        /*echo '<pre/>';
        print_r($fields);
        die();*/

        $event = new adminEventModel();

        $i = 0;
        $columns = array(
            array('db' => 'Event_id', 'dt' => $i++),
            array('db' => 'category_id', 'dt' => $i++),
            array('db' => 'event_name_fa',   'dt' => $i++),
            array('db' => 'event_name_en', 'dt' => $i++),
            array('db' => 'event_phone', 'dt' => $i++),
            array('db' => 'city_id', 'dt' => $i++),
            array('db' => 'event_time', 'dt' => $i++),
            //array( 'db' => 'event_date', 'dt' => $i++ ),
            array('db' => 'event_time2', 'dt' => $i++),
            //array( 'db' => 'event_date2', 'dt' => $i++ ),
            array('db' => 'event_time3', 'dt' => $i++),
            //array( 'db' => 'event_date3', 'dt' => $i++ ),
            array('db' => 'status', 'dt' => $i++),
            array('db' => 'address_fa', 'dt' => $i++),
            array('db' => 'address_en', 'dt' => $i++),
            array('db' => 'logo', 'dt' => $i++),
            array('db' => 'Event_id', 'dt' => $i++)
        );
        $convert = new convertDatatableIO();
        $convert->input = $fields;
        $convert->columns = $columns;


        $searchFields = $convert->convertInput();

        //$date = date('Y-m-d', strtotime(COMPANY_EXPIRE_PERIOD));
        // print_r_debug($date);
        //$searchFields['where'] = 'where refresh_date < '."'$date'";
        //print_r_debug($searchFields);

        $result = $event->getEvent($searchFields);

        if ($result['result'] != '1') {
            $this->fileName = 'admin.event.showList.php';
            $this->template('', $result['msg']);
            die();
        }

        $list['list'] = $event->list;
        $list['paging'] = $event->recordsCount;
        /*$other['2']=array(
            'formatter' =>function($list)
            {
                $st='<div data-event_id="'.$list['Event_id'].'" class="event_phone">'.$list['phone_number'].'</div>';
                return $st;
            }
        );*/
        $other['6'] = array(
            'formatter' => function ($list) {
                $st =  $list['event_time'] . '<br>' . ($list['date'] != '0000-00-00' ? convertDate($list['date']) : '');
                return $st;
            }
        );
        $other['7'] = array(
            'formatter' => function ($list) {
                $st =  $list['event_time2'] . '<br>' . ($list['date2'] != '0000-00-00' ? convertDate($list['date2']) : '');
                return $st;
            }
        );
        $other['8'] = array(
            'formatter' => function ($list) {
                $st =  $list['event_time3'] . '<br>' . ($list['date3'] != '0000-00-00' ? convertDate($list['date3']) : '');
                return $st;
            }
        );
        $other['9'] = array(
            'formatter' => function ($list) {
                if ($list['status'] == 1) {
                    $st = 'فعال';
                } else {
                    $st = 'غیر فعال';
                }
                return $st;
            }
        );
        $other['5'] = array(
            'formatter' => function ($list) {
                $city = country::find($list['country_id']);
                return $city->fields["nice_name"];
            }
        );
        $other['12'] = array(
            'formatter' => function ($list) {
                $st = "<img height='50' src='" . RELA_DIR . 'statics/event/' . $list['logo'] . "'>";

                return $st;
            }
        );
        $internalVariable['showstatus'] = $fields['status'];
        $other[$i - 1] = array(
            'formatter' => function ($list, $internal) {

                $st = '<a href="' . RELA_DIR . 'zamin/?component=event&action=edit&id=' . $list['Event_id'] . '&showStatus=' . $internal['showstatus']
                    . '">ویرایش</a> <br/>
                        <a href="' . RELA_DIR . 'zamin/?component=event&action=gallery&id=' . $list['Event_id'] . '">تصاویر</a><br/>
                        <a href="' . RELA_DIR . 'zamin/?component=event&action=delete&id=' . $list['Event_id'] . $list['event_name'] . '">حذف</a>';
                return $st;
            }
        );

        $export = $convert->convertOutput($list, $columns, $other, $internalVariable);
        echo json_encode($export);
        die();
    }
    public function searchDraft($fields)
    {



        $event = new adminEventModel();

        $i = 0;
        $columns = array(
            array('db' => 'Event_id', 'dt' => $i++),
            array('db' => 'category_id', 'dt' => $i++),
            array('db' => 'event_name_fa',   'dt' => $i++),
            array('db' => 'event_name_en', 'dt' => $i++),
            array('db' => 'event_phone', 'dt' => $i++),
            array('db' => 'city_id', 'dt' => $i++),
            array('db' => 'event_time', 'dt' => $i++),
            //array( 'db' => 'event_date', 'dt' => $i++ ),
            array('db' => 'event_time2', 'dt' => $i++),
            //array( 'db' => 'event_date2', 'dt' => $i++ ),
            array('db' => 'event_time3', 'dt' => $i++),
            //array( 'db' => 'event_date3', 'dt' => $i++ ),
            array('db' => 'status', 'dt' => $i++),
            array('db' => 'address_fa', 'dt' => $i++),
            array('db' => 'address_en', 'dt' => $i++),
            array('db' => 'logo', 'dt' => $i++),
            array('db' => 'Event_id', 'dt' => $i++)
        );
        $convert = new convertDatatableIO();
        $convert->input = $fields;
        $convert->columns = $columns;


        $searchFields = $convert->convertInput();

        //$date = date('Y-m-d', strtotime(COMPANY_EXPIRE_PERIOD));
        // print_r_debug($date);
        //$searchFields['where'] = 'where refresh_date < '."'$date'";
        //print_r_debug($searchFields);

        $result = $event->getEventDraft($searchFields);

        if ($result['result'] != '1') {
            $this->fileName = 'admin.event.showList.php';
            $this->template('', $result['msg']);
            die();
        }

        $list['list'] = $event->list;
        $list['paging'] = $event->recordsCount;
        /*$other['2']=array(
            'formatter' =>function($list)
            {
                $st='<div data-event_id="'.$list['Event_id'].'" class="event_phone">'.$list['phone_number'].'</div>';
                return $st;
            }
        );*/
        $other['6'] = array(
            'formatter' => function ($list) {
                $st =  $list['event_time'] . '<br>' . ($list['date'] != '0000-00-00' ? convertDate($list['date']) : '');
                return $st;
            }
        );
        $other['7'] = array(
            'formatter' => function ($list) {
                $st =  $list['event_time2'] . '<br>' . ($list['date2'] != '0000-00-00' ? convertDate($list['date2']) : '');
                return $st;
            }
        );
        $other['8'] = array(
            'formatter' => function ($list) {
                $st =  $list['event_time3'] . '<br>' . ($list['date3'] != '0000-00-00' ? convertDate($list['date3']) : '');
                return $st;
            }
        );
        $other['9'] = array(
            'formatter' => function ($list) {
                if ($list['status'] == 1) {
                    $st = 'فعال';
                } else {
                    $st = 'غیر فعال';
                }
                return $st;
            }
        );
        $other['5'] = array(
            'formatter' => function ($list) {
                // include_once ROOT_DIR . "component/province/admin/model/admin.province.model.php";
                $city = adminProvinceModel::find($list['city_id']);

                global $lang;
                return $city->fields["name_$lang"];
            }
        );
        $other['12'] = array(
            'formatter' => function ($list) {
                $st = "<img height='50' src='" . RELA_DIR . 'statics/event/' . $list['logo'] . "'>";

                return $st;
            }
        );
        $internalVariable['showstatus'] = $fields['status'];
        $other[$i - 1] = array(
            'formatter' => function ($list, $internal) {

                $st = '<a href="' . RELA_DIR . 'zamin/?component=event&action=editDraft&id=' . $list['Event_id'] . '&showStatus=' . $internal['showstatus']
                    . '">ویرایش</a> <br/>
                        <a href="' . RELA_DIR . 'zamin/?component=event&action=deleteDraft&id=' . $list['Event_id'] . $list['event_name'] . '">حذف</a>';
                return $st;
            }
        );

        $export = $convert->convertOutput($list, $columns, $other, $internalVariable);
        echo json_encode($export);
        die();
    }

    public function searchGallery($fields)
    {

        // include_once(ROOT_DIR . 'component/event_gallery/admin/model/admin.event_gallery.model.php');
        //print_r_debug($fields);
        $event = new adminEvent_galleryModel();

        $i = 0;
        $columns = array(
            array('db' => 'Event_gallery_id', 'dt' => $i++),
            array('db' => 'event_id', 'dt' => $i++),
            array('db' => 'image', 'dt' => $i++),
            array('db' => 'Event_gallery_id', 'dt' => $i++)
        );
        $convert = new convertDatatableIO();
        $convert->input = $fields;
        $convert->columns = $columns;
        $searchFields = $convert->convertInput();


        $searchFields['where'] = ' event_id= ' . $fields['event_id'] . ' ';
        $result = $event->getByFilter($searchFields);

        //$result = $event->getEvent($searchFields);

        if ($result['result'] != '1') {
            $this->fileName = 'admin.event.showList.php';
            $this->template('', $result['msg']);
            die();
        }

        $list['list'] = $result['export']['list'];
        $list['paging'] = $result['export']['recordsCount'];
        /*$other['2']=array(
            'formatter' =>function($list)
            {
                $st='<div data-event_id="'.$list['Event_id'].'" class="event_phone">'.$list['phone_number'].'</div>';
                return $st;
            }
        );*/
        $other['1'] = array(
            'formatter' => function ($list) {
                global $lang;
                $obj = adminEventModel::find($list['event_id']);
                $st = $obj->fields["event_name_$lang"];

                return $st;
            }
        );
        $other['2'] = array(
            'formatter' => function ($list) {
                $st = "<img height='50' src='" . RELA_DIR . 'statics/event/' . $list['image'] . "'>";

                return $st;
            }
        );
        $other['4'] = array(
            'formatter' => function ($list) {
                if ($list['status'] == 1) {
                    $st = 'فعال';
                } else {
                    $st = 'غیر فعال';
                }
                return $st;
            }
        );


        $internalVariable['showstatus'] = $fields['status'];
        $other[$i - 1] = array(
            'formatter' => function ($list, $internal) {

                $st = '<a href="' . RELA_DIR . 'zamin/?component=event&action=deleteGallery&id=' . $list['Event_gallery_id'] . $list['event_name'] . '">حذف</a>';
                return $st;
            }
        );

        $export = $convert->convertOutput($list, $columns, $other, $internalVariable);
        echo json_encode($export);
        die();
    }

    /**
     * @param $fields
     *
     * @return mixed
     *
     * @author malekloo
     * @date 3/6/2015
     *
     * @version 01.01.01
     */
    public function searchExpire($fields)
    {
        /*echo '<pre/>';
        print_r($fields);
        die();*/

        $event = new adminEventModel();

        $i = 0;
        $columns = array(
            array('db' => 'Event_id', 'dt' => $i++),
            array('db' => 'event_name', 'dt' => $i++),
            array('db' => 'phone_number', 'dt' => $i++),
            array('db' => 'refresh_date',   'dt' => $i++),
            array('db' => 'address_address', 'dt' => $i++),
            array('db' => 'email_email', 'dt' => $i++),
            array('db' => 'website_url', 'dt' => $i++),
            array('db' => 'status', 'dt' => $i++),
            array('db' => 'Event_id', 'dt' => $i++)
        );
        $convert = new convertDatatableIO();
        $convert->input = $fields;
        $convert->columns = $columns;
        $searchFields = $convert->convertInput();

        $date = date('Y-m-d', strtotime(COMPANY_EXPIRE_PERIOD));
        // print_r_debug($date);
        $searchFields['where'] = 'where refresh_date < ' . "'$date'";
        //print_r_debug($searchFields);

        $result = $event->getEvent($searchFields);
        if ($result['result'] != '1') {
            $this->fileName = 'admin.event.showList.php';
            $this->template('', $result['msg']);
            die();
        }
        $list['list'] = $event->list;
        $list['paging'] = $event->recordsCount;

        $other['2'] = array(
            'formatter' => function ($list) {
                $st = '<div data-event_id="' . $list['Event_id'] . '" class="event_phone">' . $list['phone_number'] . '</div>';

                return $st;
            }

        );

        $other['3'] = array(
            'formatter' => function ($list) {
                $st = convertDate($list['refresh_date']);
                return $st;
            }
        );
        $other['4'] = array(
            'formatter' => function ($list) {
                $st = convertDate(date('Y-m-d', strtotime(COMPANY_EXPIRE_PERIOD, strtotime($list['refresh_date']))));
                return $st;
            }
        );
        $other['7'] = array(
            'formatter' => function ($list) {
                if ($list['status'] == 1) {
                    $st = 'فعال';
                } else {
                    $st = 'غیر فعال';
                }
                return $st;
            }
        );

        $internalVariable['showstatus'] = $fields['status'];
        $other[$i - 1] = array(
            'formatter' => function ($list, $internal) {
                $st = 'a' . $list['showstatus'];
                $st = '<a href="' . RELA_DIR . 'zamin/?component=event&action=edit&id=' . $list['Event_id'] . '&showStatus=' . $internal['showstatus']
                    . '">ویرایش</a> <br/>
                        <a href="' . RELA_DIR . 'zamin/?component=product&id=' . $list['Event_id'] . '">لیست محصولات</a><br/>
                        <a href="' . RELA_DIR . 'zamin/?component=honour&id=' . $list['Event_id'] . '">لیست افتخارات</a><br/>
                        <a href="' . RELA_DIR . 'zamin/?component=licence&id=' . $list['Event_id'] . '">لیست مجوز ها</a><br/>
                        <a href="' . RELA_DIR . 'zamin/?component=event&action=delete&id=' . $list['Event_id'] . $list['event_name'] . '">حذف</a>';
                return $st;
            }
        );
        $export = $convert->convertOutput($list, $columns, $other, $internalVariable);
        echo json_encode($export);
        die();
    }

    /**
     * @param $fields
     *
     * @return mixed
     *
     * @author malekloo
     * @date 3/6/2015
     *
     * @version 01.01.01
     */
    public function searchUnverified($fields)
    {
        /*echo '<pre/>';
        print_r($fields);
        die();*/

        $event = new adminEventModel();

        $i = 0;
        $columns = array(
            array('db' => 'Event_id', 'dt' => $i++),
            array('db' => 'event_name', 'dt' => $i++),
            array('db' => 'phone_number', 'dt' => $i++),
            array('db' => 'city_name',   'dt' => $i++),
            array('db' => 'address_address', 'dt' => $i++),
            array('db' => 'email_email', 'dt' => $i++),
            array('db' => 'website_url', 'dt' => $i++),
            array('db' => 'status', 'dt' => $i++),
            array('db' => 'logo', 'dt' => $i++),
            array('db' => 'Event_id', 'dt' => $i++)
        );
        $convert = new convertDatatableIO();
        $convert->input = $fields;
        $convert->columns = $columns;
        $searchFields = $convert->convertInput();

        //$date = date('Y-m-d', strtotime(COMPANY_EXPIRE_PERIOD));
        // print_r_debug($date);
        //$searchFields['where'] = 'where refresh_date < '."'$date'";
        //print_r_debug($searchFields);
        $searchFields['where'] = " WHERE  status = '0' ";
        $result = $event->getEvent($searchFields);
        if ($result['result'] != '1') {
            $this->fileName = 'admin.event.showList.php';
            $this->template('', $result['msg']);
            die();
        }
        $list['list'] = $event->list;
        $list['paging'] = $event->recordsCount;

        $other['2'] = array(
            'formatter' => function ($list) {
                $st = '<div data-event_id="' . $list['Event_id'] . '" class="event_phone">' . $list['phone_number'] . '</div>';
                return $st;
            }
        );

        $other['7'] = array(
            'formatter' => function ($list) {
                if ($list['status'] == 1) {
                    $st = 'فعال';
                } else {
                    $st = 'غیر فعال';
                }
                return $st;
            }
        );
        $internalVariable['showstatus'] = $fields['status'];
        $other[$i - 1] = array(
            'formatter' => function ($list, $internal) {
                $st = 'a' . $list['showstatus'];
                $st = '<a href="' . RELA_DIR . 'zamin/?component=event&action=edit&id=' . $list['Event_id'] . '&showStatus=' . $internal['showstatus']
                    . '">ویرایش</a> <br/>
                        <a href="' . RELA_DIR . 'zamin/?component=product&id=' . $list['Event_id'] . '">لیست محصولات</a><br/>
                        <a href="' . RELA_DIR . 'zamin/?component=honour&id=' . $list['Event_id'] . '">لیست افتخارات</a><br/>
                        <a href="' . RELA_DIR . 'zamin/?component=licence&id=' . $list['Event_id'] . '">لیست مجوز ها</a><br/>
                        <a href="' . RELA_DIR . 'zamin/?component=event&action=delete&id=' . $list['Event_id'] . $list['event_name'] . '">حذف</a>';
                return $st;
            }
        );
        $export = $convert->convertOutput($list, $columns, $other, $internalVariable);
        //print_r_debug($export);
        echo json_encode($export);
        die();
    }

    /**
     * @param $fields
     *
     * @return mixed
     *
     * @author malekloo
     * @date 3/6/2015
     *
     * @version 01.01.01
     */
    public function showExpiredList($msg)
    {

        $export['status'] = 'expired';
        $this->fileName = 'admin.event.showExpireList.php';
        $this->template($export);
        die();
    }

    /**
     * @param $fields
     *
     * @return mixed
     *
     * @author malekloo
     * @date 3/6/2015
     *
     * @version 01.01.01
     */
    public function showUnverifiedList($msg)
    {

        $export['status'] = 'unverified';
        $this->fileName = 'admin.event.showUnverifiedList.php';
        $this->template($export);
        die();
    }
    /**
     * importCompanies.
     *
     * @return redirectPage
     */
    public function updateCity()
    {

        $cityList = adminCityModelDb::getAll()['export']['list'];

        foreach ($cityList as $key => $fields) {

            $province_id = $fields['province_id'];

            echo $province_id;

            $conn = dbConn::getConnection();

            $sql = "
                UPDATE event
                  SET
                    `state_id`             =   '" . $fields['province_id'] . "'
                    WHERE city_id = '" . $fields['City_id'] . "'
                    ";

            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);

            if (!$stmt) {
                $result['result'] = -1;
                $result['Number'] = 1;
                $result['msg'] = $conn->errorInfo();
                return $result;
            }





            //print_r_debug($fields);
            $city_id = $fields['City_id'];
            $province_id = $fields['province_id'];
            echo $province_id;
            //echo '<br/>';
            //echo '<br/>$city_id<br/>';
            //echo $city_id;

        }
        die();
        //print_r_debug($cityList);




    }
   

   

    public function deleteEvent($id)
    {

        if (!validators::required($id) and !validators::Numeric($id)) {
            $msg = 'یافت نشد';
            redirectPage(RELA_DIR . 'zamin/index.php?component=event', $msg);
        }

        $event = adminEventModel::find($id);
        if (!is_object($event)) {
            $msg = $event['msg'];
            redirectPage(RELA_DIR . 'zamin/index.php?component=event', $msg);
        }


        $result = adminEvent_galleryModel::getBy_event_id($id)->get();


        if ($result['export']['recordsCount'] > 0) {
            $msg = 'توجه : ابتدا گالری این رویداد را حذف نمایید.';
            redirectPage(RELA_DIR . 'zamin/index.php?component=event', $msg);
        }

        $dir = ROOT_DIR . 'statics/event/';
        fileRemover($dir, $event->fields['logo']);

        $result = $event->delete();

        if ($result['result'] != '1') {
            redirectPage(RELA_DIR . 'zamin/index.php?component=event');
        }

        $msg = 'عملیات با موفقیت انجام شد';
        redirectPage(RELA_DIR . 'zamin/index.php?component=event', $msg);
        die();
    }
    public function deleteEventDraft($id)
    {

        if (!validators::required($id) and !validators::Numeric($id)) {
            $msg = 'یافت نشد';
            redirectPage(RELA_DIR . 'zamin/index.php?component=event&action=draft', $msg);
        }

        $event = adminEventDraftModel::find($id);
        if (!is_object($event)) {
            $msg = $event['msg'];
            redirectPage(RELA_DIR . 'zamin/index.php?component=event&action=draft', $msg);
        }


        $result = $event->delete();

        if ($result['result'] != '1') {
            redirectPage(RELA_DIR . 'zamin/index.php?component=event&action=draft');
        }

        $msg = 'عملیات با موفقیت انجام شد';
        redirectPage(RELA_DIR . 'zamin/index.php?component=event&action=draft', $msg);
        die();
    }

    public function deleteGallery($id)
    {

        if (!validators::required($id) and !validators::Numeric($id)) {
            $msg = 'یافت نشد';
            redirectPage(RELA_DIR . 'zamin/index.php?component=event', $msg);
        }

        $event = adminEvent_galleryModel::find($id);

        if (!is_object($event)) {
            $msg = $event['msg'];
            redirectPage(RELA_DIR . 'zamin/index.php?component=event&action=gallery&id=' . $event->fields['event_id'], $msg);
        }

        $dir = ROOT_DIR . 'statics/event/';
        fileRemover($dir, $event->fields['image']);

        $result = $event->delete();

        if ($result['result'] != '1') {
            redirectPage(RELA_DIR . 'zamin/index.php?component=event&action=gallery&id=' . $event->fields['event_id']);
        }

        $msg = 'عملیات با موفقیت انجام شد';
        redirectPage(RELA_DIR . 'zamin/index.php?component=event&action=gallery&id=' . $event->fields['event_id'], $msg);
        die();
    }
    public function call($fields)
    {
        include_once dirname(__FILE__) . '/php-ami-class.php';
        $conn = new AstMan();
        $ret = $conn->clickToCall($fields['number']);
        die();
    }

    public function getEventphone($input)
    {
        $event_id =   $input['event_id'];
        $model = new adminEventModel();
        $result = $model->getEventphoneAll($event_id);
        $phone = '';
        foreach ($result['export']['list'] as $key => $value) {
            $phone .= '<h4><a class="btn btn-default event_allphone label label-default" href="#" role="button" data-myphonenumber="' . $value . '" data-myeventid="' . $event_id . '"><span class="glyphicon glyphicon-phone-alt"></span></a><span>' . $value . '</span></h4>';
        }
        echo $phone;
        //print_r_debug($result );
        //json_encode($result);
        die();
    }

    public function getCityAjax($input)
    {
        $province_id = $input['province_id'];
        $model = new adminCityModel();
        $result = $model->getCitiesByprovinceID($province_id);

        $option = '';
        foreach ($result['export']['list'] as $key => $value) {
            $option .= "<option>" . $value['name'] . "</option>";
        }
        echo $option;

        die();
    }
}
