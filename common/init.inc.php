<?php

use Common\Breadcrumb;
use Common\dataStack;
use Common\dbConn;
use Common\messageStack;
use Component\login\model\memberLogIn;
use Component\sales\model\salesModel;

$db = dbConn::getConnection();

$db->exec('SET character_set_database=UTF8');
$db->exec('SET character_set_client=UTF8');
$db->exec('SET character_set_connection=UTF8');
$db->exec('SET character_set_results=UTF8');
$db->exec('SET character_set_server=UTF8');
$db->exec('SET names UTF8');

$sql = "SELECT * FROM web_config";
$stmt = $db->query($sql);
$obj = $stmt->fetchAll(PDO::FETCH_OBJ);
foreach ($obj as $v) {

    if (strtoupper($v->config) == "TITLE") {
        define(strtoupper($v->config), ucwords(strtolower($v->value)));
    } else {
        define(strtoupper($v->config), $v->value);
    }
}


$breadcrumb = new Breadcrumb();
$breadcrumbSearch = new Breadcrumb();

if (isset($_REQUEST['lang'])) {
    $_SESSION['lang'] = $_REQUEST['lang'];
}

if ($_SESSION['lang'] == "" || !isset($_SESSION['lang']) || $_SESSION['lang'] != 'en') {
    $_SESSION['lang'] = 'fa'; 
}

$lang = $_SESSION['lang'];

if ($_REQUEST['color'] == 'white') {
    unset($_SESSION['themeColor']);
    header("location: " . RELA_DIR);
} elseif ($_REQUEST['color'] == 'black') {
    $_SESSION['themeColor'] = '_black';
    header("location: " . RELA_DIR);
}


if ($lang == 'en') {
    $cs = "template_ltr{$_SESSION['themeColor']}";
} else {
    $cs = "template_rtl{$_SESSION['themeColor']}";
}

define('CURRENT_SKIN', $cs);

define('TEMPLATE_DIR', RELA_DIR . "templates/" . CURRENT_SKIN . "/");
define('Count_Permission', '20');

include(ROOT_DIR . "resource/language_$lang.inc.php");



$login = new memberLogIn();

$member_info = $login->checkLogin();

global $messageStack;
$messageStack = new messageStack();
$messageStack->loadFromSession();
$dataStack = new dataStack();


global $admin_info, $member_info;


spl_autoload_register(function ($name) {
    $modelFileName = ROOT_DIR . 'model/' . $name . '.class.php';
    $adminModelFileName = ROOT_DIR . 'model/admin.' . $name . '.class.php';

    if (file_exists($modelFileName)) {
        require_once($modelFileName);
    } elseif (file_exists($adminModelFileName)) {
        require_once($adminModelFileName);
    }
});


/** delete ticket date more than 10 min */
$checkreservesale = salesModel::getAll()
    ->where('status', '=', 0)
    ->andWhere('date', '<', date('Y-m-d H:i:s', strtotime('-10 minutes')))
    ->get();
if ($checkreservesale['export']['recordsCount'] > 0) {
    foreach ($checkreservesale['export']['list'] as $deleteOldReserve) {
        $deleteOldReserve->delete();
    }
}





//$member_info='';
//$member_info['member_id']=1;
