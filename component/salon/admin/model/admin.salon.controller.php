<?php
/**
 * Created by PhpStorm.
 * User: malek
 * Date: 2/20/2016
 * Time: 4:24 PM
 */

include_once(dirname(__FILE__)."/admin.salon.model.php");

/**
 * Class newsController
 */
class adminSalonController
{

    /**
     * Contains file type
     * @var
     */
    public $exportType;

    /**
     * Contains file name
     * @var
     */
    public $fileName;

    /**
     *
     */
    public function __construct()
    {
        $this->exportType='html';

    }

    /**
     * @param string $list
     * @param $msg
     * @return string
     */
    function template($list=array(),$msg)
    {
        // global $conn, $lang;


        switch($this->exportType)
        {
            case 'html':

                include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_start.php");
                include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_header.php");
                include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_rightMenu_admin.php");
                include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/$this->fileName");
                include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_footer.php");
                include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_end.php");
                break;

            case 'json':
                echo json_encode($list);
                break;
            case 'array':
                return $list;
                break;

            case 'serialize':
                 echo serialize($list);
                break;
            default:
                break;
        }

    }

    /**
     * @param $_input
     *
     */
    public function showMore($_input)
    {
        if(!is_numeric($_input))
        {
            $msg= 'یافت نشد';
            $this->template($msg);
        }
        $news=new adminNewsModel();
        $result=$news->getNewsById($_input);

        if($result['result']!=1)
        {
            die();
        }

        $this->template($news->fields);
        die();
    }


    public function getSalon_option($parent_id='0')
    {
        $model = new adminSalonModel();
        $result=$model->getSalonOption();

    }

        /**
     * @param $fields
     */
    public function showList($parent_id='0')
    {
        $model=new adminSalonModel();



        $result=$model->getSalonOption();

        if($result['result']!='1')
        {
            $this->fileName='admin.salon.showList.php';
            $this->template('',$result['msg']);
            die();
        }

        $export['list']=$model->list;
        $export['recordsCount']=$model->recordsCount;
        $this->fileName='admin.salon.showList.php';

        $this->template($export);

        die();

        foreach ($result as $key => $val)
        {
            print_r($val['export'].'<br/>');
        }
        //echo "<br/>start<br/>" . $st, "<br/>close<br/>";
        print_r($result);


        $result=$model->getSalonTree();
        /*
         * //ul li sample
        $mainMenu=$model->getulli($model->list[$parent_id],1,$model->list);
        $mainMenu = "<ul>\n".$mainMenu ."</ul>";
        echo '<pre/>';
        print_r($mainMenu);*/

        $this->fileName='admin.news.showList.php';
        $this->template('',$result['msg']);
        die();

        $export['list']=$model->list;
        $export['recordsCount']=$news->recordsCount;
        $this->fileName='admin.news.showList.php';


        $fields = $result['export']['list'];
        $this->listCat = $fields;
        $mainMenu=$this->getulli($fields[0]);
        $mainMenu = "<ul>\n".$mainMenu ."</ul>";

        return $mainMenu;

        //////////////////////////
        if($result['result']!='1')
        {
            $this->fileName='admin.news.showList.php';
            $this->template('',$result['msg']);
            die();
        }
        $export['list']=$news->list;
        $export['recordsCount']=$news->recordsCount;
        $this->fileName='admin.news.showList.php';
        /////////////////////////



        //////
        if($result['result']!='1')
        {
            $this->fileName='admin.news.showList.php';
            $this->template('',$result['msg']);
            die();
        }
        $export['list']=$news->list;
        $export['recordsCount']=$news->recordsCount;
        $this->fileName='admin.news.showList.php';

        $this->template($export);
        die();
      //////



        if($result['result']!='1')
        {
            die();
        }
        $export['list']=$news->list;
        $export['recordsCount']=$news->recordsCount;
        $this->fileName='admin.news.showList.php';

        $this->template($export);
        die();
    }

    /**
     * @param $fields
     * @param $msg
     */
    public function showSalonAddForm($fields,$msg)
    {


        $salon = new adminSalonModel();

        $resultSalon = $salon->getSalonOption('|-- ',0,'1');
        if($resultSalon['result'] == 1)
        {
            $fields['salon'] = $salon->list;
        }


        $this->fileName='admin.salon.addForm.php';
        $this->template($fields,$msg);
        die();
    }

    /**
     * @param $fields
     * @return mixed
     */
    public function addSalon($fields)
    {
        $salon=new adminSalonModel();

        $fields['status'] = 1;
        $result = $salon->setFields($fields);

        $valid = $salon->validator();

        $salon->save();


        $msg='عملیات با موفقیت انجام شد';
        redirectPage(RELA_DIR . "zamin/index.php?component=salon", $msg);
        die();
    }

    /**
     * @param $fields
     * @param $msg
     */
    public function showSalonEditForm($fields,$msg)
    {

        $salon=new adminSalonModel();

        $result    = $salon->getSalonById($fields['Salon_id']);

        if($result['result']!='1')
        {
            $msg=$result['msg'];
            redirectPage(RELA_DIR . "zamin/index.php?component=salon", $msg);
        }

        $export=$salon->fields;

        $where="Salon_id<>'{$fields['Salon_id']}'";
        $resultSalon = $salon->getSalonOption('|-- ',0,'1',$where);
        if($resultSalon['result'] == 1)
        {
            $export['salon_list'] = $salon->list;
        }

        $this->fileName='admin.salon.editForm.php';
        $this->template($export,$msg);
        die();
    }

    /**
     * @param $fields
     */
    public function editSalon($fields)
    {
        $object = adminSalonModel::find($fields['Salon_id']);
        if(!is_object($object))
        {
            $msg=$object['msg'];
            redirectPage(RELA_DIR . "zamin/index.php?component=salon", $msg);
        }
        $result=$object->setFields($fields);
        $result=$object->validator();

        $result = $object->save();


        if($result['result']!='1')
        {
            $this->showSalonEditForm($fields,$result['msg']);
        }
        $msg='عملیات با موفقیت انجام شد';
        redirectPage(RELA_DIR . "zamin/index.php?component=salon", $msg);
        die();
    }
    public function deleteSalon($id)
    {

        $object = adminSalonModel::find($id);

        if(!is_object($object))
        {
            $msg=$object['msg'];
            redirectPage(RELA_DIR . "zamin/index.php?component=salon", $msg);
        }


        $result=adminSalonModel::getBy_parent_id($id)->get();

        if($result['export']['recordsCount']!='0')
        {
            $result['result'] = -1;
            $result['msg']='ابتدا زیر دسته ها را پاک نمایید';
            redirectPage(RELA_DIR . "zamin/index.php?component=salon", $msg);
        }

        $result = $object->delete();


        $msg='حذف دسته بندی';
        redirectPage(RELA_DIR . "zamin/index.php?component=salon", $msg);
        die();
    }

}
?>