<?php

namespace Component\salon\admin\model;

use Common\dbConn;
use PDO;
use PDOException;

class salonImportModel
{
    static function update($fields)
    {

        $conn = dbConn::getConnection();
        $sql = "
                UPDATE salon
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
                    WHERE Salon_id = '" . $fields['Salon_id'] . "'
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

    public static function getSalonById($id)
    {
        //global $lang;
        $conn = dbConn::getConnection();
        $sql = "SELECT
                    *
                FROM
                    salon
                WHERE
                    Salon_id= '$id'";

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
					`salon`.*
				FROM salon
					ORDER BY salon.Salon_id  ASC';

        $stmt = $conn->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();

        if (!$stmt) {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = $conn->errorInfo();

            return $result;
        }
        $salon = array();

        while ($row = $stmt->fetch()) {
            $list[$row['parent_id']][] = $row;
        }
        $result['result'] = 1;
        $result['export']['list'] = $list;

        return $result;
    }

    public static function getSalonByIdArray($id = array())
    {
        $conn = dbConn::getConnection();

        $categories = '';
        foreach ($id as $i) {
            $categories .= "'$i',";
        }
        $categories = substr($categories, 0, -1);
        $sql = 'SELECT * FROM salon WHERE Salon_id IN (' . $categories . ')';
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

    public static function getSalonByIdString($id = '')
    {
        $conn = dbConn::getConnection();
        if (substr($id, -1) == ',') {
            $id = substr($id, 0, -1);
        }
        if (substr($id, 0, 1) == ',') {
            $id = substr($id, 1);
        }
        $sql = 'SELECT * FROM salon WHERE Salon_id IN (' . $id . ')';
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

    public static function getSalonParents($id)
    {
        $conn = dbConn::getConnection();

        while (1) {
            $sql = "SELECT * FROM salon WHERE Salon_id = '$id'";
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
                $list[$row['Salon_id']] = $row;
                $id = $row['parent_id'];
            } else {
                break;
            }
        }

        $result['result'] = 1;
        $result['export']['list'] = $list;

        return $result;
    }

    public static function getSalonChildes($id)
    {
        static $list;

        $conn = dbConn::getConnection();

        $sql = "SELECT * FROM salon WHERE parent_id = '$id'";
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
            self::getSalonChildes($row['Salon_id']);
            $list[$row['Salon_id']] = $row;
        }

        $result['result'] = 1;
        $result['export']['list'] = $list;

        return $result;
    }



    public static function getSalonList()
    {
        $conn = dbConn::getConnection();


        try{

            $sql = 'SELECT * FROM salon ';
            $stmt = $conn->prepare($sql);
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $stmt->execute();
        }catch(PDOException $e){
            dd($e);
        }

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
