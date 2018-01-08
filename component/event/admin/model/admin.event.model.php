<?php
/**
 * Created by PhpStorm.
 * User: marjani
 * Date: 3/6/2015
 * Time: 10:35 AM
 */

include_once(ROOT_DIR . "/common/validators.php");

class adminEventModel extends looeic
{
    public $list;
    public $recordsCount;
    protected $TABLE_NAME = 'event';

    /**
     * get all event
     *
     * @param $fields
     * @return mixed
     * @author malekloo
     * @date 2/24/2015
     * @version 01.01.01
     */
    public function getEvent($fields)
    {
        include_once(dirname(__FILE__) . "/admin.event.model.db.php");

        ///$fields['order']['Event_id'] =
        $result = adminEventModelDb::getEvent($fields);

        if($result['result'] != 1)
        {
            return $result;
        }
        $this->list = $result['export']['list'];
        $this->recordsCount = $result['export']['recordsCount'];

        return $result;
    }

    /**
     * get getEventById
     *
     * @param $id
     * @return mixed
     */
    public function getEventById($id)
    {
        include_once(dirname(__FILE__) . "/admin.event.model.db.php");

        $result = adminEventModelDb::getEventById($id);

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


    
    public function getEventphoneAll($input){
        include_once(dirname(__FILE__) . "/admin.event.model.db.php");
        $result = adminEventModelDb::getAllPhone($input);

        if($result['result']!=1)
        {
            return $result;
        }

        $this->list=$result['export']['list'];

        return $result;
    }

}
