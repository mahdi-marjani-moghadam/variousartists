<!-- Page Title
		============================================= -->

<section id="page-title">

    <div class="container clearfix">
        <h1><?=$list['event']['event_name'];?></h1>

    </div>

</section><!-- #page-title end -->

<!-- Content
		============================================= -->
<section id="content">

    <div class="content-wrap">

        <div class="container clearfix">

            <div class="single-event col-md-8 col-md-offset-2">

                    <div class="panel panel-default events-meta" id="changeNumber">
                        <div class="panel-heading" style="padding: 10px">
                            <h3 class="panel-title" >
                                <span class="hidden-xs" style=" padding: 5px 10px; border-right: 1px solid silver;"> <a href="<?=$list['backUrl']?>"><span class="badge">1</span>  Choose Date and hour </a></span>
                                <span style=" padding: 5px 10px;  background: #fff; "> <span class="badge">2</span> Choose part</span>
                                <span class="hidden-xs" style=" padding: 5px 10px; border-left: 1px solid silver; border-right: 1px solid silver "> <span class="badge">3</span> Choose chair</span>
                                <span class="hidden-xs" style=" padding: 5px 10px; "> <span class="badge">4</span> Order</span>
                            </h3>

                        </div>


                        <div class="panel-body">

                            <? global $messageStack;
                            $msg = $messageStack->output('message');
                            if($msg){ echo $msg; }?>
                            <div class="col_half">


                                <ul class="iconlist nobottommargin">
                                    <li><i class="icon-calendar3"></i> Date:    <?=($list['get']['date']).' -  '.$list['get']['time']?> </li>
                                    <br>
                                    <li><i class="icon-map-marker2"></i>  Place :    <?=$list['salon']['address_en']?>,<?=$list['salon']['title_en']?></li>
                                    <br>
                                </ul>



                                <?php  foreach ($list['position'] as $k => $position): ?>

                                    <a  href="<?=$position['nextUrl']?>" class="btn btn-warning" value="<?=$salon["Salon_id"]?>"><?=$position["title"]?> <?=$position["price"]?> Rial</a>

                                <? endforeach; ?>
                            </div>
                            <div class="col_last col_half">
                                <ul class="iconlist nobottommargin">
                                    <li></li>

                                        <input type="hidden" name="action" value="step3" />
                                        <input type="hidden" name="place" value="<?=$salon["parent_id"]?>" />
                                    <input type="hidden" name="event_time" value="<?=$list['list']['event_time']?>" />
                                    <input type="hidden" name="Event_id" value="<?=$list['list']['Event_id']?>" />

                                        <img  src="<?=RELA_DIR?>statics/salon/<?=$list['salon']['image']?>">

                                </ul>

                    </div>
                        </form>
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
                </div>






            </div>

        </div>

    </div>

</section><!-- #content end -->





