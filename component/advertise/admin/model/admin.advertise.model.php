<?php
/**
 * Created by PhpStorm.
 * User: marjani
 * Date: 3/06/2016
 * Time: 12:08 AM
 */
class adminAdvertiseModel
{
    /**
     * @var
     */
    private $TableName;

    /**
     * set fields by post arrived
     *
     * @var
     */
    private $fields;  // other record fields

    /**
     * @var
     */
    private $list;  // other record fields

    /**
     * @var
     */
    private $recordsCount;  // other record fields


    /**
     * @var
     */
    private $result;

    /**
     * adminAdvertiseModel constructor.
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
     *
     * @param $field
     * @return mixed
     * @author marjani
     * @date 3/06/2015
     * @version 01.01.01
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
     * set the values that have been received through post
     *
     * @param $input
     * @return mixed
     * @author marjani
     * @date 3/06/2015
     * @version 01.01.01
     */
    public function setFields ($input)
    {

        foreach($input as $field =>$val)
        {
            $funcName='__set'.ucfirst($field);

            if(method_exists($this,$funcName))
            {
                $result=$this->$funcName($val);
                if($result['result']==1)
                {
                    $this->fields[$field]=$val;
                }else
                {
                    return $result;
                }
            }
        }

        $result['result']=1;
        return $result;
    }

    /**
     * set the values that have been received through post
     *
     * @param $input
     * @return mixed
     * @author marjani
     * @date 3/06/2015
     * @version 01.01.01
     */
    private function __setTitle ($input)
    {

        if(!Validator::required($input))
        {
            $result['result']=-1;
            $result['msg']='pleas enter title';
        }else
        {
            $result['result'] = 1;
        }

        return $result;
    }

    /**
     * set the values that have been received through post
     *
     * @param $input
     * @return mixed
     * @author marjani
     * @date 3/06/2015
     * @version 01.01.01
     */
    private function __setBrif_description ($input)
    {
        if($input=='')
        {
            $result['result'] = 1;
        }else if(!Validator::required($input))
        {
            $result['result']=-1;
            $result['msg']='pleas enter Brif description';
        }else
        {
            $result['result'] = 1;
        }
        return $result;
    }






    /**
     * set the values that have been received through post
     *
     * @param $input
     * @return mixed
     * @author marjani
     * @date 3/06/2015
     * @version 01.01.01
     */
    private function __setCategory_id ($input)
    {

        if($input=='')
        {
            $result['result'] = 1;
        }
        else if(!Validator::required($input) || count($input) == 0)
        {
            $result['result']=-1;
            $result['msg']='pleas enter Category';
        }else
        {
            $result['result'] = 1;
        }

        return $result;
    }

    /**
     * set the values that have been received through post
     *
     * @param $input
     * @return mixed
     * @author marjani
     * @date 3/06/2015
     * @version 01.01.01
     */
    private function __setImage ($input)
    {
        if($input=='')
        {
            $result['result'] = 1;
        }else if(!Validator::required($input))
        {
            $result['result']=-1;
            $result['msg']='pleas enter Image';
        }else
        {
            $result['result'] = 1;
        }
        return $result;
    }
    /**
     * set the values that have been received through post
     *
     * @param $input
     * @return mixed
     * @author marjani
     * @date 3/06/2015
     * @version 01.01.01
     */
    private function __setUrl ($input)
    {

        if(!Validator::required($input))
        {
            $result['result']=-1;
            $result['msg']='pleas enter url';
        }else
        {
            $result['result'] = 1;
        }

        return $result;
    }

    /**
     * get advertise by id
     *
     * @param $id
     * @return mixed
     * @author marjani
     * @date 3/06/2015
     * @version 01.01.01
     */
    public function getAdvertiseById($id)
    {
        include_once(dirname(__FILE__)."/admin.advertise.model.db.php");

        $result=adminAdvertiseModelDb::getAdvertiseById($id);

        if($result['result']!=1)
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

        $this->fields=$result['export']['list'];
        return $result;
    }

    /**
     * get all advertise
     *
     * @param $fields
     * @return mixed
     * @author marjani
     * @date 3/06/2015
     * @version 01.01.01
     */
    public function getAdvertise($fields)
    {
        include_once(dirname(__FILE__)."/admin.advertise.model.db.php");

        $result=adminAdvertiseModelDb::getAdvertise($fields);

        if($result['result']!=1)
        {
            return $result;
        }
        $this->list=$result['export']['list'];
        $this->recordsCount=$result['export']['recordsCount'];

        return $result;
    }

    /**
     * add new advertise
     *
     * @return mixed
     * @author marjani
     * @date 3/06/2015
     * @version 01.01.01
     */
    public function add()
    {

        $category_idString = ',';
        foreach($this->fields['category_id'] as $key => $value)
        {
            $category_idString .= $value.",";
        }
        if(strlen($category_idString)<2)
        {
            $result['result'] = -1;
            $result['msg'] = 'دسته بندی انتخاب نشده است';
            return $result;
        }
        $this->fields['category_id'] = $category_idString;
        include_once(dirname(__FILE__)."/admin.advertise.model.db.php");
        $result=adminAdvertiseModelDb::insert($this->fields);

        $this->fields['Advertise_id']=$result['export']['insert_id'];
        return $result;
    }

    /**
     * edit advertise by advertise_id
     *
     * @return mixed
     * @author marjani
     * @date 3/06/2015
     * @version 01.01.01
     */
    public function edit()
    {
        $category_idString = ',';
        foreach($this->fields['category_id'] as $key => $value)
        {
            $category_idString .= $value.",";
        }
        if(strlen($category_idString)<2)
        {
            $result['result'] = -1;
            $result['msg'] = 'دسته بندی انتخاب نشده است';
            return $result;
        }
        $this->fields['category_id'] = $category_idString;
        //echo "<pre>"; print_r($this->fields);die();
        include_once(dirname(__FILE__)."/admin.advertise.model.db.php");
        $result=adminAdvertiseModelDb::update($this->fields);
        return $result;
    }

    /**
     * delete advertise by advertise_id
     *
     * @return mixed
     * @author mahdi marjani moghadam <marjani@dabacenter.ir>
     * @date 3/06/2015
     * @version 01.01.01
     */
    public function delete()
    {
        include_once(dirname(__FILE__)."/admin.advertise.model.db.php");
        $result=adminAdvertiseModelDb::delete($this->fields);
        return $result;
    }



}