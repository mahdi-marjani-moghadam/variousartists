<?php
/**
 * Created by PhpStorm.
 * User: marjani
 * Date: 2/27/2016
 * Time: 4:24 PM
 */
include_once(ROOT_DIR."/common/validators.php");
class aboutusModel
{
    private $fields;  // other record fields
    private $list;  // other record fields
    private $recordsCount;  // other record fields



    private $result;

    /**
     * aboutusModel constructor.
     */
    public function __construct()
    {
       /* $this->fields = array(
                                'title'=>  '',
                                'brif_description'=>  '',
                                'description'=>  '',
                                'meta_keyword'=>  '',
                                'meta_description'=>  '',
                                'image'=>  '',
                                'date'=>  ''
                                );*/
    }

    /**
     * @param $field
     * @return mixed
     */
    public function __get($field)
    {
        if ($field == 'result')
        {
            return $this->result;
        }
        else if ($field == 'fields')
        {
            return $this->fields;
        }
        else if ($field == 'list')
        {
            return $this->list;
        }
        else if ($field == 'recordsCount')
        {
            return $this->recordsCount;
        }


        else
        {
            return $this->fields[$field];
        }

    }



    /**
     * get about us
     *
     * @param $fields
     * @return mixed
     * @author marjani
     * @date 2/27/2015
     * @version 01.01.01
     */
    public function getAboutus($fields)
    {
        include_once(dirname(__FILE__)."/aboutus.model.db.php");

        $result=aboutusModelDb::getAboutus($fields);

        if($result['result']!=1)
        {
            return $result;
        }
        $this->list=$result['export']['list'];
        $this->recordsCount=$result['export']['recordsCount'];


        return $result;
    }



}