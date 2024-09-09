<div class="col-md-12 col-xs-12 col-sm-12">
    <div class="col-md-12 col-sm-12 col-xs-12" style="overflow: scroll">
        <table class="table table-responsive table-striped">
            <thead>

                <th>Name </th>
                <th>Image</th>
                <th>Date</th>
                <th>Status </th>

            </thead>

            <?php

            foreach ($list['artistsBlogList'] as $k => $value):

            ?>
                <tr>

                    <td><a href="<?php echo RELA_DIR ?>blog/detail/<?php echo $value['id'] ?>"><?php echo $value["title_$lang"] ?></a></td>
                    <td>

                        <div class="iportfolio" style="width: 100px">
                            <div class="portfolio-image">
                                <a href="<?php echo RELA_DIR ?>blog">
                                    <img src="/statics/blog/<?php echo $value['image'] ?>" alt="Open Imagination">
                                </a>
                                <div class="portfolio-overlay">
                                    <a href="/statics/blog/<?php echo $value['image'] ?>" class="center-icon" data-lightbox="image"><i class="icon-line-plus"></i></a>
                                </div>
                            </div>

                        </div>

                    </td>
                    <td><?php echo ($value['date']) ?></td>

                    <td>
                        <div class="style-msg   <?php echo ($value['status'] == 1) ? '' : 'style-msg-light'; ?>" style="background-color: <?php echo ($value['status'] == 1) ? '#AEE239' : '#444'; ?>">
                            <div class="sb-msg"><i class="<?php echo ($value['status'] == 1) ? 'icon-thumbs-up' : 'icon-remove'; ?>"></i> <?php echo ($value['status'] == 1) ? 'Confirmed' : 'Not Confirm '; ?></div>
                        </div>

                        <a href="<?php echo RELA_DIR ?>account/editBlog/<?php echo $value['id'] ?>" class="button button-3d button-dirtygreen">Edit</a>
                        <a href="<?php echo RELA_DIR ?>account/deleteBlog/<?php echo $value['id'] ?>" class="button button-3d button-red">Delete</a>

                    </td>
                    <!--<td><a href=" "  class="button button-3d button-mini button-rounded button-aqua ">پرداخت فاکتور</a> </td>-->
                </tr>
            <?php endforeach; ?>
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