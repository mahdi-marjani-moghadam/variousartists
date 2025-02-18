<?php


namespace Component\register\model;

use Common\looeic;
use Common\validators;
use Component\register\model\registerModelDb;

class registerModel extends looeic
{
    private $fields;  // other record fields
    private $list;  // other record fields

    private $result;


    public function __get($field)
    {
        if ($field == 'result') {
            return $this->result;
        } else if ($field == 'fields') {
            return $this->fields;
        } else if ($field == 'list') {
            return $this->list;
        } else {
            return $this->fields[$field];
        }
    }


    private function __setCompany_name($input)
    {
        if (!validators::required($input)) {
            $result['result'] = -1;
            $result['msg'] = 'لطفا نام کمپانی را وارد نمایید.';
        } else {
            $result['result'] = 1;
        }

        return $result;
    }


    private function __setEmail($input)
    {
        if (validators::Email($input) != '1') {
            $result['result'] = -1;
            $result['msg'] = 'ایمیل را به درستی وارد نمایید.';
        } else {
            $result['result'] = 1;
        }

        return $result;
    }


    private function __setAddress($input)
    {
        /*if(!validators::required($input))
        {
            $result['result']=-1;
            $result['msg']='لطفا آدرس را وارد نمایید.';
        }else
        {
            $result['result'] = 1;
        }*/
        $result['result'] = 1;

        return $result;
    }

    private function __setCompany_phone1($input)
    {
        if (!validators::required($input)) {
            $result['result'] = -1;
            $result['msg'] = 'لطفا تلفن را وارد نمایید.';
        } else {
            $result['result'] = 1;
        }

        return $result;
    }



    private function __setCoordinator_name($input)
    {
        if (!validators::required($input)) {
            $result['result'] = -1;
            $result['msg'] = 'لطفا نام نماینده را وارد نمایید.';
        } else {
            $result['result'] = 1;
        }

        return $result;
    }


    private function __setCoordinator_family($input)
    {
        if (!validators::required($input)) {
            $result['result'] = -1;
            $result['msg'] = 'لطفا نام خانوادگی نماینده را وارد نمایید.';
        } else {
            $result['result'] = 1;
        }

        return $result;
    }


    private function __setCoordinator_phone($input)
    {
        if (!validators::required($input)) {
            $result['result'] = -1;
            $result['msg'] = 'لطفا تلفن نماینده را وارد نمایید.';
        } else {
            $result['result'] = 1;
        }

        return $result;
    }

    public function addRegister()
    {
        
        foreach ($this->requiredFields as $field => $val) {
            $requiredList[$field] = $this->fields[$field];
        }
        $result = $this->setFields($requiredList);

        if ($result['result'] == -1) {
            return $result;
        }





        $result = registerModelDb::insert($this->fields);

        if ($result['result'] != 1) {
            return $result;
        }

        $this->fields['Register_id'] = $result['export']['insert_id'];

        return $result;
    }
}
