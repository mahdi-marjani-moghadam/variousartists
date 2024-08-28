<?php

use Component\search\model\searchModel;

include_once dirname(__FILE__) . '/search.model.php';

class searchController
{
    
    public $exportType;

   
    public $fileName;

   
    public function __construct()
    {
        $this->exportType = 'html';
    }

   
    public function template($list = [], $msg = ''): void
    {
        global  $lang;

        switch ($this->exportType) {
            case 'html':
                include ROOT_DIR . 'templates/' . CURRENT_SKIN . '/title.inc.php';
                include ROOT_DIR . 'templates/' . CURRENT_SKIN . "/$this->fileName";
                include ROOT_DIR . 'templates/' . CURRENT_SKIN . '/tail.inc.php';
                break;

            case 'json':
                echo json_encode($list);
                break;


            case 'serialize':
                echo serialize($list);
                break;
            default:
                break;
        }
    }

   
    public function showALL($fields)
    {
        $search = new searchModel();
        $result = $search->setFields($fields);
        $this->fileName = 'search.result.php';

        if ($result['result'] == -1) {
            $this->template([], $result['msg']);
            die();
        }
        // if (isset($fields['category']) && $fields['category'] != '0') {
        //     $categoryId = $fields['category'];
        //     $fields['filter']['category_id'] = ','.$fields['category'].',';
        // }
        $result = $search->getSearch($fields);
        //        print_r_debug($result);
        if ($result['result'] != '1') {
            $this->template([], $result['msg']);
            die();
        }
        $export['list'] = $result['export'];


        //$export['type'] = $fields['type'];
        //$export['q'] = $search->q;
        //$export['recordsCount'] = $search->recordsCount;
        //$export['pagination'] = $search->pagination;

        //        print_r_debug($export);
        $this->template($export, $result['msg']);
        die();
    }
}
