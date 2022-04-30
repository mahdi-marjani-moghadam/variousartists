


                            <div class="p-notification">

                                <div class="col-md-12 col-sm-12 col-xs-12 p-ch text-right" style="margin-top: 20px ;display: none">
                                    <div class="col_one_fifth ">
                                        <ul>
                                            <li><i class="icon-star3 font-size2x"></i> </li>
                                            <li>جمع امتیازات <?php echo $list['list']['rate']?><br>از <?php echo $list['list']['rate_count']?> نظر</li>
                                        </ul>
                                    </div>

                                    <div class="col_one_fifth ">
                                        <ul>
                                            <li><i class="icon-line-box font-size2x"></i> </li>
                                            <li>تعداد اثرات<br>
                                                <?php echo $list['artistsProduct']?></li>
                                        </ul>
                                    </div>
                                    <div class="col_one_fifth col_last">
                                        <a href="<?php echo RELA_DIR.'account/addProduct'?>">
                                        <ul>
                                            <li><i class="icon-line-marquee-plus font-size2x"></i> </li>
                                            <li class="font-size2x">افزودن اثر
                                                </li>
                                        </ul>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <?php if(isset($list['invoice'])): ?>
                            <div class="p-invoice row ">
                                <h4 class="text-center">آخرین صورتحصاب ها</h4>
                                <div class="col-md-12 col-xs-12 col-sm-12">
                                    <div class="col-md-12 col-sm-12 col-xs-12" style="overflow: scroll">
                                        <table   class="table table-responsive table-striped">
                                            <thead>
                                            <th>ردیف </th>
                                            <th>نوع فاکتور</th>
                                            <th>تاریخ فاکتور </th>
                                            <th>کل حساب(تومان)</th>
                                            <th>وضعیت فاکتور</th>
                                            <!--<th>پرداخت فاکتور</th>-->
                                            </thead>
                                            <?php 
                                            $i= 0;
                                            foreach($list['invoice'] as $kInvoice => $vInvoice):?>
                                                <?php $i++;?>
                                            <tr>
                                                <td><?php echo $vInvoice["id"];?></td>
                                                <td><?php echo $vInvoice["title_$lang"];?></td>
                                                <td><?php echo $vInvoice['date'];?></td>
                                                <td><?php echo $vInvoice['total_price'];?></td>

                                                <td>
                                                    <div class="style-msg   <?php echo ($vInvoice['status'] == 1)?'':'style-msg-light';?>" style="background-color: <?php echo ($vInvoice['status'] == 1)?'#EEE':'#444';?>">
                                                        <div class="sb-msg"><i class="<?php echo ($vInvoice['status'] == 1)?'icon-thumbs-up':'icon-remove';?>"></i>تایید <?php echo ($vInvoice['status'] == 1)?'شده':' نشده';?></div>
                                                    </div>

                                                </td>

                                                <!--<td><a href=" "  class="button button-3d button-mini button-rounded button-aqua ">پرداخت فاکتور</a> </td>-->
                                            </tr>
                                                <?php if($i >3){break;};?>
                                            <?php endforeach;?>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <?php endif;?>