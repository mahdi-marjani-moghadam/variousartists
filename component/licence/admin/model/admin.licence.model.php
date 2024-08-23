<?php
/**
 * Created by PhpStorm.
 * User: marjani
 * Date: 3/6/2015
 * Time: 10:35 AM.
 */
include_once ROOT_DIR.'/common/validators.php';
class adminLicenceModel
{
    private $fields;  // other record fields
    private $list;  // other record fields

    private $result;

    /**
     * adminRegisterModel constructor.
     */
    public function __construct()
    {
        $this->requiredFields = array(
            'licence_name' => '',
        );
    }

    /**
     * @param $field
     *
     * @return mixed
     *
     * @author malekloo
     * @date 3/6/2015
     *
     * @version 01.01.01
     */
    public function __get($field)
    {
        if ($field == 'result') {
            return $this->result;
        } elseif ($field == 'fields') {
            return $this->fields;
        } elseif ($field == 'list') {
            return $this->list;
        } else {
            return $this->fields[$field];
        }
    }

    /**
     * validator controller.
     *
     * @param $input
     *
     * @return mixed
     *
     * @author malekloo
     * @date 3/6/2015
     *
     * @version 01.01.01
     */
    public function setFields($input)
    {
        foreach ($input as $field => $val) {
            $funcName = '__set'.ucfirst($field);
            if (method_exists($this, $funcName)) {
                $result = $this->$funcName($val);

                if ($result['result'] == '1') {
                    if (!isset($result['val'])) {
                        $this->fields[$field] = $val;
                    } else {
                        $this->fields[$field] = $result['val'];
                    }
                } else {
                    return $result;
                }
            }
        }
        $result['result'] = 1;

        return $result;
    }

    /**
     * check Title.
     *
     * @param $input
     *
     * @return mixed
     *
     * @author malekloo
     * @date 3/6/2015
     *
     * @version 01.01.01
     */
    private function __setTitle($input)
    {
        if (!Validator::required($input)) {
            $result['result'] = -1;
            $result['msg'] = 'لطفا عنوان را وارد نمایید.';
        } else {
            $result['result'] = 1;
        }

        return $result;
    }

    /**
     * check Description.
     *
     * @param $input
     *
     * @return mixed
     *
     * @author malekloo
     * @date 3/6/2015
     *
     * @version 01.01.01
     */
    private function __setDescription($input)
    {
        $result['result'] = 1;

        return $result;
    }


    /**
     * check Image.
     *
     * @param $input
     *
     * @return mixed
     *
     * @author malekloo
     * @date 3/6/2015
     *
     * @version 01.01.01
     */
    private function __setImage($input)
    {
        $result['result'] = 1;

        return $result;
    }

    /**
     * check Company id.
     *
     * @param $input
     *
     * @return mixed
     *
     * @author malekloo
     * @date 3/6/2015
     *
     * @version 01.01.01
     */
    private function __setCompany_id($input)
    {
        $result['result'] = 1;

        return $result;
    }


    /**
     * add licence us.
     *
     * @return mixed
     *
     * @author malekloo
     * @date 3/6/2015
     *
     * @version 01.01.01
     */
    public function addLicence()
    {
        foreach ($this->requiredFields as $field => $val) {
            $requiredList[$field] = $this->fields[$field];
        }
        $result = $this->setFields($requiredList);
        if ($result['result'] == -1) {
            return $result;
        }

        include_once dirname(__FILE__).'/admin.licence.model.db.php';

        $result = adminLicenceModelDb::insert($this->fields);

        if ($result['result'] != 1) {
            return $result;
        }

        $this->fields['Licence_id'] = $result['export']['insert_id'];

        return $result;
    }

    /**
     * edit licence by Licence_id.
     *
     * @return mixed
     *
     * @author malekloo
     * @date 3/06/2015
     *
     * @version 01.01.01
     */
    public function edit()
    {
        foreach ($this->requiredFields as $field => $val) {
            $requiredList[$field] = $this->fields[$field];
        }
        $result = $this->setFields($requiredList);
        if ($result['result'] == -1) {
            return $result;
        }

        include_once dirname(__FILE__).'/admin.licence.model.db.php';
        $result = adminLicenceModelDb::update($this->fields);

        return $result;
    }

    /**
     * get all licence.
     *
     * @param $fields
     *
     * @return mixed
     *
     * @author malekloo
     * @date 2/24/2015
     *
     * @version 01.01.01
     */
    public function getLicence($fields)
    {
        include_once dirname(__FILE__).'/admin.licence.model.db.php';

        $result = adminLicenceModelDb::getLicence($fields);

        if ($result['result'] != 1) {
            return $result;
        }
        $this->list = $result['export']['list'];
        $this->recordsCount = $result['export']['recordsCount'];

        return $result;
    }

    /**
     * get getLicenceById.
     *
     * @param $id
     *
     * @return mixed
     */
    public function getLicenceById($id)
    {
        include_once dirname(__FILE__).'/admin.licence.model.db.php';

        $result = adminLicenceModelDb::getLicenceById($id);

        if ($result['result'] != 1) {
            return $result;
        }

        /*$resultSet=$this->setFields($result['list']);
        if($resultSet!=1)
        {
            return $resultSet;
        }
        $result['result']=1;
        $result['list']= $this->fields;
        return $result;
        */
        //or

        $this->fields = $result['export']['list'];

        return $result;
    }

    /**
     * get Licence By Company Id.
     *
     * @param $id
     *
     * @return mixed
     */
    public function getLicenceByCompanyId($id)
    {
        include_once dirname(__FILE__).'/admin.licence.model.db.php';

        $result = adminLicenceModelDb::getLicenceByCompanyId($id);

        if ($result['result'] != 1) {
            return $result;
        }

        /*$resultSet=$this->setFields($result['list']);
        if($resultSet!=1)
        {
            return $resultSet;
        }
        $result['result']=1;
        $result['list']= $this->fields;
        return $result;
        */
        //or

        $this->list = $result['list'];
        $this->list = $result['export']['list'];
        $this->recordsCount = $result['export']['recordsCount'];

        return $result;
    }

    /**
     * delete company by company_id.
     *
     * @return mixed
     *
     * @author mahmoud malekloo <mahmoud.malekloo@gmail.com>
     * @date 2/24/2015
     *
     * @version 01.01.01
     */
    public function delete()
    {
        include_once dirname(__FILE__).'/admin.licence.model.db.php';
        $result = adminLicenceModelDb::delete($this->fields['Company_licences_id']);

        return $result;
    }
}
