<?php
namespace Component\genre\model;
use Common\dbConn;
use PDO;

/**
 * Created by PhpStorm.
 * User: malek
 * Date: 2/20/2016
 * Time: 4:33 AM.
 */
class genreModelDb
{
    public static function getGenreById($id)
    {
        global $lang;
        $conn = dbConn::getConnection();
        $sql = "SELECT
                    *,title_$lang as title
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
        global $lang;
        $conn = dbConn::getConnection();
        $sql = "
				SELECT
					`genre`.*,title_$lang as title
				FROM genre
					ORDER BY genre.priority  ASC";

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

    public static function getGenreAll()
    {
        global $lang;
        $conn = dbConn::getConnection();

        $sql = "SELECT *,title_$lang as title FROM genre ";
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
            $list[$row['Genre_id']] = $row;
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
        global $lang;
        $categories = substr($categories, 0, -1);
        $sql = "SELECT *,title_$lang as title FROM genre WHERE Genre_id IN ('.$categories.')";
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
            $list[$row['Genre_id']] = $row;
        }
        $result['result'] = 1;
        $result['export']['list'] = $list;

        return $result;
    }

    public static function getGenreByIdString($id = '')
    {
        global $lang;
        $conn = dbConn::getConnection();
        if (substr($id, -1) == ',') {
            $id = substr($id, 0, -1);
        }
        if (substr($id, 0, 1) == ',') {
            $id = substr($id, 1);
        }
        $sql = "SELECT *,title_$lang as title FROM genre WHERE Genre_id IN ('.$id.')";
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

        global $lang;
        while (1) {
            $sql = "SELECT *,title_$lang as title FROM genre WHERE Genre_id = '$id'";
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
        global $lang;
        $conn = dbConn::getConnection();

        $sql = "SELECT *,title_$lang as title FROM genre WHERE parent_id = '$id'";
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
}
