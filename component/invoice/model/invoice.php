<?php

namespace Component\invoice\model;
use Common\looeic;

// include_once(ROOT_DIR . "/common/validators.php");

class invoice extends looeic
{
    protected $TABLE_NAME = 'invoice';
    public $list;
    public $recordsCount;

    public function getInvoiceByArtistsId($id,$fields)
    {
        // include_once dirname(__FILE__).'/invoice.model.db.php';

        $result = invoiceModelDb::getInvoiceByArtistsId($id,$fields);

        if ($result['result'] != 1) {
            return $result;
        }
        $this->recordsCount = $result['export']['recordsCount'];

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

        $page = $this->pagination();

        if($page['result'] == 1)
        {
            $result['pagination'] = $page['export'];
        }

        $this->list = $result['list'];
        $this->list = $result['export']['list'];
        $this->recordsCount = $result['export']['recordsCount'];

        return $result;
    }
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

        for ($i = 1;$i <= $pageCount;++$i) {
            $pagination[] = $PARAM[0].'/'.$PARAM[1].'/page/'.$temp;
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
        else
        {
            $page = 1;
        }
        $result['export']['current'] = $page;

        return $result;
    }
    /*protected $rules = array(
        'title_fa' => 'required*ejbariii|min_len,5*kamtazr az 5 ta nmishe',
        'brif_description' => 'required|max_len,100'
    );*/


    /*public function setadmin()
    {
        $this->rules = array(
            'title' => 'required*ejbari|min_len,5*dorost vared kon'
        );
    }

    public function setmember()
    {
        $this->rules = array(
            'title' => 'required*ejbari|min_len,5*dorost vared kon',
            'brif_description' => 'required|max_len,100',
        );
    }*/

}

/* protected $fields =
    array(
                'News_id' => ''
            , 'title' => ''
            , 'brif_description' => ''
            , 'description' => ''
            , 'meta_keyword' => ''
            );*/
//$attributes = array('title' => 'My first blog post!!', 'brif_description' => '5');

/*function validate_name($input)
{
    echo 'a';

}*/