<?php

/**
 * Created by PhpStorm.
 * User: malek
 * Date: 2/20/2016
 * Time: 4:33 AM.
 */
class productModelDb
{
    public static function getProductById($id)
    {
        //global $lang;
        $conn = dbConn::getConnection();
        $sql = "SELECT
                    *
                FROM
                    company_products
                WHERE
                    Company_products_id= '$id'";

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

    public static function getProductByCompanyId($id)
    {
        $conn = dbConn::getConnection();
        $sql = "SELECT
                *
                FROM
                    company_products
                WHERE
                    company_id ='$id' ";

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
            $list[$row['Company_products_id']] = $row;
        }

        $result['result'] = 1;
        $result['export']['list'] = $list;

        return $result;
    }

    public static function getProductByCategoryId($fields = '')
    {
        $conn = dbConn::getConnection();

        include_once ROOT_DIR.'/model/db.inc.class.php';

        $condition = DataBase::filterBuilder($fields);

        $sql = "SELECT SQL_CALC_FOUND_ROWS
                 *
    		     FROM 	company_products where category_id like '%,".$fields['where']['category_id'].",%'".$condition['list']['order'].$condition['list']['limit'];

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
            $list[$row['Product_id']] = $row;
        }
        $result['result'] = 1;
        $result['export']['list'] = $list;

        return $result;
    }
    public static function getProduct($fields = '')
    {
        $conn = dbConn::getConnection();

        include_once ROOT_DIR.'/model/db.inc.class.php';

        $condition = DataBase::filterBuilder($fields);

        $sql = '
                select  SQL_CALC_FOUND_ROWS  *  from (  SELECT
                  `company_products`.*,
                  `company`.`company_name`
                FROM
                  `company_products`
                  LEFT JOIN `company` ON `company_products`.`company_id` =
                    `company`.`Company_id`) as t1 '.$fields['where'].$condition['list']['WHERE'].$condition['list']['filter'].$condition['list']['order'].$condition['list']['limit'];

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
            $list[$row['Company_products_id']] = $row;
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
}
