<!-- Page Sub Menu
		============================================= -->
<div id="page-menu">

    <div id="page-menu-wrap">

        <div class="container clearfix">

            <div class="menu-title"> Contact with <span>Various Artists</span> </div>



            <div id="page-submenu-trigger"><i class="icon-reorder"></i></div>

        </div>

    </div>

</div><!-- #page-menu end -->

<!-- Content
============================================= -->
<section id="content">

    <div class="content-wrap">

        <div class="container clearfix">

            <!-- Google Map
            ============================================= -->
            <div class="col-md-6 bottommargin">

                <form class="" action="" method="post" name="form1" id="form1" role="form" novalidate="novalidate" data-toggle="validator">
                    <input name="action" type="hidden" id="action" value="send">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12  pull-right">
                            <header class="text-center text-light mb">
                                Information Form
                            </header>

                            <br>
                            <?php
                            if($msg != '')
                            {
                                ?>
                                <div class="col xs-12 col-sm-12 col-md-12 ">
                                    <div class="alert alert-danger fade in "><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong><?=$msg?></strong></div></div>
                                <?
                            }
                            $msg = (strlen($messageStack->output('contactus')) ? $messageStack->output('contactus') : "");
                            if(isset($msg) && !empty($msg))
                            {
                                ?>
                                <div class="col xs-12 col-sm-12 col-md-12 ">

                                    <?php echo $msg; ?>

                                </div>
                                <?php
                            }
                            ?>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <input type="text" name="name" id="name" class="form-control rtl transition ltr" required data-error="لطفا نام خود را وارد نمایید"   placeholder="نام و نام خانوادگی"  value="<?php echo (isset($list) && strlen($list['list']['name']) ? $list['list']['name'] : "");?>" tabindex="1">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <input type="email" name="email" id="email" class="form-control  transition ltr" required data-error="لطفا آدرس پست الکترونیکی را وارد نمایید"   placeholder="Email"  value="<?php echo (isset($list) && strlen($list['list']['email']) ? $list['list']['email'] : "");?>" tabindex="1">
                                </div>
                            </div>
                            <div class="row xxxsmallSpace"></div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group company-list-keyboard-container">
                                    <input name="subject" id="subject" class="form-control  transition keyboard" type="text" data-error="لطفا موضوع را وارد نمایید"  placeholder="Subject"required value="<?php echo (isset($list) && strlen($list['list']['subject']) ? $list['list']['subject'] : "");?>" tabindex="2">

                                </div>
                            </div>
                            <div class="row xxxsmallSpace"></div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group company-list-keyboard-container company-list-keyboard-container-textarea ">
                                    <textarea name="comment" class="form-control  transition fullWidth keyboard" id="comment" cols="4" placeholder="Comment" tabindex="3"><?php echo (isset($list) && strlen($list['list']['comment']) ? $list['list']['comment'] : "");?></textarea>

                                </div>
                            </div>
                            <div class="row xxxsmallSpace"></div>
                            <div class="col-xs-12 col-sm-12 col-md-12 text-left mb">
                                <button type="submit" class=" center-block btn btn-default btn-login text-center text-ultralight text-white roundCorner transition" tabindex="4">
                                    Send
                                </button>
                            </div>
                        </div>

                    </div>
                </form>

            </div><!-- Google Map End -->

            <div class="col-md-6">

                <!-- Contact Info
                ============================================= -->
                <div class="col_two_fifth">
                    <div class="col-md-12">
                        <address>
                            <strong>Contact information:</strong><br>

                        </address>
                        <abbr title="Phone Number"><strong>Phone:</strong></abbr><br><span dir="ltr"> +98 (21) 22768101</span><br>
                        <abbr title="Email Address"><strong>Email:</strong></abbr><span dir="ltr"> info@variousartists.ir</span>
                        <abbr title="Email Address"><strong><img src="<?=TEMPLATE_DIR?>img/whatsapp.png" width="30"> WhatsApp:</strong></abbr><br><span dir="ltr">+98 (919) 3110190</span><br>
                        <abbr title="Email Address"><strong><img style="margin: 0 4px" src="<?=TEMPLATE_DIR?>img/telegram.png" width="20"> Telegram:</strong></abbr><br><span dir="ltr"><a href="https://telegram.me/VariousArtist"> https://telegram.me/VariousArtist </a></span>
                    </div>
                </div><!-- Contact Info End -->

                <!-- Testimonials
                ============================================= -->
                <div class="col_three_fifth col_last">

                    <div class="widget notoppadding noborder">
                        <div class="col-xs-12 col-sm-12 col-md-12 text-left noPadding  pull-left">


                            <? /*<div id="map" style="width:100%;height:250px"></div>

                            <script>
                                function myMap() {
                                    var mapCanvas = document.getElementById("map");
                                    var mapOptions = {
                                        center: new google.maps.LatLng(35.803369,51.4339609),
                                        zoom: 15,
                                        styles: [{"featureType":"all","elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#000000"},{"lightness":40}]},{"featureType":"all","elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#000000"},{"lightness":16}]},{"featureType":"all","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#000000"},{"lightness":20}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#000000"},{"lightness":17},{"weight":1.2}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":20}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":21}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#000000"},{"lightness":17}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#000000"},{"lightness":29},{"weight":0.2}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":18}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":16}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":19}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":17}]}]
                                    }
                                    var map = new google.maps.Map(mapCanvas, mapOptions);

                                    var marker = new google.maps.Marker({
                                        position: new google.maps.LatLng(35.803369,51.4339609),
                                        map: map,
                                        animation:google.maps.Animation.BOUNCE,
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
                            */?>
                            <?/*<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCIh9IvVEgJFsmTg0UcXLn8LDoPnz2CnRc&callback=initMap"
                                    async defer></script>*/?>


                            <?/*<div class="map  " >

                                <!--<iframe
                                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3235.4731620588063!2d51.41640450000003!3d35.812864999999995!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3f8e08a716c96309%3A0x997a8b0e7ef5c224!2sTehran%2C+Kooh+Peykar!5e0!3m2!1sen!2sir!4v1442735189471"
                                    width="100%" height="100" frameborder="0" allowfullscreen=""
                                    class="item-center roundCorner">
                                </iframe>-->

                            </div>*/?>
                        </div>

                    </div>

                </div><!-- Testimonial End -->

                <div class="clear"></div>



            </div>

        </div>

    </div>

</section><!-- #content end -->




<?/*<script src="<?php echo RELA_DIR.'templates/'.CURRENT_SKIN; ?>/assets/js/validator.min.js"></script>*/?>
<!-- owl carousel js -->
