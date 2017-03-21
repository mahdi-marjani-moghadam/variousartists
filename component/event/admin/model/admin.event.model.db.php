<?php
/**

 * Created by PhpStorm.
 * User: malekloo
 * Date: 2/27/2016
 * Time: 11:02 AM.
 */
class adminEventModelDb
{
    public static function insert($fields)
    {
        // category
        $category_st = '';
        if (count($fields['category_id']) > 0) {
            $category_st = implode(',', $fields['category_id']);
            $category_st = ','.$category_st.',';
        }

        $category_rs = self::arrayToTag($fields['category_id']);
        $fields['category_list'] = $category_rs['export']['list'];
        // end category

        // certification
        $certification_st = '';
        if (count($fields['certification_id']) > 0) {
            $certification_st = implode(',', $fields['certification_id']);
            $certification_st = ','.$certification_st.',';
        }

        $certification_st = self::arrayToTag($fields['certification_id']);
        $fields['certification_list'] = $certification_st['export']['list'];
        // end certification
        //
        $conn = dbConn::getConnection();
        $sql = "
                    INSERT INTO event(
                    `category_id`,
                    `certification_id`,
                    `state_id`,
                    `city_id`,
                    `event_name`,
                    `meta_keyword`,
                    `meta_description`,
                    `registration_number`,
                    `national_id`,
                    `logo`,
                    `instagram`,
                    `twitter`,
                    `telegram`,
                    `description`,
                    `coordinator_name`,
                    `coordinator_phone`,
                    `coordinator_family`,
                    `date`,
                    `date2`,
                    `refresh_date`,
                    `priority`,
                    `status`
                    )
                    VALUES(
                    '".$fields['category_list']."',
                    '".$fields['certification_list']."',
                    '".$fields['state_id']."',
                    '".$fields['city_id']."',
                    '".$fields['event_name']."',
                    '".$fields['meta_keyword']."',
                    '".$fields['meta_description']."',
                    '".$fields['registration_number']."',
                    '".$fields['national_id']."',
                    '".$fields['logo']."',
                    '".$fields['instagram']."',
                    '".$fields['twitter']."',
                    '".$fields['telegram']."',
                    '".$fields['description']."',
                    '".$fields['coordinator_name']."',
                    '".$fields['coordinator_phone']."',
                    '".$fields['coordinator_family']."',
                     NOW(),
                     NOW(),
                    '".$fields['refresh_date']."',
                    '".$fields['priority']."',
                    '".$fields['status']."'
                    )";

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        if (!$stmt) {
            $result['result'] = -1;
            $result['Number'] = 1;
            $result['msg'] = $conn->errorInfo();

            return $result;
        }
        $result['export']['insert_id'] = $conn->lastInsertId();
        $result['result'] = 1;

        return $result;
    }

    public static function insert2($fields)
    {
        $fields['event_name']=str_replace('*','',$fields['event_name']);
        $fields['event_name']=str_replace('~','',$fields['event_name']);

        $conn = dbConn::getConnection();
        $sql = "
                    INSERT INTO event(
                    `Event_id`,
                    `category_id`,
                    `state_id`,
                    `city_id`,
                    `event_name`,
                    `meta_description`,
                    `description`,
                    `date`,
                    `date2`,
                    `refresh_date`,
                    `priority`,
                    `status`
                    )
                    VALUES(
                    '".$fields['Event_id']."',
                    '".$fields['category_list']."',
                    '".$fields['state_id']."',
                    '".$fields['city_id']."',
                    '".$fields['event_name']."',
                    '".$fields['meta_description']."',
                    '".$fields['description']."',
                     NOW(),
                     NOW(),
                     NOW(),
                    '0',
                    '1'
                    )";

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        if (!$stmt) {
            $result['result'] = -1;
            $result['Number'] = 1;
            $result['msg'] = $conn->errorInfo();

            return $result;
        }
        $result['result'] = 1;

        return $result;
    }

    /**
     * add event phones.
     *
     * @param $fields ,$event
     *
     * @return mixed
     */
    public static function insertToPhones($fields, $event_id)
    {
        $phones = $fields['event_phone'];

        $conn = dbConn::getConnection();
        $sql = '
                INSERT INTO event_phones(
                `event_id`,
                `phone_subject`,
                `phone_number`,
                `phone_state`,
                `phone_value`
                )
                VALUES ';
        for ($i = 0; $i < count($phones['subject']); ++$i) {
            $sql .= "('".$event_id."','".$phones['subject'][$i]."','".$phones['number'][$i]."','".$phones['state'][$i]."','".$phones['value'][$i]."'),";
        }
        $sql = substr($sql, 0, -1);

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        if (!$stmt) {
            $result['result'] = -1;
            $result['Number'] = 1;
            $result['msg'] = $conn->errorInfo();

            return $result;
        }
        $result['export']['insert_id'] = $conn->lastInsertId();
        $result['result'] = 1;

        return $result;
    }

    /**
     * add event emails.
     *
     * @param $fields
     * @param $event_id
     *
     * @return mixed
     */
    public static function insertToEmails($fields, $event_id)
    {
        $emails = $fields['event_email'];

        $conn = dbConn::getConnection();
        $sql = '
                INSERT INTO event_emails(
                `event_id`,
                `email_subject`,
                `email_email`
                )
                VALUES ';

        for ($i = 0; $i < count($emails['subject']); ++$i) {
            $sql .= "('".$event_id."','".$emails['subject'][$i]."','".$emails['email'][$i]."'),";
        }
        $sql = substr($sql, 0, -1);

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        if (!$stmt) {
            $result['result'] = -1;
            $result['Number'] = 1;
            $result['msg'] = $conn->errorInfo();

            return $result;
        }
        $result['export']['insert_id'] = $conn->lastInsertId();
        $result['result'] = 1;

        return $result;
    }
    /**
     * add event addresses.
     *
     * @param $fields
     * @param $event_id
     *
     * @return mixed
     */
    public static function insertToAddresses($fields, $event_id)
    {
        $addresses = $fields['event_address'];

        $conn = dbConn::getConnection();
        $sql = '
                INSERT INTO event_addresses(
                `event_id`,
                `address_subject`,
                `address_address`
                )
                VALUES ';

        for ($i = 0; $i < count($addresses['subject']); ++$i) {
            $sql .= "('".$event_id."','".$addresses['subject'][$i]."','".$addresses['address'][$i]."'),";
        }
        $sql = substr($sql, 0, -1);

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        if (!$stmt) {
            $result['result'] = -1;
            $result['Number'] = 1;
            $result['msg'] = $conn->errorInfo();

            return $result;
        }
        $result['export']['insert_id'] = $conn->lastInsertId();
        $result['result'] = 1;

        return $result;
    }
    /**
     * add event websites.
     *
     * @param $fields
     * @param $event_id
     *
     * @return mixed
     */
    public static function insertToWebsites($fields, $event_id)
    {
        $websites = $fields['event_website'];

        $conn = dbConn::getConnection();
        $sql = '
                INSERT INTO event_websites(
                `event_id`,
                `website_subject`,
                `website_url`
                )
                VALUES ';

        for ($i = 0; $i < count($websites['subject']); ++$i) {
            $sql .= "('".$event_id."','".$websites['subject'][$i]."','".$websites['url'][$i]."'),";
        }
        $sql = substr($sql, 0, -1);

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        if (!$stmt) {
            $result['result'] = -1;
            $result['Number'] = 1;
            $result['msg'] = $conn->errorInfo();

            return $result;
        }
        $result['export']['insert_id'] = $conn->lastInsertId();
        $result['result'] = 1;

        return $result;
    }

    /**
     * add event phones 2.
     *
     * @param $fields ,$event
     *
     * @return mixed
     */
    public static function insertToPhones2($fields)
    {

        $conn = dbConn::getConnection();
        $sql = "
                INSERT INTO event_phones(
                `event_id`,
                `phone_subject`,
                `phone_number`,
                `phone_state`,
                `phone_value`
                )
                VALUES ";
        $sql .= "('".$fields['event_id']."','".$fields['subject']."','".$fields['number']."','".$fields['state']."','".$fields['value']."')";

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        if (!$stmt) {
            $result['result'] = -1;
            $result['Number'] = 1;
            $result['msg'] = $conn->errorInfo();

            return $result;
        }
        $result['export']['insert_id'] = $conn->lastInsertId();
        $result['result'] = 1;

        return $result;
    }
    /**
     * add event phones 2.
     *
     * @param $fields ,$event
     *
     * @return mixed
     */
    public static function insertToEmails2($fields)
    {
        $conn = dbConn::getConnection();
        $sql = "
                INSERT INTO event_emails(
                `event_id`,
                `email_subject`,
                `email_email`
                )
                VALUES ";
        $sql .= "('".$fields['event_id']."','".$fields['subject']."','".$fields['email']."')";

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        if (!$stmt) {
            $result['result'] = -1;
            $result['Number'] = 1;
            $result['msg'] = $conn->errorInfo();

            return $result;
        }
        $result['export']['insert_id'] = $conn->lastInsertId();
        $result['result'] = 1;

        return $result;
    }
    /**
     * add event phones 2.
     *
     * @param $fields ,$event
     *
     * @return mixed
     */
    public static function insertToAddresses2($fields)
    {
        $conn = dbConn::getConnection();
        $sql = "
                INSERT INTO event_addresses(
                `event_id`,
                `address_subject`,
                `address_address`
                )
                VALUES ";
        $sql .= "('".$fields['event_id']."','".$fields['subject']."','".$fields['address']."')";

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        if (!$stmt) {
            $result['result'] = -1;
            $result['Number'] = 1;
            $result['msg'] = $conn->errorInfo();

            return $result;
        }
        $result['export']['insert_id'] = $conn->lastInsertId();
        $result['result'] = 1;

        return $result;
    }
    /**
     * add event websites 2.
     *
     * @param $fields ,$event
     *
     * @return mixed
     */
    public static function insertToWebsites2($fields)
    {
        $conn = dbConn::getConnection();
        $sql = "
                INSERT INTO event_websites(
                `event_id`,
                `website_subject`,
                `website_url`
                )
                VALUES ";
        $sql .= "('".$fields['event_id']."','".$fields['subject']."','".$fields['website']."')";

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        if (!$stmt) {
            $result['result'] = -1;
            $result['Number'] = 1;
            $result['msg'] = $conn->errorInfo();

            return $result;
        }
        $result['export']['insert_id'] = $conn->lastInsertId();
        $result['result'] = 1;

        return $result;
    }
    /**
     * edit event by Event_id.
     *
     * @param $fields
     *
     * @return mixed
     *
     * @author malekloo
     * @date 3/16/2015
     *
     * @version 01.01.01
     */
    public static function update($fields)
    {
        $conn = dbConn::getConnection();

        $temp = self::arrayToTag($fields['category_id']);
        $fields['category_id'] = $temp ['export']['list'];

        $temp = self::arrayToTag($fields['certification_id']);
        $fields['certification_id'] = $temp ['export']['list'];

        $sql = 'UPDATE event SET ';

        foreach ($fields as $fieldName => $val) {
            //echo $fieldName.'='.$val;
            if($fieldName != 'event_phone' && $fieldName != 'event_email' && $fieldName != 'event_address' && $fieldName != 'event_website')
                $sql = $sql.'`'.$fieldName."` = '".$val."',";
        }
        $sql = substr($sql, 0, -1);
        $sql = $sql."WHERE Event_id = '".$fields['Event_id']."'";

        include_once ROOT_DIR.'component/product/admin/model/admin.product.model.db.php';

        $result = adminProductModelDb::updateEventProductsCity($fields['city_id'],$fields['Event_id']);

        if($result['result'] != 1)
        {
            return $result;
        }

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        if (!$stmt) {
            $result['result'] = -1;
            $result['Number'] = 1;
            $result['msg'] = $conn->errorInfo();

            return $result;
        }
        $result['result'] = 1;

        return $result;
    }

    /**
     * delete event phones.
     *
     * @param $eventId
     *
     * @return mixed
     */
    public static function deletePhones($eventId)
    {
        $conn = dbConn::getConnection();

        $sql = "DELETE FROM event_phones WHERE `event_id` = '".$eventId."'";

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        if (!$stmt) {
            $result['result'] = -1;
            $result['Number'] = 1;
            $result['msg'] = $conn->errorInfo();

            return $result;
        }

        $result['result'] = 1;

        return $result;
    }

    /**
     * delete event emails.
     *
     * @param $eventId
     *
     * @return mixed
     */
    public static function deleteEmails($eventId)
    {
        $conn = dbConn::getConnection();

        $sql = "DELETE FROM event_emails WHERE `event_id` = '".$eventId."'";

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        if (!$stmt) {
            $result['result'] = -1;
            $result['Number'] = 1;
            $result['msg'] = $conn->errorInfo();

            return $result;
        }

        $result['result'] = 1;

        return $result;
    }

    /**
     * delete event addresses.
     *
     * @param $eventId
     *
     * @return mixed
     */
    public static function deleteAddresses($eventId)
    {
        $conn = dbConn::getConnection();

        $sql = "DELETE FROM event_addresses WHERE `event_id` = '".$eventId."'";

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        if (!$stmt) {
            $result['result'] = -1;
            $result['Number'] = 1;
            $result['msg'] = $conn->errorInfo();

            return $result;
        }

        $result['result'] = 1;

        return $result;
    }

    /**
     * delete event websites.
     *
     * @param $eventId
     *
     * @return mixed
     */
    public static function deleteWebsites($eventId)
    {
        $conn = dbConn::getConnection();

        $sql = "DELETE FROM `event_websites` WHERE `event_id` = '".$eventId."'";

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        if (!$stmt) {
            $result['result'] = -1;
            $result['Number'] = 1;
            $result['msg'] = $conn->errorInfo();

            return $result;
        }

        $result['result'] = 1;

        return $result;
    }


    private function _getReport($fields='')
    {

        global $event_info;
        $event_name=$event_info['comp_name'];
        $this->_checkPermission();
        $conn = parent::getConnection();
        $fields['useTrash']='false';
        $filter=$this->filterBuilder($fields);
        $length=$filter['length'];
        $filter=$filter['list'];
        if($filter['order'] =='')
        {
            $filter['order']= 'ORDER BY `calldate` DESC';
        }
        $sql = "
                  SELECT  `t1`.* FROM (SELECT `cdr`.* FROM `cdr` WHERE `cdr`.`dcontext` like '%-$event_name') as t1

        ".$filter['WHERE'] .$filter['filter'].$filter['order'].$filter['limit'];

        //or WHERE    news_id='$id' ");
        $stmt = $conn->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();

        if (!$stmt)
        {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = $conn->errorInfo();
            return $result;
        }

        $sql="

                SELECT
                  Count(`t1`.`cdr_id`) AS `recCount`
                FROM
                  (SELECT *
                  FROM `cdr`
                  WHERE `cdr`.`dcontext` LIKE '%-$event_name') AS `t1`

             ".$filter['WHERE'] .$filter['filter'];
        //echo $stmt->rowCount();

        $stmTp = $conn->prepare($sql);
        $stmTp->setFetchMode(PDO::FETCH_ASSOC);
        $stmTp->execute();

        $rowP = $stmTp->fetch();
        $rowFound=$rowP['recCount'];
        $this->_paging['recordsFiltered']=$rowP['recCount'];
        $this->_paging['recordsTotal']= $rowFound['found'];

        while($row = $stmt->fetch())
        {
            $callDate=$row['calldate'];
            list($date, $time) = explode(" ",$callDate);
            list($year, $month, $day) = explode("-", $date);
            list($extension, $compName) = explode("-", $row['dcontext']);
            $row['filename']=RELA_CHANEL.$event_name.'/'.$year.'/'.$month.'/'.$day.'/'.$row['uniqueid'].'.'.'wav';
            $this->_set_reportListDb($row['cdr_id'], $row);
        }


        $result['result'] = 1;
        $result['no'] = 2;
        return $result;
    }

    public function getEventold($fields = '')
    {

        $conn = dbConn::getConnection();

        include_once ROOT_DIR.'/model/db.inc.class.php';

        $condition = DataBase::filterBuilder($fields);



        $sql = 'SELECT SQL_CALC_FOUND_ROWS
                 *
    		     FROM 	event '.$condition['list']['WHERE'].$condition['list']['filter'].$condition['list']['order'].$condition['list']['limit'];

        $stmt = $conn->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();

        if (!$stmt) {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = $conn->errorInfo();

            return $result;
        }

        $sql = ' SELECT FOUND_ROWS() as recCount ';

        $stmTp = $conn->prepare($sql);
        $stmTp->setFetchMode(PDO::FETCH_ASSOC);
        $stmTp->execute();
        $row_count = $stmTp->fetch();

        $result['export']['recordsCount'] = $row_count['recCount'];

        while ($row = $stmt->fetch()) {
            $temp = self::tagToArray($row['category_id']);
            $row['category_id'] = $temp['export']['list'];
            $list[$row['Event_id']] = $row;

            $temp = self::tagToArray($row['certification_id']);
            $row['certification_id'] = $temp['export']['list'];
            $list[$row['Event_id']] = $row;

            include_once ROOT_DIR.'component/city/admin/model/admin.city.model.db.php';
            $row['city'] = adminCityModelDb::getCityById($row['city_id']);

            $id = $row['Event_id'];
            // get event phones
            $sql1 = "select * from event_phones where `event_id`='$id'";



            $stmt1 = $conn->prepare($sql1);
            $stmt1->execute();
            $stmt1->setFetchMode(PDO::FETCH_ASSOC);

            if (!$stmt1) {
                $result1['result'] = -1;
                $result1['Number'] = 1;
                $result1['msg'] = $conn->errorInfo();

                return $result1;
            }

            $phones = [
                'Event_phones_id' => [],
                'subject' => [],
                'number' => [],
                'state' => [],
                'value' => [],
            ];

            while ($row1 = $stmt1->fetch()) {
                array_push($phones['Event_phones_id'], $row1['Event_phones_id']);
                array_push($phones['subject'], $row1['phone_subject']);
                array_push($phones['number'], $row1['phone_number']);
                array_push($phones['state'], $row1['phone_state']);
                array_push($phones['value'], $row1['phone_value']);
            }

            $row['event_phone'] = $phones;
            $list[$row['Event_id']] = $row;
            // get event emails
            $sql1 = "select * from event_emails where `event_id`='$id'";

            $stmt1 = $conn->prepare($sql1);
            $stmt1->execute();
            $stmt1->setFetchMode(PDO::FETCH_ASSOC);

            if (!$stmt1) {
                $result1['result'] = -1;
                $result1['Number'] = 1;
                $result1['msg'] = $conn->errorInfo();

                return $result1;
            }

            $emails = [
                'Event_emails_id' => [],
                'subject' => [],
                'email' => [],
            ];

            while ($row1 = $stmt1->fetch()) {
                array_push($emails['Event_emails_id'], $row1['Event_emails_id']);
                array_push($emails['subject'], $row1['email_subject']);
                array_push($emails['email'], $row1['email_email']);
            }

            $row['event_email'] = $emails;
            $list[$row['Event_id']] = $row;

            // get event addresses
            $sql1 = "select * from event_addresses where `event_id`='$id'";

            $stmt1 = $conn->prepare($sql1);
            $stmt1->execute();
            $stmt1->setFetchMode(PDO::FETCH_ASSOC);

            if (!$stmt1) {
                $result1['result'] = -1;
                $result1['Number'] = 1;
                $result1['msg'] = $conn->errorInfo();

                return $result1;
            }

            $addresses = [
                'Event_addresses_id' => [],
                'subject' => [],
                'address' => [],
            ];

            while ($row1 = $stmt1->fetch()) {
                array_push($addresses['Event_addresses_id'], $row1['Event_addresses_id']);
                array_push($addresses['subject'], $row1['address_subject']);
                array_push($addresses['address'], $row1['address_address']);
            }

            $row['event_address'] = $addresses;
            $list[$row['Event_id']] = $row;
            // get event websites
            $sql1 = "select * from event_websites where `event_id`='$id'";

            $stmt1 = $conn->prepare($sql1);
            $stmt1->execute();
            $stmt1->setFetchMode(PDO::FETCH_ASSOC);

            if (!$stmt1) {
                $result1['result'] = -1;
                $result1['Number'] = 1;
                $result1['msg'] = $conn->errorInfo();

                return $result1;
            }

            $websites = [
                'Event_websites_id' => [],
                'subject' => [],
                'url' => [],
            ];

            while ($row1 = $stmt1->fetch()) {
                array_push($websites['Event_websites_id'], $row1['Event_websites_id']);
                array_push($websites['subject'], $row1['website_subject']);
                array_push($websites['url'], $row1['website_url']);
            }

            $row['event_website'] = $websites;
            $list[$row['Event_id']] = $row;

        }

        $result['result'] = 1;
        $result['export']['list'] = $list;
        return $result;
    }

    public function getEvent($fields = '')
    {

        $conn = dbConn::getConnection();

        include_once ROOT_DIR.'/model/db.inc.class.php';

        $condition = DataBase::filterBuilder($fields);

        $length=$condition['length'];
        if($condition['list']['order'] =='')
        {
            $condition['list']['order']= ' ORDER BY `Event_id` ASC ';
        }

        $sql="
                select
                SQL_CALC_FOUND_ROWS
                `t1`.* FROM
                 (
                    SELECT `event`.*
                    
                      FROM `event`
                        ".
                       $fields['where']
                     ."GROUP BY `event`.`Event_id`
                  ) as t1 "
                  .$condition['list']['useWhere'].$condition['list']['filter'].$condition['list']['order'].$condition['list']['limit'];

        $stmt = $conn->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();

        if (!$stmt) {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = $conn->errorInfo();

            return $result;
        }


        $sql = ' SELECT FOUND_ROWS() as recCount ';

        $stmTp = $conn->prepare($sql);
        $stmTp->setFetchMode(PDO::FETCH_ASSOC);
        $stmTp->execute();
        $row_count = $stmTp->fetch();
        $result['export']['recordsCount'] = $row_count['recCount'];


        include_once ROOT_DIR."component/category/admin/model/admin.category.model.php";

        //$cat = new adminCategoryModel();
        //$obj = adminCategoryModel::getBy_not_Category_id(0)->getList();

        global $lang;
        while ($row = $stmt->fetch()) {

            $cat_title = '';

            foreach (explode(',',$row['category_id']) as $k => $v ){

                if($v == ''){ continue;}
                $obj = adminCategoryModel::find($v);

                $cat_title .= $obj->fields["title_$lang"] .' / ';

            }

            $row['category_id'] = substr($cat_title,0,-2);

            //$temp = self::tagToArray($row['category_id']);
            //$row['category_id'] = $temp['export']['list'];
            $list[$row['Event_id']] = $row;

            //$temp = self::tagToArray($row['certification_id']);
            //$row['certification_id'] = $temp['export']['list'];

            $list[$row['Event_id']] = $row;

        }


        $result['result'] = 1;
        $result['export']['list'] = $list;
        return $result;
    }

    public static function getEventById($id)
    {
        //global $lang;
        $conn = dbConn::getConnection();
        $sql = "SELECT
                    *
                FROM
                    event
                WHERE
                    Event_id= '$id'";

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        if (!$stmt) {
            $result['result'] = -1;
            $result['Number'] = 1;
            $result['msg'] = $conn->errorInfo();

            return $result;
        }

        if (!$stmt->rowCount()) {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = 'This Record was Not Found';

            return $result;
        }

        $row = $stmt->fetch();
        $temp = self::tagToArray($row['category_id']);
        $row['category_id'] = $temp['export']['list'];

        $temp = self::tagToArray($row['certification_id']);
        $row['certification_id'] = $temp['export']['list'];

        $result['result'] = 1;
        $result['export']['list'] = $row;




        return $result;
    }

    public static function delete($id)
    {
        $conn = dbConn::getConnection();

        $sql = "
                DELETE FROM event
                    WHERE Event_id = '".$id."'
                    ";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        if (!$stmt) {
            $result['result'] = -1;
            $result['Number'] = 1;
            $result['msg'] = $conn->errorInfo();

            return $result;
        }
        $result['result'] = 1;

        return $result;
    }

    public static function arrayToTag($input)
    {
        $export = '';
        if (count($input) > 0) {
            $export = implode(',', $input);
            $export = ','.$export.',';
        }
        $result ['export']['list'] = $export;
        $result['result'] = '1';

        return $result;
    }

    public static function tagToArray($input)
    {
        $export = explode(',', $input);
        $export = array_filter($export, 'strlen');
        $result ['export']['list'] = $export;
        $result['result'] = '1';

        return $result;
    }

    public static function getAllPhone($input){

        $conn = dbConn::getConnection();
        
        $sql = "
                select phone_number FROM event_phones 
                    where Event_id = '".$input['']."'
                    ";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        if (!$stmt) {
            $result['result'] = -1;
            $result['Number'] = 1;
            $result['msg'] = $conn->errorInfo();

            return $result;
        }

        while ($row = $stmt->fetch()) {

            $result['export']['list'][]=$row['phone_number'];
        }

        $result['result'] = 1;
        return $result;
    }
}
