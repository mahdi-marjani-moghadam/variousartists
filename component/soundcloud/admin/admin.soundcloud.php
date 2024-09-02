<?php

include_once(ROOT_DIR. "component/soundcloud/controllers/admin.soundcloud.controller.php");


global $admin_info,$PARAM;

$soundcloudController = new adminSoundcloudController();
if(isset($exportType))
{
    $soundcloudController->exportType=$exportType;
}
switch ($_GET['action'])
{
    case 'add':

        if(isset($_POST['action']) & $_POST['action']=='add')
        {

            $soundcloudController->addSoundcloud($_POST);
        }
        else
        {

            $soundcloudController->showSoundcloudAddForm([],'');
        }
        break;
    case 'delete':
        $soundcloudController->deleteSoundcloud($_GET['id']);

        break;
    default:
        $soundcloudController->showList();
        break;
}

?>