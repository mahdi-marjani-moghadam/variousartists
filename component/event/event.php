<?php
/**
 * Created by PhpStorm.
 * User: malek
 * Date: 3/16/2016
 * Time: 3:21 AM.
 */
include_once dirname(__FILE__).'/model/event.controller.php';

global $PARAM;

$eventController = new eventController();
if (isset($exportType)) {
    $eventController->exportType = $exportType;
}

/*if (isset($PARAM[0]) and $PARAM[0] == $_SESSION['city']) {
    $fields['limit']['start'] = (isset($page)) ? ($page - 1) * PAGE_SIZE : '0';
    $fields['limit']['length'] = PAGE_SIZE;
    $fields['order']['event_id'] = 'DESC';
    $fields['chose']['category_id'] = $PARAM[2];

    include_once ROOT_DIR.'component/city/admin/model/admin.city.model.db.php';
    $cities = adminCityModelDb::getAll()['export']['list'];
    $city = $_SESSION['city'];
    foreach ($cities as $key => $c) {
        if ($city == $c['name']) {
            $fields['chose']['city_id'] = $c['City_id'];
        }
    }
    $eventController->showALL($fields);
    die();
} else*/if (isset($PARAM[1]) and $PARAM[1] != 'Detail') {
    $fields['limit']['start'] = (isset($page)) ? ($page - 1) * PAGE_SIZE : '0';
    $fields['limit']['length'] = PAGE_SIZE;
    $fields['order']['event_id'] = 'DESC';
    $fields['chose']['category_id'] = $PARAM[1];
    $eventController->showALL($fields);
    die();
} elseif (isset($PARAM[2]) and $PARAM[1] == 'Detail') {
    $eventController->showDetail($PARAM[2]);
    die();
}
else if (isset($PARAM[1]) and $PARAM[1] != 'category') {
    $fields['limit']['start'] = (isset($page)) ? ($page - 1) * PAGE_SIZE : '0';
    $fields['limit']['length'] = PAGE_SIZE;
    $fields['order']['event_id'] = 'DESC';
    $fields['chose']['category_id'] = $PARAM[2];
    $eventController->showALL($fields);
    die();
}

else{
    $fields['limit']['start'] = (isset($page)) ? ($page - 1) * PAGE_SIZE : '0';
    $fields['limit']['length'] = PAGE_SIZE;
    $fields['order']['event_id'] = 'DESC';
    $fields['chose']['category_id'] = 0;
    $eventController->showALL($fields);
    die();
}