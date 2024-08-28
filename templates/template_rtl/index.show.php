
<!-- slider pro -->
<div class="row width5 mr">
    <div class="col-xs-12 col-sm-12 col-md-12 mainPage">
        <!-- slider container -->
        <div id="slider" class="slider-pro ltr pull-left boxBorder roundCorner noSelect">
            <div class="sp-slides roundCorner">
                <?php
                if(isset($list['banner_list']))
                {
                    foreach ($list['banner_list'] as $id => $fields)
                    {
                        ?>
                        <div class="sp-slide roundCorner">
                            <img class="sp-image roundCorner" src="<?php echo '/templates/' . CURRENT_SKIN; ?>/bower_components/slider-pro/src/css/images/blank.gif" data-src="<?php //echo RELA_DIR ?> <?php echo (strlen($fields['image'])) ? $fields['image']:  'templates/'.CURRENT_SKIN.'/assets/images/sliderImages/image2.jpg' ; ?> "/>
                            <h3 class="sp-layer sp-black sp-padding" data-horizontal="50" data-vertical="40%" data-show-transition="right" data-hide-transition="right" data-layer-init="true" style="visibility: visible;right: 50px;top: 40%;transform-origin: left top 0px;transform: scale(1) translate3d(0px, 0px, 0px);opacity: 1;">
                                <?php echo $fields['title'];?>
                            </h3>
                            <p class="sp-layer sp-black sp-padding hide-small-screen" data-horizontal="50" data-vertical="58%" data-width="650" data-show-transition="right" data-show-delay="400" data-hide-transition="right" data-hide-delay="500" data-layer-init="true" style="visibility: visible;width: 650px;right: 50px;top: 58%;transform-origin: left top 0px;transform: scale(1) translate3d(0px, 0px, 0px);opacity: 1;">
                                <?php echo $fields['brief_description'];?>
                            </p>
                        </div>
                        <?php 
                    }
                }
                ?>
            </div>
            <div class="sp-thumbnails">
                <?php
                if(isset($list['banner_list']))
                {
                    foreach ($list['banner_list'] as $id => $fields)
                    {
                        ?>
                        <div class="sp-thumbnail">
                            <div class="sp-thumbnail-title rtl text-right"><?php echo $fields['title']?></div>
                            <div class="sp-thumbnail-description rtl text-right text-ultralight <?php echo ((strlen($fields['brief_description'])>100)? "block-with-text" : "")?>"><?php echo $fields['brief_description']?></div>
                        </div>
                        <?php 
                    }
                }
                ?>
            </div>
        </div><!-- /end of slider container -->
        <?php include_once("categoryList.php"); ?>
        <!-- separator -->
    </div>
</div>

<!-- search container -->
<?php //include __DIR__.'/search.template.php'; ?>
<!-- separator -->
<div class="or-spacer center-block">
    <div class="mask"></div>
</div><!-- /end of separator -->

<!-- boxContainer -->
<div class="boxContainer">
    <div class="row width5 fullPadding">
        <div class="col-xs-12 col-sm-9 col-md-9 pull-right">
            <!-- /end of boxContainer -->
            <div id="bestProduct" class=" bestProduct whiteBg boxBorder roundCorner fullWidth">
                <header>
                    <div class="center-block text-center">
        تولیدکنندگان جدید
                    </div>
                </header>
                <div class="content content1 ltr">
                    <div class="slider-pro">
                        <div class="sp-slides">
                        <?php
                            foreach($list['company_list'] as $item => $value)
                        {
                            ?>
                            <div class="sp-slide">
                                <a class="single" href="<?php echo RELA_DIR.'company/Detail/'.$value['Company_id'].'/'.$value['company_name']; ?>">
                                    <div class="item text-center">
                                        <div class="logoContainer pull-right">
                                            <?php
                                            $file = ROOT_DIR.ltrim($value['logo'], '/');
                                            ?>
                                            <img src="<?php echo (strlen($value['logo'])  ? $value['logo'] : '/templates/'.CURRENT_SKIN.'/assets/images/placeholder.png'); ?>" class="boxBorder roundCorner" alt="<?php echo (strlen($value['title']) ? $value['title'] : '-'); ?>">
                                        </div>
                                        <div class="content pull-right">
                                            <header class="text-right">
                                                <?php echo (strlen($value['company_name']) ? $value['company_name'] : '-'); ?>
                                            </header>
                                            <footer>
                                                <p class="text-right text-justify block-with-text">
                                                    <?php echo (strlen($value['description']) ? $value['description'] : '-'); ?>
                                                </p>
                                            </footer>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php
                        }
                        ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- separator -->
            <div class="or-spacer center-block">
                <div class="mask"></div>
            </div><!-- /end of separator -->

            <!-- boxContainer -->
            <div class="bestProduct whiteBg boxBorder roundCorner fullWidth">
                <header>
                    <div class="center-block text-center">
                        حامیان ما
                    </div>
                </header>
                <div class="content content1 ltr">
                    <div class="slider-pro">
                      <div class="sp-slides">
                          <?php
                          if(isset($list['advertise_list']))
                          {
                          foreach($list['advertise_list'] as $id => $fields)
                          {

                              ?>
                              <div class="sp-slide">
                                  <div class="item text-center item-logo slidImg">
                                      <div class=" grayBg roundCorner text-white text-ultralight text-center center-block">
                                          <a href="<?php echo (strlen($fields['url']) ? $fields['url'] : "#"); ?>" target="_blank">
                                              <img width="100%" class="boxBorder roundCorner  center-block" src="<?php echo (strlen($fields['image']) ? $fields['image'] : 'templates/'.CURRENT_SKIN.'/assets/images/placeholder.png'); ?>" alt="<?php echo (strlen($fields['title']) ? $fields['title'] : "-"); ?>">
                                          </a>
                                      </div>
                                  </div>
                              </div>
                              <?php
                          }
                          }
                          ?>
                      </div>
                    </div>
                </div>
            </div>
            <!-- /end of boxContainer -->
        </div>
        <div class="col-xs-12 col-sm-3 col-md-3 pull-left newsColumn">
            <div id="newsContainer" class="newsContainer whiteBg boxBorder roundCorner fullWidth">
               <header>
                   <div class="center-block text-center">
                       <a class="pointer" href="<?php echo RELA_DIR; ?>news">اخبار تولیدات</a>
                       اخبار تولیدات
                   </div>
               </header>
                <div class="content ltr">
                    <div class="slider-pro">
                        <div class="sp-slides">
                            <?php
                            if(isset($list['news_list']))
                            {
                                foreach($list['news_list'] as $id => $field)
                                {
                                    ?>
                                    <div class="sp-slide">
                                        <a class="single" href="<?php echo  $field['link'] ?>">
                                        <div class="innerContent pull-left">
                                                <h2 class="text-right rtl text-light">
                                                    <?php echo (strlen($field['title']) ? $field['title'] : "") ?>
                                                </h2>
                                                <div class="logoContainer pull-right">
                                                    <img class="roundCorner fullWidth" src="<?php echo  $field['image'] ?>">
                                                </div>
                                                <article class="text-right text-light rtl"><?php echo (strlen($field['description']) ? $field['description'] : "") ?></article>
                                        </div>
                                        </a>
                                    </div>
                                <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /end of boxContainer -->

