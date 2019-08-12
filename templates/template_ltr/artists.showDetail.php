<!-- Star Rating CSS -->
<link rel="stylesheet" href="<?=TEMPLATE_DIR?>css/components/bs-rating.css" type="text/css" />
<!-- Page Title
============================================= -->
<section id="page-title">

    <div class="container clearfix">
        <h1> <?=$list['list']['artists_name'];?> / <?=$list['list']['nickname'];?>  </h1>
        <ol class="breadcrumb">
            <li><a href="<?=RELA_DIR?>artists"> <?=artists?></a></li>
            <li class="active"><?=$list['list']['artists_name'];?> </li>
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
            <div class="col artists_img nobottommargin text-center" >
                <img width="100%" src="<?=RELA_DIR.'statics/files/'.$list['list']['Artists_id'].'/'.$list['list']['logo'];?>" alt="">
                <div class="si-share clearfix no-border mt-1  ">
                    <div class="pull-left">Follow <?=$list['list']['artists_name'];?> social network:</div>
                    <div class="">
                        <? if($list['list']['facebook'] != ''): ?>
                            <a href="https://facebook.com/<?=$list['list']['facebook']?>" class="social-icon si-borderless ">
                                <i class="icon-facebook"></i>
                                <i class="icon-facebook"></i>
                            </a>
                        <? endif;?>
                        <? if($list['list']['twitter'] != ''): ?>
                            <a href="https://twitter.com/<?=$list['list']['twitter']?>" class="social-icon si-borderless ">
                                <i class="icon-twitter"></i>
                                <i class="icon-twitter"></i>
                            </a>
                        <? endif;?>
                        <? if($list['list']['instagram'] != ''): ?>
                            <a href="https://instagram.com/<?=$list['list']['instagram']?>" class="social-icon si-borderless ">
                                <i class="icon-instagram"></i>
                                <i class="icon-instagram"></i>
                            </a>
                        <? endif;?>
                        <? if($list['list']['telegram'] != ''): ?>
                            <a href="https://telegram.me/<?=$list['list']['telegram']?>" class="social-icon si-borderless ">
                                <i class="icon-email2"></i>
                                <i class="icon-email2"></i>
                            </a>
                        <? endif;?>
                        <? if($list['list']['site'] != ''): ?>
                            <a href="<?=$list['list']['site']?>" class="social-icon si-borderless ">
                                <i class="icon-ie"></i>
                                <i class="icon-ie"></i>
                            </a>
                        <? endif;?>
                        <? if($list['list']['soundcloud'] != ''): ?>
                            <a href="https://www.soundcloud.com/<?=$list['list']['soundcloud']?>" class="social-icon si-borderless ">
                                <i class="icon-soundcloud    "></i>
                                <i class="icon-soundcloud"></i>
                            </a>
                        <? endif;?>
                    </div>
                </div>
            </div><!-- .portfolio-single-image end -->

            <!-- Portfolio Single Content
            ============================================= -->
            <div class="col portfolio-single-content col_last nobottommargin">

                <!-- Portfolio Single - Description
                ============================================= -->
                <div class="fancy-title title-bottom-border topmargin-sm">
                    <h2><?=biography?></h2>
                </div>
                <p ><?=$list['list']['description']?></p>

                <!-- Portfolio Single - Description End -->



                <!-- Portfolio Single - Meta
                ============================================= -->
                <ul class="portfolio-meta bottommargin">
                    <? if($list['list']['show_birthday'] == 'on'):?>
                        <div class="line"></div>
                        <li><span><i class="icon-user"></i><?=birthday?></span><?=($list['list']['birthday'])?></li>
                    <? endif; ?>

                    <li style="display: none;" ><i class="icon-trophy"></i>جمع امتیازات <?=$list['list']['rate']?> ( از <?=$list['list']['rate_count']?> نظر ):
                        <div  dir="ltr">

                            <!--<input id="input-1" disabled type="number" class="rating"  value="<?/*=$list['list']['rate']*/?>"  max="10"  data-step="0.1" data-size="sm" data-glyphicon="false" data-rating-class="fontawesome-icon">-->


                        </div>
                    </li>
                </ul>
                <!-- Portfolio Single - Meta End -->


            </div><!-- .portfolio-single-content end -->



            <!-- Related Portfolio Items
            ============================================= -->
            <!-- Related Portfolio Items
           ============================================= -->
            <?php if(count($list['product_list'])) : ?>
                <div class="divider divider-center"><i class="icon-circle"></i></div>
                <h4>Products:</h4>

                <div class="section nobottommargin" style="padding-right:10px; padding-left: 10px; ">


                    <!-- Portfolio Filter
                    ============================================= -->
                    <ul id="portfolio-filter" class="portfolio-filter clearfix" data-container="#portfolio">

                        <li class="activeFilter"><a href="#" data-filter="*">همه</a></li>
                        <? foreach ($list['genre_list_all'] as $cat_id => $catValue):?>
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

                        <?php foreach ($list['product_list'] as $id =>$value): ?>
                            <?php
                            $file = ROOT_DIR.ltrim($value['image'], '/');
                            $cat_id = str_replace(',',' ',$value['genre_id']);
                            $cat_title = '';
                            foreach (explode(',',$value['genre_id']) as $k => $v ){
                                $cat_title .= $list['genre_list_all'][$v]['title'] .' / ';

                            }
                            $cat_title = substr($cat_title,0,-2);


                            ?>
                            <article class="portfolio-item <?=$cat_id?>">
                                <div class="portfolio-image">
                                    <a href="<?=RELA_DIR?>product/<?=$list['list']['artists_name']?>/<?=$value['Artists_products_id']?>/<?=$value['title']?>">
                                        <img src="<?=(strlen($value['image']) ? RELA_DIR.'statics/files/'.$value['artists_id'].'/'.$value['image'] : '/templates/'.CURRENT_SKIN.'/assets/images/placeholder.png');?>" alt="Open Imagination">
                                    </a>
                                    <div class="portfolio-overlay">
                                        <a href="<?=(strlen($value['image']) ? RELA_DIR.'statics/files/'.$value['artists_id'].'/'.$value['image'] : '/templates/'.CURRENT_SKIN.'/assets/images/placeholder.png');?>" class="left-icon" data-lightbox="image"><i class="icon-line-plus"></i></a>
                                        <a href="<?=RELA_DIR?>product/<?=$list['list']['artists_name']?>/<?=$value['Artists_products_id']?>/<?=$value['title']?>" class="right-icon"><i class="icon-line-ellipsis"></i></a>
                                    </div>
                                </div>
                                <div class="portfolio-desc">
                                    <h3><a href="<?=RELA_DIR?>product/<?=$list['list']['artists_name']?>/<?=$value['Artists_products_id']?>/<?=$value['title']?>"><?=$value['title']?></a></h3>
                                    <span><?=$cat_title?></span>
                                </div>
                            </article>

                        <? endforeach;?>


                    </div><!-- #portfolio end -->



                </div>

            <? endif; ?>
            <div class="divider divider-center"><i class="icon-circle"></i></div>




        </div>

    </div>

</section><!-- #content end -->




