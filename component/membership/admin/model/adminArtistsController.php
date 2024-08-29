<?php

use Common\dbConn;
use Common\validators;
use Component\artists\admin\model\adminArtistsModel;
use Component\category\admin\model\adminCategoryModel;
use Component\city\admin\model\adminCityModel;
use Component\city\admin\model\adminCityModelDb;
use Component\genre\admin\model\adminGenreModel;
use Component\product\admin\model\adminProductModel;
use Component\province\admin\model\adminProvinceModel;
use Model\convertDatatableIO;


class adminArtistsController
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
    public function template(array $list = [], string $msg = ''): void
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

    /**
     * add Artists.
     *
     * @param $fields
     * @return int|mixed
     * @internal param $_input
     *
     * @author marjani
     * @date 2/27/2015
     *
     * @version 01.01.01
     */
    public function addArtists($fields)
    {
        global $messageStack;

        $artists = new adminArtistsModel();

        $fields['password'] = md5($fields['password']);

        $fields['refresh_date'] = convertJToGDate($fields['refresh_date']);
        $fields['birthday'] = convertJToGDate($fields['birthday']);

        $fields['category_id'] = ',' . implode(',', $fields['category_id']) . ',';

        $artists->setFields($fields);
        //$result = $artists->validators();

        /*if ($result['result'] == -1) {
            $this->showArtistsAddForm($fields, $result['msg']);
        }*/
        $result = $artists->save();
        $fields['Artists_id'] = $artists->fields['Artists_id'];

        if (file_exists($_FILES['logo']['tmp_name'])) {
            $input['upload_dir'] = ROOT_DIR . 'statics/files/' . $fields['Artists_id'] . '/';
            $result = fileUploader($input, $_FILES['logo']);
            fileRemover($input['upload_dir'], $artists->fields['logo']);
            $artists->logo = $result['image_name'];
            $result = $artists->save();
        }
        //print_r_debug($artists);
        //print_r_debug($_FILES);

        if ($result['result'] != '1') {
            $messageStack->add_session('register', $result['msg']);
            $this->showArtistsAddForm($fields, $result['msg']);
        }
        $msg = 'ثبت نام با موفقیت انجام شد.';
        $messageStack->add_session('register', $msg);

        redirectPage(RELA_DIR . 'zamin/?component=artists', $msg);
        die();
    }

    /**
     * call register form.
     *
     * @param $fields
     * @param $msg
     *
     * @return mixed
     *
     * @author malekloo
     * @date 14/03/2016
     *
     * @version 01.01.01
     */
    public function showArtistsAddForm($fields, $msg)
    {
        include_once ROOT_DIR . 'component/category/admin/model/admin.category.model.php';
        $category = new adminCategoryModel();

        $resultCategory = $category->getCategoryOption();
        if ($resultCategory['result'] == 1) {
            $fields['category'] = $category->list;
        }

        /** genre */
        include_once ROOT_DIR . 'component/genre/admin/model/admin.genre.model.php';
        $genre = new adminGenreModel();

        $resultGenre = $genre->getGenreOption();
        if ($resultGenre['result'] == 1) {
            $fields['genre'] = $genre->list;
        }

        /*include_once ROOT_DIR.'component/city/admin/model/admin.city.model.php';
        $city = new adminCityModel();
        $resultCity = $city->getCities();
        if ($resultCity['result'] == 1) {
            $fields['cities'] = $city->list;
        }*/

        include_once ROOT_DIR . 'component/province/admin/model/admin.province.model.php';
        //$province = new adminProvinceModel();
        $province = adminProvinceModel::getAll()->getList();

        //$resultProvince = $province->getStates();
        if ($province['result'] == 1) {
            $fields['provinces'] = $province['export']['list'];
        }




        $this->fileName = 'admin.artists.addForm.php';
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
    public function editArtists($fields)
    {
        //$artists = new adminArtistsModel();



        $artists = adminArtistsModel::find($fields['Artists_id']);

        $fields['refresh_date'] = convertJToGDate($fields['refresh_date']);
        $fields['birthday'] = convertJToGDate($fields['birthday']);

        if ($fields['password'] != '') {
            $fields['password'] = md5($fields['password']);
        } else {
            unset($fields['password']);
        }

        $result = $artists->setFields($fields);

        $temp = implode(",", $artists->fields['category_id']);
        $artists->category_id = ',' . $temp . ',';

        $temp = implode(",", $artists->fields['genre_id']);
        $artists->genre_id = ',' . $temp . ',';


        if ($result['result'] != 1) {
            $this->showArtistsEditForm($fields, $result['msg']);
        }

        $artists->update_date = date('Y-m-d H:i:s');
        $result = $artists->save();

        //$result = $artists->edit();

        if ($result['result'] != '1') {
            $this->showArtistsEditForm($fields, $result['msg']);
        }

        if (isset($fields['showStatus'])) {
            $action = '&action=' . $fields['showStatus'];
        }

        if (file_exists($_FILES['logo']['tmp_name'])) {

            $input['upload_dir'] = ROOT_DIR . 'statics/files/' . $fields['Artists_id'] . '/';
            $result = fileUploader($input, $_FILES['logo']);
            fileRemover($input['upload_dir'], $artists->fields['logo']);
            $artists->logo = $result['image_name'];
            $result = $artists->save();
        }


        $msg = 'عملیات با موفقیت انجام شد';
        redirectPage(RELA_DIR . 'zamin/index.php?component=artists' . $action, $msg);
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
    public function showArtistsEditForm($fields, $msg)
    {
        $showStatus = $fields['showStatus'];
        if (strtoupper($_SERVER['REQUEST_METHOD']) != 'POST') {
            $artists = new adminArtistsModel();
            $result = $artists->getArtistsById($fields['Artists_id']);
            if ($result['result'] != '1') {
                $msg = $result['msg'];
                redirectPage(RELA_DIR . 'zamin/index.php?component=artists', $msg);
            }
            $export = $artists->fields;
        } else {
            $export = $fields;
        }



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


        //$province = new adminProvinceModel();
        $province = adminProvinceModel::getAll()->getList();

        //$resultProvince = $province->getStates();
        if ($province['result'] == 1) {
            $export['cities'] = $province['export']['list'];
        }

        /*include_once ROOT_DIR.'component/city/admin/model/admin.city.model.php';
        $city = new adminCityModel();
        $resultCity = $city->getCities();
        if ($resultCity['result'] == 1) {
            $export['cities'] = $city->list;
        }*/

        /*include_once ROOT_DIR.'component/state/admin/model/admin.state.model.php';
        $state = new adminStateModel();
        $resultState = $state->getStates();
        if ($resultState['result'] == 1) {
            $export['states'] = $state->list;
        }

        include_once ROOT_DIR.'component/certification/admin/model/admin.certification.model.php';
        $certification = new adminCertificationModel();

        $resultCertification = $certification->getCertification();
        if ($resultCity['result'] == 1) {
            $export['certifications'] = $certification->list;
        }*/

        $export['showStatus'] = $showStatus;
        $this->fileName = 'admin.artists.editForm.php';
        $this->template($export, $msg);
        die();
    }



    public function showList($msg = '')
    {
        $export['status'] = 'showAll';
        $this->fileName = 'admin.artists.showList.php';
        $this->template($export, $msg);
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
    public function search($fields)
    {



        $artists = new adminArtistsModel();

        $i = 0;
        $columns = array(
            array('db' => 'Artists_id', 'dt' => $i++),
            array('db' => 'username', 'dt' => $i++),
            array('db' => 'nickname', 'dt' => $i++),
            array('db' => 'category_id', 'dt' => $i++),
            /*array( 'db' => 'email', 'dt' =>$i++),*/
            array('db' => 'artists_phone1', 'dt' => $i++),
            array('db' => 'artists_name_en', 'dt' => $i++),
            array('db' => 'artists_name_fa',   'dt' => $i++),
            array('db' => 'site', 'dt' => $i++),
            array('db' => 'status', 'dt' => $i++),
            array('db' => 'logo', 'dt' => $i++),
            array('db' => 'Artists_id', 'dt' => $i++)
        );
        $convert = new convertDatatableIO();
        $convert->input = $fields;
        $convert->columns = $columns;


        $searchFields = $convert->convertInput();
        //        $searchFields['order']['update_date'] = 'desc';
        //        print_r_debug($searchFields);//
        //$date = date('Y-m-d', strtotime(COMPANY_EXPIRE_PERIOD));
        // print_r_debug($date);
        //$searchFields['where'] = 'where refresh_date < '."'$date'";
        $searchFields['filter']['type'] = '1';
        //print_r_debug($searchFields);

        $result = $artists->getArtists($searchFields);

        if ($result['result'] != '1') {
            $this->fileName = 'admin.artists.showList.php';
            $this->template('', $result['msg']);
            die();
        }

        $list['list'] = $artists->list;

        $list['paging'] = $artists->recordsCount;

        /*$other['2']=array(
            'formatter' =>function($list)
            {
                $st='<div data-artists_id="'.$list['Artists_id'].'" class="artists_phone">'.$list['phone_number'].'</div>';
                return $st;
            }
        );*/
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
        $other['10'] = array(
            'formatter' => function ($list) {
                $st = "<img height='50' src='" . RELA_DIR . 'statics/files/' . $list['Artists_id'] . '/' . $list['logo'] . "'>";

                return $st;
            }
        );
        $internalVariable['showstatus'] = $fields['status'];
        $other[$i - 1] = array(
            'formatter' => function ($list, $internal) {
                $st = 'a' . $list['showstatus'];
                $st = '<a href="' . RELA_DIR . 'zamin/?component=artists&action=edit&id=' . $list['Artists_id'] . '&showStatus=' . $internal['showstatus']
                    . '">ویرایش</a> <br/>
                        <a href="' . RELA_DIR . 'zamin/?component=product&id=' . $list['Artists_id'] . '">لیست کارها</a><br/>
                        <a href="' . RELA_DIR . 'zamin/?component=artists&action=delete&id=' . $list['Artists_id'] . $list['artists_name'] . '">حذف</a>';
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
    public function searchExpire($fields)
    {
        /*echo '<pre/>';
        print_r($fields);
        die();*/

        $artists = new adminArtistsModel();

        include_once(ROOT_DIR . "model/datatable.converter.php");
        $i = 0;
        $columns = array(
            array('db' => 'Artists_id', 'dt' => $i++),
            array('db' => 'artists_name', 'dt' => $i++),
            array('db' => 'phone_number', 'dt' => $i++),
            array('db' => 'refresh_date',   'dt' => $i++),
            array('db' => 'address_address', 'dt' => $i++),
            array('db' => 'email_email', 'dt' => $i++),
            array('db' => 'website_url', 'dt' => $i++),
            array('db' => 'status', 'dt' => $i++),
            array('db' => 'Artists_id', 'dt' => $i++)
        );
        $convert = new convertDatatableIO();
        $convert->input = $fields;
        $convert->columns = $columns;
        $searchFields = $convert->convertInput();

        $date = date('Y-m-d', strtotime(COMPANY_EXPIRE_PERIOD));
        // print_r_debug($date);
        $searchFields['where'] = 'where refresh_date < ' . "'$date'";
        //print_r_debug($searchFields);

        $result = $artists->getArtists($searchFields);
        if ($result['result'] != '1') {
            $this->fileName = 'admin.artists.showList.php';
            $this->template('', $result['msg']);
            die();
        }
        $list['list'] = $artists->list;
        $list['paging'] = $artists->recordsCount;

        $other['2'] = array(
            'formatter' => function ($list) {
                $st = '<div data-artists_id="' . $list['Artists_id'] . '" class="artists_phone">' . $list['phone_number'] . '</div>';

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
                $st = '<a href="' . RELA_DIR . 'zamin/?component=artists&action=edit&id=' . $list['Artists_id'] . '&showStatus=' . $internal['showstatus']
                    . '">ویرایش</a> <br/>
                        <a href="' . RELA_DIR . 'zamin/?component=product&id=' . $list['Artists_id'] . '">لیست محصولات</a><br/>
                        <a href="' . RELA_DIR . 'zamin/?component=honour&id=' . $list['Artists_id'] . '">لیست افتخارات</a><br/>
                        <a href="' . RELA_DIR . 'zamin/?component=licence&id=' . $list['Artists_id'] . '">لیست مجوز ها</a><br/>
                        <a href="' . RELA_DIR . 'zamin/?component=artists&action=delete&id=' . $list['Artists_id'] . $list['artists_name'] . '">حذف</a>';
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

        $artists = new adminArtistsModel();

        include_once(ROOT_DIR . "model/datatable.converter.php");
        $i = 0;
        $columns = array(
            array('db' => 'Artists_id', 'dt' => $i++),
            array('db' => 'artists_name', 'dt' => $i++),
            array('db' => 'phone_number', 'dt' => $i++),
            array('db' => 'city_name',   'dt' => $i++),
            array('db' => 'address_address', 'dt' => $i++),
            array('db' => 'email_email', 'dt' => $i++),
            array('db' => 'website_url', 'dt' => $i++),
            array('db' => 'status', 'dt' => $i++),
            array('db' => 'logo', 'dt' => $i++),
            array('db' => 'Artists_id', 'dt' => $i++)
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
        $result = $artists->getArtists($searchFields);
        if ($result['result'] != '1') {
            $this->fileName = 'admin.artists.showList.php';
            $this->template('', $result['msg']);
            die();
        }
        $list['list'] = $artists->list;
        $list['paging'] = $artists->recordsCount;

        $other['2'] = array(
            'formatter' => function ($list) {
                $st = '<div data-artists_id="' . $list['Artists_id'] . '" class="artists_phone">' . $list['phone_number'] . '</div>';
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
                $st = '<a href="' . RELA_DIR . 'zamin/?component=artists&action=edit&id=' . $list['Artists_id'] . '&showStatus=' . $internal['showstatus']
                    . '">ویرایش</a> <br/>
                        <a href="' . RELA_DIR . 'zamin/?component=product&id=' . $list['Artists_id'] . '">لیست محصولات</a><br/>
                        <a href="' . RELA_DIR . 'zamin/?component=honour&id=' . $list['Artists_id'] . '">لیست افتخارات</a><br/>
                        <a href="' . RELA_DIR . 'zamin/?component=licence&id=' . $list['Artists_id'] . '">لیست مجوز ها</a><br/>
                        <a href="' . RELA_DIR . 'zamin/?component=artists&action=delete&id=' . $list['Artists_id'] . $list['artists_name'] . '">حذف</a>';
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
        $this->fileName = 'admin.artists.showExpireList.php';
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
        $this->fileName = 'admin.artists.showUnverifiedList.php';
        $this->template($export);
        die();
    }

    public function updateCity()
    {

        $cityList = adminCityModelDb::getAll()['export']['list'];

        foreach ($cityList as $key => $fields) {

            $province_id = $fields['province_id'];

            echo $province_id;

            $conn = dbConn::getConnection();

            $sql = "
                UPDATE artists
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


    public function deleteArtists($id)
    {
        $artists = new adminArtistsModel();


        if (!validators::required($id) and !validators::Numeric($id)) {
            $msg = 'یافت نشد';
            redirectPage(RELA_DIR . 'zamin/index.php?component=artists', $msg);
        }
        $result = $artists->getArtistsById($id);
        $file = $result['export']['list']['logo'];

        if ($result['result'] != '1') {
            $msg = $result['msg'];
            redirectPage(RELA_DIR . 'zamin/index.php?component=artists', $msg);
        }

        $product = adminProductModel::getBy_artists_id($id)->get();


        if ($product['export']['recordsCount'] > 0) {
            $msg = 'توجه : ابتدا محصولات این کمپانی را حذف تنایید.';
            redirectPage(RELA_DIR . 'zamin/index.php?component=artists', $msg);
        }

        $result = $artists->delete();
        fileRemover(ROOT_DIR . 'statics/files/' . $id . '/', $file);




        if ($result['result'] != '1') {
            redirectPage(RELA_DIR . 'zamin/index.php?component=artists');
        }

        $msg = 'عملیات با موفقیت انجام شد';
        redirectPage(RELA_DIR . 'zamin/index.php?component=artists', $msg);
        die();
    }
    // public function call($fields)
    // {
    //     include_once dirname(__FILE__) . '/php-ami-class.php';
    //     $conn = new AstMan();
    //     $ret = $conn->clickToCall($fields['number']);
    //     die();
    // }

    public function getArtistsphone($input)
    {
        $artists_id =   $input['artists_id'];
        $model = new adminArtistsModel();
        $result = $model->getArtistsphoneAll($artists_id);
        $phone = '';
        foreach ($result['export']['list'] as $key => $value) {
            $phone .= '<h4><a class="btn btn-default artists_allphone label label-default" href="#" role="button" data-myphonenumber="' . $value . '" data-myartistsid="' . $artists_id . '"><span class="glyphicon glyphicon-phone-alt"></span></a><span>' . $value . '</span></h4>';
        }
        echo $phone;

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
