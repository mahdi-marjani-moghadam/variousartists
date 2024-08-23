<?php

/**
 * Created by PhpStorm.
 * User: malek
 * Date: 2/20/2016
 * Time: 4:33 AM.
 */
class eventModelDb
{
    public static function getEventById($id)
    {
        global $lang;
        $conn = dbConn::getConnection();
        $sql = "SELECT
                    Event_id,category_id,salon_id,city_id,country_id,event_name_$lang as event_name,event_phone,sale_type,
                event_time,event_time2,event_time3,address_$lang as address,meta_keyword,meta_description,
                logo,brief_description_$lang as brief_description,description_$lang as description,`date`,`date2`,`date3`,priority,status,lat,`longe`,price,organizer
                FROM
                    event
                WHERE
                    Event_id= '$id' and status='1' ";

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

        //$row = self::getEventContactInfo($id, $row);

        $result['result'] = 1;
        $result['list'] = $row;

        return $result;
    }

    public static function getEventGalleryById($id)
    {
        $conn = dbConn::getConnection();
        $sql = "SELECT SQL_CALC_FOUND_ROWS
                *
                FROM
                    event_gallery
                WHERE
                    event_id in ($id)";

        $stmt = $conn->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();
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

        $sql = ' SELECT FOUND_ROWS() as recCount ';

        $stmTp = $conn->prepare($sql);
        $stmTp->setFetchMode(PDO::FETCH_ASSOC);
        $stmTp->execute();
        $rowP = $stmTp->fetch();

        $result['export']['recordsCount'] = $rowP['recCount'];

        while ($row = $stmt->fetch()) {
            // $row1 = self::getEventContactInfo($id,$row);
            $list[$row['Event_gallery_id']] = $row;
        }

        $result['result'] = 1;
        $result['export']['list'] = $list;

        return $result;
    }
    public static function getEventByCategoryId($id)
    {
        $conn = dbConn::getConnection();
        $sql = "SELECT SQL_CALC_FOUND_ROWS
                *
                FROM
                    article
                WHERE
                    category_id in ($id)";

        $stmt = $conn->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();
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

        $sql = ' SELECT FOUND_ROWS() as recCount ';

        $stmTp = $conn->prepare($sql);
        $stmTp->setFetchMode(PDO::FETCH_ASSOC);
        $stmTp->execute();
        $rowP = $stmTp->fetch();

        $result['export']['recordsCount'] = $rowP['recCount'];

        while ($row = $stmt->fetch()) {
            // $row1 = self::getEventContactInfo($id,$row);
            $list[$row['Article_id']] = $row;
        }

        $result['result'] = 1;
        $result['export']['list'] = $list;

        return $result;
    }

    public function getEvent($fields = '')
    {
        global $lang;
        $conn = dbConn::getConnection();

        include_once ROOT_DIR.'/model/db.inc.class.php';
        $condition = DataBase::filterBuilder($fields);

        $sql = "SELECT SQL_CALC_FOUND_ROWS 
 
                Event_id,category_id,category_id,city_id,event_name_$lang as event_name,event_phone,
                event_time,event_time2,event_time3,address_$lang as address,meta_keyword,meta_description,
                logo,brief_description_$lang as brief_description,description_$lang as description,`date`,`date2`,`date3`,priority,status
                
                FROM event WHERE  status='1'";
        /*if (isset($fields['condition']['city_id'])) {
            $sql .= ' AND city_id = '.$fields['condition']['city_id'];
        }*/
        if (isset($fields['condition']['category_id'])) {
            $sql .= ' AND (';
            $categories = explode(',', $fields['condition']['category_id']);
            foreach ($categories as $key => $value) {
                $sql .= "category_id like '%,".$value.",%' or ";
            }
            $sql = substr($sql, 0, -3);
            $sql .= ') ';
        }

        $sql .= $condition['list']['order'].$condition['list']['limit'];
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
        $rowP = $stmTp->fetch();

        $result['export']['recordsCount'] = $rowP['recCount'];

        while ($row = $stmt->fetch()) {
            $list[$row['Event_id']] = $row;
        }
        $result['result'] = 1;
        $result['export']['list'] = $list;

        return $result;
    }
    public function getLastEvent($fields = '')
    {
        global $lang;
        $conn = dbConn::getConnection();

        include_once ROOT_DIR.'/model/db.inc.class.php';
        $condition = DataBase::filterBuilder($fields);
        $appendSql = "WHERE  status='1' ";

        if ($condition['list']['WHERE'] != '') {
            $appendSql = $appendSql.' and ';
            $condition['list']['filter'] = '('.$condition['list']['filter'].')';
        }

         $sql = "SELECT SQL_CALC_FOUND_ROWS
                 *,event_name_$lang as event_name
    		     FROM 	event ".$appendSql;
        if (isset($fields['chose']['city_id'])) {
            $sql .= ' AND city_id = '.$fields['chose']['city_id'];
        }
        $sql .= $condition['list']['filter'].$condition['list']['order'].$condition['list']['limit'];
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
        $rowP = $stmTp->fetch();

        $result['export']['recordsCount'] = $rowP['recCount'];

        while ($row = $stmt->fetch()) {
            $list[$row['Event_id']] = $row;
        }
        $result['result'] = 1;
        $result['export']['list'] = $list;

        return $result;
    }
    /**
     * @author vaziry
     */
    public static function getRelatedCompanies($id)
    {
        $event = self::getEventById($id);
        $keywords = explode(',', $event['list']['meta_keyword']);

        $conn = dbConn::getConnection();

        $sql = 'SELECT * FROM event WHERE';
        $keyCount = 0;
        foreach ($keywords as $key => $value) {
            if ($value != '') {
                if ($keyCount == 0) {
                    $sql .= " (meta_keyword like '$value' or meta_keyword like '$value,%' or meta_keyword like '%,$value,%' or meta_keyword like '%,$value'";
                } else {
                    $sql .= " or meta_keyword like '$value' or meta_keyword like '$value,%' or meta_keyword like '%,$value,%' or meta_keyword like '%,$value'";
                }
                ++$keyCount;
            }
        }
        if ($keyCount > 0) {
            $sql .= ') AND Event_id != '.$id;
        } else {
            $sql .= ' 0';
        }

        $sqlLow = $sql." AND (priority != '1' or priority is null) ";
        $sqlHigh = $sql." AND priority = '1' ";

        $stmt = $conn->prepare($sqlHigh);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();

        //  if high priority companies are less than 10
        if ($stmt->rowCount() < RELATED_COMPANY_COUNT) {
            // get limit of low priority companies
            $limit = RELATED_COMPANY_COUNT - $stmt->rowCount();
            // ---

            // get high priority companies
            $stmt = $conn->prepare($sqlHigh);
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $stmt->execute();
            while ($row = $stmt->fetch()) {
                $list[$row['Event_id']] = $row;
            }
            // ---

            // get low priority companies random
            $stmt = $conn->prepare($sqlLow);
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $stmt->execute();
            while ($row = $stmt->fetch()) {
                $listTmp[$row['Event_id']] = $row;
            }
            if (count($listTmp) >= $limit) {
                $randList = array_rand($listTmp, $limit);
            } else {
                $randList = array_rand($listTmp, count($listTmp));
            }
            if (count($randList) > 1) {
                foreach ($randList as $key => $value) {
                    $list[$value] = $listTmp[$value];
                }
            } elseif (count($randList) == 1) {
                $list[$randList] = $listTmp[$randList];
            }
            // ---
        } else {
            $stmt = $conn->prepare($sqlHigh);
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $stmt->execute();
            while ($row = $stmt->fetch()) {
                $list[$row['Event_id']] = $row;
            }
        }

        $result['result'] = 1;
        $result['export']['list'] = $list;

        return $result;
    }

    public static function getArticleEasy()
    {
        //global $lang;

        $conn = dbConn::getConnection();
        $sql = "SELECT
                    *
                FROM
                    article
                   ORDER BY 'date' DESC ";

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        if (!$stmt) {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = $conn->errorInfo();

            return $result;
        }

        $list = $stmt->fetchAll();
        $result['result'] = 1;
        $result['export']['list'] = $list;

        return $result;
    }

    private static function getEventContactInfo($id, $row)
    {
        $conn = dbConn::getConnection();

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

        return $row;
    }
    public static function getEventByArtistsId($id,$fields)
    {
        global $lang;
        $conn = dbConn::getConnection();

        include_once(ROOT_DIR."/model/db.inc.class.php");
        $condition = DataBase::filterBuilder($fields);

        $sql = "SELECT  SQL_CALC_FOUND_ROWS
                *,event_name_$lang as title
                FROM
                    event
                WHERE
                    member_id ='$id'   ".$fields['where'].$condition['list']['filter'].$condition['list']['order'].$condition['list']['limit'] ;

        $stmt = $conn->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();
        if (!$stmt) {
            $result['result'] = -1;
            $result['Number'] = 1;
            $result['msg'] = $conn->errorInfo();

            return $result;
        }

        if (!$stmt->rowCount()) {
            $result['result'] = -1;
            $result['no'] = 100;
            $result['msg'] = 'This Record was Not Found';

            return $result;
        }

        $sql = ' SELECT FOUND_ROWS() as recCount ';

        $stmTp = $conn->prepare($sql);
        $stmTp->setFetchMode(PDO::FETCH_ASSOC);
        $stmTp->execute();
        $rowP = $stmTp->fetch();

        $result['export']['recordsCount'] = $rowP['recCount'];

        while ($row = $stmt->fetch()) {
            $list[$row['Event_id']] = $row;
        }

        $result['result'] = 1;
        $result['export']['list'] = $list;
        return $result;
    }
}
