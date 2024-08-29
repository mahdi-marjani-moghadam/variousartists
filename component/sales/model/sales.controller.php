<?php

use Component\event\model\eventModel;
use Component\sales\model\salesModel;
use Component\salon\model\salonModel;

class salesController
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

    /**
     * salesController constructor.
     */
    public function __construct()
    {
        $this->exportType = 'html';
    }

    /**
     * call tempate.
     *
     * @param array $list
     * @param $msg
     *
     * @return string
     */
    public function template($list = [], $msg = '')
    {
        global $member_info;

        switch ($this->exportType) {
            case 'html':
                include ROOT_DIR . 'templates/' . CURRENT_SKIN . '/title.inc.php';
                include ROOT_DIR . 'templates/' . CURRENT_SKIN . "/$this->fileName";
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


    public function showMore($_input = '')
    {


        if (!is_numeric($_input)) {
            $msg = 'یافت نشد';
            $this->fileName = 'sales.showList.php';
            $this->template('', $msg);
            die();
        }
        $sales = new salesModel();
        $result = $sales->getSalesById($_input);

        if ($result['result'] != 1) {
            $this->fileName = 'sales.showList.php';
            $this->template('', $result['msg']);
            die();
        }

        // breadcrumb
        global $breadcrumb;
        $breadcrumb->reset();
        $breadcrumb->add('بنر');
        $breadcrumb->add($sales['list']['title']);
        $export['breadcrumb'] = $breadcrumb->trail();

        $this->fileName = 'sales.showMore.php';
        $this->template($sales->fields);
        die();
    }
    public function showMoresandali($input)

    {

        /*print_r_debug($input);*/

        $salonpartname = new salonModel();
        $resultSalonpartname = $salonpartname->getSalonByid($input['part']);
        /*              klklk print_r_debug($resultSalonname);*/

        if ($resultSalonpartname['result'] == 1) {
            $export['salonpartname'] = $resultSalonpartname['list'];
        }

        $salonname = new salonModel();
        $resultSalonname = $salonname->getSalonByid($input['place']);
        /*              klklk print_r_debug($resultSalonname);*/

        if ($resultSalonname['result'] == 1) {
            $export['salonname'] = $resultSalonname['list'];
        }

        $sales = salesModel::getAll()->getList();


        $eventname = new eventModel();
        $resulteventname = $eventname->getEventById($input['Event_id']);
        if ($resulteventname['result'] == 1) {
            $export['eventname'] = $resulteventname['list'];
        }
        $event = eventModel::getAll()->getList();


        /*   entekhabe sandali     -----*/


        $fildes['where'] = 'status=0 and' . 'event_id =' . $input['Event_id'] . ' and part_id=' . $input['part'] . ' and place_id=' . $input['place'] . ' and event_time="' . $input['event_time'] . '"';
        $sandali = new salesModel();

        $resultsandali = $sandali->getByFilter($fildes);
        if ($resultsandali['result'] == 1) {
            $export['sandalipor'] = $resultsandali['export'];
        }
        $sandali = $resultsandali;
        //$sandali=salesModel::getAll()->getList();
        $export['sandalipor']['list'] = $sandali['export']['list'];

        $export['list'] = $sales->list;
        $export['eventlist'] = $event->eventlist;
        $export['recordsCount'] = $sales->recordsCount;
        $export['pagination'] = $sales->pagination;
        $export['list']['event_name'] = $input['event_name'];
        $export['list']['event_time'] = $input['event_time'];
        $export['list']['event_part'] = $input['place'];
        $export['list']['Event_id'] = $input['Event_id'];
        $min = $export['salonpartname']['min_sandali'];
        $max = $export['salonpartname']['max_sandali'];
        $sandalipor = array();

        foreach ($export['sandalipor']['list'] as $k => $x):
            $sandalipor[] = $x["sandali"];
        endforeach;
        for ($x = $min; $x < $max; $x++) {
            $sandalikhali[] = $x;
        }
        $result = array_diff($sandalikhali, $sandalipor);

        $export['skhali'] = $result;
        $this->fileName = 'sales.sandali.php';
        $this->template($export);
        die();
    }
    public function acceptpage($input)

    {
        global $member_info;
        if ($member_info == -1) {
            redirectPage(RELA_DIR . 'login', 'برای خرید لطفا وارد شوید.');
        }

        $temp = $input['sandali'];
        unset($input['sandali']);

        foreach ($temp as $k => $sandali) {
            $export['sandali'][$k] = $sandali;
            $input['sandali'] = $sandali;

            $export['place_id'] = $input['place_id'];
            $export['place_name'] = $input['place_name'];
            $export['part_id'] = $input['part_id'];
            $export['part_name'] = $input['part_name'];

            $export['event_name'] = $input['Event_name'];
            $export['event_time'] = $input['event_time'];
            $export['Event_id'] = $input['Event_id'];

            $finalsave = new salesModel();
            $finalsave->setFields($input);
            $finalsave->event_id = $input['Event_id'];
            $finalsave->user_id = $member_info['Artists_id'];
            //            print_r_debug($finalsave);
            $finalsave->save();
        }


        //
        /*$finalsave->sandali = $input['sandali'];
        $finalsave->place_id = $input['place_id'];
        $finalsave->place_name = $input['place_name'];
        $finalsave->part_id = $input['part_id'];
        $finalsave->part_name = $input['part_name'];*/

        $this->fileName = 'sales.final.php';
        $this->template($export);
        die();
    }


    /** decode url */
    function urlDecode()
    {
        global $PARAM;

        $input = base64_decode($PARAM[1]);
        $temp = explode('&', rawurldecode($input));
        $fields = array();

        foreach ($temp as $v) {
            $temp = explode('=', $v);
            $fields[$temp[0]] = $temp[1];
        }
        return $fields;
    }
    /** get event by id */
    function checkEvent($fields)
    {
        global $lang, $messageStack;
        include_once ROOT_DIR . 'component/event/model/event.model.php';
        $objEvent = eventModel::getBy_Event_id($fields['event_id'])->getList();
        if ($objEvent['export']['recordsCount'] == 0) {
            $ms = event_not_found;
            $messageStack->add_session('message', $ms, 'error');
            redirectPage(RELA_DIR . "event/Detail/{$fields['event_id']}/{$objEvent['export']['list'][0]['event_name_' .$lang]}", $ms);
        }
        $objEvent['export']['list'][0]['event_name'] = $objEvent['export']['list'][0]['event_name_' . $lang];
        return $objEvent['export']['list'][0];
    }
    /** get salon by id */
    function checkSalon($objEvent)
    {
        global $lang, $messageStack;
        $salon_id = substr($objEvent['salon_id'], 1, -1);
        $objSalon = salon::getBy_Salon_id($salon_id)->getList();
        if ($objSalon['export']['recordsCount'] == 0) {
            $ms = salon_not_found;
            $messageStack->add_session('message', $ms, 'error');
            redirectPage(RELA_DIR . "event/Detail/{$objEvent['Event_id']}/{$objEvent['event_name_' .$lang]}", $ms);
        }
        $objSalon['export']['list'][0]['title'] = $objSalon['export']['list'][0]['title_' . $lang];
        return $objSalon['export']['list'][0];
    }
    /** get position by id */
    function checkPosition($salon_id)
    {
        global $lang, $messageStack;
        $fields = $this->urlDecode();

        include_once ROOT_DIR . 'component/salon/newModel/salon.model.php';
        $objSalon = salon::getBy_Salon_id($salon_id)->getList();

        if ($objSalon['export']['recordsCount'] == 0) {
            $ms = position_not_found;
            $messageStack->add_session('message', $ms, 'error');
            $urlEncode = base64_encode('event_id=' . $fields['event_id'] . '&date=' . $fields['date'] . '&time=' . $fields['time']);

            redirectPage(RELA_DIR . "sales/" . $urlEncode, $ms);
        }
        $objSalon['export']['list'][0]['title'] = $objSalon['export']['list'][0]['title_' . $lang];
        return $objSalon['export']['list'][0];
    }
    /** get position by id */
    function existsSandali($objPosition)
    {
        global $lang, $messageStack;
        $fields = $this->urlDecode();

        include_once ROOT_DIR . 'component/sales/model/sales.model.php';
        $obj = new salesModel();

        $objSales = $obj->getAll()
            ->where('event_id', '=', $fields['event_id'])
            ->andWhere('place_id', '=', $objPosition['parent_id'])
            ->andWhere('part_id', '=', $fields['position'])
            ->andWhere('event_time', '=', $fields['time'])
            ->andWhere('event_date', '=', $fields['date'])
            ->andWhere('status', '=', 0)
            ->getList();
        //getBy_event_id_and_place_id_and_part_id_and_event_time_and_status
        //($fields['event_id'],$objPosition['parent_id'],$fields['position'],$fields['time'],0)

        //print_r_debug($objSales);

        $sandalipor = array();

        foreach ($objSales['export']['list'] as $userSandali => $v):
            foreach (explode(',', $v['sandali']) as $k => $x):
                $sandalipor[] = $x;
            endforeach;
        endforeach;


        $sandalipor = array_unique($sandalipor);

        for ($x = $objPosition['min_sandali']; $x <= $objPosition['max_sandali']; $x++) {
            $sandalikhali[] = $x;
        }

        $result = array_diff($sandalikhali, $sandalipor);



        if (count($result) == 0) {

            $ms = not_exists_chair;
            $messageStack->add_session('message', $ms, 'error');
            $urlEncode = base64_encode('event_id=' . $fields['event_id'] . '&date=' . $fields['date'] . '&time=' . $fields['time']);

            redirectPage(RELA_DIR . "sales/" . $urlEncode, $ms);
        }


        return $result;
    }


    /** step 2 */
    public function step1()
    {
        global $lang, $messageStack, $PARAM;


        /** url decode*/
        $fields = $this->urlDecode();
        $export['get']['date'] = $fields['date'];
        $export['get']['time'] = $fields['time'];


        /** check and get event by id */
        $objEvent = $this->checkEvent($fields);

        /** get salon by objEvent */
        $objSalon = $this->checkSalon($objEvent);

        $export['event'] = $objEvent;
        $export['salon'] = $objSalon;



        /** get salon position */
        include_once ROOT_DIR . 'component/salon/newModel/salon.model.php';
        $objSalon = salon::getBy_parent_id($objSalon['Salon_id'])->getList();
        if ($objSalon['export']['recordsCount'] == 0) {
            /** if not found go to next step */
            $ms = Position_not_found_with_this_salon;
            $messageStack->add_session('message', $ms, 'error');
            redirectPage(RELA_DIR . "event/Detail/{$objEvent['Event_id']}/{$objEvent['event_name']}", $ms);
        }
        $export['position'] = $objSalon['export']['list'];


        foreach ($export['position'] as $k => $item) {
            $urlEncode = base64_encode('event_id=' . $fields['event_id'] . '&date=' . $fields['date'] . '&time=' . $fields['time'] . '&position=' . $item['Salon_id']);
            $export['position'][$k]['nextUrl'] = RELA_DIR . "sales/" . $urlEncode;
            $export['position'][$k]['title'] = $export['position'][$k]['title_' . $lang];
        }
        //print_r_debug($export['position']);



        //        print_r_debug($export);

        $export['backUrl'] = RELA_DIR . "event/Detail/{$objEvent['Event_id']}/{$objEvent['event_name']}";
        //$export['currentUrl'] = RELA_DIR."sales/".$urlEncode;
        //$export['nextUrl'] = RELA_DIR."sales/".$urlEncode;
        //print_r_debug($urlEncode);
        $this->fileName = 'sales.php';
        $this->template($export);
        die();
    }
    /** step 3 */
    public function step3($input)
    {
        global $lang, $messageStack, $PARAM;


        /** url decode*/
        $fields = $this->urlDecode();
        $export['get']['date'] = $fields['date'];
        $export['get']['time'] = $fields['time'];
        $export['get']['position'] = $fields['position'];



        /** check and get event by id */
        $objEvent = $this->checkEvent($fields);

        /** get salon by objEvent */
        $objSalon = $this->checkSalon($objEvent);


        /** check position  */
        $objPosition = $this->checkPosition($fields['position']);


        /** sandali */
        $export['sandali'] = $this->existsSandali($objPosition);




        $export['event'] = $objEvent;
        $export['salon'] = $objSalon;
        $export['position'] = $objPosition;

        $export['step1'] = RELA_DIR . "event/Detail/{$objEvent['Event_id']}/{$objEvent['event_name']}";

        $urlEncode = base64_encode('event_id=' . $fields['event_id'] . '&date=' . $fields['date'] . '&time=' . $fields['time']);
        $export['step2'] = RELA_DIR . "sales/" . $urlEncode;

        $urlEncode = base64_encode('event_id=' . $fields['event_id'] . '&date=' . $fields['date'] . '&time=' . $fields['time'] . '&position=' . $fields['position']);
        $export['step3'] = RELA_DIR . "sales/" . $urlEncode;

        $this->fileName = 'sales.sandali.php';
        $this->template($export);
        die();
    }
    /** step 4 */
    function addSales($post)
    {
        global $member_info;

        /** url decode*/
        $fields = $this->urlDecode();
        $export['get']['date'] = $fields['date'];
        $export['get']['time'] = $fields['time'];
        $export['get']['position'] = $fields['position'];



        /** check and get event by id */
        $objEvent = $this->checkEvent($fields);

        /** get salon by objEvent */
        $objSalon = $this->checkSalon($objEvent);


        /** check position  */
        $objPosition = $this->checkPosition($fields['position']);

        /** sandali */
        $sandali = $this->existsSandali($objPosition);

        /** check sandali */
        $result = array_diff($sandali, $post['sandali']);
        $result2 = array_diff($sandali, $result);
        if (count($result2) == 0) {
            global $messageStack;
            $ms = not_exists_chair;
            $messageStack->add_session('message', $ms, 'error');
            $urlEncode = base64_encode('event_id=' . $fields['event_id'] . '&date=' . $fields['date'] . '&time=' . $fields['time']);

            redirectPage(RELA_DIR . "sales/" . $urlEncode, $ms);
        }


        /** my chair */
        $choose = implode($result2, ',');

        /** add sales  / status is 0 */
        $finalsave = new salesModel();
        $finalsave->event_id = $objEvent['Event_id'];
        $finalsave->place_id = $objSalon['Salon_id'];
        $finalsave->part_id = $objPosition['Salon_id'];
        $finalsave->user_id = $member_info['Artists_id'];
        $finalsave->sandali = $choose;
        $finalsave->event_time = $fields['time'];
        $finalsave->status = 0;
        $finalsave->price = count($result2) * $objPosition['price'];
        $finalsave->date = date('Y-m-d H:i:s');
        $finalsave->event_date = $fields['date'];
        $finalsave->save();


        $urlEncode = base64_encode('invoice=' . $finalsave->Sales_id);
        $export['step4'] = RELA_DIR . "sales/invoice";

        redirectPage($export['step4'], add_ticket);
    }
    function invoice()
    {
        global $member_info;

        /** get sales */
        $salesObj = salesModel::getBy_user_id($member_info['Artists_id'])->getList();
        if ($salesObj['export']['recordsCount'] == 0) {
            redirectPage(RELA_DIR, invoice_not_found);
        }

        $export['invoice'] = $salesObj['export']['list'];

        foreach ($export['invoice'] as $k => $invoice) {

            $fields['event_id'] = $invoice['event_id'];
            $fields['time'] = $invoice['event_time'];
            $fields['date'] = $invoice['event_time'];
            $fields['position'] = $invoice['part_id'];

            /** check and get event by id */
            $objEvent = $this->checkEvent($fields);
            $export['invoice'][$k]['event'] = $objEvent;

            /** get salon by objEvent */
            $objSalon = $this->checkSalon($objEvent);
            $export['invoice'][$k]['salon'] = $objSalon;

            /** check position  */
            $objPosition = $this->checkPosition($fields['position']);
            $export['invoice'][$k]['position'] = $objPosition;

            //            print_r_debug($export);

        }



        $this->fileName = 'invoice.php';
        $this->template($export);
        die();
    }

    function deleteInvoice($id)
    {
        global $member_info;

        /** get sales */
        $salesObj = salesModel::getBy_user_id_and_Sales_id($member_info['Artists_id'], $id)->get();
        if ($salesObj['export']['recordsCount'] == 0) {
            redirectPage(RELA_DIR, invoice_not_found);
        }
        $salesObj['export']['list'][0]->delete();

        redirectPage(RELA_DIR . 'sales/invoice', success);
    }

    function pay($input)
    {
        global $member_info;
        /** get sales */
        $salesObj = salesModel::getBy_user_id_and_sales_id($member_info['Artists_id'], $input['sid'])->getList();
        if ($salesObj['export']['recordsCount'] == 0) {
            redirectPage(RELA_DIR, invoice_not_found);
        }



        /**
         *
         * BANK
         *
         */

        include_once(ROOT_DIR . 'model/ipg/enpayment.php');
        $resNum = $salesObj['export']['list'][0]['Sales_id'];
        $redirectUrl = RELA_DIR . "sales/returnbank/";
        $amount = $salesObj['export']['list'][0]['price'];

        /////////////////State1
        $payment = new Payment();
        $login = $payment->login(bank_username, bank_password);



        $login = $login['return'];
        $sessionId = $login['SessionId'];

        $params['ReserveNum'] = $resNum;
        $params['Amount'] = $amount;
        $params['RedirectUrl'] = $redirectUrl;
        $params['WSContext'] = array('SessionId' => $sessionId, 'UserId' => username, 'Password' => password);
        $params['TransType'] = "enGoods";
        $getPurchaseParamsToSign = $payment->getPurchaseParamsToSign($params);
        $getPurchaseParamsToSign =  $getPurchaseParamsToSign['return'];
        $uniqueId =  $getPurchaseParamsToSign['UniqueId'];
        $dataToSign = $getPurchaseParamsToSign['DataToSign'];

        ///////////////////////State3
        $params['UniqueId'] = $uniqueId;
        $params['Signature'] = $dataToSign;
        $params['WSContext'] = array('SessionId' => $sessionId, 'UserId' => username, 'Password' => password);

        $generateSignedPurchaseToken = $payment->generateSignedPurchaseToken($params);
        $generateSignedPurchaseToken = $generateSignedPurchaseToken['return'];
        $generateSignedPurchaseToken = $generateSignedPurchaseToken['Token'];

        /** end bank */
        $export['gspt'] = $generateSignedPurchaseToken;

        $salesObj2 = salesModel::getBy_user_id_and_sales_id($member_info['Artists_id'], $input['sid'])->get()['export']['list'][0];
        $salesObj2->bank_token = $generateSignedPurchaseToken;
        $salesObj2->save();

        $this->fileName = 'bankRequest.php';
        $this->template($export);

        die();
    }

    function returnBank($input)
    {
        global $member_info, $lang;

        $msg = array(6 => canceled_by_user);

        $salesObj2 = salesModel::getBy_user_id_and_bank_token($member_info['Artists_id'], $input['token'])
            ->get()['export']['list'][0];



        if ($input['State'] == 'OK') {


            /** verify bank */
            include_once(ROOT_DIR . 'model/ipg/enpayment.php');
            $amount = $salesObj2->price;

            $payment = new Payment();

            $login = $payment->login(bank_username, bank_password);
            $login = $login['return'];
            $sessionId = $login['SessionId'];
            $params['WSContext'] = array('SessionId' => $sessionId, 'UserId' => bank_username, 'Password' => bank_password);
            $params['Token'] = $input['token'];
            $params['RefNum'] = $input['RefNum'];

            /////////////////////////////////////////////Option 1--->VerifyTransaction
            $VerifyTrans = $payment->tokenPurchaseVerifyTransaction($params);
            $VerifyTrans = $VerifyTrans['return'];
            $VerifyTrans = $VerifyTrans['Amount'];
            if ($amount == $VerifyTrans) {
                //echo "Transaction Verified.";

                /** sataus update */
                $salesObj2->status = 1;
                $salesObj2->save();
            }

            /**********
            /////////////////////////////////////////////Option 2--->ReversTransaction
            $params['WSContext'] = array('SessionId' => $sessionId , 'UserId' => username, 'Password' => password);
            $params['Token']= $_POST['token'];
            $params['RefNum']= $_POST['RefNum'];
            $reverseTrans = $payment->ReverseTrans($params);
            $reverseTrans  = $reverseTrans['return'];
            $reverseTrans  = $reverseTrans['RefNum'];
            echo "Transaction Reversed.";
            //echo $reverseTrans ;
             ************/
        }

        if ($member_info['artists_phone1'] != '') {
            // include_once ROOT_DIR . 'component/magfa/magfa.model.php';
            // $sms = new WebServiceSample;

            if ($lang == 'fa') {
                $subject = 'صندلی رزرو';
                $message = 'صندلی رزرو شده ' . $salesObj2->fields['sandali'] . "می باشد." . " \n " . "http://variousartist.ir ";
            } else {
                $subject = 'chair number';
                $message = 'Your chair number is: ' . $salesObj2->fields['sandali'] . " \n http://variousartist.ir";
            }


            // $sms->simpleEnqueueSample($member_info['artists_phone1'], $message);

            ///email
            if (checkMail($member_info['email']) ==  1) {
                sendmail($member_info['email'], $subject, $message);
            }
        }



        $export['State'] = $input['State'];
        $export['msg'] = $msg[$input['ResNum']];
        $export['ResNum'] = $input['ResNum'];
        $this->fileName = 'returnbank.php';
        $this->template($export);
        die();
    }
}
