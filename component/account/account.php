<?php

include_once dirname(__FILE__).'/model/account.controller.php';

global $PARAM;

$accountController = new accountController();

if (isset($exportType)) {
    $accountController->exportType = $exportType;
}

if($member_info == -1){

    redirectPage(RELA_DIR.'login');
}

switch ($PARAM[1]) {
    case 'showMore':
        $accountController->showMore($_GET['id']);
        break;
    case 'addPackage':


        if (isset($_POST['action']) & $_POST['action'] == 'add') {

            $accountController->addPackage($_POST);

        } else {
            $accountController->showPackageAddForm('', '');
        }
        break;
    case 'editPackage':

        if (isset($_POST['action']) & $_POST['action'] == 'edit') {
          $accountController->editPackage($_POST);
        }
        else
        {
    
            $input['Package_id']=$_GET['id'];
            $accountController->showPackageEditForm($input, '');
        }
        break;
    case 'deletePackage':
       $input['Package_id'] = $_GET['id'];
    //    print_r_debug($input);
        $accountController->deletePackage($input);
        break;

    case 'event':

        $fields['limit']['start']=(isset($page))?($page-1)*PAGE_SIZE:'0';
        $fields['limit']['length']=PAGE_SIZE;
        $fields['order']['Event_id']='DESC';
        $accountController->showEventList($fields);
        break;
    case 'addEvent':

        if (isset($_POST['action']) & $_POST['action'] == 'add') {

            $accountController->addEvent($_POST);
        }
        else
        {
            $accountController->showEventAddForm($input, '');
        }
        break;
    case 'editEvent':

        if (isset($_POST['action']) & $_POST['action'] == 'edit') {

            $accountController->editEvent($_POST);
        }
        else
        {
            $input['event_id']=$PARAM[2];
            $accountController->showEventEditForm($input, '');
        }
        break;

    case 'showInvoiceList':

        $fields['limit']['start']=(isset($page))?($page-1)*PAGE_SIZE:'0';
        $fields['limit']['length']=PAGE_SIZE;
        $fields['order']['Invoice_id']='DESC';
        $accountController->showInvoiceList($fields);
        break;

    case 'showProductList':

        $fields['limit']['start']=(isset($page))?($page-1)*PAGE_SIZE:'0';
        $fields['limit']['length']=PAGE_SIZE;
        $fields['order']['Artists_products_id']='DESC';
        $accountController->showProductList($fields);
        break;
    case 'addProduct':

        if (isset($_POST['action']) & $_POST['action'] == 'add') {

            $accountController->addProduct($_POST);
        }
        else
        {
            $accountController->showProductAddForm($input, '');
        }
        break;
    case 'editProduct':
        if (isset($_POST['action']) & $_POST['action'] == 'edit') {

            $accountController->editProduct($_POST);
        }
        else
        {
            $input['product_id']=$PARAM[2];
            $accountController->showProductEditForm($input, '');
        }
        break;
    case 'deleteProduct':
        $accountController->deleteProduct($PARAM[2]);
        break;



    case 'showBlogList':

        $fields['limit']['start']=(isset($page))?($page-1)*PAGE_SIZE:'0';
        $fields['limit']['length']=PAGE_SIZE;
        $fields['order']['id']='DESC';
        $accountController->showBlogList($fields);
        break;
    case 'addBlog':

        if (isset($_POST['action']) & $_POST['action'] == 'add') {
            $result = $accountController->addBlog($_POST);
            redirectPage(RELA_DIR . 'account/showBlogList', $result['msg']);
        }
        else
        {
            $accountController->showBlogAddForm();
        }
        break;
    case 'editBlog':
        if (isset($_POST['action']) & $_POST['action'] == 'edit') {

            $accountController->editBlog($_POST);
        }
        else
        {
            $input['id']=$PARAM[2];
            $accountController->showBlogEditForm($input, '');
        }
        break;
    case 'deleteBlog':
        $accountController->deleteBlog($PARAM[2]);
        break;

    case 'editProfile':

        if (isset($_POST['action']) & $_POST['action'] == 'edit') {

            $accountController->editProfile($_POST);
        }
        else
        {

            $accountController->showProfileEditForm();
        }
        break;

    case 'ref':
        if($_POST){
            $accountController->sendInvitation($_POST);
        }else{
            $accountController->showRefForm();
        }

    default:
        
        $accountController->showPanel();
        break;
}
