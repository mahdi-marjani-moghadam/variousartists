<?php
use Component\soundcloud\model\soundcloud;
class adminSoundcloudController
{

    public $exportType;
    public $fileName;

    public function __construct()
    {
        $this->exportType = 'html';
    }

    function template($list = [], $msg = '') : void
    {
        // global $conn, $lang;


        switch ($this->exportType) {
            case 'html':

                include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_start.php");
                include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_header.php");
                include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_rightMenu_admin.php");
                include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/$this->fileName");
                include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_footer.php");
                include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_end.php");
                break;

            case 'json':
                echo json_encode($list);
                break;
          

            case 'serialize':
                echo serialize($list);
                break;
            default:
                break;
        }
    }

    public function showList()
    {
        $model = new soundcloud();

        $result = $model->getAll()->getList();


        if ($result['result'] != '1') {
            $this->fileName = 'admin.soundcloud.showList.php';
            $this->template('', $result['msg']);
            die();
        }


        $export['list'] = $result['export']['list'];
        $export['recordsCount'] = $result['export']['recordsCount'];
        $this->fileName = 'admin.soundcloud.showList.php';
        $this->template($export);

        die();
    }

    public function showSoundcloudAddForm($fields, $msg)
    {

        $this->fileName = 'admin.soundcloud.addForm.php';
        $this->template($fields, $msg);
        die();
    }

    /**
     * @param $fields
     * @return mixed
     */
    public function addSoundcloud($fields)
    {
        $soundcloud = new soundcloud();
        $result = $soundcloud->setFields($fields);
        $soundcloud->save();
        if ($result['result'] != '1') {
            $this->showSoundcloudAddForm($fields, $result['msg']);
        }

        $msg = 'عملیات با موفقیت انجام شد';
        redirectPage(RELA_DIR . "zamin/index.php?component=soundcloud", $msg);
        die();
    }


    public function deleteSoundcloud($id)
    {

        $object = soundcloud::find($id);

        if (!is_object($object)) {
            $msg = $object['msg'];
            redirectPage(RELA_DIR . "zamin/index.php?component=soundcloud", $msg);
        }

        $object->delete();

        $msg = 'حذف شد.';
        redirectPage(RELA_DIR . "zamin/index.php?component=soundcloud", $msg);
        die();
    }
}
