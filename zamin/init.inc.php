<?php

use Common\Breadcrumb;
use Common\dataStack;
use Common\dbConn;
use Common\messageStack;
use Component\login\admin\model\adminLoginModel;


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

if (isset($_REQUEST['lang'])) {
    $_SESSION['lang'] = $_REQUEST['lang'];
}
if ($_SESSION['lang'] == "" or !isset($_SESSION['lang']) or ($_SESSION['lang'] != 'en')) {

    $_SESSION['lang'] = 'fa'; // WEBSITE_LANGUAGE;
}
$lang = $_SESSION['lang'];

define('CURRENT_SKIN', "admin");
define('TEMPLATE_DIR', RELA_DIR . "templates/" . CURRENT_SKIN . "/");
define('Count_Permission', '20');

include(ROOT_DIR . "resource/language_$lang.inc.php");


global $messageStack, $dataStack;
$messageStack = new messageStack();
$messageStack->loadFromSession();
$dataStack = new dataStack();
global $breadcrumb;
$breadcrumb = new Breadcrumb();
global $admin_info;
$admin = new adminLoginModel();

$admin_info = $admin->checkLogin();

$LANG = array("en", "fa");

