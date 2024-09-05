<div class="col-md-12 col-xs-12 col-sm-12">
    <div class="col-md-12 col-sm-12 col-xs-12" style="overflow: scroll">
        <table class="table table-responsive table-striped">
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

            <?php
            $i = $this->recordsCount;
            $start = $i - (($list['pagination']['current'] - 1) * PAGE_SIZE);
            foreach ($list['artistsProductList'] as $k => $value):

            ?>
                <tr>
                    <td><?php echo $start; ?></td>
                    <td><a href="<?php echo RELA_DIR ?>product/<?php echo $list['list']["artists_name_$lang"] ?>/<?php echo $value['Artists_products_id'] ?>/<?php echo $value["title_$lang"] ?>"><?php echo $value["title_$lang"] ?></a></td>
                    <td><img height="70" src="<?php echo (strlen($value['image']) ? RELA_DIR . 'statics/files/' . $value["artists_id"] . '/' . $value['image'] : '/templates/' . CURRENT_SKIN . '/assets/images/placeholder.png'); ?>" alt="Open Imagination">
                        <br>
                        <?php if ($value['file_type'] == 'audio'): ?>
                            <audio controls style="width: 200px">
                                <source src="/statics/files/<?php echo $value['artists_id'] ?>/<?php echo $value['file'] ?>" type="audio/<?php echo $value['extension'] ?>">
                                Your browser does not support the audio element.
                            </audio>
                        <?php endif; ?>

                        <?php if ($value['file_type'] == 'video'): ?>
                            <video controls style="width: 200px">
                                <source src="/statics/files/<?php echo $value['artists_id'] ?>/<?php echo $value['file'] ?>" type="video/<?php echo $value['extension'] ?>"" /> <!-- MPEG4 for Safari -->
                                                            <!--<source src=" video.ogg" type="video/ogg" /> <!-- Ogg Theora for Firefox 3.1b2 -->
                            </video>
                        <?php endif; ?>
                        <?php if ($value['file_type'] == 'image'): ?>
                            <div class="iportfolio" style="width: 200px">
                                <div class="portfolio-image">
                                    <a href="<?php echo RELA_DIR ?>product">
                                        <img src="/statics/files/<?php echo $value['artists_id'] ?>/<?php echo $value['file'] ?>" alt="Open Imagination">
                                    </a>
                                    <div class="portfolio-overlay">
                                        <a href="/statics/files/<?php echo $value['artists_id'] ?>/<?php echo $value['file'] ?>" class="left-icon" data-lightbox="image"><i class="icon-line-plus"></i></a>
                                    </div>
                                </div>

                            </div>
                        <?php endif; ?>
                    </td>
                    <td><?php echo $value['date'] ?></td>
                    <td><?php echo $value["brif_description_$lang"] ?></td>
                    <td><?php echo $value['rate'] ?> (از <?php echo $value['rate_count'] ?> نظر)</td>
                    <td>
                        <div class="style-msg   <?php echo ($value['status'] == 1) ? '' : 'style-msg-light'; ?>" style="background-color: <?php echo ($value['status'] == 1) ? '#AEE239' : '#444'; ?>">
                            <div class="sb-msg"><i class="<?php echo ($value['status'] == 1) ? 'icon-thumbs-up' : 'icon-remove'; ?>"></i>تایید <?php echo ($value['status'] == 1) ? 'شده' : ' نشده'; ?></div>
                        </div>

                        <a href="<?php echo RELA_DIR ?>account/editProduct/<?php echo $value['Artists_products_id'] ?>" class="button button-3d button-dirtygreen">ویرایش</a>
                        <a href="<?php echo RELA_DIR ?>account/deleteProduct/<?php echo $value['Artists_products_id'] ?>" class="button button-3d button-red">حذف</a>

                    </td>
                    <!--<td><a href=" "  class="button button-3d button-mini button-rounded button-aqua ">پرداخت فاکتور</a> </td>-->
                </tr>
            <?php
                $start--;
            endforeach; ?>
        </table>

        <?php
        if (isset($list['pagination']['list']) && count($list['pagination']['list'])) {
        ?>
            <ul class="pagination">
                <li><a href="#">&laquo;</a></li>
                <?php
                foreach ($list['pagination']['list'] as $key => $link) {
                    if ($key === 'current') {
                        continue;
                    }
                ?>
                    <li class="<?php echo (($key + 1 == $list['pagination']['current']) || (empty($list['pagination']['current']) && $key == 0)) ? 'active' : ''; ?>"><a href="<?php echo RELA_DIR . $link; ?>"><?php echo $key + 1 ?></a></li>
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