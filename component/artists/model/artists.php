<?php

namespace Component\artists\model;

use articleModelDb;
use Common\looeic;
use Common\validators;

// include_once ROOT_DIR.'/common/validators.php';
class artists extends looeic
{
    protected $TABLE_NAME = 'artists';
    protected $rules = array(
        'username' => 'required',
        'password' => 'required'
        //'category_id' => 'required'
    );
}
