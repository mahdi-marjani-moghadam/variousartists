<?php

/**
 * Created by PhpStorm.
 * User: malekloo
 * Date: 3/6/2016
 * Time: 11:21 AM.
 */

use Common\validators;
use Component\artists\admin\model\adminArtistsModel;
use Component\category\admin\model\adminCategoryModel;
use Component\city\admin\model\adminCityModel;
use Component\genre\admin\model\adminGenreModel;
use Component\product\admin\model\adminProductModel;
use Component\province\admin\model\adminProvinceModel;
use Model\clsCountry;

include_once dirname(__FILE__) . '/admin.artists.model.php';

/**
 * Class registerController.
 */
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
    public function template($list = [], $msg = '')
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

    public function showArtistsAddForm($fields = array(), $msg = '')
    {

        global $dataStack;
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

        //////////////////////////////////////////////////
        ////                get country               ////
        //////////////////////////////////////////////////
        include_once(ROOT_DIR . "model/country.class.php");
        $COUNTRY = new clsCountry();
        $COUNTRY->countryFieldName = array("iso", "phone_code", "name", "max_length", "sample");

        $fields['data'] = $dataStack->output('data');

        if (isset($fields['data']['areacode']) && count($fields['data']) > 0 && $fields['data']['areacode'] != '') {
            $COUNTRY->condition = array("phone_code" => $fields['data']['areacode']); // or "iso"=>"ir"
        } else {
            $COUNTRY->condition = array("phone_code" => "98"); // or "iso"=>"us"
        }

        //set input country when come in page
        $COUNTRY->getAllCountryCode();
        $fields['default'] = $COUNTRY->country;

        //$countries = $COUNTRY->country;

        $COUNTRY->unsetCondition();

        //get select country area code
        //$COUNTRY->multiIso         = array("CN","us","IR","de");
        $COUNTRY->getAllCountryCode();
        $fields['country'] = $COUNTRY->country;


        $this->fileName = 'admin.artists.addForm.php';
        $this->template($fields, $msg);
        die();
    }
    public function addArtists($fields)
    {
        global $messageStack;

        $artists = new adminArtistsModel();

        $fields['password'] = md5($fields['password']);


        if ($fields['refresh_date'] == '') {
            unset($fields['refresh_date']);
        } else {
            $fields['refresh_date'] = convertJToGDate($fields['refresh_date']);
        }
        if ($fields['birthday'] == '') {
            unset($fields['birthday']);
        } else {
            $fields['birthday'] = convertJToGDate($fields['birthday']);
        }
        $fields['category_id'] = ',' . implode(',', $fields['category_id']) . ',';
        $fields['genre_id'] = ',' . implode(',', $fields['genre_id']) . ',';

        $artists->setFields($fields);
        //$result = $artists->validators();

        /*if ($result['result'] == -1) {
            $this->showArtistsAddForm($fields, $result['msg']);
        }*/
        $artists->type = 1;
        $artists->update_date = date('Y-m-d H:i:s');
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



        // include_once ROOT_DIR . 'component/category/admin/model/admin.category.model.php';
        $category = new adminCategoryModel();

        $resultCategory = $category->getCategoryOption();

        if ($resultCategory['result'] == 1) {
            $export['category'] = $category->list;
        }

        /** genre */
        // include_once ROOT_DIR . 'component/genre/admin/model/admin.genre.model.php';
        $genre = new adminGenreModel();

        $resultGenre = $genre->getGenreOption();
        if ($resultGenre['result'] == 1) {
            $export['genre'] = $genre->list;
        }


        // include_once ROOT_DIR . 'component/province/admin/model/admin.province.model.php';
        //$province = new adminProvinceModel();
        $province = adminProvinceModel::getAll()->getList();

        //$resultProvince = $province->getStates();
        if ($province['result'] == 1) {
            $export['cities'] = $province['export']['list'];
        }


        global $dataStack;
        //////////////////////////////////////////////////
        ////                get country               ////
        //////////////////////////////////////////////////
        // include_once(ROOT_DIR . "model/country.class.php");
        $COUNTRY = new clsCountry();
        $COUNTRY->countryFieldName = array("iso", "phone_code", "name", "max_length", "sample");

        $export['data'] = $dataStack->output('data');


        
        if (isset($export['data']['areacode']) && count($export['data']) > 0 && $export['data']['areacode'] != '') {
            $COUNTRY->condition = array("phone_code" => $export['data']['areacode']); // or "iso"=>"ir"
        } else {

            $COUNTRY->condition = array("phone_code" => $export['areacode']); // or "iso"=>"us"
        }

        //set input country when come in page
        $COUNTRY->getAllCountryCode();
        $export['default'] = $COUNTRY->country;

        //$countries = $COUNTRY->country;

        $COUNTRY->unsetCondition();

        //get select country area code
        //$COUNTRY->multiIso         = array("CN","us","IR","de");
        $COUNTRY->getAllCountryCode();
        $export['country'] = $COUNTRY->country;




        $export['showStatus'] = $showStatus;
        $this->fileName = 'admin.artists.editForm.php';
        $this->template($export, $msg);
        die();
    }
    public function editArtists($fields)
    {
        //$artists = new adminArtistsModel();




        $artists = adminArtistsModel::find($fields['Artists_id']);

        $oldStatus = $artists->fields['status'];

        $fields['refresh_date'] = convertJToGDate($fields['refresh_date']);
        if ($fields['birthday'] != '') {
            $fields['birthday'] = convertJToGDate($fields['birthday']);
        }

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


        if ($artists->fields['status'] == 1 && $oldStatus != $artists->fields['status']) {

            // include_once ROOT_DIR . 'component/magfa/magfa.model.php';
            // $sms = new WebServiceSample;

            global $lang;
            if ($lang == 'fa') {
                $subject = 'اکانت شما تایید شد';
                $message =
                    'اکانت شما تایید شد.' . " \n " .
                    " \n " .
                    "http://variousartist.ir";
            } else {
                $subject = 'اکانت شما تایید شد';
                $message =
                    'Your account has been activated' . " \n " .
                    " \n " .
                    "http://variousartist.ir";
            }


            // $sms->simpleEnqueueSample($artists->fields['artists_phone1'], $message);


            ///email
            if (checkMail($artists->fields['artists_phone1']) ==  1) {
                sendmail($artists->fields['artists_phone1'], $subject, $message);
            }
        }

        $msg = 'عملیات با موفقیت انجام شد';
        redirectPage(RELA_DIR . 'zamin/index.php?component=artists' . $action, $msg);
        die();
    }

    public function showList($msg)
    {
        $export['status'] = 'showAll';
        $this->fileName = 'admin.artists.showList.php';
        $this->template($export);
        die();
    }
    public function search($fields)
    {



        $artists = new adminArtistsModel();

        include_once(ROOT_DIR . "model/datatable.converter.php");
        $i = 0;
        $columns = array(
            array('db' => 'Artists_id', 'dt' => $i++),
            array('db' => 'Artists_id', 'dt' => $i++),
            array('db' => 'username', 'dt' => $i++),
            array('db' => 'nickname', 'dt' => $i++),
            array('db' => 'category_id', 'dt' => $i++),
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
        //$searchFields['filter']['limit'] = '0,1000';
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
        $other['1'] = array(
            'formatter' => function ($list) {
                $checked = ($list['blog'] == 1) ? 'checked' : '';
                $value = ($list['blog'] == 1) ? 1 : 0;
                $st = "<input type='checkbox' value='$value' data-a='{$list['Artists_id']}' class='changeBlog' $checked >";

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
        $other['10'] = array(
            'formatter' => function ($list) {
                if (file_exists(ROOT_DIR . 'statics/files/' . $list['Artists_id'] . '/' . $list['logo'])) {
                    $st = "<img height='50' src='" . RELA_DIR . 'statics/files/' . $list['Artists_id'] . '/' . $list['logo'] . "'>";
                } else {
                    $st = '';
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
                        <a href="' . RELA_DIR . 'zamin/?component=product&id=' . $list['Artists_id'] . '">لیست کارها</a><br/>
                        <a onclick="return confirm(\'آیا مطمئن هستید؟\')" href="' . RELA_DIR . 'zamin/?component=artists&action=delete&id=' . $list['Artists_id'] . $list['artists_name'] . '">حذف</a>';
                return $st;
            }
        );

        $export = $convert->convertOutput($list, $columns, $other, $internalVariable);
        //print_r_debug($export);
        echo json_encode($export);
        die();
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

        // include_once ROOT_DIR . 'component/product/admin/model/admin.product.model.php';
        $product = adminProductModel::getBy_artists_id($id)->get();


        if ($product['export']['recordsCount'] > 0) {
            $msg = 'توجه : ابتدا محصولات این کمپانی را حذف تنایید.';
            redirectPage(RELA_DIR . 'zamin/index.php?component=artists', $msg);
        }

        $result = $artists->delete();
        fileRemover(ROOT_DIR . 'statics/files/' . $id . '/', $file);

        include_once(ROOT_DIR . 'component/product/admin/model/admin.product.model.php');



        if ($result['result'] != '1') {
            redirectPage(RELA_DIR . 'zamin/index.php?component=artists', $msg);
        }

        $msg = 'عملیات با موفقیت انجام شد';
        redirectPage(RELA_DIR . 'zamin/index.php?component=artists', $msg);
        die();
    }

    public function getCityAjax($input)
    {
        $province_id = $input['province_id'];
        // include_once ROOT_DIR . '/component/city/admin/model/admin.city.model.php';
        $model = new adminCityModel();
        $result = $model->getCitiesByprovinceID($province_id);

        $option = '';
        foreach ($result['export']['list'] as $key => $value) {
            $option .= "<option>" . $value['name'] . "</option>";
        }
        echo $option;

        die();
    }

    public function activeBlog($id)
    {
        if (!validators::required($id) and !validators::Numeric($id)) {
            $msg = 'یافت نشد';
            redirectPage(RELA_DIR . 'zamin/index.php?component=artists', $msg);
        }
        $artists = new adminArtistsModel();
        $result = $artists::getAll()->where('Artists_id', '=', $id)->get();
        $result['export']['list'][0]->fields['blog'] = ($result['export']['list'][0]->fields['blog'] == 1) ? 0 : 1;
        $result['export']['list'][0]->save();
        redirectPage(RELA_DIR . 'zamin/index.php?component=artists', 'عملیات با موفقیت انجام شد.');
    }
}
