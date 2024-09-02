<?php



use Common\validators;
use Component\banner\admin\model\adminBannerModel;


class adminBannerController
{


    public $exportType;

    public $fileName;

    public function __construct()
    {
        $this->exportType = 'html';
    }


    function template($list = [], $msg = ''): void
    {


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




    /**
     * @param $fields
     */
    public function showList($fields)
    {
        $banner = adminBannerModel::getAll()->getList();
        if ($banner['result'] != '1') {
            $this->fileName = 'admin.banner.showList.php';
            $this->template('', $banner['msg']);
            die();
        }

        $export['list'] = $banner['export']['list'];

        $export['recordsCount'] = $banner['export']['recordsCount'];
        $this->fileName = 'admin.banner.showList.php';
        $this->template($export);
        die();
    }

    /**
     * @param $fields
     * @param $msg
     */
    public function showBannerAddForm($fields, $msg)
    {


        $this->fileName = 'admin.banner.addForm.php';
        $this->template($fields, $msg);
        die();
    }

    /**
     * @param $fields
     * @return mixed
     */
    public function addBanner($fields)
    {

        $banner = new adminBannerModel();

        $result = $banner->setFields($fields);


        if ($result['result'] == -1) {
            $this->showBannerAddForm($fields, $result['msg']);
            //return $result;
        }
        $banner->save();

        if (file_exists($_FILES['image']['tmp_name'])) {

            $type  = explode('/', $_FILES['image']['type']);

            $input['upload_dir'] = ROOT_DIR . 'statics/banner/';
            $result = fileUploader($input, $_FILES['image']);
            $banner->image = $result['image_name'];
            $result = $banner->save();
        }


        //$result=$banner->add();

        if ($result['result'] != '1') {
            $this->showBannerAddForm($fields, $result['msg']);
        }
        $msg = 'عملیات با موفقیت انجام شد';
        redirectPage(RELA_DIR . "zamin/index.php?component=banner", $msg);
        die();
    }

    /**
     * @param $fields
     * @param $msg
     */
    public function showBannerEditForm($fields, $msg)
    {
        if (!validators::required($fields['Banner_id']) and !validators::Numeric($fields['Banner_id'])) {
            $msg = 'یافت نشد';
            redirectPage(RELA_DIR . "zamin/index.php?component=banner", $msg);
        }

        $banner = adminBannerModel::find($fields['Banner_id']);

        if (!is_object($banner)) {
            $msg = $banner['msg'];
            redirectPage(RELA_DIR . "zamin/index.php?component=banner", $msg);
        }

        $export = $banner->fields;



        $this->fileName = 'admin.banner.editForm.php';
        $this->template($export, $msg);
        die();
    }

    /**
     * @param $fields
     */
    public function editBanner($fields)
    {
        //$banner=new adminBannerModel();

        if (!validators::required($fields['Banner_id']) and !validators::Numeric($fields['Banner_id'])) {
            $msg = 'یافت نشد';
            redirectPage(RELA_DIR . "zamin/index.php?component=banner", $msg);
        }

        $banner = adminBannerModel::find($fields['Banner_id']);

        if (!is_object($banner)) {
            $msg = $banner['msg'];
            redirectPage(RELA_DIR . "zamin/index.php?component=banner", $msg);
        }


        $result = $banner->setFields($fields);



        if ($result['result'] != 1) {
            $this->showBannerEditForm($fields, $result['msg']);
        }



        $banner->save();

        if (file_exists($_FILES['image']['tmp_name'])) {

            $type  = explode('/', $_FILES['image']['type']);

            $input['upload_dir'] = ROOT_DIR . 'statics/banner/';
            $result = fileUploader($input, $_FILES['image']);
            fileRemover($input['upload_dir'], $banner->fields['image']);
            $banner->image = $result['image_name'];

            $result = $banner->save();
        }




        if ($result['result'] != '1') {
            $this->showBannerEditForm($fields, $result['msg']);
        }
        $msg = 'عملیات با موفقیت انجام شد';
        redirectPage(RELA_DIR . "zamin/index.php?component=banner", $msg);
        die();
    }

    /**
     * delete banner by banner_id
     *
     * @param $fields
     * @author marjani
     * @date 3/06/2015
     * @version 01.01.01
     */
    public function deleteBanner($fields)
    {

        if (!validators::required($fields['Banner_id']) and !validators::Numeric($fields['Banner_id'])) {

            $this->showBannerEditForm($fields, translate('not found'));
        }

        $obj = adminBannerModel::find($fields['Banner_id']);

        if (!is_object($obj)) {
            $msg = $obj['msg'];
            redirectPage(RELA_DIR . "zamin/index.php?component=banner", $msg);
        }

        $dir = ROOT_DIR . 'statics/banner/';
        fileRemover($dir, $obj->fields['image']);
        $result = $obj->delete();


        if ($result['result'] != 1) {
            $this->showBannerEditForm($fields, $result['msg']);
        }
        $msg = 'عملیات با موفقیت انجام شد';
        redirectPage(RELA_DIR . "zamin/index.php?component=banner", $msg);
        die();
    }
}
