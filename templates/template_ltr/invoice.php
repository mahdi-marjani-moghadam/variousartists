<!-- Page Title
		============================================= -->

<section id="page-title">

    <div class="container clearfix">
        <h1><?php echo invoices?></h1>
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
                <?php foreach ($list['invoice'] as $invoice ):?>
                    <div class="col-md-6">
                        <div class="panel panel-default events-meta" id="changeNumber">
                            <div class="panel-heading" style="padding: 10px">
                            <h3 class="panel-title" >
                                <span  style=" "> <?php echo $invoice['event']['event_name']?></span>
                                <?php if($invoice['status'] == 0): ?>
                                <span class="pull-left badge " style="background: #bc1d1e; "><a href="<?php echo RELA_DIR?>sales/invoice/delete/<?php echo $invoice['Sales_id']?>" style="color: #fff;" class=" " >x | <?php echo delete_invoice?></a></span>
                                <?php endif; ?>
                            </h3>

                        </div>
                            <div class="panel-body " style="background: rgba(170,255,150,0.51)">



                                <form action="<?php echo RELA_DIR?>sales/pay" method="POST" data-validate="form" role="form">
                                    <input type="hidden" name="sid" value="<?php echo ($invoice['Sales_id']);?>">
                                    <div class="col_two_third">
                                        <ul class="iconlist nobottommargin">
                                            <li><i class="icon-calendar3"></i><?php echo invoice_time?><?php echo convertDate($invoice['date']).' -  '.$invoice['event_time']?> </li>
                                            <li><i class="icon-map-marker2"></i><?php echo invoice_place?><?php echo $invoice['salon']['address']?>,<?php echo $invoice['salon']['title']?></li>
                                            <li><i class="icon-line2-pin"></i><?php echo $invoice['position']['title']?></li>
                                            <li><i class="icon-dollar"></i><?php echo price?><?php echo $invoice['price']?><?php echo rial?></li>
                                        </ul>
                                    </div>
                                    <div class="col_one_third col_last">
                                        <div class="col-md-12"><?php echo sanladi_number?></div>
                                        <div class="col-md-12">
                                            <?php  foreach (explode(',',$invoice['sandali']) as $k => $x):?>
                                                <span  class="btn-default btn margin " style="float: none" ><?php echo $x?></span>
                                            <?endforeach; ?>
                                        </div>
                                    </div>
                                    <div class="col_full">
                                        <?php if($invoice['status'] == 0): ?>
                                        <div class="form-group form-actions center">
                                            <input type="submit" class="btn  btn-success btn-default  text-white text-16" value="<?php echo pay_by_eghtesad_novin?>">
                                        </div><!--/form-group-->
                                        <?php endif; ?>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <?endforeach; ?>
            </div>
        </div>
    </div>
</section><!-- #content end -->





