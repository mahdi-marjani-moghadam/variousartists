<?php
/**

 * Created by PhpStorm.
 * User: malekloo
 * Date: 2/27/2016
 * Time: 11:02 AM.
 */
class adminCertificationModelDb
{
    public static function insert($fields)
    {
        $category_st = '';
        if (count($fields['category_id']) > 0) {
            $category_st = implode(',', $fields['category_id']);
            $category_st = ','.$category_st.',';
        }

        $category_rs = self::arrayToTag($fields['category_id']);
        $fields['category_list'] = $category_rs['export']['list'];

        $conn = dbConn::getConnection();
        $sql = "
                    INSERT INTO certification(
                    `title`,
                    `description`,
                    `image`
                    )
                    VALUES(
                    '".$fields['title']."',
                    '".$fields['description']."',
                    '".$fields['image']."'
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

    /**
     * edit certification by Certification_id.
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

        $sql = 'UPDATE certification SET ';
        foreach ($fields as $fieldName => $val) {
            $sql = $sql.'`'.$fieldName."` = '".$val."',";
        }
        $sql = substr($sql, 0, -1);
        $sql = $sql."WHERE certification_id = '".$fields['Certification_id']."'";

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

    public function getCertification($fields = '')
    {
        $conn = dbConn::getConnection();

        include_once ROOT_DIR.'/model/db.inc.class.php';

        $condition = DataBase::filterBuilder($fields);

        $sql = 'SELECT SQL_CALC_FOUND_ROWS
                 *
    		     FROM 	certification '.$condition['list']['WHERE'].$condition['list']['filter'].$condition['list']['order'].$condition['list']['limit'];

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
            $list[$row['Certification_id']] = $row;
            $id = $row['Certification_id'];
        }

        $result['result'] = 1;
        $result['export']['list'] = $list;

        return $result;
    }

    public static function getCertificationById($id)
    {
        //global $lang;
        $conn = dbConn::getConnection();
        $sql = "SELECT
                    *
                FROM
                    certification
                WHERE
                    Certification_id= '$id'";

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
        $result['export']['list'] = $row;

        return $result;
    }

    public static function getCertificationByIdArray($id = array())
    {
        $conn = dbConn::getConnection();
        $id = substr($id, 1, -1);
        $sql = "SELECT
                    *
                FROM
                    certification
                WHERE
                    Certification_id
                IN
                    (".$id.")";

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
            $list[$row['Certification_id']] = $row;
        }

        $result['result'] = 1;
        $result['export']['list'] = $list;

        return $result;
    }


    public static function delete($id)
    {
        $conn = dbConn::getConnection();

        $sql = "
                DELETE FROM certification
                    WHERE Certification_id = '".$id."'
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
}
