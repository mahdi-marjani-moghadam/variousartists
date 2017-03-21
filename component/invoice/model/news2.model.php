<?php
/**
 * Created by PhpStorm.
 * User: malek
 * Date: 2/20/2016
 * Time: 4:24 AM
 */

include_once(ROOT_DIR . "/common/validators.php");

class adminnews2Model extends looeic
{
    protected $rules = array(
        'title' => 'required|min_len,5|max_len,10',
        'brif_description' => 'required|max_len,100'
    );

    public function post()
    {
        return $this->hasMany('province1','news_id');
    }

}

class province1 extends looeic
{


}

/*

$rules = array(
	'username'    => 'required|alpha_numeric|max_len,100|min_len,6',
	'password'    => 'required|max_len,100|min_len,6',
	'email'       => 'required|valid_email',
	'gender'      => 'required|exact_len,1',
	'credit_card' => 'required|valid_cc',
	'comment' => 'basic_tags',

	'bio'		  => 'required'
);



                 'required' :

                 'valid_email':

                 'max_len':

                 'min_len':

                 'exact_len':

                 'alpha':

                 'alpha_numeric':

                 'alpha_dash':

                 'numeric':

                 'integer':

                 'boolean':

                 'float':

                 'valid_url':

                 'url_exists':

                 'valid_ip':

                 'valid_cc':

                 'valid_name':

                 'contains':

                 'contains_list':

                 'doesnt_contain_list':

                 'street_address':

                 'date':

                 'min_numeric':

                 'max_numeric':

                 'starts':

                 'extension':

                 'required_file':

                 'equalsfield':

                 'min_age':*/
