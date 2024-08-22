



                                <div class="col-md-12 col-xs-12 col-sm-12">
                                    <div class="col-md-12 col-sm-12 col-xs-12" style="overflow: scroll">
                                        <table   class="table table-responsive table-striped">
                                            <thead>
                                            <th>ردیف </th>
                                            <th>نام اثر </th>
                                            <th>تصویر
                                            </th>
                                            <th>تاریخ درج</th>
                                            <th>مختصر توضیحات</th>
                                            <th>امتیاز</th>
                                            <th>وضعیت فاکتور</th>
                                            <!--<th>پرداخت فاکتور</th>-->
                                            </thead>

                                            <?
                                            $i=$this->recordsCount;
                                            $start = $i - (($list['pagination']['current'] - 1)*PAGE_SIZE);
                                            foreach($list['artistsProductList'] as $k => $value):

                                                ?>
                                            <tr>
                                                <td><?=$start ;?></td>
                                                <td><a href="<?=RELA_DIR?>product/<?=$list['list']["artists_name_$lang"]?>/<?=$value['Artists_products_id']?>/<?=$value["title_$lang"]?>"><?=$value["title_$lang"]?></a></td>
                                                <td><img height="70" src="<?=(strlen($value['image']) ? RELA_DIR.'statics/files/'.$value["artists_id"].'/'.$value['image'] : '/templates/'.CURRENT_SKIN.'/assets/images/placeholder.png');?>" alt="Open Imagination">
                                                <br>
                                                    <? if($value['file_type'] == 'audio'):?>
                                                        <audio controls style="width: 200px">
                                                            <source src="/statics/files/<?=$value['artists_id']?>/<?=$value['file']?>" type="audio/<?=$value['extension']?>">
                                                            Your browser does not support the audio element.
                                                        </audio>
                                                    <? endif;?>

                                                    <? if($value['file_type'] == 'video'):?>
                                                        <video controls style="width: 200px"  >
                                                            <source src="/statics/files/<?=$value['artists_id']?>/<?=$value['file']?>" type="video/<?=$value['extension']?>"" /> <!-- MPEG4 for Safari -->
                                                            <!--<source src="video.ogg" type="video/ogg" /> <!-- Ogg Theora for Firefox 3.1b2 -->
                                                        </video>
                                                    <? endif;?>
                                                    <? if($value['file_type'] == 'image'):?>
                                                        <div class="iportfolio" style="width: 200px">
                                                            <div class="portfolio-image">
                                                                <a href="<?=RELA_DIR?>product">
                                                                    <img src="/statics/files/<?=$value['artists_id']?>/<?=$value['file']?>" alt="Open Imagination">
                                                                </a>
                                                                <div class="portfolio-overlay">
                                                                    <a href="/statics/files/<?=$value['artists_id']?>/<?=$value['file']?>" class="left-icon" data-lightbox="image"><i class="icon-line-plus"></i></a>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    <? endif;?>
                                                </td>
                                                <td><?=$value['date']?></td>
                                                <td><?=$value["brif_description_$lang"]?></td>
                                                <td><?=$value['rate']?> (از <?=$value['rate_count']?> نظر)</td>
                                                <td>
                                                    <div class="style-msg   <?=($value['status'] == 1)?'':'style-msg-light';?>" style="background-color: <?=($value['status'] == 1)?'#AEE239':'#444';?>">
                                                        <div class="sb-msg"><i class="<?=($value['status'] == 1)?'icon-thumbs-up':'icon-remove';?>"></i>تایید <?=($value['status'] == 1)?'شده':' نشده';?></div>
                                                    </div>

                                                    <a href="<?=RELA_DIR?>account/editProduct/<?=$value['Artists_products_id']?>" class="button button-3d button-dirtygreen" >ویرایش</a>
                                                    <a href="<?=RELA_DIR?>account/deleteProduct/<?=$value['Artists_products_id']?>" class="button button-3d button-red" >حذف</a>

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