<?php
/**
 * Created by PhpStorm.
 * User: malek
 * Date: 2/20/2016
 * Time: 4:21 AM
 */
include_once(dirname(__FILE__). "/model/admin.genre.controller.php");
include_once(dirname(__FILE__). "/model/genre.import.model.php");


global $admin_info,$PARAM;

$genreController = new adminGenreController();
if(isset($exportType))
{
    $genreController->exportType=$exportType;
}

switch ($_GET['action'])
{
    case 'showMore':
        $newsController->showMore($_GET['id']);
        break;
    case 'add':

        if(isset($_POST['action']) & $_POST['action']=='add')
        {

            $genreController->addGenre($_POST);
        }
        else
        {

            $genreController->showGenreAddForm('','');
        }
        break;
    case 'edit':
        if(isset($_POST['action']) & $_POST['action']=='edit')
        {

            $genreController->editGenre($_POST);
        }
        else
        {
            $input['Genre_id']=$_GET['id'];

            $genreController->showGenreEditForm($input,'');
        }
        break;
    case 'delete':
        //checkPermissions('deleteGenre');
            $genreController->deleteGenre($_GET['id']);

        break;
    default:
        $genre_list =genreImportModel::getGenreList()['export']['list'];
        //print_r_debug($genre_list);
        /*echo '<pre/>';
        foreach($genre_list as $k => $fields)
        {
            echo $fields['Genre_id'];

            $fields['new_id']=($fields['group']*100)+$fields['group_sub'];
            $fields['parent_id']=($fields['group']*100);
            if($fields['group_sub']==0)
            {
                $fields['parent_id']=0;

            }
            $update=$genre_list =genreImportModel::update($fields);

        }
        die();*/


        $genreController->showList();
        break;
}

?>