<!-- Page Title
		============================================= -->
<section id="page-title">

    <div class="container clearfix">
        <h1><?php echo  $list['list']['event_name']; ?></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo  RELA_DIR ?>">خانه</a></li>
            <li><a href="<?php echo  RELA_DIR ?>event">رویدادها</a></li>
            <li class="active"><?php echo  $list['list']['event_name']; ?></li>
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
                        <img src="<?php echo(strlen($list['list']['logo']) ? RELA_DIR . 'statics/event/' . $list['list']['logo'] : RELA_DIR . 'templates/' . CURRENT_SKIN . '/assets/images/placeholder.png'); ?>"
                             alt="<?php echo  $list['list']['event_name']; ?>" title="<?php echo  $list['list']['event_name']; ?>">
                        <!--<div class="entry-overlay">
                            <span class="hidden-xs">Starts in: </span><div id="event-countdown" class="countdown"></div>
                        </div>-->
                    </div>
                </div>
                <div class="col_half col_last">
                    <div class="panel panel-default events-meta" id="changeNumber">
                        <div class="panel-heading">
                            <h3 class="panel-title">اطلاعات:<?php echo  $list['list']['event_name'] ?></h3>
                        </div>
                        <div class="panel-body">
                            <div class="col_full">
                                <?php global $messageStack;
                                $msg = $messageStack->output('message');
                                if($msg){ echo $msg; }?>
                                <ul class="iconlist nobottommargin">

                                    <?php
                                    $newDate = ($list['list']['date'] != "0000-00-00" ? convertDate($list['list']['date']) : "");
                                    $newDate2 = ($list['list']['date2'] != "0000-00-00" ? convertDate($list['list']['date2']) : "");
                                    $newDate3 = ($list['list']['date3'] != "0000-00-00" ? convertDate($list['list']['date3']) : "");
                                    $newTime = ($list['list']['event_time'] != "" ? $list['list']['event_time'] : "");
                                    $newTime2 = ($list['list']['event_time2'] != "" ? $list['list']['event_time2'] : "");
                                    $newTime3 = ($list['list']['event_time3'] != "" ? $list['list']['event_time3'] : "");
                                    $sale_type = ($list['list']['sale_type'] == 'class')?'ثبت نام کلاس':'خرید بلیط';
                                    ?>

                                    <?php if ($newTime || $newDate): ?>
                                        <li style="border-bottom: 1px dashed #dedede; padding-bottom: 10px"><i
                                                class="icon-calendar3"></i> <?php echo  $newDate ?> - <?php echo  $newTime ?>
                                        <?php if ($list['list']['salon_id'] != ""): ?>
                                            <?php 
                                            $enc = base64_encode('event_id='.$list['list']['Event_id'].'&date='.$list['list']['date'].'&time='.$list['list']['event_time']);
                                            ?>
                                            <a href="<?php echo  RELA_DIR ?>sales/<?php echo $enc?>"
                                               class="btn btn-primary btn-sm text-white text-16 "><?php echo $sale_type?></a>
                                        <?php endif; ?>

                                        </li><?php endif; ?>
                                    <?php if ($newTime2 || $newDate2): ?>
                                        <li style="border-bottom: 1px dashed #dedede; padding-bottom: 10px"><i
                                                class="icon-calendar3"></i> <?php echo  $newDate2 ?> - <?php echo  $newTime2 ?>
                                        <?php if ($list['list']['salon_id'] != ""): ?>
                                            <?php 
                                            $enc = base64_encode('event_id='.$list['list']['Event_id'].'&date='.$list['list']['date2'].'&time='.$list['list']['event_time2']);
                                            ?>
                                            <a href="<?php echo  RELA_DIR ?>sales/<?php echo $enc?>"
                                               class="btn btn-primary btn-sm text-white text-16 "><?php echo $sale_type?></a>
                                        <?php endif; ?>
                                        </li><?php endif; ?>
                                    <?php if ($newTime3 || $newDate3): ?>
                                        <li style="border-bottom: 1px dashed #dedede; padding-bottom: 10px"><i
                                                class="icon-calendar3"></i> <?php echo  $newDate3 ?> - <?php echo  $newTime3 ?>
                                        <?php if ($list['list']['salon_id'] != ""): ?>
                                            <?php 
                                            $enc = base64_encode('event_id='.$list['list']['Event_id'].'&date='.$list['list']['date3'].'&time='.$list['list']['event_time3']);
                                            ?>
                                            <a href="<?php echo  RELA_DIR ?>sales/<?php echo $enc?>"
                                               class="btn btn-primary btn-sm text-white text-16 "><?php echo $sale_type?></a>
                                        <?php endif; ?>
                                        </li><?php endif; ?>
                                    <li>
                                        <i class="icon-phone-sign"></i> <?php echo  ($list['list']['event_phone'] != "" ? $list['list']['event_phone'] : "-") ?>
                                    </li>




                                    <?php if ($list['list']['organizer'] != ""): ?>
                                        <li><i class="icon-user"></i>
                                        <strong><?php echo  $list['list']['organizer']; ?></strong></li><?php endif; ?>
                                    <?php if ($list['list']["country"] != ""): ?>
                                        <li><i class="icon-pinboard"></i>
                                        <strong><?php echo  $list['list']["country"]; ?></strong></li><?php endif; ?>
                                    <?php if ($list['list']["address"] != ""): ?>
                                        <li><i class="icon-pinboard"></i>
                                        <strong><?php echo  $list['list']["address"]; ?></strong></li><?php endif; ?>
                                </ul>
                            </div>
                            <?php if ($list['list']['salon_id'] != ""): ?>
                                <div class="col_last">
                                    <form action="<?php echo  RELA_DIR ?>sales" method="POST" data-validate="form" role="form"
                                          style="display: none">
                                        <input type="hidden" name="action" value="login"/>

                                        <input type="hidden" name="place"
                                               value="<?php echo  $list['salon_list']['Salon_id'] ?>"/>
                                        <input type="hidden" name="event_name"
                                               value="<?php echo  $list['list']['event_name']; ?>"/>
                                        <input type="hidden" name="event_id" value="<?php echo  $list['list']['Event_id']; ?>"/>

                                        <select name="time">
                                            <?php if ($newTime || $newDate): ?>
                                                <option value="<?php echo  $list['list']['date']; ?> "><?php echo  $newDate ?>
                                                - <?php echo  $newTime ?></option><?php endif; ?>
                                            <?php if ($newTime2 || $newDate2): ?>
                                                <option value="<?php echo  $list['list']['date2']; ?> "><?php echo  $newDate2 ?>
                                                - <?php echo  $newTime2 ?></option><?php endif; ?>
                                            <?php if ($newTime3 || $newDate3): ?>
                                                <option value="<?php echo  $list['list']['date3']; ?> "><?php echo  $newDate3 ?>
                                                - <?php echo  $newTime3 ?></option><?php endif; ?>
                                        </select>
                                        <div class="form-group form-actions">
                                            <input type="submit"
                                                   class="btn btn-primary btn-default btn-block text-white text-16"
                                                   value="خرید آنلاین">
                                        </div><!--/form-group-->
                                    </form>


                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <!--<a href="#" class="btn btn-success btn-block btn-lg">Buy Tickets</a>-->


                    <div class="col_full nobottommargin">
                        <?php if (count($list['event_gallery'])): ?>
                            <h4>تصاویر</h4>

                            <!-- Events Single Gallery Thumbs
                            ============================================= -->
                            <div class="masonry-thumbs col-4" data-lightbox="gallery">
                                <?php foreach ($list['event_gallery'] as $image_id => $imageDetail): ?>

                                    <a href="<?php echo  RELA_DIR . 'statics/event/' . $imageDetail['image'] ?>"
                                       data-lightbox="gallery-item">
                                        <img class="image_fade"
                                             src="<?php echo  RELA_DIR . 'statics/event/' . $imageDetail['image'] ?>"
                                             alt="<?php echo  $list['list']['event_name']; ?>"></a>
                                <?php endforeach; ?>

                            </div><!-- Event Single Gallery Thumbs End -->
                        <?php endif; ?>

                    </div>
                    
                </div>

                <div class="clear"></div>

                <div class="col_full">

                    <h3>جزییات</h3>

                    <p class="font-size1 color-silver2"><?php echo  $list['list']['brief_description'] ?></p>

                    <p><?php echo  $list['list']['description'] ?></p>


                </div>


            </div>

        </div>

    </div>

</section><!-- #content end -->





