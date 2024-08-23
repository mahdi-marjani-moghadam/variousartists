<!-- Page Title
		============================================= -->
<section id="page-title">

    <div class="container clearfix">
        <h1><?= $list['list']['event_name']; ?></h1>
        <ol class="breadcrumb">
            <li><a href="<?= RELA_DIR ?>">Home</a></li>
            <li><a href="<?= RELA_DIR ?>event">Events</a></li>
            <li class="active"><?= $list['list']['event_name']; ?></li>
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
                             alt="<?= $list['list']['event_name']; ?>" title="<?= $list['list']['event_name']; ?>">
                        <!--<div class="entry-overlay">
                            <span class="hidden-xs">Starts in: </span><div id="event-countdown" class="countdown"></div>
                        </div>-->
                    </div>
                </div>
                <div class="col_half col_last">
                    <div class="panel panel-default events-meta" id="changeNumber">
                        <div class="panel-heading">
                            <h3 class="panel-title">Info:<?= $list['list']['event_name'] ?></h3>
                        </div>
                        <div class="panel-body">
                            <div class="col_full">
                                <? global $messageStack;
                                $msg = $messageStack->output('message');
                                if($msg){ echo $msg; }?>
                                <ul class="iconlist nobottommargin">

                                    <?php
                                    $newDate = ($list['list']['date'] != "0000-00-00" ? ($list['list']['date']) : "");
                                    $newDate2 = ($list['list']['date2'] != "0000-00-00" ? ($list['list']['date2']) : "");
                                    $newDate3 = ($list['list']['date3'] != "0000-00-00" ? ($list['list']['date3']) : "");
                                    $newTime = ($list['list']['event_time'] != "" ? $list['list']['event_time'] : "");
                                    $newTime2 = ($list['list']['event_time2'] != "" ? $list['list']['event_time2'] : "");
                                    $newTime3 = ($list['list']['event_time3'] != "" ? $list['list']['event_time3'] : "");
                                    $sale_type = ($list['list']['sale_type'] == 'class')?class_register:buy_ticket;
                                    ?>

                                    <? if ($newTime || $newDate): ?>
                                        <li style="border-bottom: 1px dashed #dedede; padding-bottom: 10px"><i
                                                class="icon-calendar3"></i> <?= $newDate ?> - <?= $newTime ?>
                                        <? if ($list['list']['salon_id'] != ""): ?>
                                            <?
                                            $enc = base64_encode('event_id='.$list['list']['Event_id'].'&date='.$list['list']['date'].'&time='.$list['list']['event_time']);
                                            ?>
                                            <a href="<?= RELA_DIR ?>sales/<?=$enc?>"
                                               class="btn btn-primary btn-sm text-white text-16 "><?=$sale_type?></a>
                                        <? endif; ?>

                                        </li><? endif; ?>
                                    <? if ($newTime2 || $newDate2): ?>
                                        <li style="border-bottom: 1px dashed #dedede; padding-bottom: 10px"><i
                                                class="icon-calendar3"></i> <?= $newDate2 ?> - <?= $newTime2 ?>
                                        <? if ($list['list']['salon_id'] != ""): ?>
                                            <?
                                            $enc = base64_encode('event_id='.$list['list']['Event_id'].'&date='.$list['list']['date2'].'&time='.$list['list']['event_time2']);
                                            ?>
                                            <a href="<?= RELA_DIR ?>sales/<?=$enc?>"
                                               class="btn btn-primary btn-sm text-white text-16 "><?=$sale_type?></a>
                                        <? endif; ?>
                                        </li><? endif; ?>
                                    <? if ($newTime3 || $newDate3): ?>
                                        <li style="border-bottom: 1px dashed #dedede; padding-bottom: 10px"><i
                                                class="icon-calendar3"></i> <?= $newDate3 ?> - <?= $newTime3 ?>
                                        <? if ($list['list']['salon_id'] != ""): ?>
                                            <?
                                            $enc = base64_encode('event_id='.$list['list']['Event_id'].'&date='.$list['list']['date3'].'&time='.$list['list']['event_time3']);
                                            ?>
                                            <a href="<?= RELA_DIR ?>sales/<?=$enc?>"
                                               class="btn btn-primary btn-sm text-white text-16 "><?=$sale_type?></a>
                                        <? endif; ?>
                                        </li><? endif; ?>
                                    <li>
                                        <i class="icon-phone-sign"></i> <?= ($list['list']['event_phone'] != "" ? $list['list']['event_phone'] : "-") ?>
                                    </li>




                                    <? if ($list['list']['organizer'] != ""): ?>
                                        <li><i class="icon-user"></i>
                                        <strong><?= $list['list']['organizer']; ?></strong></li><? endif; ?>
                                    <? if ($list['list']["country"] != ""): ?>
                                        <li><i class="icon-pinboard"></i>
                                        <strong><?= $list['list']["country"]; ?></strong></li><? endif; ?>
                                    <? if ($list['list']["address"] != ""): ?>
                                        <li><i class="icon-pinboard"></i>
                                        <strong><?= $list['list']["address"]; ?></strong></li><? endif; ?>
                                </ul>
                            </div>
                            <? if ($list['list']['salon_id'] != ""): ?>
                                <div class="col_last">
                                    <form action="<?= RELA_DIR ?>sales" method="POST" data-validate="form" role="form"
                                          style="display: none">
                                        <input type="hidden" name="action" value="login"/>

                                        <input type="hidden" name="place"
                                               value="<?= $list['salon_list']['Salon_id'] ?>"/>
                                        <input type="hidden" name="event_name"
                                               value="<?= $list['list']['event_name']; ?>"/>
                                        <input type="hidden" name="event_id" value="<?= $list['list']['Event_id']; ?>"/>

                                        <select name="time">
                                            <? if ($newTime || $newDate): ?>
                                                <option value="<?= $list['list']['date']; ?> "><?= $newDate ?>
                                                - <?= $newTime ?></option><? endif; ?>
                                            <? if ($newTime2 || $newDate2): ?>
                                                <option value="<?= $list['list']['date2']; ?> "><?= $newDate2 ?>
                                                - <?= $newTime2 ?></option><? endif; ?>
                                            <? if ($newTime3 || $newDate3): ?>
                                                <option value="<?= $list['list']['date3']; ?> "><?= $newDate3 ?>
                                                - <?= $newTime3 ?></option><? endif; ?>
                                        </select>
                                        <div class="form-group form-actions">
                                            <input type="submit"
                                                   class="btn btn-primary btn-default btn-block text-white text-16"
                                                   value="خرید آنلاین">
                                        </div><!--/form-group-->
                                    </form>


                                </div>
                            <? endif; ?>
                        </div>
                    </div>
                    <!--<a href="#" class="btn btn-success btn-block btn-lg">Buy Tickets</a>-->


                    <div class="col_full nobottommargin">
                        <? if (count($list['event_gallery'])): ?>
                            <h4>تصاویر</h4>

                            <!-- Events Single Gallery Thumbs
                            ============================================= -->
                            <div class="masonry-thumbs col-4" data-lightbox="gallery">
                                <? foreach ($list['event_gallery'] as $image_id => $imageDetail): ?>

                                    <a href="<?= RELA_DIR . 'statics/event/' . $imageDetail['image'] ?>"
                                       data-lightbox="gallery-item">
                                        <img class="image_fade"
                                             src="<?= RELA_DIR . 'statics/event/' . $imageDetail['image'] ?>"
                                             alt="<?= $list['list']['event_name']; ?>"></a>
                                <? endforeach; ?>

                            </div><!-- Event Single Gallery Thumbs End -->
                        <? endif; ?>

                    </div>

                </div>

                <div class="clear"></div>

                <div class="col_full">

                    <h3>Detail:</h3>

                    <p class="font-size1 color-silver2"><?= $list['list']['brief_description'] ?></p>

                    <p><?= $list['list']['description'] ?></p>


                </div>


            </div>

        </div>

    </div>

</section><!-- #content end -->





