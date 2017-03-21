<?php
/**
 * Created by PhpStorm.
 * User: marjani
 * Date: 3/6/2015
 * Time: 10:35 AM
 */

include_once(ROOT_DIR . "/common/validators.php");

class adminCertificationModel
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
            'title' => ''
        );
    }

    /**
     * @param $field
     * @return mixed
     * @author vaziry
     * @date 3/6/2015
     * @version 01.01.01
     */
    public function __get($field)
    {
        if($field == 'result')
        {
            return $this->result;
        } else if($field == 'fields')
        {
            return $this->fields;
        } else if($field == 'list')
        {
            return $this->list;
        } else
        {
            return $this->fields[$field];
        }

    }

    /**
     * validator controller
     *
     * @param $input
     * @return mixed
     * @author vaziry
     * @date 3/6/2015
     * @version 01.01.01
     */
    public function setFields($input)
    {
        foreach($input as $field => $val)
        {
            $funcName = '__set' . ucfirst($field);
            if(method_exists($this, $funcName))
            {
                $result = $this->$funcName($val);

                if($result['result'] == '1')
                {
                    if(!isset($result['val']))
                    {
                        $this->fields[$field] = $val;
                    } else
                    {
                        $this->fields[$field] = $result['val'];
                    }
                } else
                {
                    return $result;
                }
            }
        }
        $result['result'] = 1;

        return $result;
    }

    /**
     * check subject
     *
     * @param $input
     * @return mixed
     * @author vaziry
     * @date 3/6/2015
     * @version 01.01.01
     */
    private function __setTitle($input)
    {
        if(!Validator::required($input))
        {
            $result['result'] = -1;
            $result['msg'] = 'لطفا عنوان گواهی را وارد نمایید.';
        } else
        {
            $result['result'] = 1;
        }

        return $result;
    }

    /**
     * check subject
     *
     * @param $input
     * @return mixed
     * @author vaziry
     * @date 3/6/2015
     * @version 01.01.01
     */
    private function __setDescription($input)
    {
        $result['result'] = 1;

        return $result;
    }

    /**
     * check subject
     *
     * @param $input
     * @return mixed
     * @author vaziry
     * @date 3/6/2015
     * @version 01.01.01
     */
    private function __setImage($input)
    {
        $result['result'] = 1;

        return $result;
    }

    /**
     * add certification us
     *
     * @return mixed
     * @author vaziry
     * @date 3/6/2015
     * @version 01.01.01
     */
    public function addCertification()
    {

        foreach($this->requiredFields as $field => $val)
        {
            $requiredList[$field] = $this->fields[$field];
        }

        $result = $this->setFields($requiredList);
        if($result['result'] == -1)
        {
            return $result;
        }

        include_once(dirname(__FILE__) . "/admin.certification.model.db.php");

        $result = adminCertificationModelDb::insert($this->fields);
        if($result['result'] != 1)
        {
            return $result;
        }

        $this->fields['Certification_id'] = $result['export']['insert_id'];

        return $result;
    }


    /**
     * edit certification by Certification_id
     *
     * @return mixed
     * @author vaziry
     * @date 3/06/2015
     * @version 01.01.01
     */
    public function edit()
    {
        foreach($this->requiredFields as $field => $val)
        {
            $requiredList[$field] = $this->fields[$field];
        }
        $result = $this->setFields($requiredList);


        if($result['result'] == -1)
        {
            return $result;
        }

        include_once(dirname(__FILE__) . "/admin.certification.model.db.php");
        // companies
        $result = adminCertificationModelDb::update($this->fields);
        if($result['result'] != 1)
        {
            return $result;
        }


        return $result;
    }


    /**
     * get all certification
     *
     * @param $fields
     * @return mixed
     * @author vaziry
     * @date 2/24/2015
     * @version 01.01.01
     */
    public function getCertification($fields)
    {
        include_once(dirname(__FILE__) . "/admin.certification.model.db.php");

        $result = adminCertificationModelDb::getCertification($fields);

        if($result['result'] != 1)
        {
            return $result;
        }
        $this->list = $result['export']['list'];
        $this->recordsCount = $result['export']['recordsCount'];

        return $result;
    }

    /**
     * get getCertificationById
     *
     * @param $id
     * @return mixed
     */
    public function getCertificationById($id)
    {
        include_once(dirname(__FILE__) . "/admin.certification.model.db.php");

        $result = adminCertificationModelDb::getCertificationById($id);

        if($result['result'] != 1)
        {
            return $result;
        }

        $this->fields = $result['export']['list'];

        return $result;
    }
    /**
     * get getCertificationByIdArray
     *
     * @param $id
     * @return mixed
     */
    public function getCertificationByIdArray($id = array())
    {
        include_once(dirname(__FILE__) . "/admin.certification.model.db.php");

        $result = adminCertificationModelDb::getCertificationByIdArray($id);

        if($result['result'] != 1)
        {
            return $result;
        }

        $this->fields = $result['export']['list'];

        return $result;
    }
    /**
     * delete certification by certification_id
     *
     * @return mixed
     * @author mahmoud vaziry <mahmoud.vaziry@gmail.com>
     * @date 2/24/2015
     * @version 01.01.01
     */
    public function delete()
    {
        include_once(dirname(__FILE__) . "/admin.certification.model.db.php");
        $result = adminCertificationModelDb::delete($this->fields['Certification_id']);

        return $result;
    }

}
