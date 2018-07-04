<?php
/**
 * Created by PhpStorm.
 * User: malekloo
 * Date: 3/6/2016
 * Time: 11:21 AM.
 */
include_once dirname(__FILE__).'/admin.event.model.php';

/**
 * Class registerController.
 */
class adminEventController
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
     * registerController constructor.
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
        global $messageStack,$admin_info,$lang;

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


    public function addEvent($_input)
    {
        global $messageStack;



        $event = new adminEventModel();

        $_input['date'] = ($_input['date']!=''?convertJToGDate($_input['date']):'0000-00-00');
        $_input['date2'] = ($_input['date2']!=''?convertJToGDate($_input['date2']):'0000-00-00');
        $_input['date3'] = ($_input['date3']!=''?convertJToGDate($_input['date3']):'0000-00-00');
        $_input['category_id'] = ','.implode(',',$_input['category_id'] ).',';
        $_input['salon_id'] = ','.implode(',',$_input['salon_id'] ).',';

        $result = $event->setFields($_input);

        if ($result['result'] == -1) {
            $this->showEventAddForm($_input, $result['msg']);
        }
        $event->save();


        if(file_exists($_FILES['logo']['tmp_name'])){

            $input['upload_dir'] = ROOT_DIR.'statics/event/';
            $result = fileUploader($input,$_FILES['logo']);
            //fileRemover($input['upload_dir'],$product->fields['image']);
            $event->logo = $result['image_name'];
            $result = $event->save();
        }


        //$result = $event->addEvent();

        if ($result['result'] != '1') {
            $messageStack->add_session('register', $result['msg']);
            $this->showEventAddForm($_input, $result['msg']);
        }
        $msg = 'ثبت نام با موفقیت انجام شد.';
        $messageStack->add_session('register', $msg);

        redirectPage(RELA_DIR.'zamin/?component=event', $msg);
        die();
    }


    public function showEventAddForm($fields, $msg)
    {
        /** category */
        include_once ROOT_DIR.'component/category/admin/model/admin.category.model.php';
        $category = new adminCategoryModel();

        $resultCategory = $category->getCategoryOption();
        if ($resultCategory['result'] == 1) {
            $fields['category'] = $category->list;
        }

        /** genre */
        include_once ROOT_DIR.'component/genre/admin/model/admin.genre.model.php';
        $genre = new adminGenreModel();

        $resultGenre = $genre->getGenreOption();
        if ($resultGenre['result'] == 1) {
            $fields['genre'] = $genre->list;
        }

        include_once ROOT_DIR.'component/salon/admin/model/admin.salon.model.php';
        $salon = new adminSAlonModel();

        $resultSalon = $salon->getSalonOption();
        if ($resultSalon['result'] == 1) {
            $fields['salon'] = $salon->list;
        }

        include_once ROOT_DIR.'component/city/admin/model/admin.city.model.php';
        $city = new adminCityModel();
        $resultCity = $city->getCities();
        if ($resultCity['result'] == 1) {
            $fields['cities'] = $city->list;
        }

        include_once ROOT_DIR.'component/state/admin/model/admin.state.model.php';
        $province = new adminStateModel();
        $resultProvince = $province->getStates();
        if ($resultProvince['result'] == 1) {
            $fields['provinces'] = $province->list;
        }

        include_once ROOT_DIR.'component/certification/admin/model/admin.certification.model.php';
        $certification = new adminCertificationModel();

        $resultCertification = $certification->getCertification();
        if ($resultCity['result'] == 1) {
            $fields['certifications'] = $certification->list;
        }

        $this->fileName = 'admin.event.addForm.php';
        $this->template($fields, $msg);
        die();
    }

    public function addGallery($_input)
    {
        global $messageStack;

        include_once ROOT_DIR.'component/event_gallery/admin/model/admin.event_gallery.model.php';
        $event = new adminEvent_galleryModel();

        $result = $event->setFields($_input);

        if ($result['result'] == -1) {
            $this->showEventAddForm($_input, $result['msg']);
        }
        $event->save();



        if(file_exists($_FILES['image']['tmp_name'])){

            $input['upload_dir'] = ROOT_DIR.'statics/event/';
            $result = fileUploader($input,$_FILES['image']);

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

        redirectPage(RELA_DIR.'zamin/?component=event&action=gallery&id='.$_input['event_id'], $msg);
        die();
    }

    public function showGalleryAddForm($fields, $msg)
    {

        $this->fileName = 'admin.gallery.addForm.php';
        $this->template($fields, $msg);
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


        //$event = new adminEventModel();
        $event = adminEventModel::find($fields['Event_id']);
        //$result = $event->getEventById($fields['Event_id']);

        $fields['date'] = ($fields['date']!=''?convertJToGDate($fields['date']):'0000-00-00');
        $fields['date2'] = ($fields['date2']!=''?convertJToGDate($fields['date2']):'0000-00-00');
        $fields['date3'] = ($fields['date3']!=''?convertJToGDate($fields['date3']):'0000-00-00');
        $fields['category_id'] = ",".(implode(",",$fields['category_id'])).",";
        $fields['genre_id'] = ",".(implode(",",$fields['genre_id'])).",";
        $fields['salon_id'] = ",".(implode(",",$fields['salon_id'])).",";


        $result = $event->setFields($fields);
        $event->update_date = date('Y-m-d H:i:s');

        $result=$event->save();
//        print_r_debug($event);

        $fields=$event->fields;
        if($result['result']!='1')
        {
            $this->showEventEditForm($fields, $result['msg']);
        }


        if(file_exists($_FILES['logo']['tmp_name'])){

            $input['upload_dir'] = ROOT_DIR.'statics/event/';
            $result = fileUploader($input,$_FILES['logo']);

            fileRemover($input['upload_dir'],$event->fields['logo']);
            $event->logo = $result['image_name'];

            $result = $event->save();
        }



        $msg = 'عملیات با موفقیت انجام شد';
        redirectPage(RELA_DIR.'zamin/index.php?component=event', $msg);
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
    public function showEventEditForm($fields, $msg)
    {
        $showStatus=$fields['showStatus'];
        if (strtoupper($_SERVER['REQUEST_METHOD']) != 'POST') {
            $event = new adminEventModel();
            $result = $event->getEventById($fields['Event_id']);
            if ($result['result'] != '1') {
                $msg = $result['msg'];
                redirectPage(RELA_DIR.'zamin/index.php?component=event', $msg);
            }
            $export = $event->fields;
        } else {
            $export = $fields;
        }

        /** category */
        include_once ROOT_DIR.'component/category/admin/model/admin.category.model.php';
        $category = new adminCategoryModel();

        $resultCategory = $category->getCategoryOption();

        if ($resultCategory['result'] == 1) {
            $export['category'] = $category->list;
        }
        /** genre */
        include_once ROOT_DIR.'component/genre/admin/model/admin.genre.model.php';
        $genre = new adminGenreModel();

        $resultGenre = $genre->getGenreOption();

        if ($resultGenre['result'] == 1) {
            $export['genre'] = $genre->list;
        }

        include_once ROOT_DIR.'component/salon/admin/model/admin.salon.model.php';
        $salon = new adminSAlonModel();

        $resultSalon = $salon->getSalonOption();
        if ($resultSalon['result'] == 1) {
            $export['salon'] = $salon->list;
        }
        include_once ROOT_DIR.'component/province/admin/model/admin.province.model.php';
        //$city = new adminCityModel();
        $province = adminProvinceModel::getAll()->getList();

        //$resultCity = $city->getCities();
        if ($province['result'] == 1) {
            $export['provinces'] = $province['export']['list'];
        }

        /*include_once ROOT_DIR.'component/state/admin/model/admin.state.model.php';
        $state = new adminStateModel();
        $resultState = $state->getStates();
        if ($resultState['result'] == 1) {
            $export['states'] = $state->list;
        }*/


        $export['showStatus']=$showStatus;
        $this->fileName = 'admin.event.editForm.php';
        $this->template($export, $msg);
        die();
    }



    public function showList($msg)
    {
        $export['status']='showAll';
        $this->fileName = 'admin.event.showList.php';
        $this->template($export);
        die();
    }


    public function showListGallery($msg)
    {
        $export['status']='showAll';
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

        include_once(ROOT_DIR . "model/datatable.converter.php");
        $i=0;
        $columns = array(
            array( 'db' => 'Event_id', 'dt' =>$i++),
            array( 'db' => 'category_id', 'dt' =>$i++),
            array( 'db' => 'event_name_fa',   'dt' => $i++),
            array( 'db' => 'event_name_en', 'dt' => $i++ ),
            array( 'db' => 'event_phone', 'dt' => $i++ ),
            array( 'db' => 'city_id', 'dt' => $i++ ),
            array( 'db' => 'event_time', 'dt' => $i++ ),
            //array( 'db' => 'event_date', 'dt' => $i++ ),
            array( 'db' => 'event_time2', 'dt' => $i++ ),
            //array( 'db' => 'event_date2', 'dt' => $i++ ),
            array( 'db' => 'event_time3', 'dt' => $i++ ),
            //array( 'db' => 'event_date3', 'dt' => $i++ ),
            array( 'db' => 'status', 'dt' => $i++ ),
            array( 'db' => 'address_fa', 'dt' => $i++ ),
            array( 'db' => 'address_en', 'dt' => $i++ ),
            array( 'db' => 'logo', 'dt' => $i++ ),
            array( 'db' => 'Event_id', 'dt' => $i++ )
        );
        $convert=new convertDatatableIO();
        $convert->input=$fields;
        $convert->columns=$columns;


        $searchFields= $convert->convertInput();

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

        $list['list']=$event->list;
        $list['paging']=$event->recordsCount;
        /*$other['2']=array(
            'formatter' =>function($list)
            {
                $st='<div data-event_id="'.$list['Event_id'].'" class="event_phone">'.$list['phone_number'].'</div>';
                return $st;
            }
        );*/
        $other['6']=array(
            'formatter' =>function($list)
            {
                $st =  $list['event_time'] .'<br>'.($list['date']!='0000-00-00'?convertDate($list['date']):'');
                return $st;
            }
        );
        $other['7']=array(
            'formatter' =>function($list)
            {
                $st =  $list['event_time2'] .'<br>'. ($list['date2']!='0000-00-00'?convertDate($list['date2']):'');
                return $st;
            }
        );
        $other['8']=array(
            'formatter' =>function($list)
            {
                $st =  $list['event_time3'] .'<br>'.($list['date3']!='0000-00-00'?convertDate($list['date3']):'');
                return $st;
            }
        );
        $other['9']=array(
            'formatter' =>function($list)
            {
                if($list['status']==1) {
                    $st ='فعال';
                }else {
                    $st ='غیر فعال';
                }
                return $st;
            }
        );
        $other['5']=array(
            'formatter' =>function($list)
            {
                include_once ROOT_DIR."component/province/admin/model/admin.province.model.php";
                $city = adminProvinceModel::find($list['city_id']);

                global $lang;
                return $city->fields["name_$lang"];
            }
        );
        $other['12']=array(
            'formatter' =>function($list)
            {
                $st = "<img height='50' src='".RELA_DIR.'statics/event/'.$list['logo']."'>";

                return $st;
            }
        );
        $internalVariable['showstatus']=$fields['status'];
        $other[$i-1]=array(
            formatter =>function($list,$internal)
            {

                $st='<a href="'. RELA_DIR.'zamin/?component=event&action=edit&id='.$list['Event_id'].'&showStatus='.$internal['showstatus']
                    .'">ویرایش</a> <br/>
                        <a href="'.RELA_DIR.'zamin/?component=event&action=gallery&id='.$list['Event_id'].'">تصاویر</a><br/>
                        <a href="'.RELA_DIR.'zamin/?component=event&action=delete&id='.$list['Event_id'].$list['event_name'].'">حذف</a>';
                return $st;
            }
        );

        $export= $convert->convertOutput($list,$columns,$other,$internalVariable);
        echo json_encode($export);
        die();
    }

    public function searchGallery($fields)
    {

        include_once (ROOT_DIR.'component/event_gallery/admin/model/admin.event_gallery.model.php');
        //print_r_debug($fields);
        $event = new adminEvent_galleryModel();

        include_once(ROOT_DIR . "model/datatable.converter.php");
        $i=0;
        $columns = array(
            array( 'db' => 'Event_gallery_id', 'dt' =>$i++),
            array( 'db' => 'event_id', 'dt' =>$i++),
            array( 'db' => 'image', 'dt' => $i++ ),
            array( 'db' => 'Event_gallery_id', 'dt' => $i++ )
        );
        $convert=new convertDatatableIO();
        $convert->input=$fields;
        $convert->columns=$columns;
        $searchFields= $convert->convertInput();


        $searchFields['where']=' event_id= '. $fields['event_id'] .' ' ;
        $result=$event->getByFilter($searchFields);

        //$result = $event->getEvent($searchFields);

        if ($result['result'] != '1') {
            $this->fileName = 'admin.event.showList.php';
            $this->template('', $result['msg']);
            die();
        }

        $list['list']=$result['export']['list'];
        $list['paging']=$result['export']['recordsCount'];
        /*$other['2']=array(
            'formatter' =>function($list)
            {
                $st='<div data-event_id="'.$list['Event_id'].'" class="event_phone">'.$list['phone_number'].'</div>';
                return $st;
            }
        );*/
        $other['1']=array(
            'formatter' =>function($list)
            {
                global $lang;
                $obj = adminEventModel::find($list['event_id']);
                $st = $obj->fields["event_name_$lang"];

                return $st;
            }
        );
        $other['2']=array(
            'formatter' =>function($list)
            {
                $st = "<img height='50' src='".RELA_DIR.'statics/event/'.$list['image']."'>";

                return $st;
            }
        );
        $other['4']=array(
            'formatter' =>function($list)
            {
                if($list['status']==1) {
                    $st ='فعال';
                }else {
                    $st ='غیر فعال';
                }
                return $st;
            }
        );


        $internalVariable['showstatus']=$fields['status'];
        $other[$i-1]=array(
            'formatter' =>function($list,$internal)
            {

                $st='<a href="'.RELA_DIR.'zamin/?component=event&action=deleteGallery&id='.$list['Event_gallery_id'].$list['event_name'].'">حذف</a>';
                return $st;
            }
        );

        $export= $convert->convertOutput($list,$columns,$other,$internalVariable);
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

        include_once(ROOT_DIR . "model/datatable.converter.php");
        $i=0;
        $columns = array(
            array( 'db' => 'Event_id', 'dt' =>$i++),
            array( 'db' => 'event_name', 'dt' =>$i++),
            array( 'db' => 'phone_number', 'dt' =>$i++),
            array( 'db' => 'refresh_date',   'dt' => $i++),
            array( 'db' => 'address_address', 'dt' => $i++ ),
            array( 'db' => 'email_email', 'dt' => $i++ ),
            array( 'db' => 'website_url', 'dt' => $i++ ),
            array( 'db' => 'status', 'dt' => $i++ ),
            array( 'db' => 'Event_id', 'dt' => $i++ )
        );
        $convert=new convertDatatableIO();
        $convert->input=$fields;
        $convert->columns=$columns;
        $searchFields= $convert->convertInput();

        $date = date('Y-m-d', strtotime(COMPANY_EXPIRE_PERIOD));
        // print_r_debug($date);
        $searchFields['where'] = 'where refresh_date < '."'$date'";
        //print_r_debug($searchFields);

        $result = $event->getEvent($searchFields);
        if ($result['result'] != '1') {
            $this->fileName = 'admin.event.showList.php';
            $this->template('', $result['msg']);
            die();
        }
        $list['list']=$event->list;
        $list['paging']=$event->recordsCount;

        $other['2']=array(
            'formatter' =>function($list)
            {
                $st='<div data-event_id="'.$list['Event_id'].'" class="event_phone">'.$list['phone_number'].'</div>';

                return $st;
            }

        );

        $other['3']=array(
            'formatter' =>function($list)
            {
                $st= convertDate($list['refresh_date']);
                return $st;
            }
        );
        $other['4']=array(
            'formatter' =>function($list)
            {
                $st=convertDate(date('Y-m-d',strtotime(COMPANY_EXPIRE_PERIOD,strtotime($list['refresh_date'])))) ;
                return $st;
            }
        );
        $other['7']=array(
            'formatter' =>function($list)
            {
                if($list['status']==1) {
                    $st ='فعال';
                }else {
                    $st ='غیر فعال';
                }
                return $st;
            }
        );

        $internalVariable['showstatus']=$fields['status'];
        $other[$i-1]=array(
            formatter =>function($list,$internal)
            {
                $st= 'a'.$list['showstatus'];
                $st='<a href="'. RELA_DIR.'zamin/?component=event&action=edit&id='.$list['Event_id'].'&showStatus='.$internal['showstatus']
                    .'">ویرایش</a> <br/>
                        <a href="'.RELA_DIR.'zamin/?component=product&id='.$list['Event_id'].'">لیست محصولات</a><br/>
                        <a href="'.RELA_DIR.'zamin/?component=honour&id='.$list['Event_id'].'">لیست افتخارات</a><br/>
                        <a href="'.RELA_DIR.'zamin/?component=licence&id='.$list['Event_id'].'">لیست مجوز ها</a><br/>
                        <a href="'.RELA_DIR.'zamin/?component=event&action=delete&id='.$list['Event_id'].$list['event_name'].'">حذف</a>';
                return $st;
            }
        );
        $export= $convert->convertOutput($list,$columns,$other,$internalVariable);
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

        include_once(ROOT_DIR . "model/datatable.converter.php");
        $i=0;
        $columns = array(
            array( 'db' => 'Event_id', 'dt' =>$i++),
            array( 'db' => 'event_name', 'dt' =>$i++),
            array( 'db' => 'phone_number', 'dt' =>$i++),
            array( 'db' => 'city_name',   'dt' => $i++),
            array( 'db' => 'address_address', 'dt' => $i++ ),
            array( 'db' => 'email_email', 'dt' => $i++ ),
            array( 'db' => 'website_url', 'dt' => $i++ ),
            array( 'db' => 'status', 'dt' => $i++ ),
            array( 'db' => 'logo', 'dt' => $i++ ),
            array( 'db' => 'Event_id', 'dt' => $i++ )
        );
        $convert=new convertDatatableIO();
        $convert->input=$fields;
        $convert->columns=$columns;
        $searchFields= $convert->convertInput();

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
        $list['list']=$event->list;
        $list['paging']=$event->recordsCount;

        $other['2']=array(
            'formatter' =>function($list)
            {
                $st='<div data-event_id="'.$list['Event_id'].'" class="event_phone">'.$list['phone_number'].'</div>';
                return $st;
            }
        );

        $other['7']=array(
            'formatter' =>function($list)
            {
                if($list['status']==1) {
                    $st ='فعال';
                }else {
                    $st ='غیر فعال';
                }
                return $st;
            }
        );
        $internalVariable['showstatus']=$fields['status'];
        $other[$i-1]=array(
            formatter =>function($list,$internal)
            {
                $st= 'a'.$list['showstatus'];
                $st='<a href="'. RELA_DIR.'zamin/?component=event&action=edit&id='.$list['Event_id'].'&showStatus='.$internal['showstatus']
                    .'">ویرایش</a> <br/>
                        <a href="'.RELA_DIR.'zamin/?component=product&id='.$list['Event_id'].'">لیست محصولات</a><br/>
                        <a href="'.RELA_DIR.'zamin/?component=honour&id='.$list['Event_id'].'">لیست افتخارات</a><br/>
                        <a href="'.RELA_DIR.'zamin/?component=licence&id='.$list['Event_id'].'">لیست مجوز ها</a><br/>
                        <a href="'.RELA_DIR.'zamin/?component=event&action=delete&id='.$list['Event_id'].$list['event_name'].'">حذف</a>';
                return $st;
            }
        );
        $export= $convert->convertOutput($list,$columns,$other,$internalVariable);
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
        include_once ROOT_DIR.'component/city/admin/model/admin.city.model.db.php';

        $cityList = adminCityModelDb::getAll()['export']['list'];

        foreach ($cityList as $key=>$fields)
        {

            $province_id= $fields['province_id'];

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

            if (!$stmt)
            {
                $result['result'] = -1;
                $result['Number'] = 1;
                $result['msg'] = $conn->errorInfo();
                return $result;
            }





            //print_r_debug($fields);
            $city_id= $fields['City_id'];
            $province_id= $fields['province_id'];
            echo $province_id;
            //echo '<br/>';
            //echo '<br/>$city_id<br/>';
            //echo $city_id;

        }
        die();
        //print_r_debug($cityList);




    }
    /**
     * importCompanies.
     *
     * @return redirectPage
     */
    public function importCompanies()
    {
        include_once dirname(__FILE__).'/admin.event.model.db.php';
        include_once ROOT_DIR.'component/city/admin/model/admin.city.model.db.php';
        $xml = (STATIC_ROOT_DIR.'/xml/companies.xml');
        $xmlDoc = new DOMDocument();
        $xmlDoc->load($xml);
        $wb = $xmlDoc->getElementsByTagName('Workbook')->item(0);

        $ws = $wb->getElementsByTagName('Worksheet')->item(0);
        $table = $ws->getElementsByTagName('Table')->item(0);
        $row = $table->getElementsByTagName('Row');
        $i = 1;

        foreach ($row as $rowkey => $rowValue) {
            $fields = array();
            $cell = $rowValue->getElementsByTagName('Cell');
            $fields['Event_id'] = $i;
            $fields['event_name'] = $cell[19]->getElementsByTagName('Data')[0]->nodeValue;
            $fields['meta_description'] = $cell[16]->getElementsByTagName('Data')[0]->nodeValue;
            $fields['description'] = $cell[16]->getElementsByTagName('Data')[0]->nodeValue;

            $g1 = $cell[6]->getElementsByTagName('Data')[0]->nodeValue;
            $g1s = $cell[5]->getElementsByTagName('Data')[0]->nodeValue;
            $g2 = $cell[4]->getElementsByTagName('Data')[0]->nodeValue;
            $g2s = $cell[3]->getElementsByTagName('Data')[0]->nodeValue;
            $g3 = $cell[2]->getElementsByTagName('Data')[0]->nodeValue;
            $g3s = $cell[1]->getElementsByTagName('Data')[0]->nodeValue;
            $fields['category_list'] = '';
            if ($g1 != '{-}') {
                $fieldsArray = explode(',', $fields['category_list']);
                if (!array_search(($g1 * 100), $fieldsArray)) {
                    $fields['category_list'] .= ','.($g1 * 100);
                }
                if (!array_search((($g1 * 100) + $g1s), $fieldsArray)) {
                    $fields['category_list'] .= ','.(($g1 * 100) + $g1s);
                }
            }
            if ($g2 != '{-}') {
                $fieldsArray = explode(',', $fields['category_list']);
                if (!array_search(($g2 * 100), $fieldsArray)) {
                    $fields['category_list'] .= ','.($g2 * 100);
                }
                if (!array_search((($g2 * 100) + $g2s), $fieldsArray)) {
                    $fields['category_list'] .= ','.(($g2 * 100) + $g2s);
                }
            }
            if ($g3 != '{-}') {
                $fieldsArray = explode(',', $fields['category_list']);
                if (!array_search(($g3 * 100), $fieldsArray)) {
                    $fields['category_list'] .= ','.($g3 * 100);
                }
                if (!array_search((($g3 * 100) + $g3s), $fieldsArray)) {
                    $fields['category_list'] .= ','.(($g3 * 100) + $g3s);
                }
            }
            $fields['category_list']=$fields['category_list'].',';
            //print_r_debug($fields['category_list']);

            $city_name = $cell[13]->getElementsByTagName('Data')[0]->nodeValue;
            $city_id = adminCityModelDb::getCityByName($city_name)['City_id'];
            if ($city_id == '') {
                $fieldsCity = array('city_name' => $city_name);
                //$resultInsetCity = adminCityModelDb::insert($fieldsCity);
                //$city_id = $resultInsetCity['export']['insert_id'];
            }
            $fields['city_id'] = $city_id;


            ///$result = adminEventModelDb::insert2($fields);

            // phone 1
            $code = $cell[21]->getElementsByTagName('Data')[0]->nodeValue;
            $number = $cell[22]->getElementsByTagName('Data')[0]->nodeValue;
            $until = $cell[23]->getElementsByTagName('Data')[0]->nodeValue;
            if ($code != '{-}') {
                $fieldsPhone['event_id'] = $i;
                $fieldsPhone['subject'] = 'تلفن 1';
                $fieldsPhone['number'] = $number;
                if ($until != '{-}') {
                    $fieldsPhone['state'] = 'الی';
                    $fieldsPhone['value'] = $until;
                } else {
                    $fieldsPhone['state'] = 'سایر';
                    $fieldsPhone['value'] = '';
                }
                $result = adminEventModelDb::insertToPhones2($fieldsPhone);
            }
            // end phone 1

            // phone 2
            $code = $cell[24]->getElementsByTagName('Data')[0]->nodeValue;
            $number = $cell[25]->getElementsByTagName('Data')[0]->nodeValue;
            $until = $cell[26]->getElementsByTagName('Data')[0]->nodeValue;
            if ($code != '{-}') {
                $fieldsPhone['event_id'] = $i;
                $fieldsPhone['subject'] = 'تلفن 2';
                $fieldsPhone['number'] = $number;
                if ($until != '{-}') {
                    $fieldsPhone['state'] = 'الی';
                    $fieldsPhone['value'] = $until;
                } else {
                    $fieldsPhone['state'] = 'سایر';
                    $fieldsPhone['value'] = '';
                }
                $result = adminEventModelDb::insertToPhones2($fieldsPhone);
            }
            // end phone 2

            // phone 3
            $code = $cell[27]->getElementsByTagName('Data')[0]->nodeValue;
            $number = $cell[28]->getElementsByTagName('Data')[0]->nodeValue;
            $until = $cell[29]->getElementsByTagName('Data')[0]->nodeValue;
            if ($code != '{-}') {
                $fieldsPhone['event_id'] = $i;
                $fieldsPhone['subject'] = 'تلفن 3';
                $fieldsPhone['number'] = $number;
                if ($until != '{-}') {
                    $fieldsPhone['state'] = 'الی';
                    $fieldsPhone['value'] = $until;
                } else {
                    $fieldsPhone['state'] = 'سایر';
                    $fieldsPhone['value'] = '';
                }
                $result = adminEventModelDb::insertToPhones2($fieldsPhone);
            }
            // end phone 3

            // phone 4
            $code = $cell[30]->getElementsByTagName('Data')[0]->nodeValue;
            $number = $cell[31]->getElementsByTagName('Data')[0]->nodeValue;
            $until = $cell[32]->getElementsByTagName('Data')[0]->nodeValue;
            if ($code != '{-}') {
                $fieldsPhone['event_id'] = $i;
                $fieldsPhone['subject'] = 'تلفن 4';
                $fieldsPhone['number'] = $number;
                if ($until != '{-}') {
                    $fieldsPhone['state'] = 'الی';
                    $fieldsPhone['value'] = $until;
                } else {
                    $fieldsPhone['state'] = 'سایر';
                    $fieldsPhone['value'] = '';
                }
                $result = adminEventModelDb::insertToPhones2($fieldsPhone);
            }
            // end phone 4

            // fax 1
            $code = $cell[34]->getElementsByTagName('Data')[0]->nodeValue;
            $number = $cell[35]->getElementsByTagName('Data')[0]->nodeValue;
            $until = $cell[36]->getElementsByTagName('Data')[0]->nodeValue;
            if ($code != '{-}') {
                $fieldsFax['event_id'] = $i;
                $fieldsFax['subject'] = 'فکس 1';
                $fieldsFax['number'] = $number;
                if ($until != '{-}') {
                    $fieldsFax['state'] = 'الی';
                    $fieldsFax['value'] = $until;
                } else {
                    $fieldsFax['state'] = 'سایر';
                    $fieldsFax['value'] = '';
                }
                $result = adminEventModelDb::insertToPhones2($fieldsFax);
            }
            // end fax 1

            // fax 2
            $code = $cell[37]->getElementsByTagName('Data')[0]->nodeValue;
            $number = $cell[38]->getElementsByTagName('Data')[0]->nodeValue;
            $until = $cell[39]->getElementsByTagName('Data')[0]->nodeValue;
            if ($code != '{-}') {
                $fieldsFax['event_id'] = $i;
                $fieldsFax['subject'] = 'فکس 2';
                $fieldsFax['number'] = $number;
                if ($until != '{-}') {
                    $fieldsFax['state'] = 'الی';
                    $fieldsFax['value'] = $until;
                } else {
                    $fieldsFax['state'] = 'سایر';
                    $fieldsFax['value'] = '';
                }
                $result = adminEventModelDb::insertToPhones2($fieldsFax);
            }
            // end fax 2

            // email
            $email = $cell[12]->getElementsByTagName('Data')[0]->nodeValue;
            if ($email != '{-}') {
                $fieldsEmail['event_id'] = $i;
                $fieldsEmail['subject'] = 'ایمیل';
                $fieldsEmail['email'] = $email;
                $result = adminEventModelDb::insertToEmails2($fieldsEmail);
            }
            // end email

            // address
            $address = $cell[14]->getElementsByTagName('Data')[0]->nodeValue;
            if ($address != '{-}') {
                $fieldsAddresses['event_id'] = $i;
                $fieldsAddresses['subject'] = 'آدرس';
                $fieldsAddresses['address'] = $address;
                $result = adminEventModelDb::insertToAddresses2($fieldsAddresses);
            }
            // end address

            // website
            $website = $cell[11]->getElementsByTagName('Data')[0]->nodeValue;
            if ($website != '{-}') {
                $fieldsWebsite['event_id'] = $i;
                $fieldsWebsite['subject'] = 'وب سایت';
                $fieldsWebsite['website'] = $website;
                $result = adminEventModelDb::insertToWebsites2($fieldsWebsite);
            }
            // end website

            /*if ($i % 10 == 0) {
                echo $i;
                echo '<br>';
                die();
            }*/
            ++$i;
            //flush();
            //ob_flush();
            //ob_end_clean();
        }

        $msg = 'ایمپورت انجام شد';
        redirectPage(RELA_DIR.'zamin/index.php?component=event', $msg);
    }

    /**
     * importEventPhones.
     *
     * @return redirectPage
     */
    public function importEventPhones()
    {
        include_once dirname(__FILE__).'/admin.event.model.db.php';
        $xml = (STATIC_ROOT_DIR.'/xml/event-phones.xml');
        $xmlDoc = new DOMDocument();
        $xmlDoc->load($xml);
        $wb = $xmlDoc->getElementsByTagName('Workbook')->item(0);
        $ws = $wb->getElementsByTagName('Worksheet')->item(0);
        $table = $ws->getElementsByTagName('Table')->item(0);
        $row = $table->getElementsByTagName('Row');
        $i = 1;
        foreach ($row as $rowkey => $rowValue) {
            $fields = array();
            $cell = $rowValue->getElementsByTagName('Cell');
            $eventId = $cell[0]->getElementsByTagName('Data')[0]->nodeValue;
            $fields['event_id'] = $cell[0]->getElementsByTagName('Data')[0]->nodeValue;
            $fields['number'] = $cell[1]->getElementsByTagName('Data')[0]->nodeValue;
            $fields['state'] = $cell[2]->getElementsByTagName('Data')[0]->nodeValue;
            $fields['value'] = $cell[3]->getElementsByTagName('Data')[0]->nodeValue;
            $fields['subject'] = 'تلفن';
            $result = adminEventModelDb::insertToPhones2($fields);

            if ($i % 100 == 0) {
                echo $i;
                echo '<br>';
            }
            ++$i;
            flush();
            ob_flush();
            ob_end_clean();
        }

        $msg = 'ایمپورت انجام شد';
        redirectPage(RELA_DIR.'zamin/index.php?component=event', $msg);
    }
    /**
     * importEventEmails.
     *
     * @return redirectPage
     */
    public function importEventEmails()
    {
        include_once dirname(__FILE__).'/admin.event.model.db.php';
        $xml = (STATIC_ROOT_DIR.'/xml/event-emails.xml');
        $xmlDoc = new DOMDocument();
        $xmlDoc->load($xml);
        $wb = $xmlDoc->getElementsByTagName('Workbook')->item(0);
        $ws = $wb->getElementsByTagName('Worksheet')->item(0);
        $table = $ws->getElementsByTagName('Table')->item(0);
        $row = $table->getElementsByTagName('Row');
        $i = 1;
        foreach ($row as $rowkey => $rowValue) {
            ob_start();
            $fields = array();
            $cell = $rowValue->getElementsByTagName('Cell');
            $eventId = $cell[0]->getElementsByTagName('Data')[0]->nodeValue;
            $fields['event_id'] = $cell[0]->getElementsByTagName('Data')[0]->nodeValue;
            $fields['subject'] = 'ایمیل';
            $fields['email'] = $cell[1]->getElementsByTagName('Data')[0]->nodeValue;
            $result = adminEventModelDb::insertToEmails2($fields);

            echo $i;
            // if($i % 100 == 0){
            //     echo "<br>";
            // }
            ++$i;
            flush();
            ob_flush();
            ob_end_clean();
        }

        $msg = 'ایمپورت انجام شد';
        redirectPage(RELA_DIR.'zamin/index.php?component=event', $msg);
    }
    /**
     * importEventAddresses.
     *
     * @return redirectPage
     */
    public function importEventAddresses()
    {
        include_once dirname(__FILE__).'/admin.event.model.db.php';
        $xml = (STATIC_ROOT_DIR.'/xml/event-addresses.xml');
        $xmlDoc = new DOMDocument();
        $xmlDoc->load($xml);
        $wb = $xmlDoc->getElementsByTagName('Workbook')->item(0);
        $ws = $wb->getElementsByTagName('Worksheet')->item(0);
        $table = $ws->getElementsByTagName('Table')->item(0);
        $row = $table->getElementsByTagName('Row');
        $i = 1;
        foreach ($row as $rowkey => $rowValue) {
            $fields = array();
            $cell = $rowValue->getElementsByTagName('Cell');
            $eventId = $cell[0]->getElementsByTagName('Data')[0]->nodeValue;
            $fields['event_id'] = $cell[0]->getElementsByTagName('Data')[0]->nodeValue;
            $fields['subject'] = 'آدرس';
            $fields['address'] = $cell[1]->getElementsByTagName('Data')[0]->nodeValue;
            $result = adminEventModelDb::insertToAddresses2($fields);

            if ($i % 100 == 0) {
                echo $i;
                echo '<br>';
            }
            ++$i;
            flush();
            ob_flush();
            ob_end_clean();
        }

        $msg = 'ایمپورت انجام شد';
        redirectPage(RELA_DIR.'zamin/index.php?component=event', $msg);
    }
    /**
     * importEventWebsites.
     *
     * @return redirectPage
     */
    public function importEventWebsites()
    {
        include_once dirname(__FILE__).'/admin.event.model.db.php';
        $xml = (STATIC_ROOT_DIR.'/xml/event-websites.xml');
        $xmlDoc = new DOMDocument();
        $xmlDoc->load($xml);
        $wb = $xmlDoc->getElementsByTagName('Workbook')->item(0);
        $ws = $wb->getElementsByTagName('Worksheet')->item(0);
        $table = $ws->getElementsByTagName('Table')->item(0);
        $row = $table->getElementsByTagName('Row');
        $i = 1;
        foreach ($row as $rowkey => $rowValue) {
            $fields = array();
            $cell = $rowValue->getElementsByTagName('Cell');
            $eventId = $cell[0]->getElementsByTagName('Data')[0]->nodeValue;
            $fields['event_id'] = $cell[0]->getElementsByTagName('Data')[0]->nodeValue;
            $fields['subject'] = 'وب سایت';
            $fields['url'] = $cell[1]->getElementsByTagName('Data')[0]->nodeValue;
            $result = adminEventModelDb::insertToWebsites2($fields);

            if ($i % 100 == 0) {
                echo $i;
                echo '<br>';
            }
            ++$i;
            flush();
            ob_flush();
            ob_end_clean();
        }

        $msg = 'ایمپورت انجام شد';
        redirectPage(RELA_DIR.'zamin/index.php?component=event', $msg);
    }
    /**
     * delete deleteEvent by event_id.
     *
     * @param $id
     *
     * @author malekloo
     * @date 2/24/2015
     *
     * @version 01.01.01
     */

    public function deleteEvent($id)
    {

        if (!validator::required($id) and !validator::Numeric($id)) {
            $msg = 'یافت نشد';
            redirectPage(RELA_DIR.'zamin/index.php?component=event', $msg);
        }

        $event = adminEventModel::find($id);
        if (!is_object($event)) {
            $msg = $event['msg'];
            redirectPage(RELA_DIR.'zamin/index.php?component=event', $msg);
        }


        include_once ROOT_DIR.'/component/event_gallery/admin/model/admin.event_gallery.model.php';
        $result = adminEvent_galleryModel::getBy_event_id($id)->get();


        if ($result['export']['recordsCount'] > 0) {
            $msg = 'توجه : ابتدا گالری این رویداد را حذف نمایید.';
            redirectPage(RELA_DIR.'zamin/index.php?component=event', $msg);
        }

        $dir = ROOT_DIR.'statics/event/';
        fileRemover($dir,$event->fields['logo']);

        $result = $event->delete();

        if ($result['result'] != '1') {
            redirectPage(RELA_DIR.'zamin/index.php?component=event', $msg);
        }

        $msg = 'عملیات با موفقیت انجام شد';
        redirectPage(RELA_DIR.'zamin/index.php?component=event', $msg);
        die();
    }
    public function deleteGallery($id)
    {

        if (!validator::required($id) and !validator::Numeric($id)) {
            $msg = 'یافت نشد';
            redirectPage(RELA_DIR.'zamin/index.php?component=event', $msg);
        }

        include_once ROOT_DIR.'component/event_gallery/admin/model/admin.event_gallery.model.php';
        $event = adminEvent_galleryModel::find($id);

        if (!is_object($event)) {
            $msg = $event['msg'];
            redirectPage(RELA_DIR.'zamin/index.php?component=event&action=gallery&id='.$event->fields['event_id'], $msg);
        }

        $dir = ROOT_DIR.'statics/event/';
        fileRemover($dir,$event->fields['image']);

        $result = $event->delete();

        if ($result['result'] != '1') {
            redirectPage(RELA_DIR.'zamin/index.php?component=event&action=gallery&id='.$event->fields['event_id'], $msg);
        }

        $msg = 'عملیات با موفقیت انجام شد';
        redirectPage(RELA_DIR.'zamin/index.php?component=event&action=gallery&id='.$event->fields['event_id'], $msg);
        die();
    }
    public function call($fields)
    {
        include_once dirname(__FILE__).'/php-ami-class.php';
        $conn = new AstMan();
        $ret = $conn->clickToCall($fields['number']);
        die();
    }

    public function getEventphone($input)
    {
        $event_id =   $input['event_id'];
        include_once dirname(__FILE__).'/admin.event.model.php';
        $model = new adminEventModel();
        $result = $model->getEventphoneAll($event_id);
        $phone='';
        foreach ($result['export']['list'] as $key => $value ){
            $phone .='<h4><a class="btn btn-default event_allphone label label-default" href="#" role="button" data-myphonenumber="'.$value.'" data-myeventid="'.$event_id.'"><span class="glyphicon glyphicon-phone-alt"></span></a><span>'.$value.'</span></h4>';

        }
        echo $phone;
        //print_r_debug($result );
        //json_encode($result);
         die();

    }

    public function getCityAjax($input)
    {
        $province_id =$input['province_id'];
        include_once ROOT_DIR.'/component/city/admin/model/admin.city.model.php';
        $model = new adminCityModel();
        $result = $model->getCitiesByprovinceID($province_id);

        $option='';
        foreach ($result['export']['list'] as $key => $value){
            $option.="<option>".$value['name']."</option>";
        }
        echo $option;

        die();

    }

}
