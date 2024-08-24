<?php

/**
 * Created by PhpStorm.
 * User: malekloo
 * Date: 3/6/2016
 * Time: 11:21 AM
 */

use Common\validators;
use Component\artists\admin\model\adminArtistsModel;
use Component\category\admin\model\adminCategoryModel;
use Component\genre\admin\model\adminGenreModel;
use Component\product\admin\model\adminProductModel;

include_once(dirname(__FILE__) . "/admin.product.model.php");

/**
 * Class registerController
 */
class adminProductController
{

    /**
     * Contains file type
     * @var
     */
    public $exportType;

    /**
     * Contains file name
     * @var
     */
    public $fileName;

    /**
     * registerController constructor.
     */
    public function __construct()
    {
        $this->exportType = 'html';
    }

    /**
     * call template
     *
     * @param string $list
     * @param $msg
     * @return string
     */
    function template($list = array(), $msg = ''): void
    {
        global $messageStack;

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
     * add Product
     *
     * @param $_input
     * @return int|mixed
     * @author marjani
     * @date 2/27/2015
     * @version 01.01.01
     */
    public function addProduct($_input)
    {
        global $messageStack, $lang;


        $product = new adminProductModel;

        $_input['category_id'] = "," . (implode(",", $_input['category_id'])) . ",";
        $_input['genre_id'] = "," . (implode(",", $_input['genre_id'])) . ",";
        $fields['artists_id'] = $_input['artists_id'] = $_REQUEST['artists_id'];
        if ($lang == 'fa') {
            $_input['creation_date'] = convertJToGDate($_input['creation_date']);
        }
        $result = $product->setFields($_input);


        if ($result['result'] == -1) {
            $this->showProductAddForm($_input, $result['msg']);
        }
        $result = $product->save();

        if (file_exists($_FILES['file']['tmp_name'])) {

            $type  = explode('/', $_FILES['file']['type']);
            $input['max_size'] = $_FILES['file']['size'];
            $input['upload_dir'] = ROOT_DIR . 'statics/files/' . $fields['artists_id'] . '/';
            $result = fileUploader($input, $_FILES['file']);

            fileRemover($input['upload_dir'], $product->fields['file']);

            $product->file_type = $type[0];
            $product->extension = $type[1];
            $product->file = $result['image_name'];
            $result = $product->save();
        }

        if (file_exists($_FILES['image']['tmp_name'])) {

            $type  = explode('/', $_FILES['image']['type']);

            $input['upload_dir'] = ROOT_DIR . 'statics/files/' . $fields['artists_id'] . '/';
            $result = fileUploader($input, $_FILES['image']);
            fileRemover($input['upload_dir'], $product->fields['image']);
            $product->image = $result['image_name'];
            $result = $product->save();
        }

        /** update artists date  */
        // include_once ROOT_DIR.'component/artists/admin/model/admin.artists.model.php';
        $artists = adminArtistsModel::find($product->fields['artists_id']);
        $artists->update_date = date('Y-m-d H:i:s');
        $result = $artists->save();

        //$result=$product->addProduct();

        if ($result['result'] != '1') {
            $messageStack->add_session('register', $result['msg']);
            $this->showProductAddForm($_input, $result['msg']);
        }
        $msg = 'عملیات با موفقیت انجام شد';
        $messageStack->add_session('register', $msg);

        redirectPage(RELA_DIR . "zamin/?component=product&id={$_input['artists_id']}", $msg);
        die();
    }


    /**
     * call register form
     *
     * @param $fields
     * @param $msg
     * @return mixed
     * @author malekloo
     * @date 14/03/2016
     * @version 01.01.01
     */

    public function showProductAddForm($fields, $msg)
    {

        // include_once(ROOT_DIR."component/category/admin/model/admin.category.model.php");
        $category = new adminCategoryModel();

        $resultCategory = $category->getCategoryOption();

        if ($resultCategory['result'] == 1) {
            $fields['category'] = $category->list;
        }

        /** genre */
        // include_once(ROOT_DIR."component/genre/admin/model/admin.genre.model.php");
        $genre = new adminGenreModel();

        $resultGenre = $genre->getGenreOption();

        if ($resultGenre['result'] == 1) {
            $fields['genre'] = $genre->list;
        }


        $this->fileName = 'admin.product.addForm.php';
        $this->template($fields, $msg);
        die();
    }


    /**
     * @param $fields
     * @return mixed
     * @author malekloo
     * @date 3/16/2015
     * @version 01.01.01
     */
    public function editProduct($fields)
    {
        global $lang;

        $product = adminProductModel::find($fields['Artists_products_id']);

        if (!is_object($product)) {
            redirectPage(RELA_DIR . "zamin/index.php?component=product", $product['msg']);
        }

        if ($lang == 'fa') {
            $fields['creation_date'] = convertJToGDate($fields['creation_date']);
        }

        $product->setFields($fields);


        $product->category_id = "," . (implode(",", $product->category_id)) . ",";
        $product->genre_id = "," . (implode(",", $product->genre_id)) . ",";




        $result = $product->save();
        $fields = $product->fields;
        if ($result['result'] != '1') {
            $this->showProductEditForm($fields, $result['msg']);
        }


        if (file_exists($_FILES['file']['tmp_name'])) {

            $type  = explode('/', $_FILES['file']['type']);
            $input['max_size'] = $_FILES['file']['size'];
            $input['upload_dir'] = ROOT_DIR . 'statics/files/' . $fields['artists_id'] . '/';
            $result = fileUploader($input, $_FILES['file']);

            fileRemover($input['upload_dir'], $product->fields['file']);

            $product->file_type = $type[0];
            $product->extension = $type[1];
            $product->file = $result['image_name'];
            $result = $product->save();
        }

        if (file_exists($_FILES['image']['tmp_name'])) {

            $type  = explode('/', $_FILES['image']['type']);

            $input['upload_dir'] = ROOT_DIR . 'statics/files/' . $fields['artists_id'] . '/';
            $result = fileUploader($input, $_FILES['image']);
            fileRemover($input['upload_dir'], $product->fields['image']);
            $product->image = $result['image_name'];

            $result = $product->save();
        }

        /** update artists date  */
        include_once ROOT_DIR . 'component/artists/admin/model/admin.artists.model.php';
        $artists = adminArtistsModel::find($product->fields['artists_id']);
        $artists->update_date = date('Y-m-d H:i:s');
        $result = $artists->save();

        $msg = 'عملیات با موفقیت انجام شد';
        redirectPage(RELA_DIR . "zamin/index.php?component=product&id={$fields['artists_id']}", $msg);
        die();
    }


    /**
     * @param $fields
     * @return mixed
     * @author malekloo
     * @date 3/6/2015
     * @version 01.01.01
     */
    public function showProductEditForm($fields, $msg)
    {

        $product = new adminProductModel();
        $result = $product->getProductById($fields['Artists_products_id']);

        if ($result['result'] != '1') {
            $msg = $result['msg'];
            redirectPage(RELA_DIR . "zamin/index.php?component=product", $msg);
        }

        $export = $product->fields;

        include_once(ROOT_DIR . "component/category/admin/model/admin.category.model.php");
        $category = new adminCategoryModel();

        $resultCategory = $category->getCategoryOption();

        if ($resultCategory['result'] == 1) {
            $export['category'] = $category->list;
        }

        /** genre */
        include_once(ROOT_DIR . "component/genre/admin/model/admin.genre.model.php");
        $genre = new adminGenreModel();
        $resultGenre = $genre->getGenreOption();
        if ($resultGenre['result'] == 1) {
            $export['genre'] = $genre->list;
        }
        /*echo '<pre/>';
        print_r($export);
        die();*/

        $this->fileName = 'admin.product.editForm.php';
        $this->template($export, $msg);
        die();
    }



    /**
     * @param $fields
     * @return mixed
     * @author malekloo
     * @date 3/6/2015
     * @version 01.01.01
     */
    public function showList($fields)
    {
        $product = new adminProductModel();
        $result = $product->getProduct($fields);
        if ($result['result'] != '1') {
            $this->fileName = 'admin.product.showList.php';
            $this->template('', $result['msg']);
            die();
        }
        $export['list'] = $product->list;
        $export['artists_id'] = $fields['choose']['artists_id'];


        $export['recordsCount'] = $product->recordsCount;

        $this->fileName = 'admin.product.showList.php';
        $this->template($export);
        die();
    }
    /**
     * delete deleteCompany by company_id
     *
     * @param $id
     * @author malekloo
     * @date 2/24/2015
     * @version 01.01.01
     */
    public function deleteProduct($id)
    {

        $product = adminProductModel::find($id);

        if (!validators::required($id) and !validators::Numeric($id)) {
            $msg = 'یافت نشد';
            redirectPage(RELA_DIR . "admin/index.php", $msg);
        }


        if (!is_object($product)) {
            $msg = $product['msg'];
            redirectPage(RELA_DIR . "admin/index.php", $msg);
        }


        $company_id = $product->fields['artists_id'];


        $result = $product->delete();


        $dir = ROOT_DIR . 'statics/files/' . $company_id . '/';
        fileRemover($dir, $product->fields['image']);

        if ($result['result'] != '1') {
            redirectPage(RELA_DIR . "zamin/index.php?component=product&id=$company_id");
        }

        $msg = 'عملیات با موفقیت انجام شد';
        redirectPage(RELA_DIR . "zamin/index.php?component=product&id=$company_id", $msg);
        die();
    }
}
