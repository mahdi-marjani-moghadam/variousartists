<!-- Page Title
============================================= -->
<section id="page-title" style="display: none">

    <div class="container clearfix">
        <h1><?php echo $list['page_title'] ?? ''; ?></h1>


        <ol class="breadcrumb" style="display: none">
            <li><a href="<?php echo RELA_DIR ?>">خانه</a></li>
            <li class="active">پنل کاربری</li>

        </ol>

        <?php echo $list['breadcrumb'] ?? '' ?>


    </div>

</section><!-- #page-title end -->

<!-- Content
   ============================================= -->
<section id="content">



    <div class="panel section notopborder notopmargin nobottommargin notoppadding nobottompadding ">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="p-title row nopadding nomargin">
                    <!-- <div class="col-md-1 col-sm-2 cool-xs-12 nopadding" >
                            <a href="#" class="p-logo"><img src="<?php /*=TEMPLATE_DIR*/ ?>img/logo-dark.png"></a>
                        </div>-->
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <i class="icon icon-user"></i><span class="hidden-xs">Account</span>‌ <?php echo $list['list']["artists_name_$lang"] ?? ''?>


                    </div>
                    <div class="col-md-1 col-sm-2 cool-xs-12  pull-left">
                        <a href="<?php echo RELA_DIR ?>login/logout" class="p-logout">
                            <img src="<?php echo TEMPLATE_DIR ?>img/p-logout.png"><span> LogOut </span></a>
                    </div>
                </div>
                <div class="p-shortcuts row  nomargin" style="display: none ">
                    <div class="p-nav-handle"> <i class=""></i>مینانبر کلی</div>
                    <ul>
                        <li>
                            <div class="p-sh-img"><img src="<?php echo TEMPLATE_DIR ?>img/p-sh1.png"></div>
                            <div class="p-sh-ttx hidden-sm  ">
                                <a href="<?php echo RELA_DIR ?>account">Dashboard</a>
                                <div class="p-sh-brief">My Account</div>
                            </div>
                        </li>
                        <li>
                            <div class="p-sh-img"><img src="<?php echo TEMPLATE_DIR ?>img/p-sh2.png"></div>
                            <div class="p-sh-ttx hidden-sm ">
                                <a href="<?php echo RELA_DIR ?>account/editProfile">Profile</a>
                                <div class="p-sh-brief">Profile information</div>
                            </div>
                        </li>
                        <!--<li>
                                <div class="p-sh-img"><img src="<?php /*=TEMPLATE_DIR*/ ?>img/p-sh3.png"></div>
                                <div class="p-sh-ttx hidden-sm ">
                                    <a href="" >سرویس ها</a>
                                    <div class="p-sh-brief" >سرویس های من</div>
                                </div>
                            </li>
                            <li>
                                <div class="p-sh-img"><img src="<?php /*=TEMPLATE_DIR*/ ?>img/p-sh4.png"></div>
                                <div class="p-sh-ttx hidden-sm ">
                                    <a href="" >دامین ها</a>
                                    <div class="p-sh-brief" >دامنه های من</div>
                                </div>
                            </li>
                            <li>
                                <div class="p-sh-img"><img src="<?php /*=TEMPLATE_DIR*/ ?>img/p-sh5.png"></div>
                                <div class="p-sh-ttx hidden-sm ">
                                    <a href="" >صورتحساب ها</a>
                                    <div class="p-sh-brief" >فاکتور سرویس ها</div>
                                </div>
                            </li>-->
                        <li>
                            <div class="p-sh-img"><img src="<?php echo TEMPLATE_DIR ?>img/p-sh6.png"></div>
                            <div class="p-sh-ttx hidden-sm ">
                                <a href=""> Donate</a>
                            </div>
                        </li>

                    </ul>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="p-right">
                    <div class="p-nav row">

                        <div class="col-md-12 col-sm-12 col-xs-12">

                            <div class="p-nav-handle"> <i class=""></i>Menu</div>
                            <ul>
                                <?php if ($member_info['type'] == 1): ?>
                                    <?php if ($member_info['blog'] == 1): ?>
                                        <li><a href="<?php echo  RELA_DIR ?>account/addBlog"
                                                class="button  button-reveal  button-border tleft"><i
                                                    class="icon-caret-right"></i>
                                                <span>
                                                    <div class="icon-blogger"></div> Add Blog
                                                </span>
                                            </a></li>
                                        <li><a href="<?php echo  RELA_DIR ?>account/showBlogList"
                                                class="button  button-reveal  button-border tleft"><i
                                                    class="icon-caret-right"></i>
                                                <span>
                                                    <div class="icon-blogger"></div> blog
                                                </span>
                                            </a></li>
                                    <?php endif; ?>
                                    <li><a href="<?php echo  RELA_DIR ?>account/addEvent"
                                            class="button  button-reveal  button-border tleft"><i
                                                class="icon-caret-right"></i>
                                            <span>
                                                <div class="icon-line2-bell"></div> Add event
                                            </span>
                                        </a></li>
                                    <li><a href="<?php echo  RELA_DIR ?>account/event"
                                            class="button  button-reveal  button-border tleft"><i
                                                class="icon-caret-right"></i>
                                            <span>
                                                <div class="icon-line2-bell"></div> Events
                                            </span>
                                        </a></li>
                                    <li><a href="<?php echo  RELA_DIR ?>account/addProduct"
                                            class="button  button-reveal  button-border tleft"><i
                                                class="icon-caret-right"></i>
                                            <span>
                                                <div class="icon icon-line-box"></div> Add product
                                            </span>
                                        </a></li>
                                    <li><a href="<?php echo RELA_DIR ?>account/showProductList" class="button  button-reveal  button-border tleft"><i class="icon-caret-right"></i>
                                            <span>
                                                <div class="icon icon-line-box"></div> Products
                                            </span>
                                        </a> </li>

                                    <li><a href="<?php echo RELA_DIR ?>account/showInvoiceList" class="button  button-reveal  button-border tleft"><i class="icon-caret-right"></i>
                                            <span>
                                                <div class="icon-line-clipboard"></div> Invoice
                                            </span>
                                        </a> </li>



                                <?php else: ?>
                                    <li><a href="<?php echo  RELA_DIR ?>sales/invoice"
                                            class="button  button-reveal  button-border tright"><i
                                                class="icon-caret-right"></i>
                                            <span>
                                                <div class="icon-line-clipboard"></div>Basket
                                            </span>
                                        </a></li>
                                <?php endif; ?>

                                <li><a href="<?php echo  RELA_DIR ?>account/editProfile"
                                        class="button  button-reveal  button-border tleft"><i
                                            class="icon-caret-right"></i>
                                        <span>
                                            <div class="icon icon-user"></div> Profile
                                        </span>
                                    </a></li>
                                <li><a href="#"
                                        class="button  button-reveal  button-border tleft"><i
                                            class="icon-caret-right"></i>
                                        <span>
                                            <div class="icon icon-money"></div> Donate
                                        </span>
                                    </a></li>

                                <li><a href="<?php echo  RELA_DIR ?>account/ref"
                                        class="button  button-reveal  button-border tright"><i
                                            class="icon-caret-right"></i>
                                        <span>
                                            <div class="icon icon-send"></div> Send Invitation
                                        </span>
                                    </a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class=" p-left ">

                    <div class="row p-container nopadding nomargin">