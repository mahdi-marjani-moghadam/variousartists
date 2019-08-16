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
        <h1> <?=blog?></h1>

        <ol class="breadcrumb">
            <li><a href="<?=RELA_DIR?>"><?=home?></a></li>
            <li class="active"><?=blog?></li>
        </ol>
    </div>

</section><!-- #page-title end -->

<!-- Content
		============================================= -->
<section id="content">

    <div class="content-wrap" style="padding: 1px 0 0 0;">
        <div class="col-xs-12 col-sm-12 col-md-8 col-md-offset-2">
            <div class=" nobottommargin  clearfix">
                <div id="posts" class="">
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
                    <div class="entry clearfix">
                        <div class="entry-image">
                            <a href="<?php echo (strlen($value['image']) ? RELA_DIR.'statics/blog/'.$value['image'] : TEMPLATE_DIR.'/assets/images/placeholder.png'); ?>" data-lightbox="image">
                                <img class="image_fade" src="<?php echo (strlen($value['image']) ? RELA_DIR.'statics/blog/'.$value['image'] : TEMPLATE_DIR.'/assets/images/placeholder.png'); ?>" alt="" style="opacity: 1;">
                            </a>
                        </div>
                        <div class="entry-c">
                            <div class="entry-title">
                                <h2><a href="<?php echo RELA_DIR . 'blog/detail/' . $value['id'] . '/'; ?>"><?php echo($value['title_'.$lang] != "" ? $value['title_'.$lang] : "-"); ?></a></h2>
                            </div>
                            <ul class="entry-meta clearfix">
                                <li><i class="icon-calendar3"></i> <?=convertDate($value['date'])?></li>
                                <li><a href="#"><i class="icon-user"></i> <?=$value['artists_name']?></a></li>
                            </ul>
                            <div class="entry-content">
                                <p><?=$value['description_'.$lang]?></p>
                            </div>
                        </div>
                    </div>
                        <?php
                    }
                    ?>
                </div>
            </div>


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




