<!-- Page Title
		============================================= -->
<section id="page-title">

    <div class="container clearfix">
        <h1><?=$list['list']['event_name'];?></h1>
        <ol class="breadcrumb">
            <li><a href="<?=RELA_DIR?>">Home</a></li>
            <li><a href="<?=RELA_DIR?>event">Events</a></li>
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

                <div class="col_half">
                    <div class="entry-image nobottommargin">
                        <img src="<?php echo (strlen($list['list']['logo']) ? RELA_DIR.'statics/event/'.$list['list']['logo'] : RELA_DIR.'templates/'.CURRENT_SKIN.'/assets/images/placeholder.png'); ?>" alt="<?=$list['list']['event_name'];?>" title="<?=$list['list']['event_name'];?>">
                        <!--<div class="entry-overlay">
                            <span class="hidden-xs">Starts in: </span><div id="event-countdown" class="countdown"></div>
                        </div>-->
                    </div>
                </div>
                <div class="col_half col_last">
                    <div class="panel panel-default events-meta">
                        <div class="panel-heading">
                            <h3 class="panel-title">Info:</h3>
                        </div>
                        <div class="panel-body">
                            <ul class="iconlist nobottommargin">
                                <?php

                                $newDate = ($list['list']['date']!="0000-00-00" ? convertDate($list['list']['date']):"");
                                $newDate2 = ($list['list']['date2']!="0000-00-00"? convertDate($list['list']['date2']):"");
                                $newDate3 = ($list['list']['date3']!="0000-00-00"? convertDate($list['list']['date3']):"");
                                $newTime = ($list['list']['event_time']!=""?   $list['list']['event_time']:"");
                                $newTime2 = ($list['list']['event_time2']!=""? $list['list']['event_time2']:"");
                                $newTime3 = ($list['list']['event_time3']!=""? $list['list']['event_time3']:"");
                                ?>

                                <? if($newTime || $newDate):?><li><i class="icon-calendar3"></i> <?=$newDate?> - <?=$newTime?></li><?endif;?>
                                <? if($newTime2 || $newDate2):?><li><i class="icon-calendar3"></i> <?=$newDate2?> - <?=$newTime2?></li><?endif;?>
                                <? if($newTime3 || $newDate3):?><li><i class="icon-calendar3"></i> <?=$newDate3?> - <?=$newTime3?></li><?endif;?>

                                <li><i class="icon-map-marker2"></i><?=$list['list']['city']?> - <?=($list['list']['address']!=""? $list['list']['address']:"-")?></li>
                                <li><i class="icon-phone-sign"></i> <?=($list['list']['event_phone']!=""? $list['list']['event_phone']:"-")?></li>
                                <li><i class="icon-dollar"></i> <strong><?=($list['list']['price']!= "")? $list['list']['price']:"-";?> Toman</strong></li>
                            </ul>
                        </div>
                    </div>
                    <!--<a href="#" class="btn btn-success btn-block btn-lg">Buy Tickets</a>-->


                    <div class="col_full nobottommargin">
                        <? if(count($list['event_gallery'])): ?>
                        <h4>تصاویر</h4>

                        <!-- Events Single Gallery Thumbs
                        ============================================= -->
                        <div class="masonry-thumbs col-4" data-lightbox="gallery">
                            <? foreach ($list['event_gallery'] as $image_id => $imageDetail):?>

                            <a href="<?=RELA_DIR.'statics/event/'.$imageDetail['image']?>" data-lightbox="gallery-item">
                                <img class="image_fade" src="<?=RELA_DIR.'statics/event/'.$imageDetail['image']?>" alt="<?=$list['list']['event_name'];?>"></a>
                            <? endforeach;?>

                        </div><!-- Event Single Gallery Thumbs End -->
                        <? endif;?>

                    </div>
                    <div class="col_full nobottommargin">


                        <div id="map" style="width:100%;height:250px"></div>

                            <script>
                                function myMap() {
                                    var mapCanvas = document.getElementById("map");
                                    var mapOptions = {
                                        center: new google.maps.LatLng(<?=$list['list']['lat'];?>,<?=$list['list']['longe'];?>),
                                        zoom: 15

                                    }
                                    var map = new google.maps.Map(mapCanvas, mapOptions);

                                    var marker = new google.maps.Marker({
                                        position: new google.maps.LatLng(<?=$list['list']['lat'];?>,<?=$list['list']['longe'];?>),
                                        map: map,
                                        animation:google.maps.Animation.DROP,
                                        //icon:'img/fav.png',
                                        title: 'Snazzy!'
                                    });

                                    var infowindow = new google.maps.InfoWindow({
                                        content: "Hello World!"
                                    });

                                    google.maps.event.addListener(marker, 'click', function() {
                                        infowindow.open(map,marker);
                                    });
                                }
                            </script>

                            <script src="https://maps.googleapis.com/maps/api/js?callback=myMap&key=AIzaSyCIh9IvVEgJFsmTg0UcXLn8LDoPnz2CnRc"></script>








                    </div>
                </div>

                <div class="clear"></div>

                <div class="col_full">

                    <h3>Detail</h3>

                    <p class="font-size1 color-silver2"><?=$list['list']['brief_description']?></p>

                    <p><?=$list['list']['description']?></p>



                </div>







            </div>

        </div>

    </div>

</section><!-- #content end -->


<!-- External JavaScripts
	============================================= -->
<script type="text/javascript" src="<?=TEMPLATE_DIR?>js/jquery.js"></script>
<script type="text/javascript" src="<?=TEMPLATE_DIR?>js/plugins.js"></script>

<!-- Footer Scripts
============================================= -->
<script type="text/javascript" src="<?=TEMPLATE_DIR?>js/functions.js"></script>

<script type="text/javascript" src="<?=TEMPLATE_DIR?>js/jquery.gmap.js"></script>



