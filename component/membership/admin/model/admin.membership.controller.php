<?php



use Common\validators;
use Component\artists\admin\model\adminArtistsModel;
use Component\city\admin\model\adminCityModel;
use Model\clsCountry;
use Model\convertDatatableIO;

class adminMembershipController
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
    public function template(array $list = [], $msg = ''): void
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
    public function showArtistsAddForm($fieldss = array(), $msg)
    {
        //include_once ROOT_DIR.'component/category/admin/model/admin.category.model.php';
        //$category = new adminCategoryModel();

        /*$resultCategory = $category->getCategoryOption();
        if ($resultCategory['result'] == 1) {
            $fields['category'] = $category->list;
        }*/
        /** genre */
        /*include_once ROOT_DIR.'component/genre/admin/model/admin.genre.model.php';
        $genre = new adminGenreModel();


        $resultGenre = $genre->getGenreOption();
        if ($resultGenre['result'] == 1) {
            $fields['genre'] = $genre->list;
        }*/

        /*include_once ROOT_DIR.'component/city/admin/model/admin.city.model.php';
        $city = new adminCityModel();
        $resultCity = $city->getCities();
        if ($resultCity['result'] == 1) {
            $fields['cities'] = $city->list;
        }*/

        /*include_once ROOT_DIR.'component/province/admin/model/admin.province.model.php';
        $province = adminProvinceModel::getAll()->getList();

        if ($province['result'] == 1) {
            $fields['provinces'] = $province['export']['list'];
        }*/


        //////////////////////////////////////////////////
        ////                get country               ////
        //////////////////////////////////////////////////
        global $dataStack;
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
        $COUNTRY->multiIso         = array("CN", "us", "IR", "de");
        $COUNTRY->getAllCountryCode();
        $fields['country'] = $COUNTRY->country;



        $this->fileName = 'admin.membership.addForm.php';
        $this->template($fields, $msg);
        die();
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
        $fields['date'] = date('Y-m-d H:i:s');

        $fields['category_id'] = ',' . implode(',', $fields['category_id']) . ',';
        $fields['type'] = 0;
        $fields['status'] = 1;

        $fields['username'] = $fields['artists_phone1'];


        $artists->setFields($fields);
        $result = $artists->save();
        //        print_r_debug($artists);

        $fields['Artists_id'] = $artists->fields['Artists_id'];

        if (file_exists($_FILES['logo']['tmp_name'])) {
            $input['upload_dir'] = ROOT_DIR . 'statics/files/' . $fields['Artists_id'] . '/';
            $result = fileUploader($input, $_FILES['logo']);
            fileRemover($input['upload_dir'], $artists->fields['logo']);
            $artists->logo = $result['image_name'];
            $result = $artists->save();
        }


        if ($result['result'] != '1') {
            $messageStack->add_session('register', $result['msg']);
            $this->showArtistsAddForm($fields, $result['msg']);
        }
        $msg = 'ثبت نام با موفقیت انجام شد.';
        $messageStack->add_session('register', $msg);

        redirectPage(RELA_DIR . 'zamin/?component=membership', $msg);
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
        //        $showStatus=$fields['showStatus'];
        if (strtoupper($_SERVER['REQUEST_METHOD']) != 'POST') {
            $artists = new adminArtistsModel();
            $result = $artists->getArtistsById($fields['Artists_id']);
            if ($result['result'] != '1') {
                $msg = $result['msg'];
                redirectPage(RELA_DIR . 'zamin/index.php?component=membership', $msg);
            }
            $export = $artists->fields;
        } else {
            $export = $fields;
        }

        //////////////////////////////////////////////////
        ////                get country               ////
        //////////////////////////////////////////////////
        global $dataStack;
        // include_once(ROOT_DIR . "model/country.class.php");
        $COUNTRY = new clsCountry();
        $COUNTRY->countryFieldName = array("iso", "phone_code", "name", "max_length", "sample");
        $fields['data'] = $dataStack->output('data');

        if (strtoupper($_SERVER['REQUEST_METHOD']) != 'POST') {
            $COUNTRY->condition = array("phone_code" => $export['areacode']);
        } else if (isset($fields['data']['areacode']) && count($fields['data']) > 0 && $fields['data']['areacode'] != '') {
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
        $COUNTRY->multiIso         = array("CN", "us", "IR", "de");
        $COUNTRY->getAllCountryCode();
        $fields['country'] = $COUNTRY->country;



        $export['data']    = $fields['data'];
        $export['default'] = $fields['default'];
        $export['country'] = $fields['country'];
        //        $export['showStatus']=$showStatus;
        // print_r_debug($export);

        $this->fileName = 'admin.membership.editForm.php';
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
    public function editArtists($fields)
    {


        $artists = adminArtistsModel::find($fields['Artists_id']);

        //$fields['refresh_date'] = convertJToGDate($fields['refresh_date']);
        //$fields['birthday'] = convertJToGDate($fields['birthday']);

        if ($fields['password'] != '') {
            $fields['password'] = md5($fields['password']);
        } else {
            unset($fields['password']);
        }


        $result = $artists->setFields($fields);





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
        redirectPage(RELA_DIR . 'zamin/index.php?component=membership' . $action, $msg);
        die();
    }

    public function showList($msg = '')
    {
        $export['status'] = 'showAll';
        $this->fileName = 'admin.membership.showList.php';
        $this->template($export, $msg);
        die();
    }


    public function search($fields)
    {
        $artists = new adminArtistsModel();
        $i = 0;
        $columns = array(
            array('db' => 'Artists_id', 'dt' => $i++),
            array('db' => 'username', 'dt' => $i++),
            array('db' => 'artists_phone1', 'dt' => $i++),
            array('db' => 'artists_name_en', 'dt' => $i++),
            array('db' => 'artists_name_fa',   'dt' => $i++),
            array('db' => 'status', 'dt' => $i++),
            array('db' => 'date', 'dt' => $i++),
            array('db' => 'Artists_id', 'dt' => $i++)
        );
        $convert = new convertDatatableIO();
        $convert->input = $fields;
        $convert->columns = $columns;


        $searchFields = $convert->convertInput();
        $searchFields['filter']['type'] = '0';

        $result = $artists->getArtists($searchFields);

        if ($result['result'] != '1') {
            $this->fileName = 'admin.artists.showList.php';
            $this->template([], $result['msg']);
            die();
        }

        $list['list'] = $artists->list;

        $list['paging'] = $artists->recordsCount;


        $other['5'] = array(
            'formatter' => function ($list) {
                if ($list['status'] == 1) {
                    $st = 'فعال';
                } else {
                    $st = 'غیر فعال';
                }
                return $st;
            }
        );
        $other['6'] = array(
            'formatter' => function ($list) {
                $st = convertDate($list['date'], true);
                $st .= convertDate($list['update_date'], true);
                return $st;
            }
        );

        $internalVariable['showstatus'] = $fields['status'];
        $other[$i - 1] = array(
            'formatter' => function ($list, $internal) {
                $st = 'a' . $list['showstatus'];
                $st = '<a href="' . RELA_DIR . 'zamin/?component=membership&action=edit&id=' . $list['Artists_id'] . '&showStatus=' . $internal['showstatus']
                    . '">ویرایش</a> <br/>
                        <a href="' . RELA_DIR . 'zamin/?component=membership&action=delete&id=' . $list['Artists_id'] . $list['artists_name'] . '">حذف</a>';
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
            redirectPage(RELA_DIR . 'zamin/index.php?component=membership', $msg);
        }
        $result = $artists->getArtistsById($id);
        $file = $result['export']['list']['logo'];

        if ($result['result'] != '1') {
            $msg = $result['msg'];
            redirectPage(RELA_DIR . 'zamin/index.php?component=membership', $msg);
        }


        $result = $artists->delete();
        fileRemover(ROOT_DIR . 'statics/files/' . $id . '/', $file);



        if ($result['result'] != '1') {
            redirectPage(RELA_DIR . 'zamin/index.php?component=membership');
        }

        $msg = 'عملیات با موفقیت انجام شد';
        redirectPage(RELA_DIR . 'zamin/index.php?component=membership', $msg);
        die();
    }
    public function call($fields)
    {
        include_once dirname(__FILE__) . '/php-ami-class.php';
        $conn = new AstMan();
        $ret = $conn->clickToCall($fields['number']);
        die();
    }

    public function getArtistsphone($input)
    {
        $artists_id =   $input['artists_id'];
        include_once dirname(__FILE__) . '/admin.artists.model.php';
        $model = new adminArtistsModel();
        $result = $model->getArtistsphoneAll($artists_id);
        $phone = '';
        foreach ($result['export']['list'] as $key => $value) {
            $phone .= '<h4><a class="btn btn-default artists_allphone label label-default" href="#" role="button" data-myphonenumber="' . $value . '" data-myartistsid="' . $artists_id . '"><span class="glyphicon glyphicon-phone-alt"></span></a><span>' . $value . '</span></h4>';
        }
        echo $phone;
        //print_r_debug($result );
        //json_encode($result);
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
}
