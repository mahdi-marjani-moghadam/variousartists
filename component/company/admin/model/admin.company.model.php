<?php
/**
 * Created by PhpStorm.
 * User: marjani
 * Date: 3/6/2015
 * Time: 10:35 AM
 */

include_once(ROOT_DIR . "/common/validators.php");

class adminCompanyModel
{
    private $fields;  // other record fields
    private $list;  // other record fields
    private $result;

    /**
     * adminRegisterModel constructor.
     */
    public function __construct()
    {

        $this->requiredFields = array(
            'company_name' => ''

        );
    }

    /**
     * @param $field
     * @return mixed
     * @author malekloo
     * @date 3/6/2015
     * @version 01.01.01
     */
    public function __get($field)
    {
        if($field == 'result')
        {
            return $this->result;
        } else if($field == 'fields')
        {
            return $this->fields;
        } else if($field == 'list')
        {
            return $this->list;
        } else
        {
            return $this->fields[$field];
        }

    }

    /**
     * validator controller
     *
     * @param $input
     * @return mixed
     * @author malekloo
     * @date 3/6/2015
     * @version 01.01.01
     */
    public function setFields($input)
    {
        foreach($input as $field => $val)
        {
            $funcName = '__set' . ucfirst($field);
            if(method_exists($this, $funcName))
            {
                $result = $this->$funcName($val);

                if($result['result'] == '1')
                {
                    if(!isset($result['val']))
                    {
                        $this->fields[$field] = $val;
                    } else
                    {
                        $this->fields[$field] = $result['val'];
                    }
                } else
                {
                    return $result;
                }
            }
        }
        $result['result'] = 1;

        return $result;
    }

    public function setPhoneFields($input)
    {
        print_r($input);
        die();
        foreach($input as $field => $val)
        {

        }
        $result['result'] = 1;

        return $result;
    }

    public function setEmailFields($input)
    {

        foreach($input as $field => $val)
        {

        }
        $result['result'] = 1;

        return $result;
    }

    public function setAddressFields($input)
    {

        foreach($input as $field => $val)
        {

        }
        $result['result'] = 1;

        return $result;
    }

    public function setWebsiteFields($input)
    {

        foreach($input as $field => $val)
        {

        }
        $result['result'] = 1;

        return $result;
    }

    /**
     * check subject
     *
     * @param $input
     * @return mixed
     * @author malekloo
     * @date 3/6/2015
     * @version 01.01.01
     */
    private function __setCompany_name($input)
    {
        if(!Validator::required($input))
        {
            $result['result'] = -1;
            $result['msg'] = 'لطفا نام کمپانی را وارد نمایید.';
        } else
        {
            $result['result'] = 1;
        }

        return $result;
    }

    /**
     * check subject
     *
     * @param $input
     * @return mixed
     * @author malekloo
     * @date 3/6/2015
     * @version 01.01.01
     */
    private function __setDescription($input)
    {
        $result['result'] = 1;

        return $result;

        if(!Validator::required($input))
        {
            $result['result'] = -1;
            $result['msg'] = 'لطفا توضیحات را وارد نمایید.';
        } else
        {
            $result['result'] = 1;
        }

        return $result;
    }

    /**
     * check subject
     *
     * @param $input
     * @return mixed
     * @author malekloo
     * @date 3/6/2015
     * @version 01.01.01
     */
    private function __setLogo($input)
    {
        $result['result'] = 1;

        return $result;
    }

    /**
     * check subject
     *
     * @param $input
     * @return mixed
     * @author malekloo
     * @date 3/6/2015
     * @version 01.01.01
     */
    private function __setRegistration_number($input)
    {
        $result['result'] = 1;

        return $result;
    }

    /**
     * check subject
     *
     * @param $input
     * @return mixed
     * @author malekloo
     * @date 3/6/2015
     * @version 01.01.01
     */
    private function __setNational_id($input)
    {
        $result['result'] = 1;

        return $result;
    }

    /**
     * check subject
     *
     * @param $input
     * @return mixed
     * @author malekloo
     * @date 3/6/2015
     * @version 01.01.01
     */
    private function __setCategory_id($input)
    {
        $result['result'] = 1;

        return $result;
    }

    /**
     * check subject
     *
     * @param $input
     * @return mixed
     * @author malekloo
     * @date 3/6/2015
     * @version 01.01.01
     */
    private function __setCertification_id($input)
    {
        $result['result'] = 1;

        return $result;
    }

    /**
     * check subject
     *
     * @param $input
     * @return mixed
     * @author malekloo
     * @date 3/6/2015
     * @version 01.01.01
     */
    private function __setCompany_phone1($input)
    {
        $result['result'] = 1;

        return $result;
    }

    /**
     * check subject
     *
     * @param $input
     * @return mixed
     * @author malekloo
     * @date 3/6/2015
     * @version 01.01.01
     */
    private function __setCompany_phone2($input)
    {
        $result['result'] = 1;

        return $result;
    }

    /**
     * check subject
     *
     * @param $input
     * @return mixed
     * @author malekloo
     * @date 3/6/2015
     * @version 01.01.01
     */
    private function __setAddress($input)
    {
        $result['result'] = 1;

        return $result;
    }

    /**
     * check subject
     *
     * @param $input
     * @return mixed
     * @author malekloo
     * @date 3/6/2015
     * @version 01.01.01
     */
    private function __setFax($input)
    {
        $result['result'] = 1;

        return $result;
    }

    /**
     * check subject
     *
     * @param $input
     * @return mixed
     * @author malekloo
     * @date 3/6/2015
     * @version 01.01.01
     */
    private function __setEmail($input)
    {
        $result['result'] = 1;

        return $result;
    }

    /**
     * check subject
     *
     * @param $input
     * @return mixed
     * @author malekloo
     * @date 3/6/2015
     * @version 01.01.01
     */
    private function __setMeta_keyword($input)
    {
        $result['result'] = 1;

        return $result;
    }

    /**
     *check email
     *
     * @param $input
     * @return mixed
     * @author malekloo
     * @date 3/6/2015
     * @version 01.01.01
     */
    private function __setSite($input)
    {

        $result['result'] = 1;

        return $result;
    }

    /**
     * check subject
     *
     * @param $input
     * @return mixed
     * @author malekloo
     * @date 3/6/2015
     * @version 01.01.01
     */
    private function __setInstagram($input)
    {
        $result['result'] = 1;

        return $result;
    }

    /**
     * check subject
     *
     * @param $input
     * @return mixed
     * @author malekloo
     * @date 3/6/2015
     * @version 01.01.01
     */
    private function __setTwitter($input)
    {
        $result['result'] = 1;

        return $result;
    }

    /**
     * check subject
     *
     * @param $input
     * @return mixed
     * @author malekloo
     * @date 3/6/2015
     * @version 01.01.01
     */
    private function __setTelegram($input)
    {
        $result['result'] = 1;

        return $result;
    }

    /**
     * check subject
     *
     * @param $input
     * @return mixed
     * @author malekloo
     * @date 3/6/2015
     * @version 01.01.01
     */
    private function __setStatus($input)
    {
        $result['result'] = 1;

        return $result;
    }

    /**
     * check subject
     *
     * @param $input
     * @return mixed
     * @author malekloo
     * @date 3/6/2015
     * @version 01.01.01
     */
    private function __setRefresh_date($input)
    {
        $result['result'] = 1;
        // $this->fields['refresh_date'] = convertJToGDate($input);
        return $result;
    }

    /**
     * check coordinator_name
     *
     * @param $input
     * @return mixed
     * @author malekloo
     * @date 3/6/2015
     * @version 01.01.01
     */
    private function __setCoordinator_name($input)
    {
        $result['result'] = 1;

        return $result;

        if(!Validator::required($input))
        {
            $result['result'] = -1;
            $result['msg'] = 'لطفا نام نماینده را وارد نمایید.';
        } else
        {
            $result['result'] = 1;
        }

        return $result;
    }

    /**
     * check Coordinator_family
     *
     * @param $input
     * @return mixed
     * @author malekloo
     * @date 3/6/2015
     * @version 01.01.01
     */
    private function __setCoordinator_family($input)
    {
        $result['result'] = 1;

        return $result;

        if(!Validator::required($input))
        {
            $result['result'] = -1;
            $result['msg'] = 'لطفا نام خانوادگی نماینده را وارد نمایید.';
        } else
        {
            $result['result'] = 1;
        }

        return $result;
    }

    /**
     * check __setCoordinator_phone
     *
     * @param $input
     * @return mixed
     * @author malekloo
     * @date 3/6/2015
     * @version 01.01.01
     */
    private function __setCoordinator_phone($input)
    {
        $result['result'] = 1;

        return $result;

        if(!Validator::required($input))
        {
            $result['result'] = -1;
            $result['msg'] = 'لطفا تلفن نماینده را وارد نمایید.';
        } else
        {
            $result['result'] = 1;
        }

        return $result;
    }

    /**
     * @param $input
     * @return mixed
     */
    private function __setCompany_phone($input)
    {
        $result['result'] = 1;

        foreach($input['subject'] as $i => $value)
        {
            if(!Validator::required($value) || !Validator::required($input['number'][$i]))
            {
                if(!Validator::required($value))
                {
                    $result['result'] = -1;
                    $result['msg'] = 'لطفا عنوان شماره تلفن را وارد نمایید.';
                } elseif(!Validator::required($input['number'][$i]) || !Validator::Numeric($input['number'][$i]))
                {
                    $result['result'] = -1;
                    $result['msg'] = 'لطفا شماره تلفن را صحیح وارد نمایید.';
                }
            }
        }

        return $result;
    }

    /**
     * @param $input
     * @return mixed
     */
    private function __setCompany_email($input)
    {
        $result['result'] = 1;

        foreach($input['subject'] as $i => $value)
        {
            if(!Validator::required($value) || !Validator::required($input['email'][$i]))
            {

                if(!Validator::required($value))
                {
                    $result['result'] = -1;
                    $result['msg'] = 'لطفا موضوع ایمیل را وارد نمایید.';
                } elseif(!Validator::required($input['email'][$i]) || !Validator::Email($input['email'][$i]))
                {
                    $result['result'] = -1;
                    $result['msg'] = 'لطفا ایمیل را صحیح وارد نمایید.';
                }
            }
        }

        return $result;
    }

    /**
     * @param $input
     * @return mixed
     */
    private function __setCompany_address($input)
    {
        $result['result'] = 1;

        foreach($input['subject'] as $i => $value)
        {
            if(!Validator::required($value) || !Validator::required($input['address'][$i]))
            {
                if(!Validator::required($value))
                {
                    $result['result'] = -1;
                    $result['msg'] = 'لطفا موضوع آدرس را وارد نمایید.';
                } elseif(!Validator::required($input['address'][$i]))
                {
                    $result['result'] = -1;
                    $result['msg'] = 'لطفا آدرس را وارد نمایید.';
                }
            }
        }

        return $result;
    }

    private function __setCity_id($input)
    {
        $result['result'] = 1;

        return $result;
    }

    private function __setState_id($input)
    {
        $result['result'] = 1;

        return $result;
    }

    /**
     * @param $input
     * @return mixed
     */
    private function __setCompany_website($input)
    {
        $result['result'] = 1;

        foreach($input['subject'] as $i => $value)
        {
            if(!Validator::required($value) || !Validator::required($input['url'][$i]))
            {
                if(!Validator::required($value))
                {
                    $result['result'] = -1;
                    $result['msg'] = 'لطفا موضوع وب سایت را وارد نمایید.';
                } elseif(!Validator::required($input['url'][$i]))
                {
                    $result['result'] = -1;
                    $result['msg'] = 'لطفا آدرس وب سایت را وارد نمایید.';
                }
            }
        }

        return $result;
    }

    /**
     * @param $input
     * @return mixed
     */
    private function __setPriority($input)
    {
        $result['result'] = 1;

        return $result;
    }

    /**
     * add company us
     *
     * @return mixed
     * @author malekloo
     * @date 3/6/2015
     * @version 01.01.01
     */
    public function addCompany()
    {

        foreach($this->requiredFields as $field => $val)
        {
            $requiredList[$field] = $this->fields[$field];
        }

        $result = $this->setFields($requiredList);
        if($result['result'] == -1)
        {
            return $result;
        }

        include_once(dirname(__FILE__) . "/admin.company.model.db.php");

        // echo "<pre>";
        // print_r($this->fields);
        // die();

        $result = adminCompanyModelDb::insert($this->fields);
        if($result['result'] != 1)
        {
            return $result;
        }

        $this->fields['Company_id'] = $result['export']['insert_id'];

        $result = adminCompanyModelDb::insertToPhones($this->fields, $this->fields['Company_id']);
        if($result['result'] != 1)
        {
            return $result;
        }

        $result = adminCompanyModelDb::insertToEmails($this->fields, $this->fields['Company_id']);
        if($result['result'] != 1)
        {
            return $result;
        }

        $result = adminCompanyModelDb::insertToAddresses($this->fields, $this->fields['Company_id']);
        if($result['result'] != 1)
        {
            return $result;
        }

        $result = adminCompanyModelDb::insertToWebsites($this->fields, $this->fields['Company_id']);
        if($result['result'] != 1)
        {
            return $result;
        }

        return $result;
    }


    /**
     * edit company by Company_id
     *
     * @return mixed
     * @author malekloo
     * @date 3/06/2015
     * @version 01.01.01
     */
    public function edit()
    {
        foreach($this->requiredFields as $field => $val)
        {
            $requiredList[$field] = $this->fields[$field];
        }
        $result = $this->setFields($requiredList);


        if($result['result'] == -1)
        {
            return $result;
        }

        include_once(dirname(__FILE__) . "/admin.company.model.db.php");
        // companies
        $result = adminCompanyModelDb::update($this->fields);
        if($result['result'] != 1)
        {
            return $result;
        }
        // phones
        $result = adminCompanyModelDb::deletePhones($this->fields['Company_id']);
        if($result['result'] != 1)
        {
            return $result;
        }
        $result = adminCompanyModelDb::insertToPhones($this->fields,$this->fields['Company_id']);
        if($result['result'] != 1)
        {
            return $result;
        }
        // emails
        $result = adminCompanyModelDb::deleteEmails($this->fields['Company_id']);
        if($result['result'] != 1)
        {
            return $result;
        }
        $result = adminCompanyModelDb::insertToEmails($this->fields,$this->fields['Company_id']);
        if($result['result'] != 1)
        {
            return $result;
        }
        // addresses
        $result = adminCompanyModelDb::deleteAddresses($this->fields['Company_id']);
        if($result['result'] != 1)
        {
            return $result;
        }
        $result = adminCompanyModelDb::insertToAddresses($this->fields,$this->fields['Company_id']);
        if($result['result'] != 1)
        {
            return $result;
        }
        // websites
        $result = adminCompanyModelDb::deleteWebsites($this->fields['Company_id']);
        if($result['result'] != 1)
        {
            return $result;
        }
        $result = adminCompanyModelDb::insertToWebsites($this->fields,$this->fields['Company_id']);
        if($result['result'] != 1)
        {
            return $result;
        }

        return $result;
    }


    /**
     * get all company
     *
     * @param $fields
     * @return mixed
     * @author malekloo
     * @date 2/24/2015
     * @version 01.01.01
     */
    public function getCompany($fields)
    {
        include_once(dirname(__FILE__) . "/admin.company.model.db.php");


        $result = adminCompanyModelDb::getCompany($fields);
        if($result['result'] != 1)
        {
            return $result;
        }
        $this->list = $result['export']['list'];
        $this->recordsCount = $result['export']['recordsCount'];

        return $result;
    }

    /**
     * get getCompanyById
     *
     * @param $id
     * @return mixed
     */
    public function getCompanyById($id)
    {
        include_once(dirname(__FILE__) . "/admin.company.model.db.php");

        $result = adminCompanyModelDb::getCompanyById($id);

        if($result['result'] != 1)
        {
            return $result;
        }

        /*$resultSet=$this->setFields($result['list']);
        if($resultSet!=1)
        {
            return $resultSet;
        }
        $result['result']=1;
        $result['list']= $this->fields;
        return $result;
        */
        //or

        $this->fields = $result['export']['list'];

        return $result;
    }

    /**
     * delete company by company_id
     *
     * @return mixed
     * @author mahmoud malekloo <mahmoud.malekloo@gmail.com>
     * @date 2/24/2015
     * @version 01.01.01
     */
    public function delete()
    {
        include_once(dirname(__FILE__) . "/admin.company.model.db.php");
        $result = adminCompanyModelDb::delete($this->fields['Company_id']);

        return $result;
    }

    
    public function getCompanyphoneAll($input){
        include_once(dirname(__FILE__) . "/admin.company.model.db.php");
        $result = adminCompanyModelDb::getAllPhone($input);

        if($result['result']!=1)
        {
            return $result;
        }

        $this->list=$result['export']['list'];

        return $result;
    }

}
