<?php
/**
 * Created by PhpStorm.
 * User: malek
 * Date: 2/20/2016
 * Time: 4:21 AM
 */
include_once(dirname(__FILE__). "/model/admin.salon.controller.php");
include_once(dirname(__FILE__). "/model/salon.import.model.php");


global $admin_info,$PARAM;

$salonController = new adminSalonController();
if(isset($exportType))
{
    $salonController->exportType=$exportType;
}

switch ($_GET['action'])
{
    case 'showMore':
        $newsController->showMore($_GET['id']);
        break;
    case 'add':

        if(isset($_POST['action']) & $_POST['action']=='add')
        {

            $salonController->addSalon($_POST);
        }
        else
        {

            $salonController->showSalonAddForm('','');
        }
        break;
    case 'edit':
        if(isset($_POST['action']) & $_POST['action']=='edit')
        {

            $salonController->editSalon($_POST);
        }
        else
        {
            $input['Salon_id']=$_GET['id'];

            $salonController->showSalonEditForm($input,'');
        }
        break;
    case 'delete':
        checkPermissions('deleteSalon');
            $salonController->deleteSalon($_GET['id']);

        break;
    default:
        $salon_list =salonImportModel::getSalonList()['export']['list'];
        //print_r_debug($salon_list);
        /*echo '<pre/>';
        foreach($salon_list as $k => $fields)
        {
            echo $fields['Salon_id'];

            $fields['new_id']=($fields['group']*100)+$fields['group_sub'];
            $fields['parent_id']=($fields['group']*100);
            if($fields['group_sub']==0)
            {
                $fields['parent_id']=0;

            }
            $update=$salon_list =salonImportModel::update($fields);

        }
        die();*/


        $salonController->showList();
        break;
}

?>