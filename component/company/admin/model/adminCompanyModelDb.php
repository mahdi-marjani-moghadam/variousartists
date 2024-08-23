<?php
namespace Component\company\admin\model;
use Common\dbConn;
use Component\product\admin\model\adminProductModelDb;
use PDO;

class adminCompanyModelDb
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
                    INSERT INTO company(
                    `category_id`,
                    `certification_id`,
                    `state_id`,
                    `city_id`,
                    `company_name`,
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
                    `refresh_date`,
                    `priority`,
                    `status`
                    )
                    VALUES(
                    '".$fields['category_list']."',
                    '".$fields['certification_list']."',
                    '".$fields['state_id']."',
                    '".$fields['city_id']."',
                    '".$fields['company_name']."',
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
        $fields['company_name']=str_replace('*','',$fields['company_name']);
        $fields['company_name']=str_replace('~','',$fields['company_name']);

        $conn = dbConn::getConnection();
        $sql = "
                    INSERT INTO company(
                    `Company_id`,
                    `category_id`,
                    `state_id`,
                    `city_id`,
                    `company_name`,
                    `meta_description`,
                    `description`,
                    `date`,
                    `refresh_date`,
                    `priority`,
                    `status`
                    )
                    VALUES(
                    '".$fields['Company_id']."',
                    '".$fields['category_list']."',
                    '".$fields['state_id']."',
                    '".$fields['city_id']."',
                    '".$fields['company_name']."',
                    '".$fields['meta_description']."',
                    '".$fields['description']."',
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
     * add company phones.
     *
     * @param $fields ,$company
     *
     * @return mixed
     */
    public static function insertToPhones($fields, $company_id)
    {
        $phones = $fields['company_phone'];

        $conn = dbConn::getConnection();
        $sql = '
                INSERT INTO company_phones(
                `company_id`,
                `phone_subject`,
                `phone_number`,
                `phone_state`,
                `phone_value`
                )
                VALUES ';
        for ($i = 0; $i < count($phones['subject']); ++$i) {
            $sql .= "('".$company_id."','".$phones['subject'][$i]."','".$phones['number'][$i]."','".$phones['state'][$i]."','".$phones['value'][$i]."'),";
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
     * add company emails.
     *
     * @param $fields
     * @param $company_id
     *
     * @return mixed
     */
    public static function insertToEmails($fields, $company_id)
    {
        $emails = $fields['company_email'];

        $conn = dbConn::getConnection();
        $sql = '
                INSERT INTO company_emails(
                `company_id`,
                `email_subject`,
                `email_email`
                )
                VALUES ';

        for ($i = 0; $i < count($emails['subject']); ++$i) {
            $sql .= "('".$company_id."','".$emails['subject'][$i]."','".$emails['email'][$i]."'),";
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
     * add company addresses.
     *
     * @param $fields
     * @param $company_id
     *
     * @return mixed
     */
    public static function insertToAddresses($fields, $company_id)
    {
        $addresses = $fields['company_address'];

        $conn = dbConn::getConnection();
        $sql = '
                INSERT INTO company_addresses(
                `company_id`,
                `address_subject`,
                `address_address`
                )
                VALUES ';

        for ($i = 0; $i < count($addresses['subject']); ++$i) {
            $sql .= "('".$company_id."','".$addresses['subject'][$i]."','".$addresses['address'][$i]."'),";
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
     * add company websites.
     *
     * @param $fields
     * @param $company_id
     *
     * @return mixed
     */
    public static function insertToWebsites($fields, $company_id)
    {
        $websites = $fields['company_website'];

        $conn = dbConn::getConnection();
        $sql = '
                INSERT INTO company_websites(
                `company_id`,
                `website_subject`,
                `website_url`
                )
                VALUES ';

        for ($i = 0; $i < count($websites['subject']); ++$i) {
            $sql .= "('".$company_id."','".$websites['subject'][$i]."','".$websites['url'][$i]."'),";
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
     * add company phones 2.
     *
     * @param $fields ,$company
     *
     * @return mixed
     */
    public static function insertToPhones2($fields)
    {

        $conn = dbConn::getConnection();
        $sql = "
                INSERT INTO company_phones(
                `company_id`,
                `phone_subject`,
                `phone_number`,
                `phone_state`,
                `phone_value`
                )
                VALUES ";
        $sql .= "('".$fields['company_id']."','".$fields['subject']."','".$fields['number']."','".$fields['state']."','".$fields['value']."')";

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
     * add company phones 2.
     *
     * @param $fields ,$company
     *
     * @return mixed
     */
    public static function insertToEmails2($fields)
    {
        $conn = dbConn::getConnection();
        $sql = "
                INSERT INTO company_emails(
                `company_id`,
                `email_subject`,
                `email_email`
                )
                VALUES ";
        $sql .= "('".$fields['company_id']."','".$fields['subject']."','".$fields['email']."')";

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
     * add company phones 2.
     *
     * @param $fields ,$company
     *
     * @return mixed
     */
    public static function insertToAddresses2($fields)
    {
        $conn = dbConn::getConnection();
        $sql = "
                INSERT INTO company_addresses(
                `company_id`,
                `address_subject`,
                `address_address`
                )
                VALUES ";
        $sql .= "('".$fields['company_id']."','".$fields['subject']."','".$fields['address']."')";

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
     * add company websites 2.
     *
     * @param $fields ,$company
     *
     * @return mixed
     */
    public static function insertToWebsites2($fields)
    {
        $conn = dbConn::getConnection();
        $sql = "
                INSERT INTO company_websites(
                `company_id`,
                `website_subject`,
                `website_url`
                )
                VALUES ";
        $sql .= "('".$fields['company_id']."','".$fields['subject']."','".$fields['website']."')";

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
     * edit company by Company_id.
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

        $sql = 'UPDATE company SET ';

        foreach ($fields as $fieldName => $val) {
            //echo $fieldName.'='.$val;
            if($fieldName != 'company_phone' && $fieldName != 'company_email' && $fieldName != 'company_address' && $fieldName != 'company_website')
                $sql = $sql.'`'.$fieldName."` = '".$val."',";
        }
        $sql = substr($sql, 0, -1);
        $sql = $sql."WHERE Company_id = '".$fields['Company_id']."'";

        // include_once ROOT_DIR.'component/product/admin/model/admin.product.model.db.php';

        $result = adminProductModelDb::updateCompanyProductsCity($fields['city_id'],$fields['Company_id']);

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
     * delete company phones.
     *
     * @param $companyId
     *
     * @return mixed
     */
    public static function deletePhones($companyId)
    {
        $conn = dbConn::getConnection();

        $sql = "DELETE FROM company_phones WHERE `company_id` = '".$companyId."'";

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
     * delete company emails.
     *
     * @param $companyId
     *
     * @return mixed
     */
    public static function deleteEmails($companyId)
    {
        $conn = dbConn::getConnection();

        $sql = "DELETE FROM company_emails WHERE `company_id` = '".$companyId."'";

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
     * delete company addresses.
     *
     * @param $companyId
     *
     * @return mixed
     */
    public static function deleteAddresses($companyId)
    {
        $conn = dbConn::getConnection();

        $sql = "DELETE FROM company_addresses WHERE `company_id` = '".$companyId."'";

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
     * delete company websites.
     *
     * @param $companyId
     *
     * @return mixed
     */
    public static function deleteWebsites($companyId)
    {
        $conn = dbConn::getConnection();

        $sql = "DELETE FROM `company_websites` WHERE `company_id` = '".$companyId."'";

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

        global $company_info;
        $company_name=$company_info['comp_name'];
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
                  SELECT  `t1`.* FROM (SELECT `cdr`.* FROM `cdr` WHERE `cdr`.`dcontext` like '%-$company_name') as t1

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
                  WHERE `cdr`.`dcontext` LIKE '%-$company_name') AS `t1`

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
            $row['filename']=RELA_CHANEL.$company_name.'/'.$year.'/'.$month.'/'.$day.'/'.$row['uniqueid'].'.'.'wav';
            $this->_set_reportListDb($row['cdr_id'], $row);
        }


        $result['result'] = 1;
        $result['no'] = 2;
        return $result;
    }

    public function getCompanyold($fields = '')
    {

        $conn = dbConn::getConnection();

        include_once ROOT_DIR.'/model/db.inc.class.php';

        $condition = DataBase::filterBuilder($fields);



        $sql = 'SELECT SQL_CALC_FOUND_ROWS
                 *
    		     FROM 	company '.$condition['list']['WHERE'].$condition['list']['filter'].$condition['list']['order'].$condition['list']['limit'];

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
            $list[$row['Company_id']] = $row;

            $temp = self::tagToArray($row['certification_id']);
            $row['certification_id'] = $temp['export']['list'];
            $list[$row['Company_id']] = $row;

            // include_once ROOT_DIR.'component/city/admin/model/admin.city.model.db.php';
            $row['city'] = adminCityModelDb::getCityById($row['city_id']);

            $id = $row['Company_id'];
            // get company phones
            $sql1 = "select * from company_phones where `company_id`='$id'";



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
                'Company_phones_id' => [],
                'subject' => [],
                'number' => [],
                'state' => [],
                'value' => [],
            ];

            while ($row1 = $stmt1->fetch()) {
                array_push($phones['Company_phones_id'], $row1['Company_phones_id']);
                array_push($phones['subject'], $row1['phone_subject']);
                array_push($phones['number'], $row1['phone_number']);
                array_push($phones['state'], $row1['phone_state']);
                array_push($phones['value'], $row1['phone_value']);
            }

            $row['company_phone'] = $phones;
            $list[$row['Company_id']] = $row;
            // get company emails
            $sql1 = "select * from company_emails where `company_id`='$id'";

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
                'Company_emails_id' => [],
                'subject' => [],
                'email' => [],
            ];

            while ($row1 = $stmt1->fetch()) {
                array_push($emails['Company_emails_id'], $row1['Company_emails_id']);
                array_push($emails['subject'], $row1['email_subject']);
                array_push($emails['email'], $row1['email_email']);
            }

            $row['company_email'] = $emails;
            $list[$row['Company_id']] = $row;

            // get company addresses
            $sql1 = "select * from company_addresses where `company_id`='$id'";

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
                'Company_addresses_id' => [],
                'subject' => [],
                'address' => [],
            ];

            while ($row1 = $stmt1->fetch()) {
                array_push($addresses['Company_addresses_id'], $row1['Company_addresses_id']);
                array_push($addresses['subject'], $row1['address_subject']);
                array_push($addresses['address'], $row1['address_address']);
            }

            $row['company_address'] = $addresses;
            $list[$row['Company_id']] = $row;
            // get company websites
            $sql1 = "select * from company_websites where `company_id`='$id'";

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
                'Company_websites_id' => [],
                'subject' => [],
                'url' => [],
            ];

            while ($row1 = $stmt1->fetch()) {
                array_push($websites['Company_websites_id'], $row1['Company_websites_id']);
                array_push($websites['subject'], $row1['website_subject']);
                array_push($websites['url'], $row1['website_url']);
            }

            $row['company_website'] = $websites;
            $list[$row['Company_id']] = $row;

        }

        $result['result'] = 1;
        $result['export']['list'] = $list;
        return $result;
    }

    public function getCompany($fields = '')
    {

        $conn = dbConn::getConnection();

        include_once ROOT_DIR.'/model/db.inc.class.php';

        $condition = DataBase::filterBuilder($fields);

        $length=$condition['length'];
        if($condition['list']['order'] =='')
        {
            $condition['list']['order']= ' ORDER BY `Company_id` ASC ';
        }

        $sql="
                select
                SQL_CALC_FOUND_ROWS
                `t1`.* FROM
                 (
                    SELECT `company`.*,
                        `company_emails`.`email_email`,
                        `city`.`name` AS `city_name`,
                        `company_phones`.`phone_number`,
                        `company_websites`.`website_url`,
                        `company_addresses`.`address_address`
                      FROM `company`
                        LEFT JOIN `company_emails` ON `company`.`Company_id` =
                          `company_emails`.`company_id`
                        LEFT JOIN `company_phones` ON `company`.`Company_id` =
                          `company_phones`.`company_id`
                        LEFT JOIN `company_websites` ON `company`.`Company_id` =
                          `company_websites`.`company_id`
                        LEFT JOIN `city` ON `company`.`city_id` = `city`.`City_id`
                        LEFT JOIN `company_addresses` ON `company`.`Company_id` =
                          `company_addresses`.`company_id`".
                       $fields['where']
                     ."GROUP BY `company`.`Company_id`
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


        while ($row = $stmt->fetch()) {
            $temp = self::tagToArray($row['category_id']);
            $row['category_id'] = $temp['export']['list'];
            $list[$row['Company_id']] = $row;

            //$temp = self::tagToArray($row['certification_id']);
            //$row['certification_id'] = $temp['export']['list'];

            $list[$row['Company_id']] = $row;

        }


        $result['result'] = 1;
        $result['export']['list'] = $list;
        return $result;
    }

    public static function getCompanyById($id)
    {
        //global $lang;
        $conn = dbConn::getConnection();
        $sql = "SELECT
                    *
                FROM
                    company
                WHERE
                    Company_id= '$id'";

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

        // get company phones
        $sql = "select * from company_phones where `company_id`='$id'";

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        if (!$stmt) {
            $result['result'] = -1;
            $result['Number'] = 1;
            $result['msg'] = $conn->errorInfo();

            return $result;
        }

        $phones = [
            'Company_phones_id' => [],
            'subject' => [],
            'number' => [],
            'state' => [],
            'value' => [],
        ];

        while ($row = $stmt->fetch()) {
            array_push($phones['Company_phones_id'], $row['Company_phones_id']);
            array_push($phones['subject'], $row['phone_subject']);
            array_push($phones['number'], $row['phone_number']);
            array_push($phones['state'], $row['phone_state']);
            array_push($phones['value'], $row['phone_value']);
        }

        $result['export']['list']['company_phone'] = $phones;

        // get company emails
        $sql = "select * from company_emails where `company_id`='$id'";

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        if (!$stmt) {
            $result['result'] = -1;
            $result['Number'] = 1;
            $result['msg'] = $conn->errorInfo();

            return $result;
        }

        $emails = [
            'Company_emails_id' => [],
            'subject' => [],
            'email' => [],
        ];

        while ($row = $stmt->fetch()) {
            array_push($emails['Company_emails_id'], $row['Company_emails_id']);
            array_push($emails['subject'], $row['email_subject']);
            array_push($emails['email'], $row['email_email']);
        }

        $result['export']['list']['company_email'] = $emails;

        // get company addresses
        $sql = "select * from company_addresses where `company_id`='$id'";

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        if (!$stmt) {
            $result['result'] = -1;
            $result['Number'] = 1;
            $result['msg'] = $conn->errorInfo();

            return $result;
        }

        $addresses = [
            'Company_addresses_id' => [],
            'subject' => [],
            'address' => [],
        ];

        while ($row = $stmt->fetch()) {
            array_push($addresses['Company_addresses_id'], $row['Company_addresses_id']);
            array_push($addresses['subject'], $row['address_subject']);
            array_push($addresses['address'], $row['address_address']);
        }

        $result['export']['list']['company_address'] = $addresses;

        // get company websites
        $sql = "select * from company_websites where `company_id`='$id'";

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        if (!$stmt) {
            $result['result'] = -1;
            $result['Number'] = 1;
            $result['msg'] = $conn->errorInfo();

            return $result;
        }

        $websites = [
            'Company_websites_id' => [],
            'subject' => [],
            'url' => [],
        ];

        while ($row = $stmt->fetch()) {
            array_push($websites['Company_websites_id'], $row['Company_websites_id']);
            array_push($websites['subject'], $row['website_subject']);
            array_push($websites['url'], $row['website_url']);
        }

        $result['export']['list']['company_website'] = $websites;

        return $result;
    }

    public static function delete($id)
    {
        $conn = dbConn::getConnection();

        $sql = "
                DELETE FROM company
                    WHERE Company_id = '".$id."'
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
                select phone_number FROM company_phones 
                    where Company_id = '".$input['']."'
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
