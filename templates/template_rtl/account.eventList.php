



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

                                            <?php 
                                            $i=$this->recordsCount;
                                            $start = $i - (($list['pagination']['current'] - 1)*PAGE_SIZE);
                                            foreach($list['artistsInvoiceList'] as $k => $value):

                                                ?>
                                            <tr>
                                                <td><?php echo $start ;?></td>
                                                <td><a href="<?php echo RELA_DIR?>event/Detail/<?php echo $value['Event_id']?>/<?php echo $value['title']?>"><?php echo $value['title']?></a></td>

                                                <td><?php echo $value['date']?></td>
                                                <td>
                                                    <div class="style-msg   <?php echo ($value['status'] == 1)?'':'style-msg-light';?>" style="background-color: <?php echo ($value['status'] == 1)?'#EEE':'#444';?>">
                                                        <div class="sb-msg"><i class="<?php echo ($value['status'] == 1)?'icon-thumbs-up':'icon-remove';?>"></i>تایید <?php echo ($value['status'] == 1)?'شده':' نشده';?></div>
                                                    </div>
                                                    <a href="<?php echo RELA_DIR?>account/editEvent/<?php echo $value['Event_id']?>" class="button button-3d button-dirtygreen" >ویرایش</a>
                                                </td>
                                                <!--<td><a href=" "  class="button button-3d button-mini button-rounded button-aqua ">پرداخت فاکتور</a> </td>-->
                                            </tr>
                                            <?php 
                                                $start--;
                                            endforeach;?>
                                        </table>

                                        <?php 
                                        if(count($list['pagination']['list']))
                                        {
                                            ?>
                                            <ul class="pagination">
                                                <li><a href="#">&laquo;</a></li>
                                                <?php 
                                                foreach($list['pagination']['list'] as $key => $link)
                                                {
                                                    if($key === 'current'){ continue;}
                                                    ?>
                                                    <li class="<?php echo (($key+1 == $list['pagination']['current']) || (empty($list['pagination']['current']) && $key == 0 ))?'active':'';?>" ><a href="<?php echo RELA_DIR.$link;?>"><?php echo $key+1?></a></li>
                                                    <?php 
                                                }
                                                ?>

                                                <li><a href="#">&raquo;</a></li>
                                            </ul>


                                            <?php
                                        }
                                        ?>
                                    </div>
                                </div>