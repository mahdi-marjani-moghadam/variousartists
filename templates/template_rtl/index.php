
		<section id="slider" class=" swiper_wrapper full-screen clearfix">
			<div class="slider-parallax-inner">

				<div class="swiper-container swiper-parent">
					<div class="swiper-wrapper">

						<?php

						foreach ($list['banner'] as $k => $banner):
						?>

						<div class="swiper-slide dark" style="background-image: url('<?=RELA_DIR?>statics/banner/<?=$banner['image']?>');">
							<div class="container clearfix">
								<div class="slider-caption slider-caption-center">
									<h2 data-caption-animate="fadeInUp"><?=$banner["title_$lang"]?></h2>
									<p data-caption-animate="fadeInUp" data-caption-delay="200"><?=$banner["brief_description_$lang"]?></p>
								</div>
							</div>
						</div>

						<? endforeach; ?>

					</div>
					<div id="slider-arrow-left"><i class="icon-angle-left"></i></div>
					<div id="slider-arrow-right"><i class="icon-angle-right"></i></div>
				</div>

				<a href="#" data-scrollto="#content" data-offset="100" class="dark one-page-arrow"><i class="icon-angle-down infinite animated fadeInDown"></i></a>

			</div>
		</section>
        <section class="section">
            <div class="container">
                <div class="col-md-12 text-center" >

                    <p>مجموعه ی VariousArtists.ir (( سوشیال نتورک )) مرجعی تخصصی در حوزه ی موسیقی است که به معرفی هنرمندان ایرانی داخل و خارج کشور ، و همچنین اطلاع رسانی جامع در مورد رویدادهای موسیقی ایرانی , می پردازد .</p>
                </div>
            </div>
        </section>
        <section>
            <div class="container">
                <div class="col-md-4">
                    <iframe width="100%" height="166" scrolling="no" frameborder="no" allow="autoplay" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/647205381&color=%230e0c0f&auto_play=false&hide_related=false&show_comments=true&show_user=true&show_reposts=false&show_teaser=true"></iframe>
                </div>
                <div class="col-md-4">
                    <iframe width="100%" height="166" scrolling="no" frameborder="no" allow="autoplay" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/513290091&color=%230e0c0f&auto_play=false&hide_related=false&show_comments=true&show_user=true&show_reposts=false&show_teaser=true"></iframe>
                </div>
                <div class="col-md-4">
                    <iframe width="100%" height="166" scrolling="no" frameborder="no" allow="autoplay" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/442072704&color=%23340e0c&auto_play=false&hide_related=false&show_comments=true&show_user=true&show_reposts=false&show_teaser=true"></iframe>
                </div>
            </div>


        </section>
		<!-- Content
		============================================= -->
		<section id="content">

			<div class="content-wrap" style="padding-top: 10px;">



                <? if(count($list['lastEvent']) > 0 ): ?>
				<div class=" topmargin nobottommargin nobottomborder">
					<div class="container clearfix">
						<div class="heading-block center nomargin">
							<h3>رویدادها</h3>
						</div>
					</div>
				</div>

				<div id="portfolio" class="portfolio portfolio-6  grid-container portfolio-notitle grid-container clearfix">
					<? foreach ($list['lastEvent'] as $kEvent => $vEvent):
						$file = ROOT_DIR.ltrim($vEvent['logo'], '/');
						$file = (strlen($vEvent['logo']) ? RELA_DIR.'statics/event/'.$vEvent['logo'] : '/templates/'.CURRENT_SKIN.'/assets/images/placeholder.png');
						$cat_id = str_replace(',',' ',$vEvent['category_id']);
						$cat_title = '';
						foreach (explode(',',$vEvent['category_id']) as $k => $v ){
							$cat_title .= $list['category_list_all'][$v]['title'] .' / ';

						}
						$cat_title = substr($cat_title,0,-2);
						?>

					<article class="portfolio-item pf-media pf-icons">
						<div class="portfolio-image">
							<a href="<?=RELA_DIR?>event/Detail/<?=$vEvent["Event_id"];?>/<?=$vEvent["event_name_$lang"];?>">
								<img src="<?=$file;?>" alt="<?=$vEvent["event_name_$lang"];?>">
							</a>
							<div class="portfolio-overlay">
								<a href="<?=$file;?>" class="left-icon" data-lightbox="image"><i class="icon-line-plus"></i></a>
								<a href="<?=RELA_DIR?>event/Detail/<?=$vEvent["Event_id"];?>/<?=$vEvent["event_name_$lang"];?>" class="right-icon"><i class="icon-line-ellipsis"></i></a>
							</div>
						</div>
						<div class="portfolio-desc">
							<h3><a href="<?=RELA_DIR?>event/Detail/<?=$vEvent["Event_id"];?>/<?=$vEvent["event_name_$lang"];?>"><?=$vEvent["event_name_$lang"];?></a></h3>
							<span><?=$cat_title?></span>
						</div>
					</article>
					<? endforeach; ?>

				</div>
                <? endif;?>


				<div class="clear"></div>



			</div>

		</section><!-- #content end -->

		