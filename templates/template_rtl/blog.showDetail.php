<!-- Star Rating CSS -->
<link rel="stylesheet" href="<?=TEMPLATE_DIR?>css/components/bs-rating.css" type="text/css" />
<!-- Page Title
============================================= -->
<section id="page-title">

    <div class="container clearfix">
        <h1> <?=$blog['title_'.$lang];?>  </h1>
        <ol class="breadcrumb">
            <li><a href="<?=RELA_DIR?>blog"> وبلاگ</a></li>
            <li class="active"><?=$blog['title_'.$lang];?> </li>
        </ol>
    </div>

</section><!-- #page-title end -->

<!-- Content
============================================= -->
<section id="content">

    <div class="content-wrap">

        <div class="container clearfix">

            <!-- Portfolio Single Image
            ============================================= -->
            <div class="col artists_img nobottommargin text-center">
                <img src="<?=RELA_DIR.'statics/blog/'.$blog['image'];?>" alt="">
            </div><!-- .portfolio-single-image end -->

            <!-- Portfolio Single Content
            ============================================= -->
            <div class="col portfolio-single-content col_last nobottommargin">

                <!-- Portfolio Single - Description
                ============================================= -->

                <p ><?=$blog['description_'.$lang]?></p>

                <!-- Portfolio Single - Description End -->

                <div class="line"></div>


            </div><!-- .portfolio-single-content end -->

            <div class="clear"></div>


            <!-- Related Portfolio Items
            ============================================= -->
            <!-- Related Portfolio Items
           ============================================= -->
            <?php if(count($blog['product_list'])) : ?>
                <h4>نمونه کارها:</h4>

                <div class="section nobottommargin" style="padding-right:10px; padding-left: 10px; ">


                    <!-- Portfolio Filter
                    ============================================= -->
                    <ul id="portfolio-filter" class="portfolio-filter clearfix" data-container="#portfolio">

                        <li class="activeFilter"><a href="#" data-filter="*">همه</a></li>
                        <? foreach ($blog['genre_list_all'] as $cat_id => $catValue):?>
                            <li><a href="#" data-filter=".<?=$cat_id?>"><?=$catValue['title'];?></a></li>
                        <? endforeach; ?>

                    </ul><!-- #portfolio-filter end -->

                    <div id="portfolio-shuffle" class="portfolio-shuffle" data-container="#portfolio">
                        <i class="icon-random"></i>
                    </div>

                    <div class="clear"></div>

                    <!-- Portfolio Items
                    ============================================= -->
                    <div id="portfolio" class="portfolio grid-container portfolio-5 portfolio-nomargin clearfix">

                        <?php foreach ($blog['product_list'] as $id =>$value): ?>
                            <?php
                            $file = ROOT_DIR.ltrim($value['image'], '/');
                            $cat_id = str_replace(',',' ',$value['genre_id']);
                            $cat_title = '';
                            foreach (explode(',',$value['genre_id']) as $k => $v ){
                                $cat_title .= $blog['genre_list_all'][$v]['title'] .' / ';

                            }
                            $cat_title = substr($cat_title,0,-2);


                            ?>
                            <article class="portfolio-item <?=$cat_id?>">
                                <div class="portfolio-image">
                                    <a href="<?=RELA_DIR?>product/<?=$blog['artists_name']?>/<?=$value['Artists_products_id']?>/<?=$value['title']?>">
                                        <img src="<?=(strlen($value['image']) ? RELA_DIR.'statics/files/'.$value['artists_id'].'/'.$value['image'] : '/templates/'.CURRENT_SKIN.'/assets/images/placeholder.png');?>" alt="Open Imagination">
                                    </a>
                                    <div class="portfolio-overlay">
                                        <a href="<?=(strlen($value['image']) ? RELA_DIR.'statics/files/'.$value['artists_id'].'/'.$value['image'] : '/templates/'.CURRENT_SKIN.'/assets/images/placeholder.png');?>" class="left-icon" data-lightbox="image"><i class="icon-line-plus"></i></a>
                                        <a href="<?=RELA_DIR?>product/<?=$blog['artists_name']?>/<?=$value['Artists_products_id']?>/<?=$value['title']?>" class="right-icon"><i class="icon-line-ellipsis"></i></a>
                                    </div>
                                </div>
                                <div class="portfolio-desc">
                                    <h3><a href="<?=RELA_DIR?>product/<?=$blog['artists_name']?>/<?=$value['Artists_products_id']?>/<?=$value['title']?>"><?=$value['title']?></a></h3>
                                    <span><?=$cat_title?></span>
                                </div>
                            </article>

                        <? endforeach;?>


                    </div><!-- #portfolio end -->



                </div>

            <? endif; ?>





        </div>

    </div>

</section><!-- #content end -->




