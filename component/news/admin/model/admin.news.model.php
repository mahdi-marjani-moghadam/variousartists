<?php
/**
 * Created by PhpStorm.
 * User: malek,marjani
 * Date: 2/20/2016
 * Time: 4:24 PM
 * version:01.01.01
 */
class adminNewsModel
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
     * adminNewsModel constructor.
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
     * @author malekloo,marjani
     * @date 2/24/2015
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
     * @author malekloo,marjani
     * @date 2/24/2015
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
     * @author malekloo,marjani
     * @date 2/24/2015
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
     * @author malekloo,marjani
     * @date 2/24/2015
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
     * @author malekloo,marjani
     * @date 2/24/2015
     * @version 01.01.01
     */
    private function __setDescription ($input)
    {
        if($input=='')
        {
            $result['result'] = 1;
        }else if(!Validator::required($input))
        {
            $result['result']=-1;
            $result['msg']='pleas enter Description';
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
     * @author malekloo,marjani
     * @date 2/24/2015
     * @version 01.01.01
     */
    private function __setMeta_keyword ($input)
    {
        if($input=='')
        {
            $result['result'] = 1;
        }else if(!Validator::required($input))
        {
            $result['result']=-1;
            $result['msg']='pleas enter Meta_keyword';
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
     * @author malekloo,marjani
     * @date 2/24/2015
     * @version 01.01.01
     */
    private function __setMeta_description ($input)
    {
        if($input=='')
        {
            $result['result'] = 1;
        }else if(!Validator::required($input))
        {
            $result['result']=-1;
            $result['msg']='pleas enter Meta_description';
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
     * @author malekloo,marjani
     * @date 2/24/2015
     * @version 01.01.01
     */
    private function __setDate ($input)
    {
        if($input=='')
        {
            $result['result'] = 1;
        }else if(!Validator::required($input))
        {
            $result['result']=-1;
            $result['msg']='pleas enter Date';
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
     * @author malekloo,marjani
     * @date 2/24/2015
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
     * get news by id
     *
     * @param $id
     * @return mixed
     * @author malekloo,marjani
     * @date 2/24/2015
     * @version 01.01.01
     */
    public function getNewsById($id)
    {
        include_once(dirname(__FILE__)."/admin.news.model.db.php");

        $result=adminNewsModelDb::getNewsById($id);

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
     * get all news
     *
     * @param $fields
     * @return mixed
     * @author malekloo,marjani
     * @date 2/24/2015
     * @version 01.01.01
     */
    public function getNews($fields)
    {
        include_once(dirname(__FILE__)."/admin.news.model.db.php");

        $result=adminNewsModelDb::getNews($fields);

        if($result['result']!=1)
        {
            return $result;
        }
        $this->list=$result['export']['list'];
        $this->recordsCount=$result['export']['recordsCount'];

        return $result;
    }

    /**
     * add new news
     *
     * @return mixed
     * @author malekloo,marjani
     * @date 2/24/2015
     * @version 01.01.01
     */
    public function add()
    {
        include_once(dirname(__FILE__)."/admin.news.model.db.php");
        $result=adminNewsModelDb::insert($this->fields);
        $this->fields['News_id']=$result['export']['insert_id'];
        return $result;
    }

    /**
     * edit news by news_id
     *
     * @return mixed
     * @author malekloo,marjani
     * @date 2/24/2015
     * @version 01.01.01
     */
    public function edit()
    {
        include_once(dirname(__FILE__)."/admin.news.model.db.php");
        $result=adminNewsModelDb::update($this->fields);
        return $result;
    }

    /**
     * delete news by news_id
     *
     * @return mixed
     * @author mahdi marjani moghadam <marjani@dabacenter.ir>
     * @date 2/24/2015
     * @version 01.01.01
     */
    public function delete()
    {
        include_once(dirname(__FILE__)."/admin.news.model.db.php");
        $result=adminNewsModelDb::delete($this->fields);
        return $result;
    }

}