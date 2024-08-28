<!-- Page Title
		============================================= -->

<section id="page-title">

    <div class="container clearfix">
        <h1><?php echo $list['list']['event_name'];?></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo RELA_DIR?>">Home</a></li>
            <li><a href="<?php echo RELA_DIR?>event">Event</a></li>
            <li class="active"><?php echo $list['list']['event_name'];?></li>
        </ol>
    </div>

</section><!-- #page-title end -->
<!-- Content
		============================================= -->
<section id="content">

    <div class="content-wrap">

        <div class="container clearfix">

            <div class="single-event col-md-10 col-md-offset-1 center">

                <?$newDate = ($list['list']['date']!="0000-00-00" ? ($list['event_time']):"");?>
                    <div class="panel panel-default events-meta" id="changeNumber">
                        <div class="panel-heading">
                            <h3 class="panel-title">Event: <?php echo $list['event_name']?></h3>
                        </div>

                        <form action="<?php echo  RELA_DIR ?>sales" method="POST" data-validate="form" role="form">
                               <div class="col-md-offset-4 ">
                                <ul class="iconlist nobottommargin ">
<br>
                                    <br><br>
                                    <li><i class="icon-map-marker2"></i> Place :    <?php echo $list['place_name']?></li>
                                    <br>
                                    <li><i class="icon-paperplane"></i> Part:   <?php echo $list['part_name']?></li>
                                    <br>
                                    <li><i class="icon-ticket"></i> صندلی انتخاب شده: شماره
                                        <?php foreach ($list['sandali'] as $v):?>
                                        <span class="btn btn-info"><?php echo $v?></span>
                                        <?php endforeach;?>
                                    </li>
                                    <br>
                                    <li><i class="icon-time"></i> تاریخ و ساعت انتخاب شده:    <?php echo $newDate?></li>
                                    <br>
                                    <li><i class="icon-calculator"></i>جمع فاکتور:    </li>
                                   <br>
                                    <li><i class="icon-paypal"></i>درگاه پرداخت : بانک اقتصاد نوین    </li>
                                    </li><br>
                                    <br><br><br>   </ul>
                               </div>
                            <div class="form-group form-actions">
                                <input type="submit" class="btn btn-primary btn-default btn-block text-white text-16" value="پرداخت">
                            </div>
                            </form>                     </div>
        </div>


            </div>

        </div>


</section><!-- #content end -->





