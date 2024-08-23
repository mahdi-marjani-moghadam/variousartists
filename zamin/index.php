<?php


error_reporting(E_ALL ^ E_STRICT ^ E_NOTICE ^ E_DEPRECATED ^ E_WARNING);
ini_set('display_errors', "1");
ini_set('error_prepend_string', "<pre style='white-space: pre-line; line-height:1.5em; font-size:16px'>");


require __DIR__ . '/../vendor/autoload.php';
include_once("../server.inc.php");
// include_once(ROOT_DIR . "common/db.inc.php");
include_once(ROOT_DIR . "zamin/init.inc.php");
include_once(ROOT_DIR . "common/func.inc.php");
// include_once(ROOT_DIR."/common/validators.php");
// include_once ROOT_DIR.'common/looeic.php';


//include_once(ROOT_DIR . "model/admin.index.php");

if($admin_info['result'] ==-1)
{

	include_once (ROOT_DIR . "component/login/admin/admin.login.php");
    die();
}

		if(isset($_GET['component']))
		{
			$component=$_GET['component'];
			$component_name=$_GET['component_name'];
		}else
		{
			$component='index';
			$component_name='index';
		}

		include_once (ROOT_DIR . "component/$component/admin/admin.$component.php");



?>