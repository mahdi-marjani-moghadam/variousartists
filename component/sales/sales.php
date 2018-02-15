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


/*print_r_debug($_POST);*/
switch ($_POST['action']) {
        /*case 'showMore':
            $salesController->showMore($_GET['id']);
            break;

    */
        case 'showMoresandali':
            $salesController->showMoresandali($_POST);

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
        default:

            $fields['limit']['start'] = (isset($page)) ? ($page - 1) * PAGE_SIZE : '0';
            $fields['limit']['length'] = PAGE_SIZE;
            $fields['order']['Sales_id'] = 'DESC';
            $salesController->showALL($fields);
            break;


    }

