<!-- Star Rating CSS -->
<link rel="stylesheet" href="<?=TEMPLATE_DIR?>css/components/bs-rating.css" type="text/css" />
<!-- Page Title
============================================= -->
<section id="page-title">

    <div class="container clearfix">
        <h1><?=$list['list']['title'];?></h1>


        <ol class="breadcrumb" style="display: none">
            <li><a href="<?=RELA_DIR?>">خانه</a></li>
            <li><a href="<?=RELA_DIR?>artists">خانه هنرمندان</a></li>
            <li class="active"></li>
        </ol>

        <?=$list['breadcrumb'];?>
    </div>

</section><!-- #page-title end -->

<!-- Content
============================================= -->
<section id="content">

    <div class="content-wrap">

        <div class="container clearfix">

            <!-- Portfolio Single Image
            ============================================= -->
            <div class="  col_one_third portfolio-single-image nobottommargin">
                <img src="<?=RELA_DIR.'statics/files/'.$list['list']['artists_id'].'/'.$list['list']['image'];?>" alt="">
            </div><!-- .portfolio-single-image end -->

            <!-- Portfolio Single Content
            ============================================= -->
            <div class="col_two_third portfolio-single-content col_last nobottommargin">

                <!-- Portfolio Single - Description
                ============================================= -->
                <div class="fancy-title title-bottom-border">
                    <h2>درباره اثر:</h2>
                </div>
                <p><?=$list['list']['description']?></p>

                <!-- Portfolio Single - Description End -->

                <div class="line"></div>

                <!-- Portfolio Single - Meta
                ============================================= -->
                <ul class="portfolio-meta bottommargin">
                    <li><span><i class="icon-user"></i>تاریخ تولد:</span><?=convertDate($list['list']['birthday'])?></li>

                    <li><i class="icon-trophy"></i>جمع امتیازات  <?=$list['list']['rate']?>  ( از <?=$list['list']['rate_count']?> نظر ):
                        <div  dir="ltr">

                            <input id="input-1" type="number"  class="rating push-rate" data-artists="<?=$list['list']['artists_id']?>" data-product="<?=$list['list']['Artists_products_id']?>"  value="<?=$list['list']['rate']?>"  max="10"  data-step="0.1" data-size="sm" data-glyphicon="false" data-rating-class="fontawesome-icon">


                        </div>
                    </li>
                </ul>
                <!-- Portfolio Single - Meta End -->

                <? if($list['list']['file_type'] == 'audio'):?>
                    <audio controls>
                        <source src="/statics/files/<?=$list['list']['artists_id']?>/<?=$list['list']['file']?>" type="audio/<?=$list['list']['extension']?>">
                        Your browser does not support the audio element.
                    </audio>
                <? endif;?>

                <? if($list['list']['file_type'] == 'video'):?>
                    <video controls width="100%"  >
                        <source src="/statics/files/<?=$list['list']['artists_id']?>/<?=$list['list']['file']?>" type="video/<?=$list['list']['extension']?>"" /> <!-- MPEG4 for Safari -->
                        <!--<source src="video.ogg" type="video/ogg" /> <!-- Ogg Theora for Firefox 3.1b2 -->
                    </video>
                <? endif;?>
                <? if($list['list']['file_type'] == 'image'):?>
                    <div class="iportfolio">
                        <div class="portfolio-image">
                            <a href="<?=RELA_DIR?>product">
                                <img src="/statics/files/<?=$list['list']['artists_id']?>/<?=$list['list']['file']?>" alt="Open Imagination">
                            </a>
                            <div class="portfolio-overlay">
                                <a href="/statics/files/<?=$list['list']['artists_id']?>/<?=$list['list']['file']?>" class="left-icon" data-lightbox="image"><i class="icon-line-plus"></i></a>
                            </div>
                        </div>
                        <div class="portfolio-desc">
                            <h3><a href=""><?=$value['title']?></a></h3>
                            <!--<span><a href="#">Media</a>, <a href="#">Icons</a></span>-->
                        </div>
                    </div>
                <? endif;?>

            </div><!-- .portfolio-single-content end -->

            <div class="clear"></div>

            <div class="divider divider-center"><i class="icon-circle"></i></div>

            <!-- Related Portfolio Items
            ============================================= -->
            <?php if(count($list['other_product_list'])) : ?>
            <h4>نمونه کارهای <?=$list['list']['artists_name'];?>:</h4>

            <div class="section nobottommargin" style="padding-right:10px; padding-left: 10px; ">


                    <!-- Portfolio Filter
                    ============================================= -->
                    <ul id="portfolio-filter" class="portfolio-filter clearfix" data-container="#portfolio">

                        <li class="activeFilter"><a href="#" data-filter="*">همه</a></li>
                        <? foreach ($list['category_list_all'] as $cat_id => $catValue):?>
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

                <?php foreach ($list['other_product_list'] as $id =>$fields): ?>
                    <?php
                    $file = ROOT_DIR.ltrim($fields['image'], '/');
                    $cat_id = str_replace(',',' ',$fields['category_id']);
                    $cat_title = '';
                    foreach (explode(',',$fields['category_id']) as $k => $v ){
                        $cat_title .= $list['category_list_all'][$v]['title'] .' / ';

                    }
                    $cat_title = substr($cat_title,0,-2);



                    ?>
                        <article class="portfolio-item <?=$cat_id?>">
                            <div class="portfolio-image">
                                <a href="<?=RELA_DIR?>product/<?=$list['list']['artists_name']?>/<?=$fields['Artists_products_id']?>/<?=$fields['title']?>">
                                    <img src="<?=(strlen($fields['image']) ? RELA_DIR.'statics/files/'.$fields['artists_id'].'/'.$fields['image'] : '/templates/'.CURRENT_SKIN.'/assets/images/placeholder.png');?>" alt="Open Imagination">
                                </a>
                                <div class="portfolio-overlay">
                                    <a href="<?=(strlen($fields['image']) ? RELA_DIR.'statics/files/'.$fields['artists_id'].'/'.$fields['image'] : '/templates/'.CURRENT_SKIN.'/assets/images/placeholder.png');?>" class="left-icon" data-lightbox="image"><i class="icon-line-plus"></i></a>
                                    <a href="<?=RELA_DIR?>product/<?=$list['list']['artists_name']?>/<?=$fields['Artists_products_id']?>/<?=$fields['title']?>" class="right-icon"><i class="icon-line-ellipsis"></i></a>
                                </div>
                            </div>
                            <div class="portfolio-desc">
                                <h3><a href="<?=RELA_DIR?>product/<?=$list['list']['artists_name']?>/<?=$fields['Artists_products_id']?>/<?=$fields['title']?>"><?=$fields['title']?></a></h3>
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

