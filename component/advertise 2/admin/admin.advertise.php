<?php
/**
 * Created by PhpStorm.
 * User: marjani
 * Date: 3/06/2016
 * Time: 12:08 AM
 */
include_once(dirname(__FILE__). "/model/admin.advertise.controller.php");

global $admin_info,$PARAM;

$advertiseController = new adminAdvertiseController();
if(isset($exportType))
{
    $advertiseController->exportType=$exportType;
}


switch ($_GET['action'])
{
    case 'showMore':
        $advertiseController->showMore($_GET['id']);
        break;
    case 'addAdvertise':


        if(isset($_POST['action']) & $_POST['action']=='add')
        {

            $advertiseController->addAdvertise($_POST);
        }
        else
        {
            $advertiseController->showAdvertiseAddForm('','');
        }
        break;
    case 'editAdvertise':


        if(isset($_POST['action']) & $_POST['action']=='edit')
        {

            $advertiseController->editAdvertise($_POST);
        }
        else
        {
            $input['Advertise_id']=$_GET['id'];
            $advertiseController->showAdvertiseEditForm($input, '');
        }
        break;
    case 'deleteAdvertise':

        $input['Advertise_id']=$_GET['id'];
        $advertiseController->deleteAdvertise($input);

        break;
    default:

        //$fields['order']['Advertise_id'] = 'DESC';
        $advertiseController->showList($fields);
        break;
}

?>