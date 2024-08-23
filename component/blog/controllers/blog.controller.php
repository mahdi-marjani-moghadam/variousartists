<?php
include_once ROOT_DIR.'component/blog/model/blog.model.php';

class blogController extends blog {
    private $fileName;
    private $exportType;
    public function __construct()
    {
        $this->exportType = 'html';
    }
    public function template($list = array(), $msg='')
    {

        switch ($this->exportType) {
            case 'html':
                global $PAGE,$lang,$member_info;
                extract($list);
                include ROOT_DIR.'templates/'.CURRENT_SKIN.'/title.inc.php';
                include ROOT_DIR.'templates/'.CURRENT_SKIN."/$this->fileName";
                include ROOT_DIR.'templates/'.CURRENT_SKIN.'/tail.inc.php';
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

    function showAll(){
        $blog = $this->getAllBlog();

        $this->fileName = 'blog.showList.php';
        $this->template(compact('blog'));
    }
    function showDetail($id){
        global $messageStack;
        if(!is_numeric($id)){
            $messageStack->add_session('message','Error','error');
            redirectPage(RELA_DIR.'blog','Error');
        }
        $blog = $this->getBlog($id)['export']['list'][0];

        $this->fileName = 'blog.showDetail.php';
        $this->template(compact('blog'));
    }
}