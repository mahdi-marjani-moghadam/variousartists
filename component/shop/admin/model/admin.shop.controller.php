<?php
class shopController{
    /**
     * Contains file type.
     *
     * @var
     */
    public $exportType;

    /**
     * Contains file name.
     *
     * @var
     */
    public $fileName;

    /**
     * registerController constructor.
     */
    public function __construct()
    {
        $this->exportType = 'html';
    }

    /**
     * call template.
     *
     * @param string $list
     * @param $msg
     *
     * @return string
     */
    public function template($list = array(), $msg='')
    {
        global $messageStack,$admin_info,$lang;

        switch ($this->exportType) {
            case 'html':

                extract($list);

                include ROOT_DIR.'templates/'.CURRENT_SKIN.'/template_start.php';
                include ROOT_DIR.'templates/'.CURRENT_SKIN.'/template_header.php';
                include ROOT_DIR.'templates/'.CURRENT_SKIN.'/template_rightMenu_admin.php';
                include ROOT_DIR.'templates/'.CURRENT_SKIN."/$this->fileName";
                include ROOT_DIR.'templates/'.CURRENT_SKIN.'/template_footer.php';
                include ROOT_DIR.'templates/'.CURRENT_SKIN.'/template_end.php';
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

    function showALL()
    {

        $this->fileName = 'admin.shop.list.php';
        $this->template(compact('a'));
    }
    function shopListAjax($fields)
    {
        include_once ROOT_DIR.'component/sales/admin/model/admin.sales.model.php';
        $sale = new adminSalesModel();

        include_once(ROOT_DIR . "model/datatable.converter.php");
        $i=0;
        $columns = array(
            array( 'db' => 'Sales_id', 'dt' =>$i++),
            array( 'db' => 'event_id', 'dt' =>$i++),
            array( 'db' => 'place_id',   'dt' => $i++),
            array( 'db' => 'part_id', 'dt' => $i++ ),
            array( 'db' => 'user_id', 'dt' => $i++ ),
            array( 'db' => 'sandali', 'dt' => $i++ ),
            array( 'db' => 'event_time', 'dt' => $i++ ),
            array( 'db' => 'event_date', 'dt' => $i++ ),
            array( 'db' => 'status', 'dt' => $i++ ),
            array( 'db' => 'price', 'dt' => $i++ ),
            array( 'db' => 'date', 'dt' => $i++ )
        );
        $convert=new convertDatatableIO();
        $convert->input=$fields;
        $convert->columns=$columns;
        $searchFields= $convert->convertInput();

        //$searchFields['where'] = 'where refresh_date < '."'$date'";

        $result = $sale->getByFilter($searchFields);
        $list['list']=$result['export']['list'];
        $list['paging']=$result['export']['recordsCount'];

        $other['1']=array(
            'formatter' =>function($list)
            {
                include_once ROOT_DIR."component/event/admin/model/admin.event.model.php";
                $city = adminEventModel::find($list['event_id']);

                global $lang;
                return $city->fields["event_name_$lang"];
            }
        );
        $other['2']=array(
            'formatter' =>function($list)
            {
                include_once ROOT_DIR."component/salon/admin/model/admin.salon.model.php";
                $city = adminSalonModel::find($list['place_id']);

                global $lang;
                return $city->fields["title_$lang"];
            }
        );
        $other['3']=array(
            'formatter' =>function($list)
            {
                include_once ROOT_DIR."component/salon/admin/model/admin.salon.model.php";
                $city = adminSalonModel::find($list['part_id']);

                global $lang;
                return $city->fields["title_$lang"];
            }
        );
        $other['4']=array(
            'formatter' =>function($list)
            {
                include_once ROOT_DIR."component/artists/admin/model/admin.artists.model.php";
                $city = adminArtistsModel::find($list['user_id']);

                global $lang;
                return $city->fields['username'].'<br>'.$city->fields["artists_name_$lang"];
            }
        );
        $other['7']=array(
            'formatter' =>function($list)
            {
                $st =  $list['event_date'] .'<br>'.($list['event_date']!='0000-00-00'?convertDate($list['event_date']):'');
                return $st;
            }
        );
        $other['8']=array(
            'formatter' =>function($list)
            {
                if($list['status']==1) {
                    $st ='پرداخت شده';
                }else {
                    $st ='درحال انتخاب';
                }
                return $st;
            }
        );
        $other['9']=array(
            'formatter' =>function($list)
            {
                $st =  $list['price'] .' ریال';
                return $st;
            }
        );
        $other['10']=array(
            'formatter' =>function($list)
            {
                $st =  $list['date'] .'<br>'.($list['date']!='0000-00-00'?convertDate($list['date']):'');
                return $st;
            }
        );




        /*$other['12']=array(
            'formatter' =>function($list)
            {
                $st = "<img height='50' src='".RELA_DIR.'statics/event/'.$list['logo']."'>";

                return $st;
            }
        );*/
        $internalVariable['showstatus']=$fields['status'];
        /*$other[$i-1]=array(
            formatter =>function($list,$internal)
            {

                $st='<a href="'. RELA_DIR.'zamin/?component=event&action=edit&id='.$list['Event_id'].'&showStatus='.$internal['showstatus']
                    .'">ویرایش</a> <br/>
                        <a href="'.RELA_DIR.'zamin/?component=event&action=gallery&id='.$list['Event_id'].'">تصاویر</a><br/>
                        <a href="'.RELA_DIR.'zamin/?component=event&action=delete&id='.$list['Event_id'].$list['event_name'].'">حذف</a>';
                return $st;
            }
        );*/

        $export= $convert->convertOutput($list,$columns,$other,$internalVariable);
        echo json_encode($export);
        die();
    }
}