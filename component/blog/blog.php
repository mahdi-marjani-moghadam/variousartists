<?php
include_once dirname(__FILE__).'/controllers/blog.controller.php';
include_once dirname(__FILE__).'/model/blog.model.php';

global $PARAM,$PAGE;

$controller = new blogController();

if (isset($exportType)) {
    $artistsController->exportType = $exportType;
}



if (isset($PARAM[1]) and $PARAM[1] == 'detail') {
    $controller->showDetail($PARAM[2]);
}else{
    $controller->showAll($PAGE);
}



die();

if (isset($PARAM[1]) and $PARAM[1] != 'Detail') {
    $fields['limit']['start'] = (isset($page)) ? ($page - 1) * PAGE_SIZE : '0';
    $fields['limit']['length'] = PAGE_SIZE;
    $fields['order']['artists_id'] = 'DESC';
    $fields['chose']['category_id'] = $PARAM[1];
//    print_r_debug($fields);
    $artistsController->showALL($fields);
    die();
} elseif (isset($PARAM[2]) and $PARAM[1] == 'Detail') {
    $artistsController->showDetail($PARAM[2]);
    die();
}
else if (isset($PARAM[1]) and $PARAM[1] != 'category') {

    $fields['limit']['start'] = (isset($page)) ? ($page - 1) * PAGE_SIZE : '0';
    $fields['limit']['length'] = PAGE_SIZE;
    $fields['order']['artists_id'] = 'DESC';
    $fields['chose']['category_id'] = $PARAM[2];
    $artistsController->showALL($fields);
    die();
}

else{

    $fields['limit']['start'] = (isset($page)) ? ($page - 1) * 40 : '0';
    $fields['limit']['length'] = 40;
    $fields['order']['artists_id'] = 'DESC';
    $fields['chose']['category_id'] = 0;
    $artistsController->showALL($fields);

    die();
}