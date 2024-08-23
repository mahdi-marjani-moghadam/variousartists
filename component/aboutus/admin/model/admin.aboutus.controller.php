<?php
/**
 * Created by PhpStorm.
 * User: marjani
 * Date: 2/28/2016
 * Time: 10:45 AM
 */

include_once(dirname(__FILE__)."/admin.aboutus.model.php");

/**
 * Class aboutusController
 */
class adminAboutusController
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
    function template($list=[],$msg)
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
     * show about us edit form
     *
     * @param $msg
     * @author marjani
     * @date 2/27/2016
     * @version 01.01.01
     */
    public function showAboutusEditForm($msg)
    {

        $aboutus=new adminAboutusModel();

        $result    = $aboutus->getAboutus();

        if($result['result']!='1')
        {
            $msg=$result['msg'];
            redirectPage(RELA_DIR . "zamin/index.php?component=aboutus", $msg);
        }
        $export=$aboutus->list;


        $this->fileName='admin.aboutus.editForm.php';
        $this->template($export,$msg);
        die();
    }

    /**
     * edit about us
     *
     * @param $fields
     * @author marjani
     * @date 2/27/2016
     * @version 01.01.01
     */
    public function editAboutus($fields)
    {
        $aboutus=new adminAboutusModel();


        $result    = $aboutus->getAboutus();
        if($result['result']!='1')
        {
            $msg=$result['msg'];
            redirectPage(RELA_DIR . "zamin/index.php?component=aboutus", $msg);
        }


        $result=$aboutus->setFields($fields);
        if($result['result']!=1)
        {
            $this->showAboutusEditForm($result['msg']);
        }
        if($aboutus->recordsCount > 0)
        {
            $result=$aboutus->edit();
        }
        else
        {
            $result=$aboutus->add();
        }



        if($result['result']!='1')
        {
            $this->showAboutusEditForm($result['msg']);
        }
        $msg='عملیات با موفقیت انجام شد';
        redirectPage(RELA_DIR . "zamin/index.php?component=aboutus", $msg);
        die();
    }


}
?>