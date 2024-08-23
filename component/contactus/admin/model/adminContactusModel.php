<?php


namespace  Component\contactus\admin\model;

use Common\looeic;
use Component\contactus\admin\model\adminContactusModelDb;

class adminContactusModel extends looeic
{
    public $list;
    public $recordsCount;
    protected $TABLE_NAME = 'contactus';


    public function getContactusById($id)
    {

        $result = adminContactusModelDb::getContactusById($id);

        if ($result['result'] != 1) {
            return $result;
        }

        $this->fields = $result['list'];
        return $result;
    }


    public function getContactus($fields)
    {

        $result = (new adminContactusModelDb)->getContactus($fields);

        if ($result['result'] != 1) {
            return $result;
        }
        $this->list = $result['export']['list'];
        $this->recordsCount = $result['export']['recordsCount'];


        return $result;
    }



    public function add()
    {
        $result = adminContactusModelDb::insert($this->fields);
        $this->fields['Contactus_id'] = $result['export']['insert_id'];
        return $result;
    }


    public function edit()
    {
        include_once(dirname(__FILE__) . "/admin.contactus.model.db.php");
        $result = adminContactusModelDb::update($this->fields);
        return $result;
    }


    public function delete($id = '')
    {
        // include_once(dirname(__FILE__)."/admin.contactus.model.db.php");
        $result = (new adminContactusModelDb)->delete($this->fields);
        return $result;
    }
}
