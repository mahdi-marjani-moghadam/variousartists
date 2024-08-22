<?php
/**
 * Created by PhpStorm.
 * User: malek
 * Date: 2/20/2016
 * Time: 4:21 AM
 */
include_once(dirname(__FILE__). "/model/news.model.php");

//$news->setField = '';




//echo "<pre>";
//print_r($news);
$object=clsNews::query("select * from news ")->first();
//$ids = array('1', '2', '3');


/*$news = new news();
$object = $news->getByFilter();*/

//$object->title = 'tt';
//$r=$object->validator();
//$object->save();
print_r_debug($object);
//$ids = array('1', '2', '3');
//$object = artists::getBy_username('mahdi')->getList();
print_r_debug($object);



$object['export']['list'][0]->title();


print_r_debug($object);
$_POST['pic'] = $_FILES['ax']['name'];
$object->setFields($_POST);
$r = $object->validator();
print_r_debug($r);
$result  = $news->template($object);
print_r_debug($result);
/*echo "<pre>";
print_r($object);
$object = news::getBy_title('news')->get();
$object['export']['list'][0]->title = 'rrrrrrr';
print_r_debug($object);*/
$object->title = 'خبر اول';
$object->description = 'توضیحات خبر اول';
echo "<pre>";
print_r($object);
$r = $object->validator();
print_r_debug($r);
$object->save();
die();

print_r_debug($object);
//$object->save();
print_r_debug($object);



global $admin_info,$PARAM;

$newsController = new newsController();

if(isset($_POST['action']) && $_POST['action'] == 'getNews')
{
    $newsController->exportType="json";
    $fields['limit']['start']='0';
    $fields['limit']['length']='5';
    $fields['order']['News_id']='DESC';
    // $newsController->showALL($fields);
    $newsController->showAllRss();
}

if(isset($exportType))
{
    $newsController->exportType=$exportType;
}

if(isset($PARAM[1]))
{
    $newsController->showMore($PARAM[1]);
    die();
}
else
{

    //$fields['filter']['title']='sdf';


    $fields['limit']['start']=(isset($page))?($page-1)*PAGE_SIZE:'0';
    $fields['limit']['length']=PAGE_SIZE;
    $fields['order']['News_id']='DESC';
    // $newsController->showALL($fields);
    $newsController->showALL();
    die();
}


?>
