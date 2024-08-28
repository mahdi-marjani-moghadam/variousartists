<?php

namespace Component\search\model;

use Common\dbConn;
use Component\category\model\categoryModelDb;
use Component\city\admin\model\adminCityModelDb;
use Component\city\model\cityModelDb;
use Component\company\model\companyModelDb;
use Component\province\model\provinceModelDb;
use Model\DataBase;
use PDO;

class searchModelDb
{
    public function searchInDB($table, $dbField, $fields = '')
    {
        
        $conn = dbConn::getConnection();
        $condition = DataBase::filterBuilder($fields);
        $sqlPre = 'SELECT SQL_CALC_FOUND_ROWS * from ( ';
        $sqlEnd = ' ) t1 ';

        // append city
        $city = adminCityModelDb::getCityByNameArray($fields['city']);

        // append province
        $province = provinceModelDb::getProvinceByNameArray($fields['province']);
        if (count($province['export']['list'])) {
            $append_SQL_province = ' and (';
            foreach ($province['export']['list'] as $key => $value) {
                $provinceId = $value['province_id'];
                $append_SQL_province .= " `state_id` = '$provinceId' or ";
            }
            $append_SQL_province = substr($append_SQL_province, 0, -3);
            //$append_SQL_province .= ')';
        } else {

            $append_SQL_province = '';
        }


        if (count($city['export']['list'])) {
            if($append_SQL_province!='')
            {

                $append_SQL_province .= ' or ';
            }else
            {
                $append_SQL_province .= ' and (';

            }
            foreach ($city['export']['list'] as $key => $value) {
                $cityId = $value['City_id'];

                $append_SQL_province .= " `city_id` = '$cityId' or ";
            }
            $append_SQL_province = substr($append_SQL_province, 0, -3);
            $append_SQL_province .= ')';
        } else {

            if($append_SQL_province!='')
            {
                $append_SQL_province .= ' )';
            }else
            {
                $append_SQL_province .= ' ';
            }
        }
        // end append city

        // append category
        $category = categoryModelDb::getCategoryByIdString($fields['category']);
        $searchItem['category']=$category['export'];
        $searchItem['city']=$city['export'];
        $searchItem['province']=$province['export'];

        if (count($category['export']['list'])) {
            $append_SQL_category = ' AND (';
            foreach ($category['export']['list'] as $key => $value) {
                $categoryId = $value['Category_id'];
                $append_SQL_category .= " `category_id` LIKE '%,$categoryId,%' or";
            }
            $append_SQL_category = substr($append_SQL_category, 0, -2);
            $append_SQL_category .= ')';

        } else {
            $append_SQL_category = '';
        }
        // end append category

        $sql = $sqlPre . self::generateSearchSql($table, $fields, $dbField, $append_SQL_category);


        $sql .= $sqlEnd;

        //print_r_debug($sql);


        $stmt = $conn->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();

        if (!$stmt) {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = $conn->errorInfo();
            return $result;
        }

        //-------------------------------------------hamid
        $provinces = provinceModelDb::getProvinces();
        $result['export']['province'] = $provinces['export']['list'];

        //--------------------------------------------end hamid
        $cities = cityModelDb::getCities();
        $result['export']['city'] = $cities['export']['list'];

        while ($row = $stmt->fetch()) {
            $id = ucfirst($table) . '_id';
            //Province
            if (!isset($result['export']['searchProvince'][$row['state_id']])) {
                $result['export']['searchProvince'][$row['state_id']] = $result['export']['province'][$row['state_id']];
            }

            $result['export']['searchProvince'][$row['state_id']]['count'] =
                $result['export']['searchProvince'][$row['state_id']]['count'] + 1;

            //City
            if (!isset($result['export']['searchProvince'][$row['state_id']]['cities'][$row['city_id']])) {
                $result['export']['searchProvince'][$row['state_id']]['cities'][$row['city_id']] =
                    $result['export']['city'][$row['city_id']];
            }

            $result['export']['searchProvince'][$row['state_id']]['cities'][$row['city_id']]['count'] =
                $result['export']['searchProvince'][$row['state_id']]['cities'][$row['city_id']]['count'] + 1;

        }

        // end cities
        //******************************************************************************************


        $sql = $sqlPre . self::generateSearchSql($table, $fields, $dbField,'', $append_SQL_province);

        $sql .= $sqlEnd;

        $stmt = $conn->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();
        if (!$stmt) {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = $conn->errorInfo();
            return $result;
        }
        $rowP['recCount'] = $stmt->rowCount();

        // categories

        $catIds = [];

        $categories = categoryModelDb::getCategoryAll();
        $result['export']['category'] = $categories['export']['list'];

        while ($row = $stmt->fetch()) {

             //print_r_debug($row);

            $id = ucfirst($table) . '_id';
            //$listTmp[$row[$id]] = $row;
            //$catIdsArray = explode(',', $row['category_id']);
            $catIdsArray = array_filter(explode(',', $row['category_id']), 'strlen');
            foreach ($catIdsArray as $key1 => $value1) {

                $parent_id=$result['export']['category'][$value1]['parent_id'];

                if (!isset($result['export']['searchCategory'][$parent_id][$value1])) {
                    $result['export']['searchCategory'][$parent_id][$value1]=
                        $result['export']['category'][$value1];

                }

                $result['export']['searchCategory'][$parent_id][$value1]['count'] =
                    $result['export']['searchCategory'][$parent_id][$value1]['count'] + 1;
            }
        }
        //print_r_debug($result['export']['searchCategory']);
        //bedim be convertor ul li********************************************

        unset($result['export']['category'][0]);
        
        $sql = $sqlPre . self::generateSearchSql($table, $fields, $dbField,$append_SQL_category, $append_SQL_province, $append_SQL_city);
        $sql .= $sqlEnd;
        $sql .= $condition['list']['order'] . $condition['list']['limit'];

        //echo '<pre/>';

        $stmt = $conn->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();
        if (!$stmt) {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = $conn->errorInfo();

            return $result;
        }
        //print_r_debug($stmt);

        $sql = ' SELECT FOUND_ROWS() as recCount ';
        $stmTp = $conn->prepare($sql);
        $stmTp->setFetchMode(PDO::FETCH_ASSOC);
        $stmTp->execute();
        $rowP = $stmTp->fetch();


        if ($table == 'company') {
            while ($row = $stmt->fetch()) {
                $id = ucfirst($table) . '_id';
                $list[$row[$id]] = companyModelDb::getCompanyById($row[$id])['list'];
                $list[$row[$id]]['cityName']=$result['export']['city'][$list[$row[$id]]['city_id']]['name'];
            }
        } else {
            while ($row = $stmt->fetch()) {
                $id = ucfirst($table) . '_id';
                $list[$row[$id]] = $row;
            }
        }

        $result['export']['recordsCount'] = $rowP['recCount'];
        $result['result'] = 1;
        $result['export']['list'] = $list;
        $result['export']['searchItem'] = $searchItem;
        unset($sql);
        //print_r_debug($result['export'][searchProvince]);

        return $result;
    }


    private static function generateSearchSql($table, $fields, $dbField, $append_SQL_category = '', $append_SQL_province = '', $append_SQL_city = '')
    {
        $sql = '
                   SELECT CASE ';

        //$sql = '';
        $count = 1;
        foreach ($dbField as $k => $Field) {
            $sql .= "WHEN " . $Field . " = '" . $fields['q'] . "' THEN $count " . PHP_EOL;
            $count++;
            $sql .= "WHEN " . $Field . " LIKE '" . $fields['q'] . "' THEN $count " . PHP_EOL;
            $count++;
            $sql .= "WHEN " . $Field . " LIKE '" . $fields['q'] . "%' THEN $count " . PHP_EOL;
            $count++;
            $sql .= "WHEN " . $Field . " LIKE  '%" . $fields['q'] . "' THEN $count " . PHP_EOL;
            $count++;
            $sql .= "WHEN " . $Field . " LIKE  '%" . $fields['q'] . "%' THEN $count " . PHP_EOL;
            $count++;

        }

        $sql .= 'END As rnk,`' . $table . '`.*';

        $sql .= " FROM 	" . $table . " WHERE (";

        foreach ($dbField as $k => $dbField) {
            $sql .= "`" . $dbField . "` = '" . $fields['q'] . "' OR" . PHP_EOL;
            $sql .= "`" . $dbField . "` LIKE '" . $fields['q'] . "' OR" . PHP_EOL;
            $sql .= "`" . $dbField . "` LIKE '" . $fields['q'] . "%' OR" . PHP_EOL;
            $sql .= "`" . $dbField . "` LIKE '%" . $fields['q'] . "%' OR" . PHP_EOL;

        }

        $sql = substr($sql, 0, -4);

        $sql .= ") ";

        $sql .= " and status = 1 $append_SQL_province $append_SQL_city $append_SQL_category ";


        return $sql;
    }
}
