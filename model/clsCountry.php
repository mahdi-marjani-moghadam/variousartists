<?php

namespace Model;

use Component\country\model\country;

class clsCountry
{
    /**
     * filling country when call getAllCountryCode method
     * @var int
     */
    private $_country;

    /**
     * filling data base field name for get db records
     * @var array
     */
    private $_countryFieldName;

    /**
     * filling data base condition for get db record
     * @var string
     */
    private $_conditionDB;
    /**
     * filling iso of country
     * @var string
     */
    private $_multiIso;





    /**
     * set property by default value when called class
     * @var array
     * @since 9/9/2015
     * @version 1.1.1
     */
    public function __construct()
    {
        $this->_countryFieldName = [];
        $this->_multiIso = [];
        $this->_conditionDB = [];
    }

    /**
     * set variable to call method
     * @param $field
     * @param $value
     * @version 1.1.1
     */
    public function __set($field, $value)
    {
        switch ($field) {

            case "countryFieldName":
                $this->_set_countryFieldName($value);
                break;

            case "condition":
                $this->_set_condition($value);
                break;
            case "multiIso":
                $this->_set_multiIso($value);
                break;
        }
    }



    /**
     * Set the variable post by form fields
     *
     * @author mahdi marjani moghadam <marjani@dabacenter.ir>
     * @param $array
     * @return bool
     * @version 01.01.01
     * @since 9/9/2015
     */
    private function _set_countryFieldName($array)
    {

        if (count($array) > 0) {
            //if call all field
            $allField = array("id", "iso", "name", "nice_name", "iso3", "num_code", "phone_code", "max_length", "sample");
            if (count($array) == 8) {
                $this->_countryFieldName = $allField;
            } else {

                //
                foreach ($array as $key => $value) {
                    if (in_array($value, $allField) == 1) {
                        $this->_countryFieldName[] = handleData($value);
                    }
                }
            }
        } else {
            return false;
        }
    }

    /**
     * Set the variable post by form fields
     *
     * @author mahdi marjani moghadam <marjani@dabacenter.ir>
     * @param $array
     * @return bool
     * @version 01.01.01
     * @since 9/9/2015
     */
    private function _set_condition($array)
    {
        $allField = array("id", "iso", "name", "nice_name", "iso3", "num_code", "phone_code", "max_length", "sample");
        if (count($array) > 0) {
            //
            foreach ($array as $key => $value) {
                if (in_array($key, $allField) == 1) {
                    $this->_conditionDB[$key] = handleData($value);
                }
            }
        } else {
            return false;
        }
    }

    /**
     * Set mlti iso property
     *
     * @author mahdi marjani moghadam <marjani@dabacenter.ir>
     * @param $array
     * @return bool
     * @version 01.01.01
     * @since 9/9/2015
     */
    private function _set_multiIso($array)
    {

        if (count($array) > 0) {
            //
            foreach ($array as $key => $value) {
                $this->_multiIso[$key] = handleData($value);
            }
        } else {
            return false;
        }
    }


    public function __get($field)
    {
        if ($field == "country") {
            return $this->_country;
        }
    }
    /**
     * call  method if call wrong  method name redirect to index
     * @author mahdi marjani moghadam <marjani@dabacenter.ir>
     * @since 9/9/2015
     * @version 01.01.01
     * @param $methodName
     * @param $arguments
     */
    public function __call($methodName, $arguments)
    {

        $_Result = $this->_checkMethod($methodName);

        if ($_Result[0] == 1) {

            $_Result = $this->_set_Arguments($arguments);

            if ($_Result[0] == 1 || $_Result[0] == 0) {

                $methodName = '_' . $methodName;
                $_Result = $this->$methodName();
                return ($_Result);
            } elseif ($_Result[0] == -1) {

                redirectPage(RELA_DIR . 'index.php', $_Result['errMsg']);
            }
        } elseif ($_Result[0] == 0) {

            redirectPage(RELA_DIR . 'index.php', $_Result['errMsg']);
        }
    }

    /**
     * check exist method name
     * @author mahdi marjani moghadam <marjani@dabacenter.ir>
     * @since 9/9/2015
     * @version 01.01.01
     * @return mixed
     */
    private function _checkMethod()
    {
        $temp = func_get_args();
        if (method_exists($this, "_" . $temp[0])) {
            $_Result[0] = 1;
            $_Result['Msg'] = 'Model_001';
            return $_Result;
        } else {
            $_Result[0] = 0;
            $_Result['errMsg'] = 'Model_002' . $temp[0] . 'Model_003'; // For Test : The Method (".$temp[0].") that you call is wrong
            return $_Result;
        }
    }

    /**
     * Getting variable of private functions
     * @author mahdi marjani moghadam <marjani@dabacenter.ir>
     * @since 9/9/2015
     * @version 01.01.01
     * @return mixed
     */
    private function _set_Arguments()
    {

        $temp = func_get_args();
        if (!empty($temp[0])) {

            if (count($temp[0]) == 1) {
                if (!empty($temp[0][0])) {
                    $this->_Arguments = $temp[0][0];
                } else {
                    $_Result[0] = -1;
                    $_Result['errMsg'] = 'Model_004';
                    return $_Result;
                }
            } elseif (count($temp[0]) > 1) {
                for ($i = 0; $i < count($temp[0]); $i++) {
                    if (!empty($temp[0][$i])) {
                        $this->_Arguments[$i] = $temp[0][$i];
                    } else {
                        $this->_set_Arguments_toDefult($this->_Arguments);
                        $_Result[0] = -1;
                        $_Result['errMsg'] = 'Model_004';
                        return $_Result;
                    }
                }
            }

            $_Result[0] = 1;
            $_Result['Msg'] = 'Model_005';
            return $_Result;
        } else {
            $_Result[0] = 0;
            $_Result['Msg'] = 6;
            return $_Result;
        }
    }



    public function getAllCountryCode()
    {
        global $conn;

        //filling before call this method
        $fields = $this->_countryFieldName;
        $where = $this->_conditionDB;
        $multiIso = $this->_multiIso;


        // custom field name for select from database
        if (count($fields) > 0) {
            $fieldNameString = '';
            foreach ($fields as $key => $value) {
                $fieldNameString .= ',`' . $value . '`';
            }
            $fieldNameString = substr($fieldNameString, 1);
            unset($key);
            unset($value);
        } else {
            $fieldNameString = '*';
        }


        // custom condition for select from database
        if (is_array($where) && count($where) > 0) {
            $whereString = '';
            foreach ($where as $key => $value) {
                $whereString .= 'and ' . $key . "='" . $value . "'";
            }
            unset($key);
            unset($value);
        }


        // get country with select any iso name
        if (is_array($multiIso) && count($multiIso) > 0) {
            $multiIsoString = '';
            foreach ($multiIso as $key => $value) {
                $multiIsoString .= ",'" . $value . "'";
            }
            $multiIsoString = ' and iso in (' . substr($multiIsoString, 1) . ')';
            unset($key);
            unset($value);
        }


        // include_once ROOT_DIR.'component/country/model/country.model.php';
        $obj = new country;

        $obj = $obj::query("SELECT " . $fieldNameString . " from country where 1=1 " . $whereString . $multiIsoString)->getList();




        foreach ($obj['export']['list'] as $k => $v) {
            foreach ($v as $key => $value) {
                $country[$k][$key] = $value;
            }
        }
        $this->_country = $country;

        $_result[0] = 1;
        $_result['Msg'] = "_country fully";

        return $_result;
    }

    /**
     * unset condition
     * @author mahdi marjani moghadam <marjani@dabacenter.ir>
     * @since 9/9/2015
     * @version 01.01.01
     * @return bool
     */
    private function _unsetCondition()
    {
        unset($this->_conditionDB);
        return true;
    }
}
