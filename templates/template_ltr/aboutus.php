
<!-- separator -->
<!--<div class="or-spacer center-block">
    <div class="mask">
        <span class="text-center">درباره ما</span>
    </div>
</div>--><!-- /end of separator -->
<? $key = key($list['list']);?>
<section id="page-title" class="page-title-parallax page-title-dark page-title-right" style="padding: 250px 0px; background-image: url(<?=RELA_DIR?>templates/<?=CURRENT_SKIN?>/images/about/banner.jpg); background-size: cover; background-position: 50% -129.6px;" data-stellar-background-ratio="0.2">

    <div class="container clearfix" style="">
        <!--<h1>About us</h1>-->
        <span><?php echo (strlen($list['list'][$key]['text2']) ? $list['list'][$key]['text2'] : ""); ?></span>
    </div>

</section>

<section id="content" style="margin-bottom: 0px; display: none">

    <div class="content-wrap">

        <div class="container clearfix">

            <div class="row clearfix">

                <div class="col-md-12">

                    <h3><?php echo (strlen($list['list'][$key]['head1']) ? $list['list'][$key]['head1'] : ""); ?></h3>

                    <p><?php echo (strlen($list['list'][$key]['head1']) ? $list['list'][$key]['text1'] : ""); ?></p>

                </div>

                <div class="col-md-12">
                    <h3><?php echo (strlen($list['list'][$key]['head2']) ? $list['list'][$key]['head2'] : ""); ?></h3>

                    <p><?php echo (strlen($list['list'][$key]['head2']) ? $list['list'][$key]['text2'] : ""); ?></p>

                </div>

                <div class="col-md-12">
                    <h3><?php echo (strlen($list['list'][$key]['head3']) ? $list['list'][$key]['head3'] : ""); ?></h3>

                    <p><?php echo (strlen($list['list'][$key]['head3']) ? $list['list'][$key]['text3'] : ""); ?></p>

                </div>

            </div>

        </div>


    </div>

</section>


