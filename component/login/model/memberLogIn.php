<?php

namespace Component\login\model;

use Common\dbConn;
use Common\validators;
use Component\artists\model\artists;
use Component\category\admin\model\adminCategoryModel;
use Component\genre\admin\model\adminGenreModel;
// use Component\magfa\WebServiceSample;
use Component\province\model\province;
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;
use Model\clsCountry;
use PDO;

class memberLogIn
{

    private $_rasParameter;
    private $_existCompany = '';
    private $_Domain = '';
    private $_Arguments;
    private $_requiredFields;
    public $fileName;
    /**
     * Contains file type.
     *
     * @var
     */
    public $exportType;


    /**
     * articleController constructor.
     */
    public function __construct()
    {
        $this->exportType = 'html';
        $this->_requiredFields = ["username", "password", "artists_name", "logo"];
    }

    public function __set($field, $value)
    {
        switch ($field) {
            case 'rasParameter':
                $this->_rasParameter = $value;
                break;
            case 'existCompany':
                $this->_set_existCompany($value);
                break;
            case 'Domain':
                $this->_set_Domain($value);
                break;
        }
    }

    private function _set_existCompany($id): void
    {
        if (is_numeric($id)) {
            $this->_existCompany = $id;
        }
    }

    private function _set_Domain($id): void
    {
        if (is_string($id)) {
            $this->_Domain = $id;
        }
    }

    public function __get($property)
    {
        if ($property == 'existCompany') {
            return $this->_get_existCompany();
        } else {
            return false;
        }
    }

    private function _get_existCompany()
    {
        return $this->_existCompany;
    }

    public function __call($methodName, $arguments)
    {

        $_Result = $this->_checkMethod($methodName);

        if ($_Result[0] == 1) {
            $_Result = $this->_set_Arguments($arguments);

            if ($_Result[0] == 1 || $_Result[0] == 0) {
                $methodName = '_' . $methodName;
                $_Result    = $this->$methodName();
                return $_Result;
            } elseif ($_Result[0] == -1) {
                redirectPage(RELA_DIR . 'index.php', $_Result['errMsg']);
                die();
            }
        } elseif ($_Result[0] == 0) {
            redirectPage(RELA_DIR . 'index.php', $_Result['errMsg']);
            die();
        }
    }

    private function _checkMethod()
    {
        $temp = func_get_args();
        if (method_exists($this, "_" . $temp[0])) {
            $_Result[0]     = 1;
            $_Result['Msg'] = "The mathod name is correct";
            return $_Result;
        } else {
            $_Result[0]        = 0;
            $_Result['errMsg'] = "The Method (" . $temp[0] . ") that you call is wrong"; // For Test : The Method (".$temp[0].") that you call is wrong
            return $_Result;
        }
    }

    private function _set_Arguments()
    {
        $temp = func_get_args();
        if (!empty($temp[0])) {

            if (count($temp[0]) == 1) {
                if (!empty($temp[0][0])) {
                    $this->_Arguments = $temp[0][0];
                } else {
                    $_Result[0]        = -1;
                    $_Result['errMsg'] = "The arguments that you sent to class is empty";
                    return $_Result;
                }
            } elseif (count($temp[0]) > 1) {
                for ($i = 0; $i < count($temp[0]); $i++) {
                    if (!empty($temp[0][$i])) {
                        $this->_Arguments[$i] = $temp[0][$i];
                    } else {
                        $this->_set_Arguments_toDefult($this->_Arguments);
                        $_Result[0]        = -1;
                        $_Result['errMsg'] = "The arguments that you sent to class is empty";
                        return $_Result;
                    }
                }
            }

            $_Result[0]     = 1;
            $_Result['Msg'] = "The _Arguments property seted successfully";
            return $_Result;
        } else {
            $_Result[0]     = 0;
            $_Result['Msg'] = "You Dont Sent Any Argument To Method";
            return $_Result;
        }
    }



    private static function GetHash()
    {
        return '%%1^^@@REWcmv21))--';
    }

    function encrypt($string, $key)
    {
        $result = '';
        for ($i = 0; $i < strlen($string); $i++) {
            $char    = substr($string, $i, 1);
            $keychar = substr($key, ($i % strlen($key)) - 1, 1);
            $char    = chr(ord($char) + ord($keychar));
            $result .= $char;
        }

        return base64_encode($result);
    }

    function decrypt($string, $key)
    {
        $result = '';
        $string = base64_decode($string);

        for ($i = 0; $i < strlen($string); $i++) {
            $char    = substr($string, $i, 1);
            $keychar = substr($key, ($i % strlen($key)) - 1, 1);
            $char    = chr(ord($char) - ord($keychar));
            $result .= $char;
        }

        return $result;
    }

    public function template($list = [], $msg = '')
    {
        // global $conn, $lang;
        global $PARAM, $member_info, $lang, $messageStack;
        if ($msg == '') {
            $msg2 = $messageStack->output('login');
        }

        switch ($this->exportType) {
            case 'html':

                include ROOT_DIR . 'templates/' . CURRENT_SKIN . '/title.inc.php';
                include ROOT_DIR . 'templates/' . CURRENT_SKIN . "/$this->fileName";
                include ROOT_DIR . 'templates/' . CURRENT_SKIN . '/tail.inc.php';
                break;

            case 'json':
                echo json_encode($list);
                break;
            case 'array':
                return $list;

            case 'serialize':
                echo serialize($list);
                break;
            default:
                break;
        }
    }


    function showLoginForm($fields = '', $msg = '')
    {


        $this->fileName = 'login.php';
        $this->template($fields, $msg);

        die();
    }

    function showChangePassForm($fields, $msg = '')
    {

        $this->fileName = 'changePass.login.php';
        $this->template($fields, $msg);

        die();
    }


    public function logIn($username = '', $password = '', $reffer = '')
    {
        global  $member_info, $messageStack;



        $conn = dbConn::getConnection();

        if ($username == '') {
            $username = (handleData($_REQUEST["username"]));
        }
        if ($password == '') {

            $password = (handleData($_REQUEST["password"]));
        }


        /** validate */
        $remember_me = 1;
        if ($username == "") {

            $result['result'] = -1;
            $result['msg'] = 'err_01' . '102 : Your Username Or Password Is Incorrect';
            return $result;
        }
        if ($password == "") {
            $result['result'] = -1;
            $result['msg'] = 'err_103 : Your Username Or Password Is Incorrect';
            return $result;
        }

        /** delete session */
        $sql = "DELETE FROM sessions
                    WHERE
                    (last_access_time < (NOW()-36000) and remember_me <> 1 )||  last_access_time < (NOW()-2592000) ";
        $stmt = $conn->prepare($sql);

        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();

        if (!$stmt) {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = $conn->errorInfo();

            return $result;
        }

        /** find user by email or password */
        $sql = "
                SELECT Artists_id 
                      ,status
				FROM   artists
				WHERE  
				(username = '" . $username . "')
				AND    password = '" . md5($password) . "'
				";

        $stmt = $conn->prepare($sql);

        //$stmt->setFetchMode(PDO::FETCH_ASSOC);

        $stmt->execute();
        $row = $stmt->fetch();

        if (!$stmt) {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = $conn->errorInfo();

            return $result;
        }


        if ($stmt->rowCount() > 0 && $row['status'] == 1) {


            $sql = "INSERT INTO sessions (
                                        member_id ,
                                        remote_addr,
                                        last_access_time ,
                                        remember_me)
                VALUES ('" . $row['Artists_id'] . "',
                        '" . $_SERVER["SERVER_ADDR"] . "',
                        NOW() ,
                        '" . $remember_me . "')";

            $stmt = $conn->prepare($sql);
            $stmt->execute();


            $_SESSION["sessionID"] = $this->encrypt($conn->lastInsertId(), $this->GetHash());

            if ($remember_me) {

                setcookie("sessionID", $_SESSION["sessionID"], time() + 2592000, "/", $_SERVER['HTTP_HOST']); // 1 month
            } else {
                setcookie("sessionID", $_SESSION["sessionID"], time() + 3600, "/", $_SERVER['HTTP_HOST']);
            }
        } elseif ($stmt->rowCount() > 0 && $row['status'] == 0) {
            //if enter wrong password in login page add log to radPostAuth
            $result['result'] = -1;
            $result['msg'] = INDEX_0066 . " " . INDEX_0076;
            return $result;
        } else {
            $result['result'] = -1;
            $result['msg'] = "109 : " . LOGIN_PASSWORD1;
            return $result;
        }

        $result['result'] = 1;
        return $result;
    }


    function checkLogin()
    {

        global  $member_info;

        $conn = dbConn::getConnection();
        //print_r($_COOKIE["sessionID"]);
        if (!isset($_SESSION["sessionID"])) {
            if (!isset($_COOKIE["sessionID"])) {
                return -1;
            } else {
                $sessionID = $this->decrypt($_COOKIE["sessionID"], $this->GetHash());
            }
        } else {
            $sessionID = $this->decrypt($_SESSION["sessionID"], $this->GetHash());
        }

        $sql = "select `member_id`
                from   `sessions`
                where  `session_id` = '$sessionID'
                ";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $row = $stmt->fetch();

        if (!$stmt) {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = $conn->errorInfo();

            return $result;
        }


        if ($stmt->rowCount() != 1) {
            return -1;
        }

        $sql = "select * from `artists`
                where `Artists_id` = " . $row['member_id'] . "
                ";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        if (!$stmt) {
            $result['result'] = -1;
            $result['msg'] = $conn->errorInfo();
            return $result;
        }

        if ($stmt->rowCount() != 1) {
            return -1;
        }

        $member_info = $stmt->fetch();

        //added when enter wrong password
        unset($_SESSION['errorLogin']);


        return $member_info;
    }

    function logOut($return = false)
    {
        $conn = dbConn::getConnection();
        global  $member_info;

        if (!isset($_SESSION["sessionID"]) || strlen(($_SESSION["sessionID"])) < 5) {
            if (isset($_COOKIE['sessionID'])) {
                $_SESSION["sessionID"] = ($_COOKIE['sessionID']);
            }
        }

        if (isset($_SESSION["sessionID"])) {
            $sessionTable = $this->_checkLoginBySession();
            //$sessionID = $this->decrypt($_SESSION["sessionID"], $this->GetHash());
            $and = "AND session_id = '" . $sessionTable['session_id'] . "'";
        }

        $sql = "delete from sessions 
                where       member_id ='" . $member_info["Artists_id"] . "'
                $and ";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        if (!$stmt) {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = $conn->errorInfo();

            return $result;
        }

        if ($return == true) {
            $result['result'] = 1;
            return $result;
        } else {
            header("Location:" . RELA_DIR);
        }

        die();
    }

    function showRegisterForm($fields = array(), $msg = '')
    {

        /////// category
        $category = new adminCategoryModel();

        $resultCategory = $category->getCategoryOption();

        if ($resultCategory['result'] == 1) {
            $fields['category'] = $category->list;
        }
        ///////




        /// /////// genre
        $genre = new adminGenreModel();

        $resultGenre = $genre->getGenreOption();

        if ($resultGenre['result'] == 1) {
            $fields['genre'] = $genre->list;
        }



        //////////// province
        $province = province::getAll()->getList();
        //$resultProvince = $province->getStates();
        if ($province['result'] == 1) {
            $fields['provinces'] = $province['export']['list'];
        }





        global $dataStack;
        //////////////////////////////////////////////////
        ////                get country               ////
        //////////////////////////////////////////////////
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




        if (isset($_GET['ref'])) {
            $ref = (new artists)->find($_GET['ref']);
            if (is_object($ref)) {
                $fields['refferer'] = $ref;
            }
        }

        $phraseBuilder = new PhraseBuilder(5, '0123456789');
        $builder = new CaptchaBuilder(null, $phraseBuilder);
        $_SESSION['phrase'] = $builder->getPhrase();
        $captcha = $builder->build();
        $fields['captcha'] = $captcha;





        // $captcha->output();
        // $builder->save('out.jpg');
        // die();
        // dd($builder);




        $this->fileName = 'register.php';
        $this->template($fields, $msg);

        die();
    }

    function register($_input)
    {

        global $messageStack, $lang;

        sendmail('marjani.mahdi@gmail.com', 'register', 'asdfasdf');
        die();
        ///////////////////////// ref 
        if (isset($_input['ref']) && is_numeric($_input['ref'])) {
            $ref = (new artists)->find($_input['ref']);
            if (is_object($ref)) {
                $_input['refferer'] = $ref;
            }
        }
        /////////////////////////////////////////////////////




        ///////////////// captcha

        // $token = $_input['token'];
        // $action = $_input['action'];
        // call curl to POST request
        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
        // curl_setopt($ch, CURLOPT_POST, 1);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('secret' => RECAPTCHA_V3_SECRET_KEY, 'response' => $token)));
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // $response = curl_exec($ch);
        // curl_close($ch);
        // $arrResponse = json_decode($response, true);

        // verify the response
        // if ($arrResponse["success"] != '1' && $arrResponse["action"] != $action && $arrResponse["score"] < 0.5) {
        //     $messageStack->add_session('register', captcha_not_true);
        //     $this->showRegisterForm($_input, captcha_not_true);
        // }
        $captcha = $_input['captcha'];
        $builder = new CaptchaBuilder($_SESSION['phrase']);
        if (!$builder->testPhrase($captcha)) {
            $messageStack->add_session('register', captcha_not_true);
            $this->showRegisterForm($_input, captcha_not_true);
        }

        /////////////////////////////////////////////////////////////////////////////////////
        /////////////////////////////////////////////////////////////////////////////////////
        /////////////////////////////////////////////////////////////////////////////////////


        $_input['username'] = $_input['artists_phone1'];
        if ($_input['email'] != '') {
            $_input['username'] = $_input['email'];
        }

        /** check pass */
        if ($_input['password'] == '') {
            $messageStack->add_session('register', password_not_empty);
            $this->showRegisterForm($_input, password_not_empty);
        }
        //////////////////////////////////////////////////////////////////////







        /** exist user */
        $result = artists::getBy_username($_input['username'])->getList();

        if ($result['export']['recordsCount'] > 0) {
            $messageStack->add_session('register', translate('Exist user'));
            $this->showRegisterForm($_input, translate('Exist user'));
        }




        $artists = new artists;

        /** check category */
        if ($_input['category_id'] == '' and $_input['check1'] == 'on') {
            $messageStack->add_session('register', category_id_not_empty);
            $this->showRegisterForm($_input, category_id_not_empty);
        }


        /////////////////////// artists
        if ($_input['check1'] == 'on') {
            if ($_input['artists_name_fa'] == '') {
                $messageStack->add_session('register', persian_name_is_empty);
                $this->showRegisterForm($_input, persian_name_is_empty);
            }
            if ($_input['artists_name_en'] == '') {
                $messageStack->add_session('register', latin_name_is_empty);
                $this->showRegisterForm($_input, latin_name_is_empty);
            }
            if ($_input['email'] == '') {
                $messageStack->add_session('register', email_is_empty);
                $this->showRegisterForm($_input, email_is_empty);
            }
            // dd($_FILES['logo']);
            if (!file_exists($_FILES['logo']['tmp_name'])) {
                $messageStack->add_session('register', image_is_empty);
                $this->showRegisterForm($_input, image_is_empty);
            }
        }



        if (isset($_input['category_id'])) {
            $_input['category_id'] = "," . (implode(",", $_input['category_id'])) . ",";
        }
        if (isset($_input['genre_id'])) {
            $_input['genre_id'] = "," . (implode(",", $_input['genre_id'])) . ",";
        }
        if ($_input['birthday'] == '') {
            unset($_input['birthday']);
        }


        if ($lang == 'fa' && $_input['birthday'] != '') {
            $_input['birthday'] = convertJToGDate($_input['birthday']);
        }
        $_input['refresh_date'] = date('Y-m-d H:i:s');
        $pass = $_input['password'];
        $_input['password']  = md5($_input['password']);

        // $_input['certification_id'] = '';
        // $_input['registration_number'] = '';
        // $_input['national_id'] = '';
        // $_input['beeptunes'] = '';
        // $_input['show_birthday'] = '';
        // $_input['priority'] = 0;
        // $_input['forgot_code'] = '';
        // $_input['genre_id'] = '';
        // $_input['birthday_city'] = '';



        $artists->setFields($_input);

        $result = $artists->validators();



        if ($result['result'] == -1) {
            $this->showRegisterForm($_input, translate($result['msg']));
            die();
        }

        if ($_input['check1'] == 'on') {

            $artists->type = 1;

            $result = $artists->save();


            // file
            if (file_exists($_FILES['logo']['tmp_name'])) {
                $input['upload_dir'] = ROOT_DIR . 'statics/files/' . $artists->fields['Artists_id'] . '/';
                $input['max_size'] = '20480000';
                // dd($_FILES['logo']["size"]);
                $result = fileUploader($input, $_FILES['logo']);
                $artists->logo = $result['image_name'];
                $result = $artists->save();
            }


            // sms
            // $sms = new WebServiceSample;

            if ($lang == 'fa') {
                $subject = 'ثبت نام';
                $message =
                    'اکانت شما بعد از تایید ادمین فعال می شود.' . " \n " .
                    'اطلاعات حساب شما' . " \n " .
                    "username: " . $artists->username . " \n " .
                    "password: " . $pass . " \n " .
                    "http://variousartist.ir";
            } else {
                $subject = 'register';
                $message =
                    'Your account will be activated after verifying your admin' . " \n " .
                    'Your account information' . " \n " .
                    "username: " . $artists->username . " \n " .
                    "password: " . $pass . " \n " .
                    "http://variousartist.ir";
            }


            // $sms->simpleEnqueueSample($artists->artists_phone1, $message);
            // $res = $sms->send($artists->artists_phone1, $message);


            ///email
            if (checkMail($artists->email) ==  1) {
                sendmail($artists->email, $subject, $message);
            }
        } else {
            $artists->type = 0;
            $artists->status = 1;

            $result = $artists->save();
            if (file_exists($_FILES['logo']['tmp_name'])) {
                $input['upload_dir'] = ROOT_DIR . 'statics/files/' . $artists->fields['Artists_id'] . '/';
                $result = fileUploader($input, $_FILES['logo']);
                $artists->logo = $result['image_name'];
                $result = $artists->save();
            }

            // $sms = new WebServiceSample;

            if ($lang == 'fa') {
                $subject = 'ثبت نام';
                $message =
                    'اطلاعات حساب شما' . " \n " .
                    "username: " . $artists->username . " \n " .
                    "password: " . $pass . " \n " .
                    "http://variousartist.ir";
            } else {
                $subject = 'register';
                $message =
                    'Your account information' . " \n " .
                    "username: " . $artists->username . " \n " .
                    "password: " . $pass . " \n " .
                    "http://variousartist.ir";
            }


            // $sms->simpleEnqueueSample($artists->artists_phone1, $message);
            // $res = $sms->send($artists->artists_phone1, $message);


            ///email
            if (checkMail($artists->email) ==  1) {
                sendmail($artists->email, $subject, $message);
            }
        }
        // $result = $artists->save();








        if ($result['result'] != '1') {
            $messageStack->add_session('register', $result['msg']);
            $this->showLoginForm($_input, $result['msg']);
        }

        $msg = 'عملیات با موفقیت انجام شد';
        $messageStack->add_session('register', $msg);


        
        $result['msg'] = translate('Congratulation. You are registered successfuly.');
        return $result;
    }

    function memberregister($_input)
    {
        global $messageStack, $lang;

        if (checkMail($_input['username']) == 0) {
            $messageStack->add_session('register', email_is_not_valid);
            $this->showLoginForm($_input, email_is_not_valid);
        }

        $result = artists::getBy_username($_input['username'])->getList();

        if ($result['export']['recordsCount'] > 0) {
            $messageStack->add_session('register', translate('Exist user'));
            $this->showLoginForm($_input, translate('Exist user'));
        }



        $artists = new artists;


        $_input['refresh_date'] = date('Y-m-d h:i:s');
        $_input['password']  = md5($_input['password']);

        $artists->setFields($_input);
        $result = $artists->validators();


        /*if($result['result']==-1)
        {
            $this->showLoginForm($_input,translate($result['msg']));
            die();
        }*/

        $artists->status = 1;
        $result = $artists->save();



        if ($result['result'] != '1') {
            $messageStack->add_session('register', $result['msg']);
            $this->showLoginForm($_input, $result['msg']);
        }
        $msg = 'عملیات با موفقیت انجام شد';
        $messageStack->add_session('register', $msg);



        $result['msg'] = register_successfully;
        return $result;
    }

    function registerValidate($fields)
    {

        $fieldsString  = $valuesString = '';
        foreach ($fields as $name => $value) {
            if (in_array($name, $this->_requiredFields) && validators::required($value) == 0) {

                $result['result'] = -1;
                $result['msg'] = INDEX_0127 . ' ' . constant($name) . ' ' . INDEX_0128;
                return $result;
            }

            if ($name == 'password') {
                $value = md5($value);
            }

            $fieldsString .= $name . ',';
            if (is_array($value)) {
                $category_id = '';
                foreach ($value as $k => $values) {
                    $category_id .= $values . ",";
                }
                $valuesString .= "'," . $category_id . "',";
            } else {
                $valuesString .= "'" . $value . "',";
            }
        }

        $fieldsString = substr($fieldsString, 0, -1);
        $valuesString = substr($valuesString, 0, -1);



        $result['result'] = 1;
        $result['msg'] = 'ok';
        $result['fieldsString'] = $fieldsString;
        $result['valuesString'] = $valuesString;
        return $result;
    }

    private function _checkArtistsExist($username)
    {
        $conn = dbConn::getConnection();


        $sql = "select from  artists 
                WHERE
                username = '$username'";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        if (!$stmt) {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = $conn->errorInfo();
            return $result;
        }

        if ($stmt->rowCount() > 0) {
            $result['result'] = -1;
            $result['msg'] = EXIST_USER;
            return $result;
        }

        $result['result'] = 1;
        return $result;
    }



    private function memberPage($message)
    {
        header("Location:" . RELA_DIR);
        echo $message;
    }

    /**
     * explain : check user online
     * @return mixed
     * @author faridcs
     * @date 12/16/2014
     * @version 01.01.01
     */
    private function _checkUserOnline()
    {
        global $conn, $member_info;
        $device = array();

        $sql = "SELECT * FROM `radacct`
                WHERE `acctstoptime` IS NULL
                AND `compid` = '" . $member_info['compid'] . "'
                AND `username` = '" . $member_info['username'] . "'";

        $deviceRS = $conn->Execute($sql);

        if (!$deviceRS) {
            echo $conn->ErrorMsg();
            die();
        }
        if ($deviceRS->RecordCount() != 0) {
            $checkOnline = 1;
        } else {
            $checkOnline = 0;
        }
        $deviceRS->close();

        return $checkOnline;
    }

    /**
     * explain : check user with device mac online
     * @author faridcs
     * @date 12/08/2014
     * @version 01.01.01
     * @param $macAddress
     * @param $username
     * @param $compId
     * @return int
     */


    private function _checkLoginBySession(): array
    {
        $conn = dbConn::getConnection();


        if (!isset($_SESSION["sessionID"])) {
            if (!isset($_COOKIE["sessionID"])) {
                $result['result'] = 0;
                $result['msg'] = 'session Id not exists';
                return $result;
            } else {
                $sessionID = $this->decrypt($_COOKIE["sessionID"], $this->GetHash());
            }
        } else {
            $sessionID = $this->decrypt($_SESSION["sessionID"], $this->GetHash());
        }

        $sql = "SELECT          session_id
                FROM            `sessions`
                WHERE           `session_id`       = '" . $sessionID . "'";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        if (!$stmt) {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = $conn->errorInfo();

            return $result;
        }

        if ($stmt->rowCount() != 1) {

            $result['result'] = 0;
            $result['msg'] = 'user is not login';
        } else {
            $row = $stmt->fetch();

            $result['result'] = 1;
            $result['msg'] = 'user is login';
            $result['session_id'] = $row['session_id'];
        }

        return $result;
    }

    function sendPassword($fields)
    {
        global $member_info;



        if (checkMail($fields['email']) == 1) {
            $obj = artists::getBy_username($fields['email'])->get();
        } else {
            $phone1 = substr($fields['email'], 1); // 0

            $phone2 = '0' . substr($fields['email'], 2); // 98
            $phone3 = substr($fields['email'], 2); // 98

            $obj = artists::getAll()->where('artists_phone1', 'in', $fields['email'] . ',' . $phone1 . ',' . $phone2 . ',' . $phone3)->get();
        }



        if ($obj['export']['recordsCount'] == 0) {
            $result['result'] = -1;
            $result['msg'] = translate('This user in not exist');
            return $result;
        }
        $obj1 = $obj['export']['list'][0];


        $code = uniqid();
        $url =   "'<a href='" . RELA_DIR . 'login/changePass/?user=' . $obj['export']['list'][0]->fields['username'] . '&code=' . $code . "'>" . RELA_DIR . 'login/changePass/?email=' . $obj['export']['list'][0]->fields['username'] . '&code=' . $code . "</a>";

        if (checkMail($obj['export']['list'][0]->fields['username']) == 1) {
            $sendEmail = sendmail($obj['export']['list'][0]->fields['username'], translate('Remember Password'), translate('Your change password link: ') . $url . "<br>" . translate('website: www.variousartists.ir'));

            if ($sendEmail['result'] == -1) {

                $result['result'] = -1;
                $result['msg'] = $sendEmail['msg'];
                return $result;
            }
        }
        if ($obj['export']['list'][0]->fields['artists_phone1'] != '') {
            // $sms = new WebServiceSample;
            $url =  RELA_DIR . 'login/changePass/?email=' . $obj['export']['list'][0]->fields['username'] . '&code=' . $code;
            $message = translate('Your change password link: ') . "\n" . $url . "\n\n" . translate('website: www.variousartists.ir');

            // $sms->simpleEnqueueSample($obj['export']['list'][0]->fields['artists_phone1'], $message);
        }

        $obj1->forgot_code = $code;

        if ($obj1->date == '') {
            $obj1->date = date('Y-m-d H:i:s');
        }
        if ($obj1->birthday == '') {
            $obj1->birthday = date('Y-m-d H:i:s');
        }
        if ($obj1->state_id == '') {
            $obj1->state_id = 1;
        }
        $obj1->save();




        $result['result'] = 1;
        $result['msg'] = Password_sent;
        return $result;
    }


    function checkCode($fields)
    {

        $obj = artists::getBy_username_and_forgot_code($fields['email'], $fields['code'])->get();

        if ($obj['export']['recordsCount'] == 0) {
            $result['result'] = -1;
            $result['msg'] = translate('Information is wrong');
            return $result;
        }

        $result['result'] = 1;
        return $result;
    }
    function changePass($fields)
    {

        $result = $this->checkCode($fields);
        if ($result['result'] == -1) {
            return $result;
        }

        if ($fields['pass'] != $fields['pass_confirm']) {
            $this->showChangePassForm($fields, translate('don`t match'));
        }

        $obj = artists::getBy_email_and_forgot_code($fields['email'], $fields['code'])->get();
        $obj1 = $obj['export']['list'][0];


        $obj1->password = md5($fields['pass']);
        $obj1->forgot_code = '';
        $obj1->save();




        $result['result'] = 1;
        $result['msg'] = translate('Password changed.');
        return $result;
    }
}
