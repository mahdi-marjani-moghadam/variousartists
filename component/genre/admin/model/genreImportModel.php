<?php

namespace Component\genre\admin\model;

use Common\dbConn;
use PDO;

class genreImportModel
{
    static function update($fields)
    {

        $conn = dbConn::getConnection();
        $sql = "
                UPDATE genre
                  SET
                    `parent_id`             =   '" . $fields['parent_id'] . "',
                    `title`  =   '" . $fields['title'] . "',
                    `alt`       =   '" . $fields['alt'] . "',
                    `url`      =   '" . $fields['url'] . "',
                    `meta_keyword`  =   '" . $fields['meta_keyword'] . "',
                    `meta_description`             =   '" . $fields['meta_description'] . "',
                    `img_name`  =   '" . $fields['img_name'] . "',
                    `status`  =   '" . $fields['status'] . "',
                    `sort`  =   '" . $fields['sort'] . "',
                    `new_id`  =   '" . $fields['new_id'] . "'
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

    public static function getGenreById($id)
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
            $result['no'] = 100;
            $result['msg'] = 'This Record was Not Found';

            return $result;
        }

        $row = $stmt->fetch();

        $result['result'] = 1;
        $result['list'] = $row;

        return $result;
    }

    public function tree_set($parent_id = 0)
    {
        $conn = dbConn::getConnection();
        $sql = '
				SELECT
					`genre`.*
				FROM genre
					ORDER BY genre.Genre_id  ASC';

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

    public static function getGenreByIdArray($id = array())
    {
        $conn = dbConn::getConnection();

        $categories = '';
        foreach ($id as $i) {
            $categories .= "'$i',";
        }
        $categories = substr($categories, 0, -1);
        $sql = 'SELECT * FROM genre WHERE Genre_id IN (' . $categories . ')';
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

    public static function getGenreByIdString($id = '')
    {
        $conn = dbConn::getConnection();
        if (substr($id, -1) == ',') {
            $id = substr($id, 0, -1);
        }
        if (substr($id, 0, 1) == ',') {
            $id = substr($id, 1);
        }
        $sql = 'SELECT * FROM genre WHERE Genre_id IN (' . $id . ')';
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

    public static function getGenreParents($id)
    {
        $conn = dbConn::getConnection();

        while (1) {
            $sql = "SELECT * FROM genre WHERE Genre_id = '$id'";
            $stmt = $conn->prepare($sql);
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $stmt->execute();
            if (!$stmt) {
                $result['result'] = -1;
                $result['no'] = 1;
                $result['msg'] = $conn->errorInfo();

                return $result;
            }
            if ($stmt->rowCount()) {
                $row = $stmt->fetch();
                $list[$row['Genre_id']] = $row;
                $id = $row['parent_id'];
            } else {
                break;
            }
        }

        $result['result'] = 1;
        $result['export']['list'] = $list;

        return $result;
    }

    public static function getGenreChildes($id)
    {
        static $list;

        $conn = dbConn::getConnection();

        $sql = "SELECT * FROM genre WHERE parent_id = '$id'";
        $stmt = $conn->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();
        if (!$stmt) {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = $conn->errorInfo();

            return $result;
        }
        // if (!$stmt->rowCount()) {
        //     return;
        // }
        while ($row = $stmt->fetch()) {
            self::getGenreChildes($row['Genre_id']);
            $list[$row['Genre_id']] = $row;
        }

        $result['result'] = 1;
        $result['export']['list'] = $list;

        return $result;
    }



    public static function getGenreList()
    {
        $conn = dbConn::getConnection();


        $sql = 'SELECT * FROM genre order by `group`';
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
