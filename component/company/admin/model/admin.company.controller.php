<?php
/**
 * Created by PhpStorm.
 * User: malekloo
 * Date: 3/6/2016
 * Time: 11:21 AM.
 */
include_once dirname(__FILE__).'/admin.company.model.php';

/**
 * Class registerController.
 */
class adminCompanyController
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
    public function template($list = [], $msg='')
    {
        global $messageStack,$admin_info;

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
     * add Company.
     *
     * @param $_input
     *
     * @return int|mixed
     *
     * @author marjani
     * @date 2/27/2015
     *
     * @version 01.01.01
     */
    public function addCompany($_input)
    {
        global $messageStack;

        $company = new adminCompanyModel();

        $fields['refresh_date'] = convertJToGDate($fields['refresh_date']);
        $result = $company->setFields($_input);
        if ($result['result'] == -1) {
            $this->showCompanyAddForm($_input, $result['msg']);
        }

        $result = $company->addCompany();

        if ($result['result'] != '1') {
            $messageStack->add_session('register', $result['msg']);
            $this->showCompanyAddForm($_input, $result['msg']);
        }
        $msg = 'ثبت نام با موفقیت انجام شد.';
        $messageStack->add_session('register', $msg);

        redirectPage(RELA_DIR.'zamin/?component=company', $msg);
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
    public function showCompanyAddForm($fields, $msg)
    {
        include_once ROOT_DIR.'component/category/admin/model/admin.category.model.php';
        $category = new adminCategoryModel();

        $resultCategory = $category->getCategoryOption();
        if ($resultCategory['result'] == 1) {
            $fields['category'] = $category->list;
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

        $this->fileName = 'admin.company.addForm.php';
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
    public function editCompany($fields)
    {
        $company = new adminCompanyModel();

        $result = $company->getCompanyById($fields['Company_id']);

        $fields['refresh_date'] = convertJToGDate($fields['refresh_date']);
        $result = $company->setFields($fields);

        if ($result['result'] != 1) {
            $this->showCompanyEditForm($fields, $result['msg']);
        }

        $result = $company->edit();

        if ($result['result'] != '1') {
            $this->showCompanyEditForm($fields, $result['msg']);
        }

        if(isset($fields['showStatus']))
        {
            $action='&action='.$fields['showStatus'];
        }
        $msg = 'عملیات با موفقیت انجام شد';
        redirectPage(RELA_DIR.'zamin/index.php?component=company'.$action, $msg);
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
    public function showCompanyEditForm($fields, $msg)
    {
        $showStatus=$fields['showStatus'];
        if (strtoupper($_SERVER['REQUEST_METHOD']) != 'POST') {
            $company = new adminCompanyModel();
            $result = $company->getCompanyById($fields['Company_id']);
            if ($result['result'] != '1') {
                $msg = $result['msg'];
                redirectPage(RELA_DIR.'zamin/index.php?component=company', $msg);
            }
            $export = $company->fields;
        } else {
            $export = $fields;
        }

        if (count($fields['company_phone']['state'])) {
            $export['company_phone'] = $fields['company_phone'];
        }

        if (count($fields['company_email']['subject']) || count($fields['company_email']['email'])) {
            $export['company_email'] = $fields['company_email'];
        }

        if (count($fields['company_address']['subject']) || count($fields['company_address']['address'])) {
            $export['company_address'] = $fields['company_address'];
        }

        if (count($fields['company_website']['subject']) || count($fields['company_website']['url'])) {
            $export['company_website'] = $fields['company_website'];
        }

        include_once ROOT_DIR.'component/category/admin/model/admin.category.model.php';
        $category = new adminCategoryModel();

        $resultCategory = $category->getCategoryOption();

        if ($resultCategory['result'] == 1) {
            $export['category'] = $category->list;
        }

        include_once ROOT_DIR.'component/city/admin/model/admin.city.model.php';
        $city = new adminCityModel();
        $resultCity = $city->getCities();
        if ($resultCity['result'] == 1) {
            $export['cities'] = $city->list;
        }

        include_once ROOT_DIR.'component/state/admin/model/admin.state.model.php';
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
        }

        $export['showStatus']=$showStatus;
        $this->fileName = 'admin.company.editForm.php';
        $this->template($export, $msg);
        die();
    }



    public function showList($msg)
    {
        $export['status']='showAll';
        $this->fileName = 'admin.company.showList.php';
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
    public function search($fields)
    {

        /*echo '<pre/>';
        print_r($fields);
        die();*/

        $company = new adminCompanyModel();

        include_once(ROOT_DIR . "model/datatable.converter.php");
        $i=0;
        $columns = array(
            array( 'db' => 'Company_id', 'dt' =>$i++),
            array( 'db' => 'company_name', 'dt' =>$i++),
            array( 'db' => 'phone_number', 'dt' =>$i++),
            array( 'db' => 'city_name',   'dt' => $i++),
            array( 'db' => 'address_address', 'dt' => $i++ ),
            array( 'db' => 'email_email', 'dt' => $i++ ),
            array( 'db' => 'website_url', 'dt' => $i++ ),
            array( 'db' => 'status', 'dt' => $i++ ),
            array( 'db' => 'logo', 'dt' => $i++ ),
            array( 'db' => 'Company_id', 'dt' => $i++ )
        );
        $convert=new convertDatatableIO();
        $convert->input=$fields;
        $convert->columns=$columns;
        $searchFields= $convert->convertInput();

        //$date = date('Y-m-d', strtotime(COMPANY_EXPIRE_PERIOD));
        // print_r_debug($date);
        //$searchFields['where'] = 'where refresh_date < '."'$date'";
        //print_r_debug($searchFields);

        $result = $company->getCompany($searchFields);
        if ($result['result'] != '1') {
            $this->fileName = 'admin.company.showList.php';
            $this->template('', $result['msg']);
            die();
        }
        $list['list']=$company->list;
        $list['paging']=$company->recordsCount;
        $other['2']=array(
            'formatter' =>function($list)
            {
                $st='<div data-company_id="'.$list['Company_id'].'" class="company_phone">'.$list['phone_number'].'</div>';
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
                $st='a'.$list['showstatus'];
                $st='<a href="'. RELA_DIR.'zamin/?component=company&action=edit&id='.$list['Company_id'].'&showStatus='.$internal['showstatus']
                    .'">ویرایش</a> <br/>
                        <a href="'.RELA_DIR.'zamin/?component=product&id='.$list['Company_id'].'">لیست محصولات</a><br/>
                        <a href="'.RELA_DIR.'zamin/?component=honour&id='.$list['Company_id'].'">لیست افتخارات</a><br/>
                        <a href="'.RELA_DIR.'zamin/?component=licence&id='.$list['Company_id'].'">لیست مجوز ها</a><br/>
                        <a href="'.RELA_DIR.'zamin/?component=company&action=delete&id='.$list['Company_id'].$list['company_name'].'">حذف</a>';
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
    public function searchExpire($fields)
    {
        /*echo '<pre/>';
        print_r($fields);
        die();*/

        $company = new adminCompanyModel();

        include_once(ROOT_DIR . "model/datatable.converter.php");
        $i=0;
        $columns = array(
            array( 'db' => 'Company_id', 'dt' =>$i++),
            array( 'db' => 'company_name', 'dt' =>$i++),
            array( 'db' => 'phone_number', 'dt' =>$i++),
            array( 'db' => 'refresh_date',   'dt' => $i++),
            array( 'db' => 'address_address', 'dt' => $i++ ),
            array( 'db' => 'email_email', 'dt' => $i++ ),
            array( 'db' => 'website_url', 'dt' => $i++ ),
            array( 'db' => 'status', 'dt' => $i++ ),
            array( 'db' => 'Company_id', 'dt' => $i++ )
        );
        $convert=new convertDatatableIO();
        $convert->input=$fields;
        $convert->columns=$columns;
        $searchFields= $convert->convertInput();

        $date = date('Y-m-d', strtotime(COMPANY_EXPIRE_PERIOD));
        // print_r_debug($date);
        $searchFields['where'] = 'where refresh_date < '."'$date'";
        //print_r_debug($searchFields);

        $result = $company->getCompany($searchFields);
        if ($result['result'] != '1') {
            $this->fileName = 'admin.company.showList.php';
            $this->template('', $result['msg']);
            die();
        }
        $list['list']=$company->list;
        $list['paging']=$company->recordsCount;

        $other['2']=array(
            'formatter' =>function($list)
            {
                $st='<div data-company_id="'.$list['Company_id'].'" class="company_phone">'.$list['phone_number'].'</div>';

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
                $st='<a href="'. RELA_DIR.'zamin/?component=company&action=edit&id='.$list['Company_id'].'&showStatus='.$internal['showstatus']
                    .'">ویرایش</a> <br/>
                        <a href="'.RELA_DIR.'zamin/?component=product&id='.$list['Company_id'].'">لیست محصولات</a><br/>
                        <a href="'.RELA_DIR.'zamin/?component=honour&id='.$list['Company_id'].'">لیست افتخارات</a><br/>
                        <a href="'.RELA_DIR.'zamin/?component=licence&id='.$list['Company_id'].'">لیست مجوز ها</a><br/>
                        <a href="'.RELA_DIR.'zamin/?component=company&action=delete&id='.$list['Company_id'].$list['company_name'].'">حذف</a>';
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

        $company = new adminCompanyModel();

        include_once(ROOT_DIR . "model/datatable.converter.php");
        $i=0;
        $columns = array(
            array( 'db' => 'Company_id', 'dt' =>$i++),
            array( 'db' => 'company_name', 'dt' =>$i++),
            array( 'db' => 'phone_number', 'dt' =>$i++),
            array( 'db' => 'city_name',   'dt' => $i++),
            array( 'db' => 'address_address', 'dt' => $i++ ),
            array( 'db' => 'email_email', 'dt' => $i++ ),
            array( 'db' => 'website_url', 'dt' => $i++ ),
            array( 'db' => 'status', 'dt' => $i++ ),
            array( 'db' => 'logo', 'dt' => $i++ ),
            array( 'db' => 'Company_id', 'dt' => $i++ )
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
        $result = $company->getCompany($searchFields);
        if ($result['result'] != '1') {
            $this->fileName = 'admin.company.showList.php';
            $this->template('', $result['msg']);
            die();
        }
        $list['list']=$company->list;
        $list['paging']=$company->recordsCount;

        $other['2']=array(
            'formatter' =>function($list)
            {
                $st='<div data-company_id="'.$list['Company_id'].'" class="company_phone">'.$list['phone_number'].'</div>';
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
                $st='<a href="'. RELA_DIR.'zamin/?component=company&action=edit&id='.$list['Company_id'].'&showStatus='.$internal['showstatus']
                    .'">ویرایش</a> <br/>
                        <a href="'.RELA_DIR.'zamin/?component=product&id='.$list['Company_id'].'">لیست محصولات</a><br/>
                        <a href="'.RELA_DIR.'zamin/?component=honour&id='.$list['Company_id'].'">لیست افتخارات</a><br/>
                        <a href="'.RELA_DIR.'zamin/?component=licence&id='.$list['Company_id'].'">لیست مجوز ها</a><br/>
                        <a href="'.RELA_DIR.'zamin/?component=company&action=delete&id='.$list['Company_id'].$list['company_name'].'">حذف</a>';
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
        $this->fileName = 'admin.company.showExpireList.php';
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
        $this->fileName = 'admin.company.showUnverifiedList.php';
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
                UPDATE company
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
        include_once dirname(__FILE__).'/admin.company.model.db.php';
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
            $fields['Company_id'] = $i;
            $fields['company_name'] = $cell[19]->getElementsByTagName('Data')[0]->nodeValue;
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


            ///$result = adminCompanyModelDb::insert2($fields);

            // phone 1
            $code = $cell[21]->getElementsByTagName('Data')[0]->nodeValue;
            $number = $cell[22]->getElementsByTagName('Data')[0]->nodeValue;
            $until = $cell[23]->getElementsByTagName('Data')[0]->nodeValue;
            if ($code != '{-}') {
                $fieldsPhone['company_id'] = $i;
                $fieldsPhone['subject'] = 'تلفن 1';
                $fieldsPhone['number'] = $number;
                if ($until != '{-}') {
                    $fieldsPhone['state'] = 'الی';
                    $fieldsPhone['value'] = $until;
                } else {
                    $fieldsPhone['state'] = 'سایر';
                    $fieldsPhone['value'] = '';
                }
                $result = adminCompanyModelDb::insertToPhones2($fieldsPhone);
            }
            // end phone 1

            // phone 2
            $code = $cell[24]->getElementsByTagName('Data')[0]->nodeValue;
            $number = $cell[25]->getElementsByTagName('Data')[0]->nodeValue;
            $until = $cell[26]->getElementsByTagName('Data')[0]->nodeValue;
            if ($code != '{-}') {
                $fieldsPhone['company_id'] = $i;
                $fieldsPhone['subject'] = 'تلفن 2';
                $fieldsPhone['number'] = $number;
                if ($until != '{-}') {
                    $fieldsPhone['state'] = 'الی';
                    $fieldsPhone['value'] = $until;
                } else {
                    $fieldsPhone['state'] = 'سایر';
                    $fieldsPhone['value'] = '';
                }
                $result = adminCompanyModelDb::insertToPhones2($fieldsPhone);
            }
            // end phone 2

            // phone 3
            $code = $cell[27]->getElementsByTagName('Data')[0]->nodeValue;
            $number = $cell[28]->getElementsByTagName('Data')[0]->nodeValue;
            $until = $cell[29]->getElementsByTagName('Data')[0]->nodeValue;
            if ($code != '{-}') {
                $fieldsPhone['company_id'] = $i;
                $fieldsPhone['subject'] = 'تلفن 3';
                $fieldsPhone['number'] = $number;
                if ($until != '{-}') {
                    $fieldsPhone['state'] = 'الی';
                    $fieldsPhone['value'] = $until;
                } else {
                    $fieldsPhone['state'] = 'سایر';
                    $fieldsPhone['value'] = '';
                }
                $result = adminCompanyModelDb::insertToPhones2($fieldsPhone);
            }
            // end phone 3

            // phone 4
            $code = $cell[30]->getElementsByTagName('Data')[0]->nodeValue;
            $number = $cell[31]->getElementsByTagName('Data')[0]->nodeValue;
            $until = $cell[32]->getElementsByTagName('Data')[0]->nodeValue;
            if ($code != '{-}') {
                $fieldsPhone['company_id'] = $i;
                $fieldsPhone['subject'] = 'تلفن 4';
                $fieldsPhone['number'] = $number;
                if ($until != '{-}') {
                    $fieldsPhone['state'] = 'الی';
                    $fieldsPhone['value'] = $until;
                } else {
                    $fieldsPhone['state'] = 'سایر';
                    $fieldsPhone['value'] = '';
                }
                $result = adminCompanyModelDb::insertToPhones2($fieldsPhone);
            }
            // end phone 4

            // fax 1
            $code = $cell[34]->getElementsByTagName('Data')[0]->nodeValue;
            $number = $cell[35]->getElementsByTagName('Data')[0]->nodeValue;
            $until = $cell[36]->getElementsByTagName('Data')[0]->nodeValue;
            if ($code != '{-}') {
                $fieldsFax['company_id'] = $i;
                $fieldsFax['subject'] = 'فکس 1';
                $fieldsFax['number'] = $number;
                if ($until != '{-}') {
                    $fieldsFax['state'] = 'الی';
                    $fieldsFax['value'] = $until;
                } else {
                    $fieldsFax['state'] = 'سایر';
                    $fieldsFax['value'] = '';
                }
                $result = adminCompanyModelDb::insertToPhones2($fieldsFax);
            }
            // end fax 1

            // fax 2
            $code = $cell[37]->getElementsByTagName('Data')[0]->nodeValue;
            $number = $cell[38]->getElementsByTagName('Data')[0]->nodeValue;
            $until = $cell[39]->getElementsByTagName('Data')[0]->nodeValue;
            if ($code != '{-}') {
                $fieldsFax['company_id'] = $i;
                $fieldsFax['subject'] = 'فکس 2';
                $fieldsFax['number'] = $number;
                if ($until != '{-}') {
                    $fieldsFax['state'] = 'الی';
                    $fieldsFax['value'] = $until;
                } else {
                    $fieldsFax['state'] = 'سایر';
                    $fieldsFax['value'] = '';
                }
                $result = adminCompanyModelDb::insertToPhones2($fieldsFax);
            }
            // end fax 2

            // email
            $email = $cell[12]->getElementsByTagName('Data')[0]->nodeValue;
            if ($email != '{-}') {
                $fieldsEmail['company_id'] = $i;
                $fieldsEmail['subject'] = 'ایمیل';
                $fieldsEmail['email'] = $email;
                $result = adminCompanyModelDb::insertToEmails2($fieldsEmail);
            }
            // end email

            // address
            $address = $cell[14]->getElementsByTagName('Data')[0]->nodeValue;
            if ($address != '{-}') {
                $fieldsAddresses['company_id'] = $i;
                $fieldsAddresses['subject'] = 'آدرس';
                $fieldsAddresses['address'] = $address;
                $result = adminCompanyModelDb::insertToAddresses2($fieldsAddresses);
            }
            // end address

            // website
            $website = $cell[11]->getElementsByTagName('Data')[0]->nodeValue;
            if ($website != '{-}') {
                $fieldsWebsite['company_id'] = $i;
                $fieldsWebsite['subject'] = 'وب سایت';
                $fieldsWebsite['website'] = $website;
                $result = adminCompanyModelDb::insertToWebsites2($fieldsWebsite);
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
        redirectPage(RELA_DIR.'zamin/index.php?component=company', $msg);
    }

    /**
     * importCompanyPhones.
     *
     * @return redirectPage
     */
    public function importCompanyPhones()
    {
        include_once dirname(__FILE__).'/admin.company.model.db.php';
        $xml = (STATIC_ROOT_DIR.'/xml/company-phones.xml');
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
            $companyId = $cell[0]->getElementsByTagName('Data')[0]->nodeValue;
            $fields['company_id'] = $cell[0]->getElementsByTagName('Data')[0]->nodeValue;
            $fields['number'] = $cell[1]->getElementsByTagName('Data')[0]->nodeValue;
            $fields['state'] = $cell[2]->getElementsByTagName('Data')[0]->nodeValue;
            $fields['value'] = $cell[3]->getElementsByTagName('Data')[0]->nodeValue;
            $fields['subject'] = 'تلفن';
            $result = adminCompanyModelDb::insertToPhones2($fields);

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
        redirectPage(RELA_DIR.'zamin/index.php?component=company', $msg);
    }
    /**
     * importCompanyEmails.
     *
     * @return redirectPage
     */
    public function importCompanyEmails()
    {
        include_once dirname(__FILE__).'/admin.company.model.db.php';
        $xml = (STATIC_ROOT_DIR.'/xml/company-emails.xml');
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
            $companyId = $cell[0]->getElementsByTagName('Data')[0]->nodeValue;
            $fields['company_id'] = $cell[0]->getElementsByTagName('Data')[0]->nodeValue;
            $fields['subject'] = 'ایمیل';
            $fields['email'] = $cell[1]->getElementsByTagName('Data')[0]->nodeValue;
            $result = adminCompanyModelDb::insertToEmails2($fields);

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
        redirectPage(RELA_DIR.'zamin/index.php?component=company', $msg);
    }
    /**
     * importCompanyAddresses.
     *
     * @return redirectPage
     */
    public function importCompanyAddresses()
    {
        include_once dirname(__FILE__).'/admin.company.model.db.php';
        $xml = (STATIC_ROOT_DIR.'/xml/company-addresses.xml');
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
            $companyId = $cell[0]->getElementsByTagName('Data')[0]->nodeValue;
            $fields['company_id'] = $cell[0]->getElementsByTagName('Data')[0]->nodeValue;
            $fields['subject'] = 'آدرس';
            $fields['address'] = $cell[1]->getElementsByTagName('Data')[0]->nodeValue;
            $result = adminCompanyModelDb::insertToAddresses2($fields);

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
        redirectPage(RELA_DIR.'zamin/index.php?component=company', $msg);
    }
    /**
     * importCompanyWebsites.
     *
     * @return redirectPage
     */
    public function importCompanyWebsites()
    {
        include_once dirname(__FILE__).'/admin.company.model.db.php';
        $xml = (STATIC_ROOT_DIR.'/xml/company-websites.xml');
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
            $companyId = $cell[0]->getElementsByTagName('Data')[0]->nodeValue;
            $fields['company_id'] = $cell[0]->getElementsByTagName('Data')[0]->nodeValue;
            $fields['subject'] = 'وب سایت';
            $fields['url'] = $cell[1]->getElementsByTagName('Data')[0]->nodeValue;
            $result = adminCompanyModelDb::insertToWebsites2($fields);

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
        redirectPage(RELA_DIR.'zamin/index.php?component=company', $msg);
    }
    /**
     * delete deleteCompany by company_id.
     *
     * @param $id
     *
     * @author malekloo
     * @date 2/24/2015
     *
     * @version 01.01.01
     */

    public function deleteCompany($id)
    {
        $company = new adminCompanyModel();

        if (!validator::required($id) and !validator::Numeric($id)) {
            $msg = 'یافت نشد';
            redirectPage(RELA_DIR.'zamin/index.php?component=company', $msg);
        }
        $result = $company->getCompanyById($id);
        if ($result['result'] != '1') {
            $msg = $result['msg'];
            redirectPage(RELA_DIR.'zamin/index.php?component=company', $msg);
        }

        include_once ROOT_DIR.'/component/product/admin/model/admin.product.model.php';
        $product = new adminProductModel();

        $result = $product->getProductByCompanyId($id);

        if ($result['export']['recordsCount'] > 0) {
            $msg = 'توجه : ابتدا محصولات این کمپانی را حذف تنایید.';
            redirectPage(RELA_DIR.'zamin/index.php?component=company', $msg);
        }

        $result = $company->delete();

        if ($result['result'] != '1') {
            redirectPage(RELA_DIR.'zamin/index.php?component=company', $msg);
        }

        $msg = 'عملیات با موفقیت انجام شد';
        redirectPage(RELA_DIR.'zamin/index.php?component=company', $msg);
        die();
    }
    public function call($fields)
    {
        include_once dirname(__FILE__).'/php-ami-class.php';
        $conn = new AstMan();
        $ret = $conn->clickToCall($fields['number']);
        die();
    }

    public function getCompanyphone($input)
    {
        $company_id =   $input['company_id'];
        include_once dirname(__FILE__).'/admin.company.model.php';
        $model = new adminCompanyModel();
        $result = $model->getCompanyphoneAll($company_id);
        $phone='';
        foreach ($result['export']['list'] as $key => $value ){
            $phone .='<h4><a class="btn btn-default company_allphone label label-default" href="#" role="button" data-myphonenumber="'.$value.'" data-mycompanyid="'.$company_id.'"><span class="glyphicon glyphicon-phone-alt"></span></a><span>'.$value.'</span></h4>';

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
