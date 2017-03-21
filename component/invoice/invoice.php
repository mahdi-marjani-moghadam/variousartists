<?php


//global $company_info;
//print_r_debug($company_info);

include_once(dirname(__FILE__). "/model/invoice.model.php");





//$object=adminNews2Model::getBy_title('b')->first();








//****validate
//$object->title='';
//$object->brif_description='';

//$r=$object->validator();
echo '<pre/>';
/*print_r($r);
if($r['result']==-1)
{
    $result['msg']=$r[msg];
    $result['result']=-1;
    return $result;
}
//****validate

echo '<pre/>';
//print_r($object);
print_r_debug($r);*/

//$object->save();


/*$object=new adminNews2Model();

$fields['filter']['News_id']='p';
$fields['where']='news_id=2 or  ';
$fields['limit']['start']='0';
$fields['limit']['length']='10';
$fields['order']['News_id']='DESC';
$result=$object->getByFilter($fields);
print_r_debug($result);*/

//$object=model::find('news',1);
//$object=model::find('news',1);

//$object->title= 'My first blog post!!!';
//$object->save();
//print_r_debug($object);

//echo '1';



//$object=adminNews2Model::getBy_title('b')->first();
$ids = array('1', '2', '3');
$object=adminnews2Model::getBy_news2_id($ids)->post->get();
print_r_debug($object);


$object=adminNews2Model::find(100);
print_r_debug($object);
die();

echo '2';
$object=adminNews2Model::find(1);

$post=$object->post->first();

print_r_debug($post);




$object=adminNews2Model::getBy_title('b')->first();

$r=$object->validator();
echo '<pre/>';
print_r_debug($r);
$object->title='aa';

$object->save();

$object=adminNews2Model::find(1);


//$object =   looeic::model('news2')->find(1);

$object=looeic::model('news2')->getBy_News_id(1)->get();

//$object=adminNews2Model::find('1');
print_r_debug($object);



//marjani
$object=model::find('news2',2);

$object->title='4';
define ('formAdd_01','dorost vared kon');
$rules = array(
    'title' => 'required|min_len,5*'.formAdd_01.''
);

$r=$object->validator($rules)['msg'];


print_r_debug($r);
//marjani

//******* sample 1 **************************
/*$object=new adminNews2Model();
$object->date=" callMysql( now() ) ";
$object->brif_description='jkghugh';
$object->save();
print_r_debug($object->fields);*/


/*$object=adminNews2Model::find(60);
$object->date="callMysql(now())";
$object->brif_description='jkghugh';

$object->save();
print_r_debug($object->fields);*/


//*******end  sample 1 **********************




//******* sample 2 **************************
/*$_POST = array(
    'title' => 'yy',
    'brif_description' => 'yy'
);

$object=new adminNews2Model($_POST);

print_r_debug($object->validator()['msg']);

$object->save();
print_r_debug($object->fields);*/
//*******end  sample 2 **********************



//******* sample 3 **************************
$object=adminNews2Model::find('5');
$object->brif_description='hi';
$object->save();
print_r_debug($object->fields);

//*******end  sample 3 **********************




/*$object=adminNews2Model::table(news2);
$object->date="callMysql(now())";
$object->brif_description='jkghugh';*/


//******* sample 4 **************************

//$list=adminNews2Model::getBy_News_id(58)->getList();

$ids = array('1', '2', '3');
$list=adminNews2Model::getBy_News_id_or_title($ids,'b')->orderby('News_id','desc')->get();
print_r_debug($list);

$object->brif_description='hi';
$object->save();
print_r_debug($object);
//*******end  sample 4 ***********************


//******* sample 5 **************************
$object=adminNews2Model::getBy_News_id_or_title('113','jkghugh')
    ->orderBy('title')
    ->get();
$object->brif_description='hi';
$object->save();
print_r_debug($object);
//*******end  sample 5 ***********************



















/*
Class A{
    protected $fields_list;

    public function __construct($fields='')
    {
        echo '<pre/>';
        //if(method_exists($this, 'child_method')){
        echo $this->fields_list;


        $this->fields_list ='b';
        echo $this->fields_list;

    }
    function call_child_method(){
        echo '<pre/>';
        //if(method_exists($this, 'child_method')){
        print_r($this);

        $this->fields_list ='b';
            $this->child_method();
        print_r($this);

        //}
    }
}


Class B extends A{
    protected $fields_list ='a';

    protected function child_method(){
        echo $this->fields_list;
    }
}
$test = new B();
$test->call_child_method();
print_r_debug($test);
*/


/**
 * Created by PhpStorm.
 * User: malek
 * Date: 2/20/2016
 * Time: 4:21 AM
 */

include_once(dirname(__FILE__). "/model/news2.model.php");
global $admin_info,$PARAM;



$_POST = array(
'title' => 'hjhhhjkh',
 'brif_description' => 'jkghugh'
    );
$n=new adminNews2Model();

$n->title='ali';
$n->brif_description='jkghugh';
$n->save();

print_r_debug($n);


print_r_debug($n);



$n=new adminNews2Model();
$n->setFields($_POST);
print_r_debug($n);

$n->title='';
$n->brif_description='jkghugh';
$n->setadmin();
print_r_debug($n->validator());

$n->save();




print_r_debug($n->validator()['msg']);



print_r_debug($n);


$n->setadmin();

print_r_debug($n->validator());
//print_r_debug($n->getErr());
die();
$n->save();





//$class=adminNews2Model::getBy_title('rr');
//$result=adminNews2Model::getBy_News_id_or_title('113','jkghugh');


//$new=adminNews2Model::find(106);



//$result=adminNews2Model::getBy_News_id('106','a');
//print_r_debug($new);















die();
$fields['limit']['start']='0';
$fields['limit']['length']='2';
$fields['order']['News_id']='ASC';
$fields['filter']['News_id']='107';
$fields['where']=' News_id= 100 or News_id=106 ';
print_r_debug($fields);
$result=$n->getByFilter($fields);

print_r_debug($result);

if($result['result']==1)
{
    print_r_debug($result);
}
//$newsController = new news2Controller();

//$newsController->test();

?>
