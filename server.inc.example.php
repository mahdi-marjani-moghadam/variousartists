<?php
/**
 * Created by PhpStorm.
 * User: mahdi
 * Date: 9/13/16
 * Time: 4:07 PM
 */
//error_reporting(E_ALL ^ E_NOTICE);
//header("X-Powered-By: ASP.NET");
//ini_set('error_display',1);
//error_reporting(1);
session_start();
define("DB_TYPE","mysql");
// define("DB_HOST","172.18.205.250");
define("DB_HOST","localhost");
define("DB_USER","root");
define("DB_PASSWORD","root");
define("DB_DATABASE","variousa_sd");
    define("ROOT_DIR",dirname(__FILE__) ."/");

define("SUB_FOLDER","");
define("looeicConfig","");
//echo "<pre>";print_r($_SERVER);die();
if($_SERVER['HTTPS'] == 'on'){$http = 'https';}
else{$http = 'http';}
define("RELA_DIR",$http."://".$_SERVER['HTTP_HOST']."/");

define("PRODUCT_IMAGE",RELA_DIR . "templates/images/product/product_image/");
define("PRODUCT_IMAGE_ROOT",ROOT_DIR . "templates/images/product/product_image/");
define("STATIC_ROOT_DIR",ROOT_DIR . "statics");

//define("SMTP_USERNAME","info@variousartists.ir");
//define("SMTP_PASSWORD","66008190");

define("SMTP_SERVER","mail.variousartist.ir");
define("SMTP_USERNAME","support@variousartist.ir");
define("SMTP_PASSWORD","aPFgfK@VniJX");
define("SMTP_SENDER","Various Artists");

define("ADMIN_EMAIL","");

define("RECAPTCHA_V3_SECRET_KEY", '6LcUQeEeAAAAAAtcVPA0oFdA7m23hZZA05EonyXj');


date_default_timezone_set('Asia/Tehran');


define("GAPI_KEY","AIzaSyBSLTeLs4MQpfJAF32OrTdEUTe-4T_rR_s");
?>
