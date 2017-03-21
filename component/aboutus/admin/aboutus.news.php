<?php
/**
 * Created by PhpStorm.
 * User: malek
 * Date: 2/20/2016
 * Time: 4:21 AM
 */
include_once(dirname(__FILE__). "/model/admin.news.controller.php");

global $admin_info,$PARAM;

$newsController = new adminNewsController();
if(isset($exportType))
{
    $newsController->exportType=$exportType;
}


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
            $newsController->showNewsEditForm($input, '');
        }
        break;
    case 'deleteNews':

        $input['News_id']=$_GET['id'];
        $newsController->deleteNews($input);

        break;
    default:

        $fields['order']['News_id'] = 'DESC';
        $newsController->showList($fields);
        break;
}

?>