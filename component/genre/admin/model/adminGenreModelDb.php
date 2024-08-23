<?php

namespace Component\genre\admin\model;

use Common\dbConn;
use Model\DataBase;
use PDO;

class adminGenreModelDb
{

    static function insert($fields)
    {

        $conn = dbConn::getConnection();
        $sql = "
                    INSERT INTO genre(
                    `parent_id`,
                    `title_fa`,
                    `title_en`,
                    `alt_fa`,
                    `alt_en`,
                    `url`,
                    `meta_keyword`,
                    `meta_description`,
                    `img_name`,
                    `status`,
                    `sort`
                    )
                    VALUES(
                    '" . $fields['parent_id'] . "',
                    '" . $fields['title_fa']  . "',
                    '" . $fields['title_en']  . "',
                    '" . $fields['alt_fa']  . "',
                    '" . $fields['alt_en']  . "',
                    '" . $fields['url']  . "',
                    '" . $fields['meta_keyword']  . "',
                    '" . $fields['meta_description']  . "',
                    '" . $fields['img_name']  . "',
                    '1',
                    '" . $fields['sort']  . "'
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

    static function update($fields)
    {

        $conn = dbConn::getConnection();
        $sql = "
                UPDATE genre
                  SET
                    `parent_id`             =   '" . $fields['parent_id'] . "',
                    `title_fa`  =   '" . $fields['title_fa'] . "',
                    `title_en`  =   '" . $fields['title_en'] . "',
                    `alt_fa`       =   '" . $fields['alt_fa'] . "',
                    `alt_en`       =   '" . $fields['alt_en'] . "',
                    `url`      =   '" . $fields['url'] . "',
                    `meta_keyword`  =   '" . $fields['meta_keyword'] . "',
                    `meta_description`             =   '" . $fields['meta_description'] . "',
                    `img_name`  =   '" . $fields['img_name'] . "',
                    `status`  =   '" . $fields['status'] . "',
                    `sort`  =   '" . $fields['sort'] . "'
                    WHERE Genre_id = '" . $fields['Genre_id'] . "'
                    ";
        //die($sql);

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

    static function getGenreById($id)
    {
        //global $lang;
        $conn = dbConn::getConnection();
        $sql = "SELECT
                    * 
                FROM
                    genre
                WHERE
                    Genre_id= '$id'";

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

    public function getNews($fields = '')
    {

        $conn = dbConn::getConnection();

        // include_once(ROOT_DIR."/model/db.inc.class.php");

        $condition = DataBase::filterBuilder($fields);

        $sql = "SELECT
                 *
    		     FROM 	news " . $condition['list']['WHERE'] . $condition['list']['filter'] . $condition['list']['order'] . $condition['list']['limit'];

        $stmt = $conn->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();

        if (!$stmt) {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = $conn->errorInfo();
            return $result;
        }

        $sql = " SELECT FOUND_ROWS() as recCount ";

        $stmTp = $conn->prepare($sql);
        $stmTp->setFetchMode(PDO::FETCH_ASSOC);
        $stmTp->execute();
        $rowP = $stmTp->fetch();

        $result['export']['recordsCount'] = $rowP['recCount'];

        while ($row = $stmt->fetch()) {
            $list[$row['News_id']] = $row;
        }
        $result['result'] = 1;
        $result['export']['list'] = $list;
        return $result;
    }

    function tree_set($where = '')
    {
        $conn = dbConn::getConnection();
        if ($where != '') {
            $where = " WHERE " . $where;
        }
        $sql = "
				SELECT
					`genre`.*
				FROM genre $where
					ORDER BY genre.Genre_id  ASC";

        $stmt = $conn->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();

        if (!$stmt) {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = $conn->errorInfo();
            return $result;
        }
        $genre = array();

        while ($row = $stmt->fetch()) {
            $list[$row['parent_id']][] = $row;
        }
        $result['result'] = 1;
        $result['export']['list'] = $list;

        return $result;
    }

    static public function getGenreByParentId($id)
    {
        //global $lang;

        $conn = dbConn::getConnection();
        $sql = "SELECT
                    *
                FROM
                    genre
                   WHERE parent_id = '$id' ";

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
        $result['export']['recordsCount'] = $stmt->rowCount();
        return $result;
    }

    static function delete($fields)
    {

        $conn = dbConn::getConnection();

        $sql = "
                DELETE FROM genre
                    WHERE Genre_id = '" . $fields['Genre_id'] . "'
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

    public static function getGenreByTitleArray(string $title = '')
    {
        $conn = dbConn::getConnection();

        $titles = explode(',', $title);
        $categories = "";
        foreach ($titles as $title) {
            $categories .= "'$title',";
        }
        $categories = substr($categories, 0, -1);

        $sql = "SELECT * FROM genre WHERE title IN (" . $categories . ")";
        $stmt = $conn->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();

        if (!$stmt) {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = $conn->errorInfo();

            return $result;
        }

        while ($row = $stmt->fetch()) {
            $list[] = $row;
        }

        $result['result'] = 1;
        $result['export']['list'] = $list;

        return $result;
    }
}
