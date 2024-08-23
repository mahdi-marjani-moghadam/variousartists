



                                <div class="col-md-12 col-xs-12 col-sm-12">
                                    <div class="col-md-12 col-sm-12 col-xs-12" style="overflow: scroll">
                                        <table   class="table table-responsive table-striped">
                                            <thead>
                                            <th>ردیف </th>
                                            <th>نام / توضیح </th>

                                            <th>تاریخ درج</th>
                                            <th>وضعیت فاکتور</th>
                                            <!--<th>پرداخت فاکتور</th>-->
                                            </thead>

                                            <?
                                            $i=$this->recordsCount;
                                            $start = $i - (($list['pagination']['current'] - 1)*PAGE_SIZE);
                                            foreach($list['artistsInvoiceList'] as $k => $value):

                                                ?>
                                            <tr>
                                                <td><?=$start ;?></td>
                                                <td><a href="<?=RELA_DIR?>event/Detail/<?=$value['Event_id']?>/<?=$value['title']?>"><?=$value['title']?></a></td>

                                                <td><?=$value['date']?></td>
                                                <td>
                                                    <div class="style-msg   <?=($value['status'] == 1)?'':'style-msg-light';?>" style="background-color: <?=($value['status'] == 1)?'#EEE':'#444';?>">
                                                        <div class="sb-msg"><i class="<?=($value['status'] == 1)?'icon-thumbs-up':'icon-remove';?>"></i>تایید <?=($value['status'] == 1)?'شده':' نشده';?></div>
                                                    </div>
                                                    <a href="<?=RELA_DIR?>account/editEvent/<?=$value['Event_id']?>" class="button button-3d button-dirtygreen" >ویرایش</a>
                                                </td>
                                                <!--<td><a href=" "  class="button button-3d button-mini button-rounded button-aqua ">پرداخت فاکتور</a> </td>-->
                                            </tr>
                                            <?
                                                $start--;
                                            endforeach;?>
                                        </table>

                                        <?
                                        if(count($list['pagination']['list']))
                                        {
                                            ?>
                                            <ul class="pagination">
                                                <li><a href="#">&laquo;</a></li>
                                                <?
                                                foreach($list['pagination']['list'] as $key => $link)
                                                {
                                                    if($key === 'current'){ continue;}
                                                    ?>
                                                    <li class="<?=(($key+1 == $list['pagination']['current']) || (empty($list['pagination']['current']) && $key == 0 ))?'active':'';?>" ><a href="<?=RELA_DIR.$link;?>"><?=$key+1?></a></li>
                                                    <?
                                                }
                                                ?>

                                                <li><a href="#">&raquo;</a></li>
                                            </ul>


                                            <?php
                                        }
                                        ?>
                                    </div>
                                </div>