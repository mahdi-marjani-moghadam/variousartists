<?php

/**
 * Created by PhpStorm.
 * User: malekloo
 * Date: 2/27/2016
 * Time: 11:02 AM
 */
class adminLicenceModelDb
{
    static function insert($fields)
    {
        $fields['status']='1';

        include_once ROOT_DIR.'component/company/admin/model/admin.company.model.db.php';

        $company = adminCompanyModelDb::getCompanyById($fields['company_id']);

        $conn = dbConn::getConnection();
        $sql = "
                    INSERT INTO company_licences(
                    `company_id`,
                    `title`,
                    `description`,
                    `image`
                    )
                    VALUES(
                    '" . $fields['company_id']  . "',
                    '" . $fields['title']  . "',
                    '" . $fields['description']  . "',
                    '" . $fields['image']  . "'
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


    /**
     * edit licence by Licence_id
     * @param $fields
     * @return mixed
     * @author malekloo
     * @date 3/16/2015
     * @version 01.01.01
     */
    static function update($fields)
    {
        $conn = dbConn::getConnection();

        $sql = "UPDATE company_licences SET ";
        foreach($fields as $fieldName =>$val)
        {
            //echo $fieldName.'='.$val;
            $sql=$sql."`".$fieldName."` = '".$val . "',";
        }

        $sql=substr($sql,0,-1);
        $sql=$sql." WHERE Company_licences_id = '" . $fields['Company_licences_id'] . "'";

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


    /**
     * Get licence by company_id
     * @param $fields
     * @return mixed
     * @author malekloo
     * @date 3/28/2016
     * @version 01.01.01
     */
    public function getLicence($fields='')
    {

        $conn = dbConn::getConnection();

        include_once(ROOT_DIR."/model/db.inc.class.php");

        $condition= DataBase::filterBuilder($fields);

        if($condition['list']['WHERE']!='')
        {
            $append_sql=' AND ';

        }


        $sql = "SELECT SQL_CALC_FOUND_ROWS
                 *
    		     FROM 	company_licences WHERE company_id='{$fields['choose']['company_id']}' ".$append_sql.$condition['list']['filter'].$condition['list']['order'].$condition['list']['limit'];


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
        $row_count = $stmTp->fetch();

        $result['export']['recordsCount']= $row_count['recCount'];

        while ($row = $stmt->fetch())
        {

            $list[$row['Company_licences_id']]= $row;
        }

        $result['result'] = 1;
        $result['export']['list'] = $list;

        return $result;

    }

    static function getLicenceById($id)
    {
        //global $lang;
        $conn = dbConn::getConnection();
        $sql = "SELECT
                    *
                FROM
                    company_licences
                WHERE
                    Company_licences_id= '$id'";

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
        $result['export']['list'] = $row;

        return $result;

    }

    static function getLicenceByCompanyId($id)
    {
        $conn = dbConn::getConnection();
        $sql = "SELECT
                *
                FROM
                    company_licences
                WHERE
                    company_id ='$id' ";

        $stmt = $conn->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();
        if (!$stmt)
        {
            $result['result'] = -1;
            $result['Number'] = 1;
            $result['msg'] = $conn->errorInfo();
            return $result;
        }


        $result['export']['recordsCount']= $stmt->rowCount();

        while ($row = $stmt->fetch())
        {
            $list[$row['Company_licences_id']]= $row;
        }

        $result['result'] = 1;
        $result['export']['list'] = $list;

        return $result;

    }

    static function delete($id)
    {

        $conn = dbConn::getConnection();

        $sql = "
                DELETE FROM company_licences
                    WHERE Company_licences_id = '" . $id . "'
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

    static function arrayToTag($input)
    {
        $export='';
        if(count($input)>0)
        {
            $export=implode(',',$input);
            $export=','.$export.',';
        }
        $result ['export']['list']=$export;
        $result['result']='1';
        return $result;
    }

    static function tagToArray($input)
    {
        $export=explode(',',$input);
        $export=array_filter($export,'strlen');
        $result ['export']['list']=$export;
        $result['result']='1';
        return $result;
    }


}
