<section id="page-title" class="page-title-parallax page-title-dark page-title-right" style="padding: 250px 0px; background-image: url(<?php echo RELA_DIR?>templates/<?php echo CURRENT_SKIN?>/images/about/banner.jpg); background-size: cover; background-position: 50% -129.6px;" data-stellar-background-ratio="0.2">

    <div class="container clearfix">
        <h1> خدمات</h1>
        <span>VA & Founder</span>
    </div>

</section>




<div class="section nomargin nopadding">
    <div class="container clearfix ">

        <div class="row topmargin-lg bottommargin-sm">

            <div class="heading-block center">
                <h2>خدمات موزیک</h2>
                <span class="divcenter">توضیح خدماتی که می توان برا موزی انجام داد. توضیح خدماتی که می توان برا موزی انجام داد.</span>
            </div>
            <?php $key = key($list['list']);?>
            <div class="col-md-4 col-sm-6 bottommargin">

                <div class="feature-box fbox-right topmargin" data-animate="fadeIn">
                    <div class="fbox-icon">
                        <a href="#"><i class="icon-line-heart"></i></a>
                    </div>
                    <h3><?php echo (strlen($list['list'][$key]['head1']) ? $list['list'][$key]['head1'] : ""); ?></h3>
                    <p><?php echo (strlen($list['list'][$key]['text2']) ? $list['list'][$key]['text1'] : ""); ?></p>
                </div>

                <div class="feature-box fbox-right topmargin" data-animate="fadeIn" data-delay="200">
                    <div class="fbox-icon">
                        <a href="#"><i class="icon-line-paper"></i></a>
                    </div>
                    <h3><?php echo (strlen($list['list'][$key]['head2']) ? $list['list'][$key]['head2'] : ""); ?></h3>
                    <p><?php echo (strlen($list['list'][$key]['text2']) ? $list['list'][$key]['text2'] : ""); ?></p>
                </div>



            </div>

            <div class="col-md-4 hidden-sm bottommargin center">
                <img src="<?php echo TEMPLATE_DIR?>img/iphone7.png" alt="iphone 2">
            </div>

            <div class="col-md-4 col-sm-6 bottommargin">

                <div class="feature-box topmargin" data-animate="fadeIn">
                    <div class="fbox-icon">
                        <a href="#"><i class="icon-line-power"></i></a>
                    </div>
                    <h3><?php echo (strlen($list['list'][$key]['head3']) ? $list['list'][$key]['head3'] : ""); ?></h3>
                    <p><?php echo (strlen($list['list'][$key]['text3']) ? $list['list'][$key]['text3'] : ""); ?></p>
                </div>

                <div class="feature-box topmargin" data-animate="fadeIn" data-delay="200">
                    <div class="fbox-icon">
                        <a href="#"><i class="icon-line-check"></i></a>
                    </div>
                    <h3><?php echo (strlen($list['list'][$key]['head4']) ? $list['list'][$key]['head4'] : ""); ?></h3>
                    <p><?php echo (strlen($list['list'][$key]['text4']) ? $list['list'][$key]['text4'] : ""); ?></p>
                </div>


            </div>

        </div>

    </div>
</div>



