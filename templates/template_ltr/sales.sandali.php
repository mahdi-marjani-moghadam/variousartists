<!-- Page Title
		============================================= -->
<style>
    @media (min-width: 0px){
    .container{
            width:  auto !important;
        }

    }
</style>
<section id="page-title">

    <div class="container clearfix">
        <h1><?php echo $list['event']['event_name'];?></h1>
        <!--<ol class="breadcrumb">
            <li><a href="<?php /*=RELA_DIR*/?>">خانه</a></li>
            <li><a href="<?php /*=RELA_DIR*/?>event">رویدادها</a></li>
            <li class="active"><?php /*=$list['list']['event_name'];*/?></li>
        </ol>-->
    </div>

</section><!-- #page-title end -->

<!-- Content
		============================================= -->
<section id="content">

    <div class="content-wrap">

        <div class="container clearfix">

            <div class="single-event col-md-8 col-md-offset-2 col-sm-12 col-xs-12 ">



                <div class="panel panel-default events-meta" id="changeNumber">
                    <div class="panel-heading" style="padding: 10px">
                        <h3 class="panel-title" >
                            <span class="hidden-xs" style=" padding: 5px 10px; border-right: 1px solid silver;">
                                <a href="<?php echo $list['step1']?>"><span class="badge">1</span>  Choose Date and hour </a>
                            </span>
                            <span style=" padding: 5px 10px; border-right: 1px solid silver;  ">
                                <a href="<?php echo $list['step2']?>"> <span class="badge">2</span> Choose part</a>
                            </span>
                            <span class="hidden-xs" style=" background: #fff; padding: 5px 10px;  ">
                                <span class="badge">3</span> Choose chair
                            </span>
                            <span class="hidden-xs" style=" padding: 5px 10px; border-left: 1px solid silver">
                                <span class="badge">4</span> Order
                            </span>
                        </h3>

                    </div>
                    <form action="<?php echo $list['step3']?>" method="POST" data-validate="form" role="form">
                        <input name="action" value="addSales" type="hidden">
                        <div class="panel-body">
                            <div class="col_half">
                                <ul class="iconlist nobottommargin">
                                    <li><i class="icon-calendar3"></i>  Date:    <?php echo ($list['get']['date']).' -  '.$list['get']['time']?> </li>
                                    <br>
                                    <li><i class="icon-map-marker2"></i>  Place :    <?php echo $list['salon']['address_en']?>,<?php echo $list['salon']['title_en']?></li>
                                    <br>
                                    <li><i class="icon-line2-pin"></i><?php echo $list['position']['title']?></li>
                                    <li><i class="icon-dollar"></i>Price: <?php echo $list['position']['price']?> Rial</li>
                                    <br>
                                </ul>
                            </div>
                            <div class="col_half col_last">
                                <ul class="iconlist nobottommargin">
                                    <img  src="<?php echo RELA_DIR?>statics/salon/<?php echo $list['position']['image']?>">
                                </ul>
                            </div>
                        <div class="col_full">


                            <div class="pos1 ">

                                <?php include_once(ROOT_DIR.'statics/salon/'.$list['position']['file']) ?>


                            </div>

                            <div class="clearfix"></div>



                        </div>
                            <div class="col_full">

                                <div class="form-group form-actions center">
                                    <input type="submit" class="btn  btn-success btn-default  text-white text-16" value="Submit">
                                </div><!--/form-group-->
                            </div>
                    </form>
                </div>
        <!--<a href="#" class="btn btn-success btn-block btn-lg">Buy Tickets</a>-->



    </div>



    </div>

    </div>

    </div>

</section><!-- #content end -->





