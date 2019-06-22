<?

class blog extends looeic{

    function getAllBlog($page=''){
        global $PAGE;

        $offset = ($page!='') ? ($page-1) * PAGE_SIZE : (($PAGE!='')?$PAGE-1:0) * PAGE_SIZE ;




        $arr = blog::getAll()
            ->where('status','=',1)
            ->limit($offset ,PAGE_SIZE)
            ->orderBy('id','desc')
            ->getList();

        $obj = new blog();
        $query = 'select count(*) as `count` from blog where status = 1';
        $arr['export']['rows'] = $obj->getByFilter('',$query)['export']['list'][0]['count'];



        return $arr;
    }

    function getBlog($id){
        $arr = blog::getAll()
            ->where('id','=',$id)
            ->getList();
        return $arr;
    }

}