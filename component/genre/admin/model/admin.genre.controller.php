<?php



use Component\genre\admin\model\adminGenreModel;


class adminGenreController
{

    public $exportType;
    public $fileName;

    public function __construct()
    {
        $this->exportType = 'html';
    }

    /**
     * @param string $list
     * @param $msg
     * @return string
     */
    function template($list = array(), $msg = ''): void
    {
        // global $conn, $lang;


        switch ($this->exportType) {
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
        if (!is_numeric($_input)) {
            $msg = 'یافت نشد';
            $this->template($msg);
        }
        $news = new adminNewsModel();
        $result = $news->getNewsById($_input);

        if ($result['result'] != 1) {
            die();
        }

        $this->template($news->fields);
        die();
    }


    public function getGenre_option($parent_id = '0')
    {
        $model = new adminGenreModel();
        $result = $model->getGenreOption();
    }

    /**
     * @param $fields
     */
    public function showList($parent_id = '0')
    {
        $model = new adminGenreModel();



        $result = $model->getGenreOption();

        if ($result['result'] != '1') {
            $this->fileName = 'admin.genre.showList.php';
            $this->template('', $result['msg']);
            die();
        }

        $export['list'] = $model->list;
        $export['recordsCount'] = $model->recordsCount;
        $this->fileName = 'admin.genre.showList.php';

        $this->template($export);

        die();

        //     foreach ($result as $key => $val)
        //     {
        //         print_r($val['export'].'<br/>');
        //     }
        //     //echo "<br/>start<br/>" . $st, "<br/>close<br/>";
        //     print_r($result);


        //     $result=$model->getGenreTree();
        //     /*
        //      * //ul li sample
        //     $mainMenu=$model->getulli($model->list[$parent_id],1,$model->list);
        //     $mainMenu = "<ul>\n".$mainMenu ."</ul>";
        //     echo '<pre/>';
        //     print_r($mainMenu);*/

        //     $this->fileName='admin.news.showList.php';
        //     $this->template('',$result['msg']);
        //     die();

        //     $export['list']=$model->list;
        //     $export['recordsCount']=$news->recordsCount;
        //     $this->fileName='admin.news.showList.php';


        //     $fields = $result['export']['list'];
        //     $this->listCat = $fields;
        //     $mainMenu=$this->getulli($fields[0]);
        //     $mainMenu = "<ul>\n".$mainMenu ."</ul>";

        //     return $mainMenu;

        //     //////////////////////////
        //     if($result['result']!='1')
        //     {
        //         $this->fileName='admin.news.showList.php';
        //         $this->template('',$result['msg']);
        //         die();
        //     }
        //     $export['list']=$news->list;
        //     $export['recordsCount']=$news->recordsCount;
        //     $this->fileName='admin.news.showList.php';
        //     /////////////////////////



        //     //////
        //     if($result['result']!='1')
        //     {
        //         $this->fileName='admin.news.showList.php';
        //         $this->template('',$result['msg']);
        //         die();
        //     }
        //     $export['list']=$news->list;
        //     $export['recordsCount']=$news->recordsCount;
        //     $this->fileName='admin.news.showList.php';

        //     $this->template($export);
        //     die();
        //   //////



        //     if($result['result']!='1')
        //     {
        //         die();
        //     }
        //     $export['list']=$news->list;
        //     $export['recordsCount']=$news->recordsCount;
        //     $this->fileName='admin.news.showList.php';

        //     $this->template($export);
        //     die();
    }

   
    public function showGenreAddForm($fields=[], $msg='')
    {


        $genre = new adminGenreModel();

        $resultGenre = $genre->getGenreOption('|-- ', 0, '1');
        if ($resultGenre['result'] == 1) {
            $fields['genre'] = $genre->list;
        }


        $this->fileName = 'admin.genre.addForm.php';
        $this->template($fields, $msg);
        die();
    }

    /**
     * @param $fields
     * @return mixed
     */
    public function addGenre($fields)
    {
        $genre = new adminGenreModel();

        $fields['status'] = 1;
        $result = $genre->setFields($fields);
        $valid = $genre->validator();

        $genre->save();


        $msg = 'عملیات با موفقیت انجام شد';
        redirectPage(RELA_DIR . "zamin/index.php?component=genre", $msg);
        die();
    }

    /**
     * @param $fields
     * @param $msg
     */
    public function showGenreEditForm($fields, $msg)
    {

        $genre = new adminGenreModel();

        $result    = $genre->getGenreById($fields['Genre_id']);

        if ($result['result'] != '1') {
            $msg = $result['msg'];
            redirectPage(RELA_DIR . "zamin/index.php?component=genre", $msg);
        }

        $export = $genre->fields;

        $where = "Genre_id<>'{$fields['Genre_id']}'";
        $resultGenre = $genre->getGenreOption('|-- ', 0, '1', $where);
        if ($resultGenre['result'] == 1) {
            $export['genre_list'] = $genre->list;
        }

        $this->fileName = 'admin.genre.editForm.php';
        $this->template($export, $msg);
        die();
    }

    /**
     * @param $fields
     */
    public function editGenre($fields)
    {
        $object = adminGenreModel::find($fields['Genre_id']);
        if (!is_object($object)) {
            $msg = $object['msg'];
            redirectPage(RELA_DIR . "zamin/index.php?component=genre", $msg);
        }
        $result = $object->setFields($fields);
        $result = $object->validator();

        $result = $object->save();


        if ($result['result'] != '1') {
            $this->showGenreEditForm($fields, $result['msg']);
        }
        $msg = 'عملیات با موفقیت انجام شد';
        redirectPage(RELA_DIR . "zamin/index.php?component=genre", $msg);
        die();
    }
    public function deleteGenre($id)
    {

        $object = adminGenreModel::find($id);

        if (!is_object($object)) {
            $msg = $object['msg'];
            redirectPage(RELA_DIR . "zamin/index.php?component=genre", $msg);
        }


        $result = adminGenreModel::getBy_parent_id($id)->get();

        if ($result['export']['recordsCount'] != '0') {
            $result['result'] = -1;
            $result['msg'] = 'ابتدا زیر دسته ها را پاک نمایید';
            redirectPage(RELA_DIR . "zamin/index.php?component=genre");
        }

        $result = $object->delete();


        $msg = 'حذف دسته بندی';
        redirectPage(RELA_DIR . "zamin/index.php?component=genre", $msg);
        die();
    }
}
