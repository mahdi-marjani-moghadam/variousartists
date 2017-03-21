<?php
/**
 * Created by PhpStorm.
 * User: malek
 * Date: 2/20/2016
 * Time: 4:24 AM
 */

include_once(ROOT_DIR . "/common/validators.php");

class adminNews2Model extends looeic
{

    //protected $fields=array('title'=>'','brif_description'=>'');
    protected $rules = array(
        'title' => 'required*ejbariii|min_len,5*kamtazr az 5 ta nmishe',
        'brif_description' => 'required|max_len,100'
    );


    public function setadmin()
    {
        $this->rules = array(
            'title' => 'required*ejbari|min_len,5*dorost vared kon'
        );
    }

    public function setmember()
    {
        $this->rules = array(
            'title' => 'required*ejbari|min_len,5*dorost vared kon',
            'brif_description' => 'required|max_len,100',
        );
    }

}

/* protected $fields =
    array(
                'News_id' => ''
            , 'title' => ''
            , 'brif_description' => ''
            , 'description' => ''
            , 'meta_keyword' => ''
            );*/
//$attributes = array('title' => 'My first blog post!!', 'brif_description' => '5');

/*function validate_name($input)
{
    echo 'a';

}*/