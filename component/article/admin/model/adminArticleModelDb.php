<?php
namespace Component\article\admin\model;

use Common\dbConn;
use Model\DataBase;
use PDO;

class adminArticleModelDb
{

    static function insert($fields)
    {

        $conn = dbConn::getConnection();
        $sql = "
                    INSERT INTO article(
                    `title`,
                    `category_id`,
                    `brif_description`,
                    `description`,
                    `meta_keyword`,
                    `meta_description`,
                    `image`,
                    `date`
                    )
                    VALUES(
                    '" . $fields['title'] . "',
                    '" . $fields['category_id'] . "',
                    '" . $fields['brif_description']  . "',
                    '" . $fields['description']  . "',
                    '" . $fields['meta_keyword']  . "',
                    '" . $fields['meta_description']  . "',
                    '" . $fields['image']  . "',
                    NOW()
                    )";


        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        if (!$stmt)
        {
            $result['result'] = -1;
            $result['Number'] = 1;
            $result['msg'] = $conn->errorInfo();
            return $result;
        }
        $result['export']['insert_id']=$conn->lastInsertId();
        $result['result'] = 1;
        return $result;
    }

    static function update($fields)
    {

        $conn = dbConn::getConnection();

        $sql = "
                UPDATE article
                  SET
                    `title`             =   '" . $fields['title'] . "',
                    `category_id`       =   '" . $fields['category_id'] . "',
                    `brif_description`  =   '" . $fields['brif_description'] . "',
                    `description`       =   '" . $fields['description'] . "',
                    `meta_keyword`      =   '" . $fields['meta_keyword'] . "',
                    `meta_description`  =   '" . $fields['meta_description'] . "',
                    `image`             =   '" . $fields['image'] . "',
                    `date`              =   NOW()
                    WHERE Article_id = '" . $fields['Article_id'] . "'
                    ";

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        if (!$stmt)
        {
            $result['result'] = -1;
            $result['Number'] = 1;
            $result['msg'] = $conn->errorInfo();
            return $result;
        }
        $result['result'] = 1;
        return $result;
    }
    static function delete($fields)
    {

        $conn = dbConn::getConnection();

        $sql = "
                DELETE FROM article
                    WHERE Article_id = '" . $fields['Article_id'] . "'
                    ";

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        if (!$stmt)
        {
            $result['result'] = -1;
            $result['Number'] = 1;
            $result['msg'] = $conn->errorInfo();
            return $result;
        }
        $result['result'] = 1;
        return $result;
    }

    static function getArticleById($id)
    {
        //global $lang;
        $conn = dbConn::getConnection();
        $sql = "SELECT
                    *
                FROM
                    article
                WHERE
                    Article_id= '$id'";

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        if (!$stmt)
        {
            $result['result'] = -1;
            $result['Number'] = 1;
            $result['msg'] = $conn->errorInfo();
            return $result;
        }

        if (!$stmt->rowCount())
        {
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

    /**
     * @param string $fields
     * @return mixed
     * @author marjani
     * @date 2/28/2016
     * @version 01.01.02
     */
    public function getArticle($fields='')
    {

        $conn = dbConn::getConnection();

        // include_once(ROOT_DIR."/model/db.inc.class.php");

        $condition= DataBase::filterBuilder($fields);

        $sql = "SELECT SQL_CALC_FOUND_ROWS
                 article.* , category.title as category_name
    		     FROM 	article left JOIN category ON category.Category_id = article.category_id ".$condition['list']['WHERE'].$condition['list']['filter'].$condition['list']['order'].$condition['list']['limit'];

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

        $sql=" SELECT FOUND_ROWS() as recCount ";

        $stmTp = $conn->prepare($sql);
        $stmTp->setFetchMode(PDO::FETCH_ASSOC);
        $stmTp->execute();
        $rowP = $stmTp->fetch();

        $result['export']['recordsCount']= $rowP['recCount'];

        while ($row = $stmt->fetch())
        {
            $list[$row['Article_id']]= $row;
        }
        $result['result'] = 1;
        $result['export']['list'] = $list;
        return $result;

    }

    static public function getArticleEasy()
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

        if (!$stmt)
        {
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