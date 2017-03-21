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

            <div class="single-event">

                <div class="col_three_fourth">
                    <div class="entry-image nobottommargin">
                        <a href="#"><img src="<?php echo (strlen($list['list']['logo']) ? RELA_DIR.'statics/event/'.$list['list']['logo'] : RELA_DIR.'templates/'.CURRENT_SKIN.'/assets/images/placeholder.png'); ?>" alt="Event Single"></a>
                        <!--<div class="entry-overlay">
                            <span class="hidden-xs">Starts in: </span><div id="event-countdown" class="countdown"></div>
                        </div>-->
                    </div>
                </div>
                <div class="col_one_fourth col_last">
                    <div class="panel panel-default events-meta">
                        <div class="panel-heading">
                            <h3 class="panel-title">اطلاعات:</h3>
                        </div>
                        <div class="panel-body">
                            <ul class="iconlist nobottommargin">
                                <?php

                                $newDate = date('D jS \of M Y', strtotime($list['list']['date']));
                                ?>
                                <li><i class="icon-calendar3"></i> <?=$newDate?></li>
                                <li><i class="icon-time"></i> <?=($list['list']['event_time']!=""? $list['list']['event_time']:"-")?></li>
                                <li><i class="icon-map-marker2"></i><?=$list['list']['city']?> - <?=($list['list']['address']!=""? $list['list']['address']:"-")?></li>
                                <li><i class="icon-dollar"></i> <strong><?=($list['list']['price']!=""? $list['list']['price']:"-")?></strong></li>
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
                        <div id="map" style="width:100%;height:250px; ">در حال بارگذاری نقشه</div>

                        <script>
                            function myMap() {
                                var mapCanvas = document.getElementById("map");
                                var mapOptions = {
                                    center: new google.maps.LatLng(<?=$list['list']['lat']?>,<?=$list['list']['longe']?>),
                                    zoom: 15,
                                    styles: [{"featureType":"all","elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#000000"},{"lightness":40}]},{"featureType":"all","elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#000000"},{"lightness":16}]},{"featureType":"all","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#000000"},{"lightness":20}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#000000"},{"lightness":17},{"weight":1.2}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":20}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":21}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#000000"},{"lightness":17}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#000000"},{"lightness":29},{"weight":0.2}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":18}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":16}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":19}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":17}]}]
                                }
                                var map = new google.maps.Map(mapCanvas, mapOptions);

                                var marker = new google.maps.Marker({
                                    position: new google.maps.LatLng(35.803369,51.4339609),
                                    map: map,
                                    /*animation:google.maps.Animation.BOUNCE,*/
                                    /*icon:'img/fav.png',*/
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

                    <h3>جزییات</h3>

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



