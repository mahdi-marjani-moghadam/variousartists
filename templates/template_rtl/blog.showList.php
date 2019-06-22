<style>
    .category-detail{        display: none;    }
    .category-ul h2{ cursor: pointer;}
</style>
<script>
    $(document).ready(function () {
        $('.category-ul h2').click(function (e) {
            var div = $(this).next();
            div.toggle();
        });
    });
</script>
<!-- Page Title
		============================================= -->
<section id="page-title" >

    <div class="container clearfix">
        <h1> هنرمندان</h1>
        <span>نمایش تمامی هنرمندان مطرح ایران</span>
        <ol class="breadcrumb">
            <li><a href="<?=RELA_DIR?>">خانه</a></li>
            <li class="active"> وبلاگ</li>
        </ol>
    </div>

</section><!-- #page-title end -->

<!-- Content
		============================================= -->
<section id="content">

    <div class="content-wrap" style="padding: 1px 0 0 0;">

        <div class="col-xs-12 col-sm-12 col-md-2 pull-right hidden">
            <?php //include_once("categoryList.php");?>
            <nav class=" nobottommargin category-ul">
                <h2 class="btn btn-default btn-block" ><?=category_arrow_down?> ... </h2>
                <div class="category-detail">
                    <? echo $list['export']['category'];?>
                </div>

                <br>
                <h2 class="btn btn-default btn-block"  ><?=genre_arrow_down?> ...</h2>
                <div class="category-detail">
                    <? echo $list['export']['genre'];?>
                </div>
            </nav>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 pull-left">
        <!-- Portfolio Items
        ============================================= -->
        <div id="portfolio" class="portfolio grid-container portfolio-3    portfolio-masonry mixed-masonry grid-container clearfix">
            <?
            if(count($blog['export']['list']) == 0 && isset($blog['export']['list']))
            {
            ?>
            <div class="whiteBg boxBorder roundCorner clear fullWidth ">
                <!-- separator -->
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <div class="alert alert-warning">
                            <strong>توجه! </strong><? echo $msg;?>
                        </div>
                    </div>
                </div>
            </div>
            <?
            }

            foreach($blog['export']['list'] as $k => $value)
            {
                ?>
                <article class="portfolio-item pf-media pf-icons <? /* if($k % 4 ==0){echo 'wide';} */?> ">
                    <div class="portfolio-image">
                        <a href="portfolio-single.html">
                            <img src="<?php echo (strlen($value['image']) ? RELA_DIR.'statics/blog/'.$value['image'] : TEMPLATE_DIR.'/assets/images/placeholder.png'); ?>" alt="Open Imagination">
                        </a>
                        <div class="portfolio-overlay">
                            <div class="portfolio-desc">
                                <h3><a href="<?php echo RELA_DIR . 'blog/detail/' . $value['id'] . '/'; ?>"><?php echo($value['title_'.$lang] != "" ? $value['title_'.$lang] : "-"); ?> </a></h3>
                            </div>
                            <a href="<?php echo (strlen($value['image']) ? RELA_DIR.'statics/blog/'.$value['image'] : RELA_DIR.'templates/'.CURRENT_SKIN.'/assets/images/placeholder.png'); ?>" class="left-icon" data-lightbox="image"><i
                                    class="icon-line-zoom-in"></i></a>
                            <a href="<?php echo RELA_DIR . 'blog/detail/' . $value['id'] . '/'; ?>" class="right-icon"><i title="جزییات" class="icon-line-ellipsis"></i></a>
                        </div>
                    </div>
                </article>

                <?php
            }
            ?>



        </div><!-- #portfolio end -->
            <div class="clearfix"></div>
            <?
            if(($blog['export']['rows']) != 0)
            {
                ?>
                <ul class="pagination">
                    <li><a href="#">&laquo;</a></li>
                    <?
                    $pageCount = ceil($blog['export']['rows']/PAGE_SIZE);
                    for($i=1;$i <= $pageCount;$i++)
                    {
                        ?>
                        <li class="<?=($PAGE == $i)?'active':'';?>" >
                            <a href="<?=RELA_DIR;?>blog/page/<?=$i?>"><?=$i?></a>
                        </li>
                        <?

                    }
                    ?>

                    <li><a href="#">&raquo;</a></li>
                </ul>


                <?php
            }
            else
                {
                ?>
                    <div class="col-md-12">
                        <div class="alert alert-danger"><?=not_exists?></div>
                    </div>
            <?
            }
            ?>

            </div>

    </div>

</section><!-- #content end -->
                    <!-- separator -->




