<?php
namespace Component\contactus\model;
use Common\looeic;
use Common\validators;

class contactusModel extends looeic
{
    private $fields;  // other record fields
    private $list;  // other record fields

    private $result;

    public function addContactus()
    {
        // include_once(dirname(__FILE__) . "/contactus.model.db.php");

        $result = contactusModelDb::insert($this->fields);


        if ($result['result'] != 1) {
            return $result;
        }

        $this->fields['Contact_id'] = $result['export']['insert_id'];


        return $result;
    }
}
