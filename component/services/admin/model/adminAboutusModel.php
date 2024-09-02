<?php

namespace Component\services\admin\model;
use Common\looeic;
use Common\validators;

class adminAboutusModel extends looeic
{

    private $TableName;


    private $fields;  // other record fields


    private $list;  // other record fields


    private $recordsCount;  // other record fields



    private $result;


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

   
    public function __get($field)
    {
        if ($field == 'result') {
            return $this->result;
        } else if ($field == 'fields') {
            return $this->fields;
        } else if ($field == 'list') {
            return $this->list;
        } else if ($field == 'recordsCount') {
            return $this->recordsCount;
        } else {
            return $this->fields[$field];
        }
    }

    
    /**
     * set the values that have been received through post
     *
     * @param $input
     * @return mixed
     * @author marjani
     * @date 2/28/2016
     * @version 01.01.01
     */
    private function __setHead1($input)
    {

        if (!validators::required($input)) {
            $result['result'] = -1;
            $result['msg'] = 'pleas enter title';
        } else {
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
     * @date 2/28/2016
     * @version 01.01.01
     */
    private function __setHead2($input)
    {

        if (!validators::required($input)) {
            $result['result'] = -1;
            $result['msg'] = 'pleas enter title';
        } else {
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
     * @date 2/28/2016
     * @version 01.01.01
     */
    private function __setHead3($input)
    {

        if (!validators::required($input)) {
            $result['result'] = -1;
            $result['msg'] = 'pleas enter title';
        } else {
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
     * @date 2/28/2016
     * @version 01.01.01
     */
    private function __setText1($input)
    {

        if (!validators::required($input)) {
            $result['result'] = -1;
            $result['msg'] = 'pleas enter title';
        } else {
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
     * @date 2/28/2016
     * @version 01.01.01
     */
    private function __setText2($input)
    {

        if (!validators::required($input)) {
            $result['result'] = -1;
            $result['msg'] = 'pleas enter title';
        } else {
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
     * @date 2/28/2016
     * @version 01.01.01
     */
    private function __setText3($input)
    {

        if (!validators::required($input)) {
            $result['result'] = -1;
            $result['msg'] = 'pleas enter title';
        } else {
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
     * @date 2/28/2015
     * @version 01.01.01
     */
    private function __setGraph1($input)
    {

        if (!validators::required($input)) {
            $result['result'] = -1;
            $result['msg'] = 'pleas enter graph';
        } else {
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
     * @date 2/28/2015
     * @version 01.01.01
     */
    private function __setGraph2($input)
    {

        if (!validators::required($input)) {
            $result['result'] = -1;
            $result['msg'] = 'pleas enter graph';
        } else {
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
     * @date 2/28/2015
     * @version 01.01.01
     */
    private function __setGraph3($input)
    {

        if (!validators::required($input)) {
            $result['result'] = -1;
            $result['msg'] = 'pleas enter graph';
        } else {
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
     * @date 2/28/2015
     * @version 01.01.01
     */
    private function __setMeta_keyword($input)
    {

        if (!validators::required($input)) {
            $result['result'] = -1;
            $result['msg'] = 'pleas enter meta keyword';
        } else {
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
     * @date 2/28/2015
     * @version 01.01.01
     */
    private function __setMeta_description($input)
    {

        if (!validators::required($input)) {
            $result['result'] = -1;
            $result['msg'] = 'pleas enter meta description';
        } else {
            $result['result'] = 1;
        }

        return $result;
    }




    /**
     * get all aboutus
     *
     * @param $fields
     * @return mixed
     * @author marjani
     * @date 2/28/2015
     * @version 01.01.01
     */
    public function getAboutus($fields)
    {
        include_once(dirname(__FILE__) . "/admin.aboutus.model.db.php");

        $result = (new adminAboutusModelDb)->getAboutus($fields);

        if ($result['result'] != 1) {
            return $result;
        }
        $this->list = $result['export']['list'];
        $this->recordsCount = $result['export']['recordsCount'];
        return $result;
    }

    /**
     * add new aboutus
     *
     * @return mixed
     * @author marjani
     * @date 2/28/2015
     * @version 01.01.01
     */
    public function add()
    {
        include_once(dirname(__FILE__) . "/admin.aboutus.model.db.php");
        $result = adminAboutusModelDb::insert($this->fields);
        $this->fields['Aboutus_id'] = $result['export']['insert_id'];
        return $result;
    }

    /**
     * edit aboutus by aboutus_id
     *
     * @return mixed
     * @author marjani
     * @date 2/28/2015
     * @version 01.01.01
     */
    public function edit()
    {

        include_once(dirname(__FILE__) . "/admin.aboutus.model.db.php");
        $result = adminAboutusModelDb::update($this->fields);
        return $result;
    }
}
