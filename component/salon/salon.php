<?php
/**
 * Created by PhpStorm.
 * User: malek
 * Date: 2/20/2016
 * Time: 4:21 AM
 */
include_once(dirname(__FILE__). "/model/salon.controller.php");

global $admin_info,$PARAM;

$salonController = new salonController();
if(isset($exportType))
{
    $salonController->exportType=$exportType;
}


if(isset($PARAM[1]))
{
    $newsController->showMore($PARAM[1]);
    die();
}else
{

    $salonController->showList();
    die();
}


die();

switch ($_GET['action'])
{
    case 'showMore':
        $newsController->showMore($_GET['id']);
        break;
    case 'addNews':


        if(isset($_POST['action']) & $_POST['action']=='add')
        {

            $newsController->addNews($_POST);
        }
        else
        {
            $newsController->showNewsAddForm('','');
        }
        break;
    case 'editNews':


        if(isset($_POST['action']) & $_POST['action']=='edit')
        {
            $newsController->editNews($_POST);
        }
        else
        {
            $input['News_id']=$_GET['id'];
            $newsController->showNewsEditForm($input,'');
        }
        break;
    default:


        $salonController->showList();
        break;
}

?>