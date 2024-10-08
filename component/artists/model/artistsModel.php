<?php

namespace Component\artists\model;

use articleModelDb;
use Common\looeic;
use Common\validators;

// include_once ROOT_DIR.'/common/validators.php';

class artistsModel extends looeic
{
    protected $TABLE_NAME = 'artists';
    private $TableName;
    //private $fields;  // other record fields
    private $list;  // other record fields
    private $recordsCount;  // other record fields
    private $pagination;  // other record fields

    private $result;

    /**
     * articleModel constructor.
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
     *
     * @return mixed
     */
    public function __get($field)
    {
        if ($field == 'result') {
            return $this->result;
        } elseif ($field == 'fields') {
            return $this->fields;
        } elseif ($field == 'list') {
            return $this->list;
        } elseif ($field == 'recordsCount') {
            return $this->recordsCount;
        } elseif ($field == 'pagination') {
            return $this->pagination;
        } else {
            return $this->fields[$field];
        }
    }

    /**
     * @param $input
     *
     * @return int
     */
    // public function setFields($input)
    // {
    //     foreach ($input as $field => $val) {
    //         $funcName = '__set'.ucfirst($field);
    //         if (method_exists($this, $funcName)) {
    //             $result = $this->$funcName($val);
    //             if ($result['result']) {
    //                 $this->fields[$field] = $val;
    //             } else {
    //                 return $result;
    //             }
    //         }
    //     }
    //     $result = 1;

    //     return $result;
    // }

    /**
     * @param $input
     *
     * @return mixed
     */
    private function __setTitle($input)
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
     * get article.
     *
     * @param $id
     *
     * @return mixed
     */
    public function getArtistsById($id)
    {
        // include_once dirname(__FILE__).'/artists.model.db.php';

        $result = artistsModelDb::getArtistsById($id);

        if ($result['result'] != 1) {
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

        $this->fields = $result['list'];

        return $result;
    }

    /**
     * @param $fields
     *
     * @return mixed
     */
    public function getLastArtists($fields)
    {
        // include_once dirname(__FILE__) . '/artists.model.db.php';

        $result = (new artistsModelDb)->getLastArtists($fields);

        if ($result['result'] != 1) {
            return $result;
        }
        $this->list = $result['export']['list'];
        $this->recordsCount = $result['export']['recordsCount'];

        $resultPage = $this->pagination();

        $this->pagination = $resultPage['export']['list'];

        return $result;
    }
    /**
     * @param $fields
     *
     * @return mixed
     */
    public function getArtists($fields)
    {
        // include_once dirname(__FILE__) . '/artists.model.db.php';

        $result = (new artistsModelDb)->getArtists($fields);


        if ($result['result'] != 1) {
            return $result;
        }
        $this->list = $result['export']['list'];
        $this->recordsCount = $result['export']['recordsCount'];

        $resultPage = $this->pagination();

        $this->pagination = $resultPage['export']['list'];
        $this->pagination['current'] = $resultPage['export']['current'];

        return $result;
    }
    /**
     * @param $fields
     *
     * @return mixed
     */
    public function getRelatedCompanies($id)
    {
        include_once dirname(__FILE__) . '/artists.model.db.php';
        $result = artistsModelDb::getRelatedCompanies($id);
        if ($result['result'] != 1) {
            return $result;
        }
        $this->list = $result['export']['list'];

        return $result;
    }
    /**
     * get article by category
     *  // example catString : 1,2,3,5,88
     *  // example catArray : array('1'=>'3','2'=>'2','3'=>'23').
     *
     * @param $fields
     *
     * @author marjani
     * @date 2/29/2016
     *
     * @version 01.01.01
     */
    public function getArticleByCategoryId($fields)
    {
        if (!is_array($fields)) {
            $fields = handleData($fields);
            $fields = explode(',', $fields);
        }
        $catString = '';
        foreach ($fields as $k => $catid) {
            if (is_numeric($catid)) {
                $catString .= ",'" . $catid . "'";
            }
        }
        $catString = substr($catString, 1);

        // include_once dirname(__FILE__) . '/article.model.db.php';
        $result = articleModelDb::getArticleByCategoryId($catString);

        $this->list = $result['export']['list'];

        return $result;
    }

    /**
     * @return mixed
     */
    private function pagination()
    {


        $pageCount = ceil($this->recordsCount / PAGE_SIZE);
        $pagination = array();
        $temp = 1;

        $url_main = substr($_SERVER['REQUEST_URI'], strlen(SUB_FOLDER) + 1);
        $url_main = urldecode($url_main);

        $PARAM = explode('/', $url_main);
        $PARAM = array_filter($PARAM, 'strlen');

        if (array_search('page', $PARAM)) {
            $index_pageSize = array_search('page', $PARAM);

            //$page=$PARAM[$index_pageSize+1];
            unset($PARAM[$index_pageSize]);
            unset($PARAM[$index_pageSize + 1]);

            $PARAM = implode('/', $PARAM);
            $PARAM = explode('/', $PARAM);
            $PARAM = array_filter($PARAM, 'strlen');
        }

        for ($i = 1; $i <= $pageCount; ++$i) {
            $pagination[] = $PARAM[0] . '/page/' . $temp;
            $temp = $temp + 1;
        }



        $result['result'] = 1;
        $result['export']['list'] = $pagination;

        $url_main = substr($_SERVER['REQUEST_URI'], strlen(SUB_FOLDER) + 1);
        $url_main = urldecode($url_main);
        $PARAM = explode('/', $url_main);
        $PARAM = array_filter($PARAM, 'strlen');
        if (array_search('page', $PARAM)) {
            $index_pageSize = array_search('page', $PARAM);
            $page = $PARAM[$index_pageSize + 1];
        }
        $result['export']['current'] = $page;

        return $result;
    }
}
