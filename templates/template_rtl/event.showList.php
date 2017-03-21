<link rel="stylesheet" href="<?=TEMPLATE_DIR?>css/calendar.css" type="text/css" />
<div class="parallax bottommargin-lg dark" style="padding: 60px 0; /*background-image: url('<?//=TEMPLATE_DIR?>img/calendar.jpg'); background-repeat: repeat-y;*/ height: auto;" data-stellar-background-ratio="0.3">

    <div class="container clearfix">
        <script type="text/javascript" src="<?=TEMPLATE_DIR?>js/jquery.js"></script>
        <script>

            $(document).ready(function() {

                $('#fullcalendar').fullCalendar({
                    defaultDate: '<?=date('Y-m-d');?>',
                    editable: true,
                    eventLimit: true, // allow "more" link when too many events
                    events:<?=$list['calendar']?>

                });

            });

        </script>
        <div id='fullcalendar'></div>

    </div>

</div>

<section id="content" style="display: none">

    <div class="content-wrap">

        <div class="container clearfix">



            <div class="fancy-title title-border">
                <h3>لیست رویداد ها</h3>
            </div>

        <div id="posts" class="events small-thumbs">
            <?
            if(count($list['list']) == 0 && isset($msg))
            {
                ?>
                <div class="whiteBg boxBorder roundCorner clear fullWidth ">
                    <!-- separator -->
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <div class="alert alert-warning">
                                <strong>توجه! </strong><? echo $msg;?>
                            </div>
                        </div>
                    </div>
                </div>
                <?
            }

            foreach($list['list'] as $k => $value)
            {
                $link = RELA_DIR . 'event/Detail/' . $value['Event_id'] . '/' . $value['event_name'];
                //'10-20-2016'
                $convertDate = explode('-',$value['date']);
                 $currentDate = $convertDate[1].'-'.$convertDate[2].'-'.$convertDate[0];
                $canvasEvents .= "'".$currentDate."':'<a href=\"$link\" target=_blank>".$value['event_name']."</a>',";
            ?>
            <div class="entry clearfix col-md-6 col-sm-6 col-xs-12">
                <div class="entry-image hidden-sm">
                    <a href="#">
                        <img src="<?php echo (strlen($value['logo']) ? RELA_DIR.'statics/event/'.$value['logo'] : TEMPLATE_DIR.'/assets/images/placeholder.png'); ?>" alt="Inventore voluptates velit totam ipsa tenetur">
                        <div class="entry-date">10<span>Apr</span></div>
                    </a>
                </div>
                <div class="entry-c">
                    <div class="entry-title">
                        <h2><a href="#"><?php echo($value['event_name'] != "" ? $value['event_name'] : "-"); ?></a></h2>
                        <?php echo($value['brief_description'] != "" ? $value['brief_description'] : ""); ?>
                    </div>
                    <ul class="entry-meta clearfix">
                        <li><span class="label label-default">Private</span></li>
                        <li><a href="#"><i class="icon-time"></i><?php echo($value['event_time'] != "" ? $value['event_time'] : "-"); ?></a></li>
                        <li><a href="#"><i class="icon-phone3"></i> <?php echo($value['event_phone'] != "" ? $value['event_phone'] : "-"); ?></a></li>
                        <li><a href="#"><i class="icon-map-marker2"></i> <?php echo($value['address'] != "" ? $value['address'] : "-"); ?></a></li>
                    </ul>
                    <div class="entry-content">
                        <a href="<?=$link?>" class="button button-reveal button-mini button-white button-light btn"><i class="icon-line-arrow-right"></i><span> جزییات</span></a>
                        <a href="#" class="button button-border button-mini button-black btn " disabled="disabled">خرید بلیط</a>

                    </div>
                </div>
            </div>
            <?php
            }

            if(count($list['pagination']))
            {
                ?>
                <ul class="pagination">
                    <li><a href="#">&laquo;</a></li>
                    <?
                    foreach($list['pagination'] as $key => $link)
                    {
                        if($key === 'current'){ continue;}
                        ?>
                        <li class="<?=(($key+1 == $list['pagination']['current']) || (empty($list['pagination']['current']) && $key == 0 ))?'active':'';?>" ><a href="<?=RELA_DIR.$link;?>"><?=$key+1?></a></li>
                        <?
                    }
                    ?>

                    <li><a href="#">&raquo;</a></li>
                </ul>


                <?php
            }
            ?>



        </div>

    </div>
        </div>
    </div>
</section>









