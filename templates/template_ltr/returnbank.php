    <!-- Page Title
		============================================= -->

<section id="page-title">

    <div class="container clearfix">
        <h1>بازگشت از بانک</h1>
        <!--<ol class="breadcrumb">
            <li><a href="<?/*=RELA_DIR*/?>">خانه</a></li>
            <li><a href="<?/*=RELA_DIR*/?>event">رویدادها</a></li>
            <li class="active"><?/*=$list['list']['event_name'];*/?></li>
        </ol>-->
    </div>

</section><!-- #page-title end -->

<!-- Content
		============================================= -->
<section id="content">
    <div class="content-wrap">
        <div class="container clearfix">
            <div class="single-event col-md-12 ">

                    <div class="col-md-6 col-md-offset-3">
                        <div class="panel panel-default events-meta" id="changeNumber">
                            <div class="panel-heading" style="padding: 10px">
                            <h3 class="panel-title" >
                                <span  style=" "><?=pay_result?></span>

                            </h3>

                        </div>

                            <? if($list['ResNum'] == '6'): ?>
                                <div class="panel-body " style="background: rgba(255,157,126,0.51)">

                                    <input name="action" value="addSales" type="hidden">

                                    <div class="col-md-12"><?=pay_not_success?><?=$list['State']?></div>
                                    <div class="col-md-12">
                                        <a href="<?=RELA_DIR?>account"><?=return_back_to_account?></a>
                                    </div>


                                </div>
                            <? else: ?>
                                <div class="panel-body " style="background: rgba(170,255,150,0.51)">

                                    <input name="action" value="addSales" type="hidden">

                                    <div class="col-md-12"><?=pay_success?></div>
                                    <div class="col-md-12">
                                        <a href="<?=RELA_DIR?>account"><?=return_back_to_account?></a>
                                    </div>


                                </div>
                            <? endif; ?>

                        </div>
                    </div>

            </div>
        </div>
    </div>
</section><!-- #content end -->





