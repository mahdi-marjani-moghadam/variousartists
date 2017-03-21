<?php
/**
 * Created by PhpStorm.
 * User: malek
 * Date: 2/20/2016
 * Time: 4:24 PM.
 */

include_once dirname(__FILE__).'/news2.model.php';

/**
 * Class newsController.
 */
class news2Controller
{

    public function test($_input)
    {

        echo '<pre/>start';
        $n = new adminNews2Model();
        $n->title='aa';
        print_r_debug($n);

        die();


        $n=news2::find(106);
        print_r_debug($n);

        $attributes = array('title' => 'My first blog post!!', 'brif_description' => '5');
        $n = news2::create($attributes);
        $n->title='a';
        $n->save();
        print_r_debug($n);




        //*********add**************// mass assignment
        /*$n = news2::create($attributes);
        print_r($n->fields);

        $n->title='my';
        $n->save();
        print_r($n->fields);
        die();*/

        /*$n = new news2($attributes);
        $n->save();
        print_r($n->fields);
        die();*/
        $n = new news2();
        
        $n->setFields($attributes);
        print_r($n->fields);
        $n->save();

        die();
        $n->title='my';

        $n->save();
        print_r($n->fields);
        die();

        //*********end add**************


        //*********edit**************

        $n=news2::find(59);
        $n->setAtrr($attributes);

        //$n->title='omid111';
        $n->save();
        print_r_debug($n->fields);

        //*********end edit**************

        die();

    }


}
