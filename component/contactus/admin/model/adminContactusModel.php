<?php
/**
 * Created by PhpStorm.
 * User: malek,marjani
 * Date: 2/20/2016
 * Time: 4:24 PM
 * version:01.01.01
 */
namespace Component\vontactus\admin\model;

use Common\looeic;
use Component\contactus\admin\model\adminContactusModelDb;

class adminContactusModel extends looeic
{
    public $list;
    public $recordsCount;
    protected $TABLE_NAME = 'event';






    /**
     * get contactus by id
     *
     * @param $id
     * @return mixed
     * @author malekloo,marjani
     * @date 2/24/2015
     * @version 01.01.01
     */
    public function getContactusById($id)
    {
        // include_once(dirname(__FILE__)."/admin.contactus.model.db.php");

        $result=adminContactusModelDb::getContactusById($id);

        if($result['result']!=1)
        {
            return $result;
        }



        $this->fields=$result['list'];
        return $result;
    }

    /**
     * get all contactus
     *
     * @param $fields
     * @return mixed
     * @author malekloo,marjani
     * @date 2/24/2015
     * @version 01.01.01
     */
    public function getContactus($fields)
    {
        // include_once(dirname(__FILE__)."/admin.contactus.model.db.php");

        $result=(new adminContactusModelDb)->getContactus($fields);

        if($result['result']!=1)
        {
            return $result;
        }
        $this->list=$result['export']['list'];
        $this->recordsCount=$result['export']['recordsCount'];


        return $result;
    }


    /**
     * add new contactus
     *
     * @return mixed
     * @author malekloo,marjani
     * @date 2/24/2015
     * @version 01.01.01
     */
    public function add()
    {
        // include_once(dirname(__FILE__)."/admin.contactus.model.db.php");
        $result=adminContactusModelDb::insert($this->fields);
        $this->fields['Contactus_id']=$result['export']['insert_id'];
        return $result;
    }

    /**
     * edit contactus by contactus_id
     *
     * @return mixed
     * @author malekloo,marjani
     * @date 2/24/2015
     * @version 01.01.01
     */
    public function edit()
    {
        include_once(dirname(__FILE__)."/admin.contactus.model.db.php");
        $result=adminContactusModelDb::update($this->fields);
        return $result;
    }

    /**
     * delete contactus by contactus_id
     *
     * @return mixed
     * @author mahdi marjani moghadam <marjani@dabacenter.ir>
     * @date 2/24/2015
     * @version 01.01.01
     */
    public function delete()
    {
        // include_once(dirname(__FILE__)."/admin.contactus.model.db.php");
        $result=(new adminContactusModelDb)->delete($this->fields);
        return $result;
    }

}