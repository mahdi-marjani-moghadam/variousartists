
<!-- Page Title
============================================= -->
<section id="page-title">

    <div class="container clearfix">
        <h1><?=$list['page_title'];?></h1>


        <ol class="breadcrumb" style="display: none" >
            <li><a href="<?=RELA_DIR?>">خانه</a></li>
            <li class="active">پنل کاربری</li>

        </ol>

        <?=$list['breadcrumb']?>


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
                            <a href="#" class="p-logo"><img src="<?/*=TEMPLATE_DIR*/?>img/logo-dark.png"></a>
                        </div>-->
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <i class="icon icon-user"></i><span class="hidden-xs">پنل مدیریتی‌:</span>‌ <?=$list['list']["artists_name_$lang"]?>


                    </div>
                    <div class="col-md-1 col-sm-2 cool-xs-12  pull-left" >
                        <a href="<?=RELA_DIR?>login/logout" class="p-logout"><img src="<?=TEMPLATE_DIR?>img/p-logout.png"><span> خروج </span></a>
                    </div>
                </div>
                <div class="p-shortcuts row  nomargin">
                    <div class="p-nav-handle"> <i class=""></i>مینانبر کلی</div>
                    <ul>
                        <li>
                            <div class="p-sh-img"><img src="<?=TEMPLATE_DIR?>img/p-sh1.png"></div>
                            <div class="p-sh-ttx hidden-sm  ">
                                <a href="<?=RELA_DIR?>account" >پیشخوان</a>
                                <div class="p-sh-brief" >دفتر کار من</div>
                            </div>
                        </li>
                        <li>
                            <div class="p-sh-img"><img src="<?=TEMPLATE_DIR?>img/p-sh2.png"></div>
                            <div class="p-sh-ttx hidden-sm ">
                                <a href="<?=RELA_DIR?>account/editProfile" >مشخصات من</a>
                                <div class="p-sh-brief" >پروفایل کاری من</div>
                            </div>
                        </li>
                        <!--<li>
                                <div class="p-sh-img"><img src="<?/*=TEMPLATE_DIR*/?>img/p-sh3.png"></div>
                                <div class="p-sh-ttx hidden-sm ">
                                    <a href="" >سرویس ها</a>
                                    <div class="p-sh-brief" >سرویس های من</div>
                                </div>
                            </li>
                            <li>
                                <div class="p-sh-img"><img src="<?/*=TEMPLATE_DIR*/?>img/p-sh4.png"></div>
                                <div class="p-sh-ttx hidden-sm ">
                                    <a href="" >دامین ها</a>
                                    <div class="p-sh-brief" >دامنه های من</div>
                                </div>
                            </li>
                            <li>
                                <div class="p-sh-img"><img src="<?/*=TEMPLATE_DIR*/?>img/p-sh5.png"></div>
                                <div class="p-sh-ttx hidden-sm ">
                                    <a href="" >صورتحساب ها</a>
                                    <div class="p-sh-brief" >فاکتور سرویس ها</div>
                                </div>
                            </li>-->
                        <li>
                            <div class="p-sh-img"><img src="<?=TEMPLATE_DIR?>img/p-sh6.png"></div>
                            <div class="p-sh-ttx hidden-sm ">
                                <a href="" >کمک مالی</a>
                            </div>
                        </li>

                    </ul>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="p-right" >
                    <div class="p-nav row">

                        <div class="col-md-12 col-sm-12 col-xs-12">

                            <div class="p-nav-handle"> <i class=""></i>منو پنل</div>
                            <ul>
                                <li><a href="<?=RELA_DIR?>account/showProductList" class="button  button-reveal  button-border tright"><i class="icon-caret-right"></i>
                                        <span><div class="icon icon-line-box"></div>   نمونه کار ها</span>
                                    </a> </li>
                                <li><a href="<?=RELA_DIR?>account/showInvoiceList" class="button  button-reveal  button-border tright"><i class="icon-caret-right"></i>
                                        <span><div class="icon-line-clipboard"></div> لیست پرداختی</span>
                                    </a> </li>

                            </ul>
                        </div>
                    </div>
                </div>
                <div class=" p-left ">
                    <div class="row p-container nopadding nomargin">
                        <? if($msg != ''):?><div class="alert alert-danger"><?=$msg;?></div><? endif;?>