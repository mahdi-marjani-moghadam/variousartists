<!-- Page Title
		============================================= -->

<section id="page-title">

    <div class="container clearfix">
        <h1><?=$list['list']['event_name'];?></h1>
        <ol class="breadcrumb">
            <li><a href="<?=RELA_DIR?>">خانه</a></li>
            <li><a href="<?=RELA_DIR?>event">رویدادها</a></li>
            <li class="active"><?=$list['list']['event_name'];?></li>
        </ol>
    </div>

</section><!-- #page-title end -->

<!-- Content
		============================================= -->
<section id="content">

    <div class="content-wrap">

        <div class="container clearfix">

            <div class="single-event col-md-10 col-md-offset-1">

                <?$newDate = ($list['list']['date']!="0000-00-00" ? convertDate($list['list']['event_time']):"");?>

                <div class="panel panel-default events-meta" id="changeNumber">
                    <div class="panel-heading">
                        <h3 class="panel-title">رویداد:<?=$list['list']['event_name']?></h3>
                    </div>
                    <form action="<?= RELA_DIR ?>sales" method="POST" data-validate="form" role="form">
                        <div class="panel-body">
                            <div class="col_half">
                                <ul class="iconlist nobottommargin">


                                    <li><i class="icon-calendar3"></i> زمان استفاده:    <?=$newDate?> </li>
                                    <br>

                                    <li><i class="icon-map-marker2"></i> مکان استفاده:    <?=$list['salonname']['title_fa']?>, <?=$list['salonpartname']['title_fa']?></li>




                                    <? /* ?>
                                    <select name="sandali" >
                                        <?php  foreach ($list['skhali'] as $k => $x):?>
                                            <option value="<?=$x?>"><?=$x?></option>
                                        <?endforeach; ?>

                                    </select>
                                    <? */ ?>



                                </ul>
                            </div>
                            <div class="col_half col_last">
                                <ul class="iconlist nobottommargin">
                                    <input type="hidden" name="action" value="acceptpage" />
                                    <input type="hidden" name="place_id" value="<?=$list['salonpartname']['parent_id']?>" />
                                    <input type="hidden" name="place_name" value="<?=$list['salonname']['title_fa']?>" />
                                    <input type="hidden" name="part_id" value="<?=$list['salonpartname']['Salon_id']?>" />
                                    <input type="hidden" name="part_name" value="<?=$list['salonpartname']['title_fa']?>" />
                                    <input type="hidden" name="event_time" value="<?=$list['list']['event_time']?>" />
                                    <input type="hidden" name="Event_id" value="<?=$list['list']['Event_id']?>" />
                                    <input type="hidden" name="Event_name" value="<?=$list['eventname']['event_name']?>" />


                                    <img  src="<?=RELA_DIR?>statics/salon/<?=$list['salonpartname']['image']?>">


                                </ul>
                            </div>

                        <div class="col_full">
                        <?php  foreach ($list['skhali'] as $k => $x):?>
                            <label for="sandali<?=$x?>" class="btn-info btn margin topmargin-sm" style="float: none" ><?=$x?>
                                <input id="sandali<?=$x?>" type="checkbox" name="sandali[]"  value="<?=$x?>">
                            </label>
                        <?endforeach; ?>
                        </div>
                        <div class="form-group form-actions">
                            <input type="submit" class="btn btn-primary btn-default btn-block text-white text-16" value="خرید آنلاین">
                        </div><!--/form-group-->
                    </form>
                </div>
        <!--<a href="#" class="btn btn-success btn-block btn-lg">Buy Tickets</a>-->



    </div>



    </div>

    </div>

    </div>

</section><!-- #content end -->





