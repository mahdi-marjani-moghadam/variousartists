<?php

/**
 * Created by PhpStorm.
 * User: marjani
 * Date: 2/27/2016
 * Time: 1:57 PM
 */
namespace Component\aboutus\admin\model;
class adminAboutusModelDb
{

    static function insert($fields)
    {
        global $lang;
        $conn = dbConn::getConnection();
        $sql = "
                    INSERT INTO aboutus(
                    `head1`,
                    `head2`,
                    `head3`,
                    `text1`,
                    `text2`,
                    `text3`,
                    `graph1`,
                    `graph2`,
                    `graph3`,
                    `meta_keyword`,
                    `meta_description`,
                    `lang`
                    )
                    VALUES(
                    '" . $fields['head1'] . "',
                    '" . $fields['head2']  . "',
                    '" . $fields['head3']  . "',
                    '" . $fields['text1']  . "',
                    '" . $fields['text2']  . "',
                    '" . $fields['text3']  . "',
                    '" . $fields['graph1']  . "',
                    '" . $fields['graph2']  . "',
                    '" . $fields['graph3']  . "',
                    '" . $fields['meta_keyword']  . "',
                    '" . $fields['meta_description']  . "',
                    '$lang'
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
        //global $lang;

        $conn = dbConn::getConnection();
         $sql = "
                UPDATE aboutus
                  SET
                    `head1`  =   '" . $fields['head1'] . "',
                    `head2`  =   '" . $fields['head2'] . "',
                    `head3`  =   '" . $fields['head3'] . "',
                    `text1`  =   '" . $fields['text1'] . "',
                    `text2`  =   '" . $fields['text2'] . "',
                    `text3`  =   '" . $fields['text3'] . "',
                    `meta_keyword` =   '" . $fields['meta_keyword'] . "',
                    `meta_description` =   '" . $fields['meta_description'] . "'
                  WHERE 
                    lang = '{$fields['language']}'
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

    public function getAboutus($fields=array())
    {
        global $lang;
        $conn = dbConn::getConnection();

        include_once(ROOT_DIR."/model/db.inc.class.php");

        $condition= DataBase::filterBuilder($fields);

        $sql = "SELECT SQL_CALC_FOUND_ROWS
                 *
    		     FROM 	aboutus ".$condition['list']['WHERE'].$condition['list']['filter'].$condition['list']['order'].$condition['list']['limit'] ;

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
            $temp[$row['lang']] = $row;
        }

        //$row = $stmt->fetch();

        $result['result'] = 1;
        $result['export']['list'] = $temp;

        return $result;

    }




}