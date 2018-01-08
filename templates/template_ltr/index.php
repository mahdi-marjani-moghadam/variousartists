
		<section id="slider" class="slider-parallax swiper_wrapper full-screen clearfix">
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

		<!-- Content
		============================================= -->
		<section id="content">

			<div class="content-wrap" style="padding-top: 10px;">




				<div class=" topmargin nobottommargin nobottomborder">
					<div class="container clearfix">
						<div class="heading-block center nomargin">
							<h3>Events</h3>
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
								<img src="<?=$file;?>"  alt="<?=$vEvent["event_name_$lang"];?>">
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


				<div class="clear"></div>



			</div>

		</section><!-- #content end -->

		