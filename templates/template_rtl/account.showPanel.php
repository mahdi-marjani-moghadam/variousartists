


                            <div class="p-notification">

                                <div class="col-md-12 col-sm-12 col-xs-12 p-ch text-right" style="margin-top: 20px ;display: none">
                                    <div class="col_one_fifth ">
                                        <ul>
                                            <li><i class="icon-star3 font-size2x"></i> </li>
                                            <li>جمع امتیازات <?=$list['list']['rate']?><br>از <?=$list['list']['rate_count']?> نظر</li>
                                        </ul>
                                    </div>

                                    <div class="col_one_fifth ">
                                        <ul>
                                            <li><i class="icon-line-box font-size2x"></i> </li>
                                            <li>تعداد اثرات<br>
                                                <?=$list['artistsProduct']?></li>
                                        </ul>
                                    </div>
                                    <div class="col_one_fifth col_last">
                                        <a href="<?=RELA_DIR.'account/addProduct'?>">
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
                            <? if(isset($list['invoice'])): ?>
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
                                            <?
                                            $i= 0;
                                            foreach($list['invoice'] as $kInvoice => $vInvoice):?>
                                                <? $i++;?>
                                            <tr>
                                                <td><?=$vInvoice["id"];?></td>
                                                <td><?=$vInvoice["title_$lang"];?></td>
                                                <td><?=$vInvoice['date'];?></td>
                                                <td><?=$vInvoice['total_price'];?></td>

                                                <td>
                                                    <div class="style-msg   <?=($vInvoice['status'] == 1)?'':'style-msg-light';?>" style="background-color: <?=($vInvoice['status'] == 1)?'#EEE':'#444';?>">
                                                        <div class="sb-msg"><i class="<?=($vInvoice['status'] == 1)?'icon-thumbs-up':'icon-remove';?>"></i>تایید <?=($vInvoice['status'] == 1)?'شده':' نشده';?></div>
                                                    </div>

                                                </td>

                                                <!--<td><a href=" "  class="button button-3d button-mini button-rounded button-aqua ">پرداخت فاکتور</a> </td>-->
                                            </tr>
                                                <? if($i >3){break;};?>
                                            <? endforeach;?>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <? endif;?>