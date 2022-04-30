<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>

	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="author" content="marjani" />

        <link rel="icon" href="<?php echo TEMPLATE_DIR; ?>img/favication.png" type="image/png" sizes="16x16">

    <link rel="icon" sizes="192x192" href="<?php echo TEMPLATE_DIR; ?>img/favication.png">
    <link rel="apple-touch-icon" sizes="128x128" href="<?php echo TEMPLATE_DIR; ?>img/favication.png">

	<!-- Stylesheets
	============================================= -->
    <!-- SLIDER REVOLUTION 5.x CSS SETTINGS -->
    <link rel="stylesheet" type="text/css" href="<?php echo TEMPLATE_DIR; ?>css/rv-settings.css" media="screen"/>

	<link rel="stylesheet" href="<?php echo TEMPLATE_DIR; ?>css/font-awesome.min.css" type="text/css" />

	<link rel="stylesheet" href="<?php echo TEMPLATE_DIR; ?>css/bootstrap.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo TEMPLATE_DIR; ?>css/bootstrap-rtl.css" type="text/css"/>

	<link rel="stylesheet" href="<?php echo TEMPLATE_DIR; ?>css/style.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo TEMPLATE_DIR; ?>css/style-rtl.css" type="text/css"/>

    <link rel="stylesheet" href="<?php echo TEMPLATE_DIR; ?>css/swiper.css" type="text/css"/>


	<link rel="stylesheet" href="<?php echo TEMPLATE_DIR; ?>css/font-icons.css" type="text/css"/>
    <link rel="stylesheet" href="<?php echo TEMPLATE_DIR; ?>css/font-icons-rtl.css" type="text/css"/>

    <link rel="stylesheet" href="<?php echo TEMPLATE_DIR; ?>css/animate.css" type="text/css"/>
    <link rel="stylesheet" href="<?php echo TEMPLATE_DIR; ?>css/magnific-popup.css" type="text/css"/>

    <link rel="stylesheet" href="<?php echo TEMPLATE_DIR; ?>css/responsive.css" type="text/css"/>
    <link rel="stylesheet" href="<?php echo TEMPLATE_DIR; ?>css/responsive-rtl.css" type="text/css"/>
    <link rel="stylesheet" href="<?php echo TEMPLATE_DIR; ?>css/magnific-popup.css" type="text/css"/>

    <link rel="stylesheet" href="<?php echo TEMPLATE_DIR; ?>css/owl.carousel.css" type="text/css"/>

	<link rel="stylesheet" href="<?php echo TEMPLATE_DIR; ?>js/calendar/fullcalendar.css" type="text/css"/>

    <link href="<?php echo RELA_DIR; ?>templates/<?php echo CURRENT_SKIN; ?>/assets/css/persianDatepicker.css" rel="stylesheet">


	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=3" />
	<!--[if lt IE 9]>
		<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
	<![endif]-->

    <!-- Here goes your colors.css
	============================================= -->
    <link rel="stylesheet" href="<?php echo TEMPLATE_DIR; ?>css/colors.css" type="text/css"/>

    <!-- Here goes your custom.css
	============================================= -->
    <link rel="stylesheet" href="<?php echo TEMPLATE_DIR; ?>css/fonts.css" type="text/css"/>
    <link rel="stylesheet" href="<?php echo TEMPLATE_DIR; ?>css/custom.css" type="text/css"/>


    <script type="text/javascript" src="<?php echo TEMPLATE_DIR; ?>js/jquery.js"></script>


	<!-- Document Title
	============================================= -->
	<title>Various Artists</title>

</head>

<body class="stretched  no-transition">


	<!-- Document Wrapper
	============================================= -->
	<div id="wrapper" class="clearfix">

		<!-- Header
		============================================= -->
		<header id="header" class=" full-header" data-sticky-class="not-dark">

			<div id="header-wrap">

				<div class="container clearfix">

					<div id="primary-menu-trigger"><i class="icon-reorder"></i></div>

					<!-- Logo
					============================================= -->
					<div id="logo">
						<a href="<?php echo RELA_DIR?>" class="standard-logo" data-dark-logo="<?php echo TEMPLATE_DIR; ?>/img/logo.png"><img src="<?php echo TEMPLATE_DIR; ?>img/logo.png" alt="Canvas Logo"></a>
						<a href="<?php echo RELA_DIR?>" class="retina-logo" data-dark-logo="<?php echo TEMPLATE_DIR; ?>/img/logo@2x.png"><img src="<?php echo TEMPLATE_DIR; ?>img/logo@2x.png" alt="Canvas Logo"></a>
					</div><!-- #logo end -->

					<!-- Primary Navigation
					============================================= -->
					<nav id="primary-menu" class="dark style-6 style-2">
						<ul>
							<li class="<?php echo ($PARAM[0] == 'event')?'current':'';?> hidden-xs" ><a href="<?php echo RELA_DIR?>event"><div>رویدادها</div></a></li>
							<li class="<?php echo ($PARAM[0] == 'artists')?'current':'';?>"><a href="<?php echo RELA_DIR?>artists"><div> هنرمندان</div></a></li>
							<li class="<?php echo ($PARAM[0] == 'artists')?'current':'';?>"><a href="<?php echo RELA_DIR?>blog"><div> وبلاگ</div></a></li>

                                <?php /*<li class="<?php echo ($PARAM[0] == 'services')?'current':'';?>"><a href="<?php echo RELA_DIR?>services"><div>خدمات</div></a></li>
							<li class="<?php echo ($PARAM[0] == 'shop')?'current':'';?>"><a href="<?php echo RELA_DIR?>shop"><div>فروشگاه</div></a></li>*/?>
							<?php if($member_info == -1){?>
                                <li class="<?php echo ($PARAM[0] == 'login')?'current':'';?>">
                                    <a href="<?php echo RELA_DIR?>login"><div><?php echo login?></div></a>
                                </li>
                                <li class="<?php echo ($PARAM[0] == 'register')?'current':'';?>">
                                    <a href="<?php echo RELA_DIR?>register"><div><?php echo register?></div></a>
                                </li>
							<?php   } else{?>
								<li class="<?php echo ($PARAM[0] == 'account')?'current':'';?>">
                                    <a href="<?php echo RELA_DIR?>account"><div>
                                            <?php global $lang ?>
                                            <?php if($member_info['nickname']){echo $member_info['nickname'];}
                                            elseif($member_info["artists_name_$lang"]){echo $member_info["artists_name_$lang"];}
                                            else{echo ' صفحه کاربری';} ?>
                                        </div></a>
                                </li>
								<li class="<?php echo ($PARAM[0] == 'logout')?'current':'';?>"><a href="<?php echo RELA_DIR?>login/logout"><div>خروج</div></a></li>

							<?php }  ?>
                            <li ><a href="<?php echo RELA_DIR?>index/?lang=en"><div><img src="<?php echo RELA_DIR?>templates/<?php echo CURRENT_SKIN?>/img/flag_en.png"> English</div></a></li>
						</ul>


						<!-- Top Cart
						============================================= -->
                        <?php /*<div id="top-cart">
							<a href="#" id="top-cart-trigger"><i class="icon-shopping-cart"></i><span>5</span></a>
							<div class="top-cart-content">
								<div class="top-cart-title">
									<h4>Shopping Cart</h4>
								</div>
								<div class="top-cart-items">
									<div class="top-cart-item clearfix">
										<div class="top-cart-item-image">
											<a href="#"><img src="images/shop/small/1.jpg" alt="Blue Round-Neck Tshirt" /></a>
										</div>
										<div class="top-cart-item-desc">
											<a href="#">Blue Round-Neck Tshirt</a>
											<span class="top-cart-item-price">$19.99</span>
											<span class="top-cart-item-quantity">x 2</span>
										</div>
									</div>
									<div class="top-cart-item clearfix">
										<div class="top-cart-item-image">
											<a href="#"><img src="images/shop/small/6.jpg" alt="Light Blue Denim Dress" /></a>
										</div>
										<div class="top-cart-item-desc">
											<a href="#">Light Blue Denim Dress</a>
											<span class="top-cart-item-price">$24.99</span>
											<span class="top-cart-item-quantity">x 3</span>
										</div>
									</div>
								</div>
								<div class="top-cart-action clearfix">
									<span class="fleft top-checkout-price">$114.95</span>
									<button class="button button-3d button-small nomargin fright">View Cart</button>
								</div>
							</div>
						</div><!-- #top-cart end --> */?>

						<!-- Top Search
						============================================= -->
						<div id="top-search">
							<a href="#" id="top-search-trigger"><i class="icon-search3"></i><i class="icon-line-cross"></i></a>
							<form action="<?php echo RELA_DIR?>search/" method="get">

                                    <input type="text" name="q"  class="form-control" value="" placeholder="به دنبال چه میگردید">
                                    <select name="type" class="form-control" style="width: 100%; margin-top: -10px">
                                        <option value="هنرمندان"> جستجو در دسته هنرمندان </option>
                                        <option value="رویدادها">جستجو در دسته رویدادها</option>
                                        <option value="سبک">جستجو در سبک</option>
                                    </select>

							</form>
						</div><!-- #top-search end -->

					</nav><!-- #primary-menu end -->

				</div>

			</div>

		</header><!-- #header end -->

