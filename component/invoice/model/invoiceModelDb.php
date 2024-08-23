<?php
namespace Component\invoice\model;

use Common\dbConn;
use Model\DataBase;
use PDO;

/**
 * Created by PhpStorm.
 * User: malek
 * Date: 2/20/2016
 * Time: 4:33 AM.
 */
class invoiceModelDb
{
    public static function getInvoiceById($id)
    {
        global $lang;
        $conn = dbConn::getConnection();
         $sql = "SELECT
                `artists_invoice`.*,artists_invoice.brif_description_$lang as brif_description,artists_invoice.description_$lang as description,
                `artists`.`artists_name_$lang` as artists_name,`artists_invoice`.`title_$lang` as title
                FROM
                `artists`
                RIGHT JOIN
                `artists_invoice`
                ON
                `artists_invoice`.`artists_id` = `artists`.`Artists_id`
                WHERE
                `artists_invoice`.`Artists_invoice_id` = '$id'";

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

        $result['result'] = 1;
        $result['list'] = $row;

        return $result;
    }

    public static function getInvoiceByCompanyId($id)
    {
        $conn = dbConn::getConnection();
        echo $sql = "SELECT
                *
                FROM
                    artists_invoice
                WHERE
                    artists_id ='$id' ";

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

        $result['export']['recordsCount'] = $stmt->rowCount();

        while ($row = $stmt->fetch()) {
            $list[$row['Company_invoice_id']] = $row;
        }

        $result['result'] = 1;
        $result['export']['list'] = $list;

        return $result;
    }
    public static function getInvoiceByArtistsId($id,$fields)
    {
        global $lang;
        $conn = dbConn::getConnection();

        // include_once(ROOT_DIR."/model/db.inc.class.php");
        $condition = DataBase::filterBuilder($fields);

           $sql = "SELECT  SQL_CALC_FOUND_ROWS
                *,title_$lang as title
                FROM
                    invoice
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
            $list[$row['Invoice_id']] = $row;
        }

        $result['result'] = 1;
        $result['export']['list'] = $list;
        return $result;
    }

    /**
     * @author vaziry
     */
    public static function getRelatedInvoices($id, $companyId = null)
    {
        $invoice = self::getInvoiceById($id);
        $keywords = explode(',', $invoice['list']['meta_keyword']);

        $conn = dbConn::getConnection();

        $sql = 'SELECT * FROM company_invoice WHERE';
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
            $sql .= ') AND Company_invoice_id != '.$id;
            if ($companyId) {
                $sql .= ' AND company_id = '.$companyId;
            }
        } else {
            $sql .= ' 0';
        }

        $sqlLow = $sql." AND (priority != '1' or priority is null) ";
        $sqlHigh = $sql." AND priority = '1' ";

        // $sql .= ') AND Company_id != '.$id;
        $stmt = $conn->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();

        //  if high priority companies are less than 10
        if ($stmt->rowCount() < RELATED_PRODUCT_COUNT) {
            // get limit of low priority companies
            $limit = RELATED_PRODUCT_COUNT - $stmt->rowCount();
            // ---

            // get high priority companies
            $stmt = $conn->prepare($sqlHigh);
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $stmt->execute();
            while ($row = $stmt->fetch()) {
                $list[$row['Company_invoice_id']] = $row;
            }
            // ---

            // get low priority companies random
            $stmt = $conn->prepare($sqlLow);
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $stmt->execute();
            while ($row = $stmt->fetch()) {
                $listTmp[$row['Company_invoice_id']] = $row;
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
                $list[$row['Company_invoice_id']] = $row;
            }
        }

        $result['result'] = 1;
        $result['export']['list'] = $list;

        return $result;
    }

    public static function getInvoiceByCategoryId($fields = '')
    {
        $conn = dbConn::getConnection();

        include_once ROOT_DIR.'/model/db.inc.class.php';

        $condition = DataBase::filterBuilder($fields);

        $sql = "SELECT SQL_CALC_FOUND_ROWS
                 *
    		     FROM 	company_invoice where category_id like '%,".$fields['where']['category_id'].",%'".$condition['list']['order'].$condition['list']['limit'];

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
            $list[$row['Invoice_id']] = $row;
        }
        $result['result'] = 1;
        $result['export']['list'] = $list;

        return $result;
    }
    public static function getInvoice($fields = '')
    {
        $conn = dbConn::getConnection();

        include_once ROOT_DIR.'/model/db.inc.class.php';

        $condition = DataBase::filterBuilder($fields);

        $sql = '
                select  SQL_CALC_FOUND_ROWS  *  from (  SELECT
                  `company_invoice`.*,
                  `company`.`company_name`
                FROM
                  `company_invoice`
                  LEFT JOIN `company` ON `company_invoice`.`company_id` =
                    `company`.`Company_id`) as t1 '.$fields['where'].$condition['list']['filter'].$condition['list']['order'].$condition['list']['limit'];

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
            $list[$row['Company_invoice_id']] = $row;
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

    public static function pushRateDB($rate,$rate_invoice,$invoice_id)
    {
        //global $lang;

        $conn = dbConn::getConnection();

        $sql = "update artists_invoice set rate='$rate',rate_count='$rate_invoice' where Artists_invoice_id = '$invoice_id'";

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
}
