<!-- Star Rating CSS -->
<link rel="stylesheet" href="<?php echo TEMPLATE_DIR ?>css/components/bs-rating.css" type="text/css" />
<!-- Page Title
============================================= -->
<section id="page-title">

    <div class="container clearfix">
        <h1> <?php echo $list['list']['artists_name']; ?> / <?php echo $list['list']['nickname']; ?> </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo RELA_DIR ?>artists"> <?php echo artists ?></a></li>
            <li class="active"><?php echo $list['list']['artists_name']; ?> </li>
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
                <img width="100%" src="<?php echo RELA_DIR . 'statics/files/' . $list['list']['Artists_id'] . '/' . $list['list']['logo']; ?>" alt="">
                <div class="si-share clearfix no-border mt-1  ">
                    <div class="pull-right">شبکه های اجتماعی <?php echo $list['list']['artists_name']; ?> را دنبال کنید:</div>
                    <div class="">
                        <?php if ($list['list']['facebook'] != '') : ?>
                            <a href="https://facebook.com/<?php echo $list['list']['facebook'] ?>" class="social-icon si-borderless ">
                                <i class="icon-facebook"></i>
                                <i class="icon-facebook"></i>
                            </a>
                        <?php endif; ?>
                        <?php if ($list['list']['twitter'] != '') : ?>
                            <a href="https://twitter.com/<?php echo $list['list']['twitter'] ?>" class="social-icon si-borderless ">
                                <i class="icon-twitter"></i>
                                <i class="icon-twitter"></i>
                            </a>
                        <?php endif; ?>
                        <?php if ($list['list']['instagram'] != '') : ?>
                            <a href="https://instagram.com/<?php echo $list['list']['instagram'] ?>" class="social-icon si-borderless ">
                                <i class="icon-instagram"></i>
                                <i class="icon-instagram"></i>
                            </a>
                        <?php endif; ?>
                        <?php if ($list['list']['telegram'] != '') : ?>
                            <a href="https://telegram.me/<?php echo $list['list']['telegram'] ?>" class="social-icon si-borderless ">
                                <i class="icon-email2"></i>
                                <i class="icon-email2"></i>
                            </a>
                        <?php endif; ?>
                        <?php if ($list['list']['site'] != '') : ?>
                            <a href="<?php echo $list['list']['site'] ?>" class="social-icon si-borderless ">
                                <i class="icon-ie"></i>
                                <i class="icon-ie"></i>
                            </a>
                        <?php endif; ?>
                        <?php if ($list['list']['soundcloud'] != '') : ?>
                            <a href="https://www.soundcloud.com/<?php echo $list['list']['soundcloud'] ?>" class="social-icon si-borderless ">
                                <i class="icon-soundcloud    "></i>
                                <i class="icon-soundcloud"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div><!-- .portfolio-single-image end -->

            <!-- Portfolio Single Content
            ============================================= -->
            <div class="col portfolio-single-content col_last nobottommargin">

                <!-- Portfolio Single - Description
                ============================================= -->
                <div class="fancy-title title-bottom-border topmargin-sm">
                    <h2><?php echo biography ?></h2>
                    <br>
                    <ul class="portfolio-meta ">
                        <?php if ($list['list']['show_birthday'] == 'on') : ?>
                            <li><span><i class="icon-user"></i>تاریخ تولد:</span><?php echo convertDate($list['list']['birthday']) ?></li>
                        <?php endif; ?>

                        <?php if ($list['list']['ref'] != '') : ?>
                            <li style="display: flex;">
                                <div>

                                    تاریخ عضویت: <?php echo convertDate($list['list']['date']) ?>
                                    <br>
                                    
                                    معرف: <img width="30" src="<?php echo RELA_DIR . 'statics/files/' . $list['list']['ref'] . '/' . $list['list']['ref_logo']; ?>" alt="">
                                    <a href="<?php echo RELA_DIR . 'artists/Detail/' . $list['list']['ref'] . '/' . $list['list']['ref_name']; ?>"><?php echo $list['list']['ref_name']; ?></a>
                                </div>
                            </li>
                        <?php endif; ?>

                        <li style="display: none;"><i class="icon-trophy"></i>جمع امتیازات <?php echo $list['list']['rate'] ?> ( از <?php echo $list['list']['rate_count'] ?> نظر ):
                            <div dir="ltr">

                                <!--<input id="input-1" disabled type="number" class="rating"  value="<?/*=$list['list']['rate']*/ ?>"  max="10"  data-step="0.1" data-size="sm" data-glyphicon="false" data-rating-class="fontawesome-icon">-->


                            </div>
                        </li>
                    </ul>
                </div>
                <p><?php echo $list['list']['description'] ?></p>

                <!-- Portfolio Single - Description End -->





            </div><!-- .portfolio-single-content end -->



            <!-- Related Portfolio Items
            ============================================= -->
            <!-- Related Portfolio Items
           ============================================= -->
            <?php if (count($list['product_list'])) : ?>
                <div class="divider divider-center"><i class="icon-circle"></i></div>
                <h4>نمونه کارها:</h4>

                <div class="section nobottommargin" style="padding-right:10px; padding-left: 10px; ">


                    <!-- Portfolio Filter
                    ============================================= -->
                    <ul id="portfolio-filter" class="portfolio-filter clearfix" data-container="#portfolio">

                        <li class="activeFilter"><a href="#" data-filter="*">همه</a></li>
                        <?php foreach ($list['genre_list_all'] as $cat_id => $catValue) : ?>
                            <li><a href="#" data-filter=".<?php echo $cat_id ?>"><?php echo $catValue['title']; ?></a></li>
                        <?php endforeach; ?>

                    </ul><!-- #portfolio-filter end -->

                    <div id="portfolio-shuffle" class="portfolio-shuffle" data-container="#portfolio">
                        <i class="icon-random"></i>
                    </div>

                    <div class="clear"></div>

                    <!-- Portfolio Items
                    ============================================= -->
                    <div id="portfolio" class="portfolio grid-container portfolio-5 portfolio-nomargin clearfix">

                        <?php foreach ($list['product_list'] as $id => $value) : ?>
                            <?php
                            $file = ROOT_DIR . ltrim($value['image'], '/');
                            $cat_id = str_replace(',', ' ', $value['genre_id']);
                            $cat_title = '';
                            foreach (explode(',', $value['genre_id']) as $k => $v) {
                                $cat_title .= $list['genre_list_all'][$v]['title'] . ' / ';
                            }
                            $cat_title = substr($cat_title, 0, -2);


                            ?>
                            <article class="portfolio-item <?php echo $cat_id ?>">
                                <div class="portfolio-image">
                                    <a href="<?php echo RELA_DIR ?>product/<?php echo $list['list']['artists_name'] ?>/<?php echo $value['Artists_products_id'] ?>/<?php echo $value['title'] ?>">
                                        <img src="<?php echo (strlen($value['image']) ? RELA_DIR . 'statics/files/' . $value['artists_id'] . '/' . $value['image'] : '/templates/' . CURRENT_SKIN . '/assets/images/placeholder.png'); ?>" alt="Open Imagination">
                                    </a>
                                    <div class="portfolio-overlay">
                                        <a href="<?php echo (strlen($value['image']) ? RELA_DIR . 'statics/files/' . $value['artists_id'] . '/' . $value['image'] : '/templates/' . CURRENT_SKIN . '/assets/images/placeholder.png'); ?>" class="left-icon" data-lightbox="image"><i class="icon-line-plus"></i></a>
                                        <a href="<?php echo RELA_DIR ?>product/<?php echo $list['list']['artists_name'] ?>/<?php echo $value['Artists_products_id'] ?>/<?php echo $value['title'] ?>" class="right-icon"><i class="icon-line-ellipsis"></i></a>
                                    </div>
                                </div>
                                <div class="portfolio-desc">
                                    <h3><a href="<?php echo RELA_DIR ?>product/<?php echo $list['list']['artists_name'] ?>/<?php echo $value['Artists_products_id'] ?>/<?php echo $value['title'] ?>"><?php echo $value['title'] ?></a></h3>
                                    <span><?php echo $cat_title ?></span>
                                </div>
                            </article>

                        <?php endforeach; ?>


                    </div><!-- #portfolio end -->



                </div>

            <?php endif; ?>
            <div class="divider divider-center"><i class="icon-circle"></i></div>




        </div>

    </div>

</section><!-- #content end -->