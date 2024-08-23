<?php

/**
 * Created by PhpStorm.
 * User: malek
 * Date: 2/20/2016
 * Time: 4:24 AM
 */
include_once ROOT_DIR."common/validators.php";
class adminGenreModel extends looeic
{
    protected $TABLE_NAME = 'genre';
    protected $rules = array(
        'title_fa' => 'required',
        'title_en' => 'required',
        'parent_id' => 'required'
    );

    /**
     * @var
     */
    private $TableName;
    /**
     * @var
     */
    public $fields;  // other record fields
    /**
     * @var
     */
    private $list;  // other record fields
    /**
     * @var
     */
    private $recordsCount;  // other record fields
    /**
     * @var
     */
    public $level = 0;


    /**
     * @var
     */
    private $result;

    /**
     *
     */
    public function __construct()
    {
        $this->requiredFields = array(
            'title'=>  '',
            'parent_id'=>  ''
        );
    }

    /**
     * @param $field
     * @return mixed
     */
    public function __get($field)
    {
        if ($field == 'result') {
            return $this->result;
        } else if ($field == 'fields') {
            return $this->fields;
        } else if ($field == 'list') {
            return $this->list;
        } else if ($field == 'recordsCount') {
            return $this->recordsCount;
        } else {
            return $this->fields[$field];
        }

    }




    /**
     * @param $id
     * @return mixed
     */
    public function getGenreById($id)
    {

        if(!validator::required($id) and !validator::Numeric($id))
        {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = 'This Record was Not Found';
            return $result;
        }

        include_once(dirname(__FILE__) . "/admin.genre.model.db.php");

        $result = adminGenreModelDb::getGenreById($id);

        if ($result['result'] != 1)
        {
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

        $this->fields = $result['list'];
        return $result;
    }

    public function getGenreByParentId($id)
    {

        if(!validator::required($id) and !validator::Numeric($id))
        {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = 'This Record was Not Found';
            return $result;
        }

        include_once(dirname(__FILE__) . "/admin.genre.model.db.php");

        $result = adminGenreModelDb::getGenreByParentId($id);

        if ($result['result'] != 1)
        {
            return $result;
        }
        //$this->recordsCount = count($export);

        return $result;

    }


    /**
     * @param $_input
     * @return mixed
     */
    public function convert($_input,$temp,$space='-')
    {


        global $lang;
        static $mainMenu = array();
        //echo $this->level;

        foreach ($_input as $key => $val) {

            $mainMenu[$val['Genre_id']]=$val;
            $mainMenu[$val['Genre_id']]['export'] = $temp .$space.$val["title_$lang"];
            $mainMenu[$val['Genre_id']]['level'] = $this->level;

            $temp = $temp . '&nbsp;&nbsp;&nbsp;&nbsp;';

            $this->level++;



            if (isset($this->list[$val['Genre_id']])) {

                $this->convert($this->list[$val['Genre_id']], $temp,$space);
            }
            $this->level--;
            $len=strlen($space);
            $temp = substr($temp , 0 , -24);

        }


        return $mainMenu;

    }

    /**
     * @param $fields
     * @return mixed
     */


    function getulli($array,$root=0,$all)
    {

        static $mainMenu = '';
        static $mainList;
        if($root==1)
        {
            $mainList = $all;
        }

        foreach ($array as $key => $val) {

            $mainMenu .= "<ul>\n";

            if(is_array($mainList[$val['Genre_id']]))
            {
                $mainMenu .= "\t<li>\n".$val['title'];

                $this->getulli($mainList[$val['Genre_id']]);
                $mainMenu .= "</li>\n";
                //$list_open = false;

            }else
            {
                $mainMenu .= "\t<li>\n".$val['title'];
                $mainMenu .= "</li>\n";
            }
            $mainMenu .= "</ul>\n";

            $this->level--;
        }

        return $mainMenu;



        /*foreach($array as $item){
            if(is_array($item) && isset($item['name']))
            {
                echo "<ul>\n";

                if(is_array($item['children'])){
                    echo "<li>".$item['name'];
                    getulli($item);
                    echo "</li>\n";
                } else {
                    echo "<li>".$item['name']."</li>\n";
                }

                echo "</ul>\n\n";
            }
        }*/

    }

    public function getGenreTree($fields)
    {

        include_once(dirname(__FILE__) . "/admin.genre.model.db.php");
        $result = adminGenreModelDb::tree_set();
        $this->list=$result['export']['list'];
        $this->recordsCount=$result['export']['recordsCount'];

        return $result;

    }

    public function getGenreOption($space='|-- ',$parent_id=0,$selectRoot='0',$where='')
    {

        include_once(dirname(__FILE__) . "/admin.genre.model.db.php");

        $result = adminGenreModelDb::tree_set($where);

        if ($result['result'] != 1)
        {
            return $result;
        }
        $fields = $result['export']['list'];
        $this->list = $fields;

        $list = $this->convert($fields[$parent_id],'',$space);


        if($selectRoot=='1')
        {
            $export['0']['Genre_id']='0';
            $export['0']['title']='والد ندارد';
            $export['0']['dataTableCount']=0;
            $export['0']['export']='والد ندارد';
        }
        $count=1;
        foreach($list as $key =>$val)
        {
            if($key==0) continue;
            $export[$key]=$val;
            $export[$key]['dataTableCount']=$count;
            $count++;
        }

        $this->list = $export;
        $this->recordsCount = count($export);

        $result['result'] = 1;
        $result['export']['list'] = $export;
        $result['export']['recordsCount'] = $this->recordsCount;

        return $result;
    }

    public function getGenreByfor($fields)
    {
        include_once(dirname(__FILE__) . "/admin.genre.model.db.php");

        $result = adminGenreModelDb::tree_set();
        $fields = $result['export']['list'];
        $this->listCat = $fields;
        $result = $this->convert($fields['1']);

        $config['root']['list']['open'] = '<ul>';

        $config['1']['list']['open'] = '<ul>';

        $config['all']['list']['open'] = '<ul>';
        $config['all']['list']['close'] = '</ul>';

        $config['all']['node']['open'] = '<li>';
        $config['all']['node']['close'] = '</li>';

        $config['all']['node-noChild']['open'] = '<li>no';
        $config['all']['node-noChild']['close'] = '</li>';


        echo '<pre>';
        $st = '<ul>';
        //print_r($result);
        //$next = (next($result));

        $key_list = array_keys($result);
        $key_count = 0;
        foreach ($result as $key => $val) {
            $key_count++;
            $next_key = $key_list[$key_count];
            //echo '<br/>key=' . $key . '<br/>next=' . $next_key;
            //echo $val['title'];
            if ($next_key == '') {
                $next = -1;
            } else {
                $next = $result[$next_key];
            }

            //print_r($result[$next]['level']);
            if ($next['level'] > $val['level'] and $next != -1) {

                $open_list = 'true';

                if (isset($config[$val['level']]['node']['open'])) {
                    $st = $st . $config[$val['level']]['node']['open'] . PHP_EOL;
                } else {
                    $st = $st . $config['all']['node']['open'] . PHP_EOL;
                }

                $st = $st .$val['title'] . PHP_EOL;
                $st = $st . $config['all']['list']['open'] . PHP_EOL;

            } else if ($next['level'] < $val['level'] and $next != -1) {
                $open_list = 'false';

                $st = $st . $config['all']['node-noChild']['open'] . PHP_EOL;
                $st = $st . $val['title'] . PHP_EOL;

                for ($i = 1; $i <=  ($val['level']-$next['level']); $i++)
                {
                    $st = $st . $config['all']['node']['close'] . PHP_EOL;
                    $st = $st . $config['all']['list']['close'] . PHP_EOL;

                }
                $st = $st . $config['all']['node']['close'] . PHP_EOL;


            } else if ($val['level'] == $next['level'] and $next != -1) {
                $open_list = '';

                if (isset($config[$val['level']]['node-noChild']['open'])) {
                    $st = $st . $config[$val['level']]['node-noChild']['open'] . PHP_EOL;
                    $st = $st . $val['title'] . PHP_EOL;
                    $st = $st . $config['all']['node-noChild']['close'] . PHP_EOL;
                } else {
                    $st = $st . $config['all']['node-noChild']['open'] . PHP_EOL;
                    $st = $st .  $val['title'] . PHP_EOL;
                    $st = $st . $config['all']['node-noChild']['close'] . PHP_EOL;
                }
            } else if ($next == -1) {


                $open_list = '';

                if (isset($config[$val['level']]['node']['open'])) {
                    $st = $st . $config[$val['level']]['node-noChild']['open'] . PHP_EOL;
                    $st = $st . $val['title'] . PHP_EOL;
                    //$st = $st . $config['all']['node']['close'] . PHP_EOL;
                    //$st = $st . $config['all']['list']['close'] . PHP_EOL;

                } else {
                    $st = $st . $config['all']['node-noChild']['open'] . PHP_EOL;
                    $st = $st . $val['title'] . PHP_EOL;
                    //$st = $st . $config['all']['node']['close'] . PHP_EOL;
                    //$st = $st . $config['all']['list']['close'] . PHP_EOL;
                }
                for ($i = 1; $i <=  ($val['level']-$next['level']); $i++)
                {
                    $st = $st . $config['all']['node']['close'] . PHP_EOL;
                    $st = $st . $config['all']['list']['close'] . PHP_EOL;

                }
                $st = $st . $config['all']['node']['close'] . PHP_EOL;

            }


        }
        $st = $st . '</ul>';


        echo "<br/>start<br/>" . $st, "<br/>close<br/>";

        //**************

        //print_r($result);


        die();

        if ($result['result'] != 1) {
            return $result;
        }
        $this->list = $result['export']['list'];
        $this->recordsCount = $result['export']['recordsCount'];

        return $result;
    }

    /**
     * @return mixed
     */
    public function add()
    {

        foreach($this->requiredFields as $field =>$val)
        {
            $requiredList[$field]=$this->fields[$field];
        }
        $result=$this->setFields($requiredList);
        if($result['result']==-1)
        {
            return $result;
        }

        include_once(dirname(__FILE__) . "/admin.genre.model.db.php");
        $result = adminGenreModelDb::insert($this->fields);
        $this->fields['Genre_id'] = $result['export']['insert_id'];
        return $result;
    }

    /**
     * @return mixed
     */
    public function edit()
    {

        foreach($this->requiredFields as $field =>$val)
        {
            $requiredList[$field]=$this->fields[$field];
        }
        $result=$this->setFields($requiredList);
        if($result['result']==-1)
        {
            return $result;
        }

        include_once(dirname(__FILE__) . "/admin.genre.model.db.php");
        $result = adminGenreModelDb::update($this->fields);
        return $result;
    }

    public function deletes()
    {
        include_once(dirname(__FILE__) . "/admin.genre.model.db.php");
        $result=$this->getGenreByParentId($this->fields['Genre_id']);

        if($result['result']!='1')
        {
            return $result;
        }
        if($result['export']['recordsCount']>0)
        {
            $result['result'] = -1;
            $result['msg']='ابتدا زیر دسته ها را پاک نمایید';
            return $result;

        }
        $result=adminGenreModelDb::delete($this->fields);
        $result['msg'] ='عملیات با موفقیت انجام شد';

        return $result;
    }

}
