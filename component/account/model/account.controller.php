<?php

/**
 * Created by PhpStorm.
 * User: daba
 * Date: 08-Sep-16
 * Time: 9:23 AM
 */

use Common\validators;
use Component\artists\model\artists;
use Component\artists\model\artistsModel;
use Component\invoice\model\invoice;
use Component\product\model\productModel;

include_once dirname(__FILE__) . '/account.model.php';


/**
 * Class packageController.
 */
class accountController
{
    /**
     * Contains file type.
     *
     * @var
     */
    public $exportType;

    /**
     * Contains file name.
     *
     * @var
     */
    public $fileName;
    public $recordsCount;
    public $pagination;

    /**
     *
     */
    public function __construct()
    {
        $this->exportType = 'html';
    }

    /**
     * @param string $list
     * @param $msg
     *
     * @return string
     */
    public function template($list = [], $msg = '')
    {
        global $PARAM, $lang, $member_info;


        switch ($this->exportType) {
            case 'html':
                include ROOT_DIR . 'templates/' . CURRENT_SKIN . '/title.inc.php';
                include ROOT_DIR . 'templates/' . CURRENT_SKIN . '/account.title.php';
                include ROOT_DIR . 'templates/' . CURRENT_SKIN . "/$this->fileName";
                include ROOT_DIR . 'templates/' . CURRENT_SKIN . '/account.tail.php';
                include ROOT_DIR . 'templates/' . CURRENT_SKIN . '/tail.inc.php';
                break;

            case 'json':
                echo json_encode($list);
                break;
            case 'array':
                return $list;
                break;

            case 'serialize':
                echo serialize($list);
                break;
            default:
                break;
        }
    }

    public function showPanel()
    {

        global $member_info;

        // include_once ROOT_DIR . "component/invoice/model/invoice.model.php";


        $invoice = invoice::getBy_member_id($member_info['Artists_id'])->getList();


        if ($invoice['export']['recordsCount'] > 0) {
            $export['invoice'] = $invoice['export']['list'];
        }



        $object = artists::find($member_info['Artists_id']);
        if (is_array($object)) {
            $this->fileName = 'account.showPanel.php';
            $this->template('', $object['msg']);
            die();
        }


        $export['list'] = $object->fields;

        // include_once ROOT_DIR . 'component/product/model/product.model.php';
        $products = new productModel();

        
        $result = $products->getProductByArtistsId($member_info['Artists_id']);
        if ($result['result'] == -1) {
            $this->fileName = 'account.showPanel.php';
            $this->template('', $result['msg']);
            die();
        }

        $export['artistsProduct'] = $products->recordsCount;





        // breadcrumb
        global $breadcrumb;
        $breadcrumb->reset();
        //        $breadcrumb->add('پیشخوان ', 'account', true);
        $breadcrumb->add(translate('پیشخوان '), 'account');
        $export['breadcrumb'] = $breadcrumb->trail();
        $export['page_title'] = translate('پنل کاربری');

        $this->fileName = 'account.showPanel.php';
        $this->template($export);
        die();
    }


    /** Event */

    public function showEventList($fields, $msg = '')
    {
        global $member_info;
        // include_once ROOT_DIR . 'component/event/model/event.model.php';
        $event = new eventModel();

        $object = artists::find($member_info['Artists_id']);

        if (is_array($object)) {
            $this->fileName = 'account.showPanel.php';
            $this->template('', $object['msg']);
            die();
        }

        $export['list'] = $object->fields;

        $result = $event->getEventByArtistsId($member_info['Artists_id'], $fields);

        if ($result['result'] == -1) {
            $this->fileName = 'account.invoiceList.php';
            $this->template('', $result['msg']);
            die();
        }

        $export['artistsInvoiceList'] = $event->list;

        $this->recordsCount = $result['export']['recordsCount'];


        $export['pagination'] = $result['pagination'];
        if ($event->recordsCount == '0') {
            $msg = 'رکوردی یافت نشد.';
        }


        // breadcrumb
        global $breadcrumb;
        $breadcrumb->reset();
        $breadcrumb->add(translate('پیشخوان '), 'account', true);
        $breadcrumb->add(translate('لیست رویداد ها'));
        $export['breadcrumb'] = $breadcrumb->trail();
        $export['page_title'] = translate('لیست رویداد ها');



        $this->fileName = 'account.eventList.php';

        $this->template($export, $msg);
        die();
    }
    public function addEvent($_input)
    {



        global $messageStack, $member_info;
        include_once ROOT_DIR . 'component/event/admin/model/admin.event.model.php';
        $event = new adminEventModel();


        $_input['date'] = ($_input['date'] != '' ? convertJToGDate($_input['date']) : '0000-00-00');
        $_input['date2'] = ($_input['date2'] != '' ? convertJToGDate($_input['date2']) : '0000-00-00');
        $_input['date3'] = ($_input['date3'] != '' ? convertJToGDate($_input['date3']) : '0000-00-00');


        $_input['category_id'] = ',' . implode(',', $_input['category_id']) . ',';
        $_input['genre_id'] = ',' . implode(',', $_input['genre_id']) . ',';

        $result = $event->setFields($_input);

        if ($result['result'] == -1) {
            $this->showEventAddForm($_input, $result['msg']);
        }

        $event->status = 1;
        $event->member_id = $member_info['Artists_id'];
        $event->update_date = date('Y-m-d H:i:s');
        $event->save();


        if (file_exists($_FILES['logo']['tmp_name'])) {

            $input['upload_dir'] = ROOT_DIR . 'statics/event/';
            $result = fileUploader($input, $_FILES['logo']);
            //fileRemover($input['upload_dir'],$product->fields['image']);
            $event->logo = $result['image_name'];
            $result = $event->save();
        }


        //$result = $event->addEvent();

        if ($result['result'] != '1') {
            $messageStack->add_session('register', $result['msg']);
            $this->showEventAddForm($_input, $result['msg']);
        }
        $msg = your_event_has_been_recorded;
        $messageStack->add_session('register', $msg);

        redirectPage(RELA_DIR . 'account/event', $msg);
        die();
    }
    public function showEventAddForm($fields, $msg)
    {
        global $member_info;

        include_once ROOT_DIR . 'component/category/admin/model/admin.category.model.php';
        $category = new adminCategoryModel();

        $resultCategory = $category->getCategoryOption();


        if ($resultCategory['result'] == 1) {
            $export['category'] = $category->list;
        }


        $export['artists_id'] = $member_info['Artists_id'];

        /** genre */
        include_once(ROOT_DIR . "component/genre/model/genre.model.php");
        $genre = new genreModel();
        $resultGenre = $genre->getGenreOption();
        if ($resultGenre['result'] == 1) {
            $export['genre'] = $genre->list;
        }


        // breadcrumb
        global $breadcrumb;
        $breadcrumb->reset();
        $breadcrumb->add(translate('پیشخوان '), 'account', true);
        $breadcrumb->add(translate('افزودن اثر'), 'account');
        $export['breadcrumb'] = $breadcrumb->trail();
        $export['page_title'] = translate('افزودن اثر');


        /** country */
        include_once ROOT_DIR . 'component/country/model/country.model.php';
        $country = new country();
        $resultCountry = $country::getAll()->getList();
        if ($resultCountry['result'] == 1) {
            $export['country'] = $resultCountry['export']['list'];
        }


        $this->fileName = 'account.event.addForm.php';
        $this->template($export, $msg);
        die();
    }
    public function editEvent($_input)
    {
        global $member_info, $lang, $messageStack;

        include_once ROOT_DIR . 'component/event/admin/model/admin.event.model.php';
        //$event = new adminEventModel();


        $event = adminEventModel::find($_input['Event_id']);
        if (!is_object($event)) {
            redirectPage(RELA_DIR, $event['msg']);
        }





        $_input['date'] = ($_input['date'] != '' ? convertJToGDate($_input['date']) : '0000-00-00');
        $_input['date2'] = ($_input['date2'] != '' ? convertJToGDate($_input['date2']) : '0000-00-00');
        $_input['date3'] = ($_input['date3'] != '' ? convertJToGDate($_input['date3']) : '0000-00-00');
        $_input['category_id'] = ',' . implode(',', $_input['category_id']) . ',';
        $_input['genre_id'] = ',' . implode(',', $_input['genre_id']) . ',';

        $result = $event->setFields($_input);
        if ($result['result'] == -1) {
            $this->showEventAddForm($_input, $result['msg']);
        }

        $event->status = 1;
        $event->member_id = $member_info['Artists_id'];
        $event->update_date = date('Y-m-d H:i:s');
        $event->save();



        if (file_exists($_FILES['logo']['tmp_name'])) {

            $input['upload_dir'] = ROOT_DIR . 'statics/event/';
            $input['upload_dir'] = ROOT_DIR . 'statics/event/';
            $result = fileUploader($input, $_FILES['logo']);
            //fileRemover($input['upload_dir'],$product->fields['image']);
            $event->logo = $result['image_name'];
            $result = $event->save();
        }


        //$result = $event->addEvent();

        if ($result['result'] != '1') {
            $messageStack->add_session('register', $result['msg']);
            $this->showEventAddForm($_input, $result['msg']);
        }
        $msg = 'رویداد شما ویرایش شد.';
        $messageStack->add_session('register', $msg);

        redirectPage(RELA_DIR . 'account/event', $msg);
        die();
    }
    public function showEventEditForm($fields, $msg)
    {
        global $member_info;


        include_once "component/event/model/event.model.php";
        $obj = eventModel::find($fields['event_id']);
        if (!is_object($obj)) {
            redirectPage(RELA_DIR, $obj['msg']);
        }

        $export = $obj->fields;

        /** category */
        include_once ROOT_DIR . 'component/category/admin/model/admin.category.model.php';
        $category = new adminCategoryModel();

        $resultCategory = $category->getCategoryOption();
        if ($resultCategory['result'] == 1) {
            $export['category'] = $category->list;
        }

        /** genre */
        include_once(ROOT_DIR . "component/genre/model/genre.model.php");
        $genre = new genreModel();
        $resultGenre = $genre->getGenreOption();
        if ($resultGenre['result'] == 1) {
            $export['genre'] = $genre->list;
        }

        $export['artists_id'] = $member_info['Artists_id'];


        // breadcrumb
        global $breadcrumb;
        $breadcrumb->reset();
        $breadcrumb->add(translate('پیشخوان '), 'account', true);
        $breadcrumb->add(translate('افزودن اثر'), 'account');
        $export['breadcrumb'] = $breadcrumb->trail();
        $export['page_title'] = translate('افزودن اثر');

        /** country */
        include_once ROOT_DIR . 'component/country/model/country.model.php';
        $country = new country();
        $resultCountry = $country::getAll()->getList();
        if ($resultCountry['result'] == 1) {
            $export['country'] = $resultCountry['export']['list'];
        }

        //        print_r_debug($export);
        $this->fileName = 'account.editEventForm.php';
        $this->template($export, $msg);
        die();
    }

    /** Invoice */
    public function showInvoiceList($fields, $msg = '')
    {
        global $member_info;

        include_once ROOT_DIR . 'component/invoice/model/invoice.model.php';
        $invoice = new invoice();


        $object = model::find('artists', $member_info['Artists_id']);
        if (is_array($object)) {
            $this->fileName = 'account.showPanel.php';
            $this->template('', $object['msg']);
            die();
        }


        $export['list'] = $object->fields;

        $result = $invoice->getInvoiceByArtistsId($member_info['Artists_id'], $fields);
        if ($result['result'] == -1) {
            $this->fileName = 'account.invoiceList.php';
            $this->template('', $result['msg']);
            die();
        }

        $export['artistsInvoiceList'] = $invoice->list;


        $this->recordsCount = $result['export']['recordsCount'];


        $export['pagination'] = $result['pagination'];
        if ($invoice->recordsCount == '0') {
            $msg = 'رکوردی یافت نشد.';
        }





        // breadcrumb
        global $breadcrumb;
        $breadcrumb->reset();
        $breadcrumb->add(translate('پیشخوان '), 'account', true);
        $breadcrumb->add(translate('لیست صورتحساب ها'));
        $export['breadcrumb'] = $breadcrumb->trail();
        $export['page_title'] = translate('لیست صورتحساب ها');



        $this->fileName = 'account.invoiceList.php';

        $this->template($export, $msg);
        die();
    }



    /** Products */
    public function showProductList($fields = array(), $msg = '')
    {
        global $member_info;

        include_once ROOT_DIR . 'component/product/model/product.model.php';
        $products = new productModel();

        $object = model::find('artists', $member_info['Artists_id']);
        if (is_array($object)) {
            $this->fileName = 'account.showPanel.php';
            $this->template('', $object['msg']);
            die();
        }


        $export['list'] = $object->fields;

        $result = productModel::getBy_artists_id($member_info['Artists_id'])->getList();

        if ($result['result'] == -1) {
            $this->fileName = 'account.productList.php';
            $this->template('', $result['msg']);
            die();
        }
        $export['artistsProductList'] = $result['export']['list'];


        $this->recordsCount = $result['export']['recordsCount'];


        $export['pagination'] = $result['pagination'];
        if ($products->recordsCount == '0') {
            $msg = 'رکوردی یافت نشد.';
        }





        // breadcrumb
        global $breadcrumb;
        $breadcrumb->reset();
        $breadcrumb->add(translate('پیشخوان '), 'account', true);
        $breadcrumb->add(translate('نمونه کارها'));
        $export['breadcrumb'] = $breadcrumb->trail();
        $export['page_title'] = translate('نمونه کارها');


        $this->fileName = 'account.productList.php';

        $this->template($export, $msg);
        die();
    }
    public function addProduct($fields)
    {

        global $member_info, $lang;
        include_once ROOT_DIR . 'component/product/model/product.model.php';
        $account = new productModel();
        $fields['category_id'] = "," . (implode(",", $fields['category_id'])) . ",";
        $fields['genre_id'] = "," . (implode(",", $fields['genre_id'])) . ",";
        $fields['artists_id'] = $member_info['Artists_id'];

        if ($lang == 'fa') {
            $fields['creation_date'] = convertJToGDate($fields['creation_date']);
        }
        $result = $account->setFields($fields);


        $account->save();


        if ($result['result'] == -1) {
            return $result;
        }



        if (file_exists($_FILES['file']['tmp_name'])) {

            $type  = explode('/', $_FILES['file']['type']);
            $input['max_size'] = $_FILES['file']['size'];
            $input['upload_dir'] = ROOT_DIR . 'statics/files/' . $member_info['Artists_id'] . '/';
            $result = fileUploader($input, $_FILES['file']);

            //fileRemover($input['upload_dir'],$product->fields['file']);

            $account->file_type = $type[0];
            $account->extension = $type[1];
            $account->file = $result['image_name'];
            $result = $account->save();
        }

        if (file_exists($_FILES['image']['tmp_name'])) {

            $type  = explode('/', $_FILES['image']['type']);

            $input['upload_dir'] = ROOT_DIR . 'statics/files/' . $member_info['Artists_id'] . '/';
            $result = fileUploader($input, $_FILES['image']);
            //fileRemover($input['upload_dir'],$product->fields['image']);
            $account->image = $result['image_name'];
            $result = $account->save();
        }
        if ($result['result'] != '1') {
            $this->showPackageAddForm($fields, $result['msg']);
        }

        /** update artists date  */
        include_once ROOT_DIR . 'component/artists/admin/model/admin.artists.model.php';
        $artists = artistsModel::find($account->fields['artists_id']);
        $artists->update_date = date('Y-m-d H:i:s');
        $result = $artists->save();

        $msg = translate('عملیات با موفقیت انجام شد');
        redirectPage(RELA_DIR . 'account/showProductList', $msg);
        die();
    }
    public function showProductAddForm($fields = array(), $msg)
    {
        global $member_info;

        /** category */
        include_once(ROOT_DIR . "component/category/model/category.model.php");
        $category = new categoryModel();
        $resultCategory = $category->getCategoryOption();
        if ($resultCategory['result'] == 1) {
            $export['category'] = $category->list;
        }

        /** genre */
        include_once(ROOT_DIR . "component/genre/model/genre.model.php");
        $genre = new genreModel();
        $resultGenre = $genre->getGenreOption();
        if ($resultGenre['result'] == 1) {
            $export['genre'] = $genre->list;
        }

        $export['artists_id'] = $member_info['Artists_id'];

        // breadcrumb
        global $breadcrumb;
        $breadcrumb->reset();
        $breadcrumb->add(translate('پیشخوان '), 'account', true);
        $breadcrumb->add(translate('افزودن اثر'), 'account');
        $export['breadcrumb'] = $breadcrumb->trail();
        $export['page_title'] = translate('افزودن اثر');


        $this->fileName = 'account.addProductForm.php';
        $this->template($export, $msg);
        die();
    }
    public function editProduct($fields)
    {
        global $member_info, $lang;
        include_once ROOT_DIR . 'component/product/model/product.model.php';


        $account = productModel::find($fields['artists_products_id']);
        if (!is_object($account)) {
            redirectPage(RELA_DIR, $account['msg']);
        }


        $fields['category_id'] = "," . (implode(",", $fields['category_id'])) . ",";
        $fields['genre_id'] = "," . (implode(",", $fields['genre_id'])) . ",";
        $fields['artists_id'] = $member_info['Artists_id'];
        $fields['status'] = 0;

        if ($lang == 'fa') {
            $fields['creation_date'] = convertJToGDate($fields['creation_date']);
        }

        $result = $account->setFields($fields);

        $account->save();


        if (file_exists($_FILES['fileT']['tmp_name'])) {

            $type  = explode('/', $_FILES['fileT']['type']);
            $input['max_size'] = $_FILES['fileT']['size'];
            $input['upload_dir'] = ROOT_DIR . 'statics/files/' . $member_info['Artists_id'] . '/';
            $result = fileUploader($input, $_FILES['fileT']);

            fileRemover($input['upload_dir'], $account->fields['file']);

            $account->file_type = $type[0];
            $account->extension = $type[1];
            $account->file = $result['image_name'];
            $result = $account->save();
        }

        if (file_exists($_FILES['imageT']['tmp_name'])) {

            $input['upload_dir'] = ROOT_DIR . 'statics/files/' . $member_info['Artists_id'] . '/';
            $result = fileUploader($input, $_FILES['imageT']);
            fileRemover($input['upload_dir'], $account->fields['image']);
            $account->image = $result['image_name'];

            $result = $account->save();
        }




        $msg = translate('عملیات با موفقیت انجام شد');
        redirectPage(RELA_DIR . 'account/showProductList', $msg);
        die();
    }
    public function showProductEditForm($fields, $msg)
    {
        global $member_info;


        include_once "component/product/model/product.model.php";
        $obj = productModel::find($fields['product_id']);
        if (!is_object($obj)) {
            redirectPage(RELA_DIR, $obj['msg']);
        }

        $export = $obj->fields;

        /** category */
        include_once(ROOT_DIR . "component/category/model/category.model.php");
        $category = new categoryModel();
        $resultCategory = $category->getCategoryOption();
        if ($resultCategory['result'] == 1) {
            $export['category'] = $category->list;
        }

        /** genre */
        include_once(ROOT_DIR . "component/genre/model/genre.model.php");
        $genre = new genreModel();
        $resultGenre = $genre->getGenreOption();
        if ($resultGenre['result'] == 1) {
            $export['genre'] = $genre->list;
        }

        $export['artists_id'] = $member_info['Artists_id'];

        /** update artists date  */
        // include_once ROOT_DIR . 'component/artists/admin/model/admin.artists.model.php';
        $artists = artistsModel::find($obj->fields['artists_id']);
        $artists->update_date = date('Y-m-d H:i:s');
        $result = $artists->save();

        // breadcrumb
        global $breadcrumb;
        $breadcrumb->reset();
        $breadcrumb->add(translate('پیشخوان '), 'account', true);
        $breadcrumb->add(translate('افزودن اثر'), 'account');
        $export['breadcrumb'] = $breadcrumb->trail();
        $export['page_title'] = translate('افزودن اثر');


        //        print_r_debug($export);
        $this->fileName = 'account.editProductForm.php';
        $this->template($export, $msg);
        die();
    }
    public function deleteProduct($id)
    {
        if (!validators::required($id) and !validators::Numeric($id)) {
            $msg = 'یافت نشد';
            redirectPage(RELA_DIR . 'account/showProductList', $msg);
        }

        include_once ROOT_DIR . 'component/product/model/product.model.php';
        $obj = productModel::find($id);

        if (!is_object($obj)) {
            $msg = $obj['msg'];
            redirectPage(RELA_DIR . 'account/showProductList', $msg);
        }

        $dir = ROOT_DIR . 'statics/event/';
        fileRemover($dir, $obj->fields['image']);

        $result = $obj->delete();

        if ($result['result'] != '1') {
            redirectPage(RELA_DIR . 'account/showProductList', $msg);
        }

        $msg = translate('عملیات با موفقیت انجام شد');
        redirectPage(RELA_DIR . 'account/showProductList', $msg);
        die();
    }


    /** Profile */
    public function editProfile($fields)
    {
        global $member_info, $lang;
        include_once ROOT_DIR . 'component/artists/model/artists.model.php';


        $account = artists::find($fields['Artists_id']);

        if (!is_object($account)) {
            redirectPage(RELA_DIR, $account['msg']);
        }

        if (isset($fields['category_id'])) {
            $fields['category_id'] = "," . (implode(",", $fields['category_id'])) . ",";
        }

        if (isset($fields['genre_id'])) {
            $fields['genre_id'] = "," . (implode(",", $fields['genre_id'])) . ",";
        }

        $fields['artists_id'] = $member_info['Artists_id'];
        //$fields['status'] = 0;
        if ($fields['password'] != '') {
            $fields['password'] = md5($fields['password']);
        } else {
            unset($fields['password']);
        }


        if ($lang == 'fa') {
            $fields['birthday']  =  convertJToGDate($fields['birthday']);
        }

        $account->setFields($fields);



        $result = $account->validators();

        $account->state_id = 0;
        $account->date = date('Y-m-d H:i:s');

        $account->priority = 1;




        $account->save();


        if (file_exists($_FILES['logo']['tmp_name'])) {

            $input['upload_dir'] = ROOT_DIR . 'statics/files/' . $member_info['Artists_id'] . '/';

            $result = fileUploader($input, $_FILES['logo']);
            fileRemover($input['upload_dir'], $account->fields['logo']);
            $account->logo = $result['image_name'];

            $result = $account->save();
        }



        $msg = translate('عملیات با موفقیت انجام شد');
        redirectPage(RELA_DIR . 'account/editProfile', $msg);
        die();
    }
    public function showProfileEditForm($fields = '', $msg = '')
    {
        global $member_info;

        // include_once "component/artists/model/artists.model.php";
        $obj = artistsModel::find($member_info['Artists_id']);
        // print_r_debug($obj);
        if (!is_object($obj)) {
            redirectPage(RELA_DIR, $obj['msg']);
        }




        $export = $obj->fields;
        $export['category_id'] = explode(',', $export['category_id']);
        $export['genre_id'] = explode(',', $export['genre_id']);

        include_once(ROOT_DIR . "component/category/model/category.model.php");
        $category = new categoryModel();

        $resultCategory = $category->getCategoryOption();

        if ($resultCategory['result'] == 1) {
            $export['category'] = $category->list;
        }
        /** genre */
        include_once(ROOT_DIR . "component/genre/model/genre.model.php");
        $genre = new genreModel();
        $resultGenre = $genre->getGenreOption();
        if ($resultGenre['result'] == 1) {
            $export['genre'] = $genre->list;
        }

        // breadcrumb
        global $breadcrumb;
        $breadcrumb->reset();
        $breadcrumb->add(translate('پیشخوان '), 'account', true);
        $breadcrumb->add(translate('ویرایش پروفایل '), 'account');
        $export['breadcrumb'] = $breadcrumb->trail();
        $export['page_title'] = translate('ویرایش پروفایل');
        //    print_r_debug($export);
        $this->fileName = 'account.editProfileForm.php';
        $this->template($export, $msg);
        die();
    }



    /** Package */
    public function showPackageEditForm($fields, $msg)
    {

        //        if (!validators::required($fields['Package_id']) and !validators::Numeric($fields['Package_id'])) {
        //
        //            $msg = 'یافت نشد';
        //            redirectPage('');
        //            redirectPage(RELA_DIR . 'zamin/index.php?component=package', $msg);
        //        }

        //$result = $account->getPackageById($fields['Package_id']);
        //$account = new accountModel();


        $account = accountModel::find($fields['Package_id']);




        /*if ($result['result'] != '1') {
            $msg = $result['msg'];
            redirectPage(RELA_DIR . 'zamin/index.php?component=package', $msg);
        }*/
        //print_r_debug($account->fields);

        $export = $account->fields;
        //  print_r_debug($export);
        $this->fileName = 'account.editForm.php';
        $this->template($export, $msg);
        die();
    }
    public function editPackage($fields)
    {

        // print_r_debug($fields);

        $Account = accountModel::find($fields['Package_id']);
        $Account->setFields($fields);

        //$n->title='omid111';
        $Account->save();
        //print_r_debug($Account->fields);




        /*  if (!validators::required($fields['Package_id']) and !validators::Numeric($fields['Package_id'])) {

            $msg = 'یافت نشد';
            redirectPage(RELA_DIR.'zamin/index.php?component=package', $msg);
        }

        $result = $account->getPackageById($fields['Package_id']);

        if ($result['result'] != '1') {
            $msg = $result['msg'];
            redirectPage(RELA_DIR.'zamin/index.php?component=package', $msg);
        }

        $result = $account->setFields($fields);


        if ($result['result'] != 1) {
            $this->showPackageEditForm($fields, $result['msg']);
        }

        $result = $account->save();

        if ($result['result'] != '1') {
            $this->showPackageEditForm($fields, $result['msg']);
        }*/
        $msg = translate('عملیات با موفقیت انجام شد');
        redirectPage(RELA_DIR . 'zamin/index.php?component=package', $msg);
        die();
    }
    public function deletePackage($fields)
    {
        $account = new accountModel();

        if (!validators::required($fields['Package_id']) and !validators::Numeric($fields['Package_id'])) {
            $msg = 'یافت نشد';
            redirectPage(RELA_DIR . 'zamin/index.php?component=package', $msg);
        }
        $result = $account->getPackageById($fields['Package_id']);
        //   print_r_debug($result);
        if ($result['result'] != '1') {
            $msg = $result['msg'];
            redirectPage(RELA_DIR . 'zamin/index.php?component=package', $msg);
        }
        $result = $account->setFields($fields);
        //print_r_debug($result);
        if ($result['result'] != 1) {
            $this->showPackageEditForm($fields, $result['msg']);
        }
        $result = $account->delete();

        if ($result['result'] != '1') {
            $this->showPackageEditForm($fields, $result['msg']);
        }
        $msg = translate('عملیات با موفقیت انجام شد');
        redirectPage(RELA_DIR . 'zamin/index.php?component=package', $msg);
        die();
    }


    /** Blog */
    public function showBlogList($fields = array(), $msg = '')
    {
        global $member_info;

        include_once ROOT_DIR . 'component/blog/model/blog.model.php';
        $blogs = new blog();

        $object = model::find('artists', $member_info['Artists_id']);
        if (is_array($object)) {
            $this->fileName = 'account.showPanel.php';
            $this->template('', $object['msg']);
            die();
        }



        $export['list'] = $object->fields;

        $result = blog::getBy_artists_id($member_info['Artists_id'])->orderBy('id', 'desc')->getList();

        if ($result['result'] == -1) {
            $this->fileName = 'account.blogList.php';
            $this->template('', $result['msg']);
            die();
        }
        $export['artistsBlogList'] = $result['export']['list'];


        $this->recordsCount = $result['export']['recordsCount'];


        $export['pagination'] = $result['pagination'];
        if ($blogs->recordsCount == '0') {
            $msg = 'رکوردی یافت نشد.';
        }





        // breadcrumb
        global $breadcrumb;
        $breadcrumb->reset();
        $breadcrumb->add(translate('پیشخوان '), 'account', true);
        $breadcrumb->add(translate('نمونه کارها'));
        $export['breadcrumb'] = $breadcrumb->trail();
        $export['page_title'] = translate('نمونه کارها');


        $this->fileName = 'account.blogList.php';

        $this->template($export, $msg);
        die();
    }

    public function showBlogAddForm($export = array(), $msg = '')
    {
        global $member_info;


        /** category */
        include_once(ROOT_DIR . "component/category/model/category.model.php");
        $category = new categoryModel();
        $resultCategory = $category->getCategoryOption();
        if ($resultCategory['result'] == 1) {
            $export['category'] = $category->list;
        }



        $export['artists_id'] = $member_info['Artists_id'];

        // breadcrumb
        global $breadcrumb;
        $breadcrumb->reset();
        $breadcrumb->add(translate('پیشخوان '), 'account', true);
        $breadcrumb->add(translate('افزودن اثر'), 'account');
        $export['breadcrumb'] = $breadcrumb->trail();
        $export['page_title'] = translate('افزودن اثر');


        $this->fileName = 'account.addBlogForm.php';
        $this->template($export, $msg);
        die();
    }
    public function addBlog($fields = array())
    {


        global $member_info;
        include_once ROOT_DIR . 'component/blog/model/blog.model.php';
        $account = new blog();

        $fields['category_id'] = "," . (implode(",", $fields['category_id'])) . ",";
        $fields['artists_id'] = $member_info['Artists_id'];
        $fields['status'] = 1;


        if (!file_exists($_FILES['image']['tmp_name'])) {
            $result['msg'] = image_not_exist;
            $this->showBlogAddForm($fields, $result['msg']);
        }

        $result = $account->setFields($fields);

        $account->save();

        if ($result['result'] == -1) {
            $result['msg'] = 'Error: blog error 1';
            return $result;
        }

        if (file_exists($_FILES['image']['tmp_name'])) {
            $input = array();
            $input['upload_dir'] = ROOT_DIR . 'statics/blog/';

            $result = fileUploader($input, $_FILES['image']);

            $account->image = $result['image_name'];
            $result = $account->save();
        }

        if ($result['result'] != '1') {
            $this->showBlogAddForm($fields, $result['msg']);
        }

        /** update artists date  */
        include_once ROOT_DIR . 'component/artists/admin/model/admin.artists.model.php';
        $artists = adminArtistsModel::find($account->fields['artists_id']);
        $artists->update_date = date('Y-m-d H:i:s');
        $result = $artists->save();

        $msg = translate('عملیات با موفقیت انجام شد');
        redirectPage(RELA_DIR . 'account/showBlogList', $msg);
        die();
    }
    public function editBlog($fields = array())
    {
        global $member_info, $lang;
        include_once ROOT_DIR . 'component/blog/model/blog.model.php';
        

        $account = blog::find($fields['id']);
        if (!is_object($account)) {
            redirectPage(RELA_DIR, $account['msg']);
        }


        $fields['category_id'] = "," . (implode(",", $fields['category_id'])) . ",";
        $fields['artists_id'] = $member_info['Artists_id'];
        $fields['status'] = 1;

        /*if($lang == 'fa')
        {
            $fields['creation_date'] = convertJToGDate($fields['creation_date']);
        }*/

        $result = $account->setFields($fields);

        $account->save();



        if (file_exists($_FILES['image']['tmp_name'])) {

            $input['upload_dir'] = ROOT_DIR . 'statics/blog/';
            $result = fileUploader($input, $_FILES['image']);
            fileRemover($input['upload_dir'], $account->fields['image']);
            $account->image = $result['image_name'];

            $result = $account->save();
        }




        $msg = translate('عملیات با موفقیت انجام شد');
        redirectPage(RELA_DIR . 'account/showBlogList', $msg);
        die();
    }
    public function showBlogEditForm($fields = array(), $msg = '')
    {
        global $member_info;


        include_once "component/blog/model/blog.model.php";
        $obj = blog::find($fields['id']);
        if (!is_object($obj)) {
            redirectPage(RELA_DIR, $obj['msg']);
        }

        $export = $obj->fields;

        /** category */
        include_once(ROOT_DIR . "component/category/model/category.model.php");
        $category = new categoryModel();
        $resultCategory = $category->getCategoryOption();
        if ($resultCategory['result'] == 1) {
            $export['category'] = $category->list;
        }



        $export['artists_id'] = $member_info['Artists_id'];

        /** update artists date  */
        /*include_once ROOT_DIR.'component/artists/admin/model/admin.artists.model.php';
        $artists = adminArtistsModel::find($obj->fields['artists_id']);
        $artists->update_date = date('Y-m-d H:i:s');
        $result = $artists->save();*/

        // breadcrumb
        global $breadcrumb;
        $breadcrumb->reset();
        $breadcrumb->add(translate('پیشخوان '), 'account', true);
        $breadcrumb->add(translate('افزودن اثر'), 'account');
        $export['breadcrumb'] = $breadcrumb->trail();
        $export['page_title'] = translate('افزودن اثر');


        //        print_r_debug($export);
        $this->fileName = 'account.editBlogForm.php';
        $this->template($export, $msg);
        die();
    }
    
    public function deleteBlog($id)
    {
        if (!validators::required($id) and !validators::Numeric($id)) {
            $msg = 'یافت نشد';
            redirectPage(RELA_DIR . 'account/showBlogList', $msg);
        }

        include_once ROOT_DIR . 'component/blog/model/blog.model.php';
        $obj = blog::find($id);

        if (!is_object($obj)) {
            $msg = $obj['msg'];
            redirectPage(RELA_DIR . 'account/showBlogList', $msg);
        }

        $dir = ROOT_DIR . 'statics/event/';
        fileRemover($dir, $obj->fields['image']);

        $result = $obj->delete();

        if ($result['result'] != '1') {
            redirectPage(RELA_DIR . 'account/showBlogList', $msg);
        }

        $msg = translate('عملیات با موفقیت انجام شد');
        redirectPage(RELA_DIR . 'account/showBlogList', $msg);
        die();
    }

    public function showList($fields)
    {

        //$fields['where']['list']
        // print_r_debug($fields);
        $account = new accountModel();
        $result = $account->getByFilter();

        //print_r_debug($export);

        //$account=accountModel::getByFilter();
        //print_r_debug($account);
        // $account = new accountModel();
        //$result = $account->getPackage($fields);
        // print_r_debug($fields);
        if ($result['result'] != '1') {
            $this->fileName = 'account.showList.php';
            $this->template('', $result['msg']);
            die();
        }
        $export['list'] = $result['export']['list'];
        $export['recordsCount'] =  $result['export']['recordsCount'];
        $this->fileName = 'account.showList.php';
        $this->template($export);
        die();
    }

    public function showRefForm($var = null)
    {
        $this->fileName = 'account.refForm.php';
        $this->template();
        die();
    }

    public function sendInvitation($post = null)
    {
        global $member_info;

        if(!is_numeric($post['mobile'])){
            $this->fileName = 'account.refForm.php';
            $this->template('', translate('شماره مشکل دارد'));
            die();
        }

        // sms
        include_once ROOT_DIR . 'component/magfa/magfa.model.php';
        $sms = new WebServiceSample;

        if ($lang == 'fa') {
            $message =
                'دوست عزیز شما توسط '.$member_info['artists_name_fa'].' به سایت variousartist.ir دعوت شده اید.' . " \n " .
                'لطفا لینک زیر را بزنید و وارد سایت شوید.' . " \n " .
                RELA_DIR."register/?ref=".$member_info['Artists_id'];
        } else {
            $message =
            'دوست عزیز شما توسط '.$member_info['artists_name_fa'].' به سایت variousartist.ir دعوت شده اید.' . " \n " .
            'لطفا لینک زیر را بزنید و وارد سایت شوید.' . " \n " .
            RELA_DIR."register/?ref=".$member_info['Artists_id'];
        }

        // dd($message);
        // $sms->simpleEnqueueSample($post['mobile'], $message);
        $res = $sms->send($post['mobile'], $message);
        if(is_array($res)){
            dd($res);
        }

        $msg = translate('عملیات با موفقیت انجام شد');
        redirectPage(RELA_DIR . 'account/ref', $msg);

        die();
    }
}
