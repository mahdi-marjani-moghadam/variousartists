<!-- Page Title
		============================================= -->
sdadasdad
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


                    <div class="panel panel-default events-meta" id="changeNumber">
                        <div class="panel-heading">
                            <h3 class="panel-title">رویداد:<?=$list['list']['event_name']?></h3>
                        </div>
                        <div class="panel-body">
                            <div class="col_half">
                                <ul class="iconlist nobottommargin">


                                   <li><i class="icon-calendar3"></i>انتخاب زمان استفاده:    <?=$list['list']['event_time']?> </li>
<br>

                                    <li><i class="icon-map-marker2"></i> انتخاب مکان استفاده:    <?=$list['salonname']['title_fa']?></li>
                                    <br>
                                    <li> نام منطقه:<br>
                                        <select>
                                            <?php

                                            foreach ($list['salon_list'] as $k => $salon):
                                            ?>
                                            <option><?=$salon["title_fa"]?></option>
                                            <? endforeach; ?>

                                        </select>

                                    </li><br>
                                    <li> انتخاب صندلی به تعداد:<br>
                                        <select></select>

                                    </li>                                </ul>
                            </div>
                            <div class="col_last">
                                <ul class="iconlist nobottommargin">
                                    <li></li> <form action="<?= RELA_DIR ?>zamin/?component=sales&action=addSales" method="POST" data-validate="form" role="form">
                                        <input type="hidden" name="action" value="login" />
                                        <input type="hidden" name="place" value="jaaaa" />
                                   <img  src="<?=RELA_DIR?>statics/test.jpg">
                                        <li></li>
                                        <div class="form-group form-actions">
                                            <input type="submit" class="btn btn-primary btn-default btn-block text-white text-16" value="خرید آنلاین">
                                        </div><!--/form-group-->


                                    </form>
                                </ul>
                            </div>
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

                    <h3>جزییات</h3>

                    <p class="font-size1 color-silver2"><?=$list['list']['brief_description']?></p>

                    <p><?=$list['list']['description']?></p>



                </div>







            </div>

        </div>

    </div>

</section><!-- #content end -->





