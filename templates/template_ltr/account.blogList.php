



                                <div class="col-md-12 col-xs-12 col-sm-12">
                                    <div class="col-md-12 col-sm-12 col-xs-12" style="overflow: scroll">
                                        <table   class="table table-responsive table-striped">
                                            <thead>

                                            <th>Name  </th>
                                            <th>Image</th>
                                            <th>Date</th>
                                            <th>Status </th>

                                            </thead>

                                            <?

                                            foreach($list['artistsBlogList'] as $k => $value):

                                                ?>
                                            <tr>

                                                <td><a href="<?=RELA_DIR?>blog/detail/<?=$value['id']?>"><?=$value["title_$lang"]?></a></td>
                                                <td>

                                                        <div class="iportfolio" style="width: 100px">
                                                            <div class="portfolio-image">
                                                                <a href="<?=RELA_DIR?>blog">
                                                                    <img src="/statics/blog/<?=$value['image']?>" alt="Open Imagination">
                                                                </a>
                                                                <div class="portfolio-overlay">
                                                                    <a href="/statics/blog/<?=$value['image']?>" class="center-icon" data-lightbox="image"><i class="icon-line-plus"></i></a>
                                                                </div>
                                                            </div>

                                                        </div>

                                                </td>
                                                <td><?=($value['date'])?></td>

                                                <td>
                                                    <div class="style-msg   <?=($value['status'] == 1)?'':'style-msg-light';?>" style="background-color: <?=($value['status'] == 1)?'#AEE239':'#444';?>">
                                                        <div class="sb-msg"><i class="<?=($value['status'] == 1)?'icon-thumbs-up':'icon-remove';?>"></i> <?=($value['status'] == 1)?'Confirmed':'Not Confirm ';?></div>
                                                    </div>

                                                    <a href="<?=RELA_DIR?>account/editBlog/<?=$value['id']?>" class="button button-3d button-dirtygreen" >Edit</a>
                                                    <a href="<?=RELA_DIR?>account/deleteBlog/<?=$value['id']?>" class="button button-3d button-red" >Delete</a>

                                                </td>
                                                <!--<td><a href=" "  class="button button-3d button-mini button-rounded button-aqua ">پرداخت فاکتور</a> </td>-->
                                            </tr>
                                            <?endforeach;?>
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