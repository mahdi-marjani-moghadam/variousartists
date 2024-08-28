<?php 

use Common\looeic;

class blog extends looeic{

    function getAllBlog($page=''){
        global $PAGE,$lang;

        $offset = ($page!='') ? ($page-1) * PAGE_SIZE : (($PAGE!='')?$PAGE-1:0) * PAGE_SIZE ;




        $arr = blog::getAll()
            ->select('blog.*,artists_name_'.$lang.' as artists_name')
            ->leftJoin('artists','artists.Artists_id','=','blog.artists_id')
            ->where('blog.status','=',1)
            ->limit($offset ,PAGE_SIZE)
            ->orderBy('blog.id','desc')
            ->getList();

        $obj = new blog();
        $query = 'select count(*) as `count` from blog where status = 1';
        $arr['export']['rows'] = $obj->getByFilter([],$query)['export']['list'][0]['count'];



        return $arr;
    }

    function getBlog($id){
        global $lang;
        $arr = blog::getAll()
            ->select('blog.*,artists_name_'.$lang.' as artists_name')
            ->leftJoin('artists','artists.Artists_id','=','blog.artists_id')
            ->where('id','=',$id)
            ->getList();

        return $arr;
    }

}