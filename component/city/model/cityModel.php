<?php

namespace Component\city\model;

use Common\looeic;
use Component\city\model\cityModelDb;

class cityModel extends looeic
{
    protected $TABLE_NAME = 'city';
    private $fields;  // other record fields
    private $list;  // other record fields
    private $recordsCount;  // other record fields
    private $pagination;  // other record fields

    private $result;


    public function getCities()
    {
        $result = cityModelDb::getCities();
        if ($result['result'] != 1) {
            return $result;
        }
        $this->list = $result['export']['list'];

        return $result;
    }
}
