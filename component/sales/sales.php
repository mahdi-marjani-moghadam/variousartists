<?php
/**
 * Created by PhpStorm.
 * User: marjani
 * Date: 3/10/2016
 * Time: 10:21 AM
 */

include_once(dirname(__FILE__). "/model/sales.controller.php");

global $admin_info,$PARAM;

$salesController = new SalesController();
if(isset($exportType))
{
    $salesController->exportType=$exportType;
}
if($member_info == -1){
    if($PARAM[0]== 'sales'){
        redirectPage(RELA_DIR.'login',please_login_before_choose_chair);
    }
    else{
        redirectPage($_SERVER['HTTP_REFERER'],please_login_before_choose_chair);
    }
}

if($_POST['action'] == 'addSales'){
    $salesController->addSales($_POST);
}

switch ($PARAM[1]) {
    default:
        /** url decode*/
        $fields = $salesController->urlDecode();

        /** show invoice page */
        if($PARAM[1] == 'invoice'){
            if($PARAM[2] == 'delete')
            {
                $salesController->deleteInvoice($PARAM[3]);
            }
            else{
                $salesController->invoice();
            }
        }

        /** if position filling send to step3 */
        if($fields['position']){
            $salesController->step3($PARAM[1]);
        }

        /** pay */
        if($PARAM[1]== 'pay')
        {
            $salesController->pay($_POST);
        }
        if($PARAM[1]== 'returnbank')
        {
            $salesController->returnBank($_POST);
        }

        $salesController->step1();
        break;
}




print_r_debug($_POST['action']);
switch ($_POST['action']) {
        /*case 'showMore':
            $salesController->showMore($_GET['id']);
            break;

    */
        /*case 'showMoresandali':
            $salesController->showMoresandali($_POST);

            break;*/
    case 'acceptpage':
        $salesController->acceptpage($_POST);

        break;
        case 'addSales':

            if (isset($_POST['action']) & $_POST['action'] == 'add') {

                $salesController->addSales($_POST);
            } else {
                $salesController->showSalesAddForm('', '');
            }
            break;
        case 'editSales':
            if (isset($_POST['action']) & $_POST['action'] == 'edit') {

                $salesController->editSales($_POST);
            } else {
                $input['Sales_id'] = $_GET['id'];
                $salesController->showSalesEditForm($input, '');
            }
            break;
        /*default:

            $fields['limit']['start'] = (isset($page)) ? ($page - 1) * PAGE_SIZE : '0';
            $fields['limit']['length'] = PAGE_SIZE;
            $fields['order']['Sales_id'] = 'DESC';
            $salesController->showALL($fields);
            break;*/


    }

