<div class="row width5 fullPadding">
<div class="col xs-12 col-sm-12 col-md-12">
    <!-- boxContainer -->
    <div class="boxContainer">
        <div class="row xsmallSpace"></div>
        <div id="bestProduct" class=" bestProduct whiteBg boxBorder roundCorner fullWidth mb">
            <header>
                <div class="center-block text-center">
                    تبلیغات
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
                                <a class="single" href="<?php echo RELA_DIR.'company/Detail/'.$value['Company_id'].'/'.$value['company_name'];?>">
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

        <div class="row">
            <!-- breadcrumb -->
            <div class="col-xs-12 col-sm-12 col-md-12 noPadding">
                <?php include_once("breadcrumb.php"); ?>
            </div>
            <!-- /end of breadcrumb -->
        </div>
        <div class="row">
            <!--  tab for cityList -->
            <div class="col-xs-12 col-sm-3 col-md-3 pull-right">
                <div class="search-box boxBorder categoryContainer">
                    <div class="search-box-header whiteBg">
                        <i class="fa fa-bars" aria-hidden="true"></i> <p>دسته بندی تولیدی ها</p>
                    </div>
                    <div class="mmenuHolder2 ">
                        <nav class="menu  mm-opened" data-placeholder="جستجو در دسته بندی تولیدی ها" data-title="دسته بندی تولیدی ها">
                            <?=$list['list']['searchCategoryUlLi'];?>
                        </nav>
                    </div>
                </div>
                <div class="search-box boxBorder">
                    <div class="search-box-header whiteBg ">
                        <i class="fa fa-map-marker"></i> <p>شهرها و استان ها</p>
                    </div>
                    <div class="mmenuHolder3">
                        <nav class="menu  mm-opened" data-placeholder="جستجو در شهرها و استان ها" data-title="دسته بندی شهرها و استان ها">
                            <ul>
                                <?php foreach ($list['list']['searchProvince'] as $key => $value) { ?>
                                    <?php if ($value['count'] > 0) { ?>
                                        <li>
                                            <a class="company-name">
                                                <span>(<?= $value['count'] ?>)</span>
                                                <?=$value['name'] ?>
                                                <input type="checkbox" name="province[]" id="province-<?= $value['province_id'] ?>" value="<?= $value['name'] ?>">
                                            </a>
                                            <ul>
                                                <? foreach ($value['cities'] as $city_id => $cityFields)
                                                { ?>
                                                <li>
                                                    <a class="company-name">
                                                        <span>(<?=$cityFields['count'] ?>)</span>
                                                        <label for="city-<?=$cityFields['City_id'] ?>" class="company-name">
                                                            <?= $cityFields['name'] ?>
                                                            <input type="checkbox" name="city[]" id="city-<?=$cityFields['City_id'] ?>" value="<?=$cityFields['name']
                                                            ?>">
                                                        </label>
                                                    </a>
                                                </li>
                                                <? } ?>
                                            </ul>
                                        </li>
                                    <?php } ?>
                                <?php } ?>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
            <!--  end tab for cityList -->

            <!--  tab for grid&list -->
            <div class="col-xs-12 col-sm-9 col-md-9 -pull-left">
                <?php if (isset($msg)) { ?>
                    <div class="whiteBg boxBorder roundCorner clear fullWidth">
                        <!-- separator -->
                        <div class="row xxsmallSpace"></div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                <div class="alert alert-warning"><strong>توجه! </strong><? echo $msg; ?> </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <!-- end tab
                               for grid&list -->
                <!--product filter-->
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <ul class="pull-right filter-container">
                            <?php if(is_array($list['list']['searchItem']['category'])){
                                if(count($list['list']['searchItem']['category']['list'])>1){ ?>
                            <li class="product-filter roundCorner boxBorder">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default dropdown-toggle btn-select " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        تولیدی<i class="fa fa-angle-down transition"></i>
                                    </button>
                                    <ul class="dropdown-menu searchType">
                                        <?php foreach ($list['list']['searchItem']['category']['list'] as $a => $b ){ ?>
                                        <li class="color-white">
                                                <span class="product-filter-container"><?=$list['list']['searchItem']['category']['list'][$a]['title']?>
                                                </span>
                                                <span class="close-filter-container">
                                                    <a href="#">
                                                        <i  class="fa" name="category[]" id="<?=$list['list']['searchItem']['category']['list'][$a]['Category_id']?>"  > </i>
                                                    </a>
                                                </span>
                                        </li>
                                                <?php }?>
                                            </ul>
                                        </div>
                                    </li>
                                <?php }else{
                                    foreach ($list['list']['searchItem']['category']['list'] as $a => $b ){ ?>
                                <li class="product-filter roundCorner boxBorder color-silver1">
                                    <span class="product-filter-container">
                                        <?=$list['list']['searchItem']['category']['list'][$a]['title'] ?>
                                    </span>
                                    <span class="close-filter-container">
                                        <a href="#">
                                            <i  class="fa" name="category[]"  id="<?=$list['list']['searchItem']['category']['list'][$a]['Category_id']?>"  > </i>
                                        </a>
                                    </span>
                                </li>
                                    <?php      }
                                }
                            } ?>
                        </ul>
                    </div>
                </div>

                <!--end of product filter-->
                <!-- showGrid and listView -->
                    <?php if (!isset($list['type']) || $list['type'] == 'تولیدی') { ?>
                        <?php foreach ($list['list']['company'] as $key => $value) { ?>
                    <div class="searchBox whiteBg boxBorder roundCorner fullWidth mb">
                        <a class="single" href="<?php echo RELA_DIR . 'company/Detail/' . $value['Company_id'] . '/' . $value['company_name']; ?>">

                        <header>
                                    <div class="text-right">
                                        <?php echo($value['company_name'] != "" ? $value['company_name'] : "-"); ?>
                                    </div>
                                </header>
                                <div class="content whiteBg  roundCorner fullWidth">
                                    <div class="item text-center">
                                            <div class="logoContainer pull-right">
                                                <img class="boxBorder" src="<?php echo (strlen($value['logo']) ? $value['logo'] : RELA_DIR . '/templates/' . CURRENT_SKIN . '/assets/images/placeholder.png'); ?>" alt="<?=$value['company_name'] ?>">
                                            </div>
                                            <div class="text pull-right">
                                                <p><?php echo($value['description'] != "" ? $value['description'] : "-"); ?>
                                                </p>
                                            </div>
                                            <div class="row Specifications">
                                                    <div class="col-xs-6 col-sm-4 col-md-4 pull-right boxA">
                                                        <p><b><i class="fa fa-envelope" aria-hidden="true"></i></b>
                                                         <span>
                                                             <?php echo($value['company_email']['email'][0] !="" ? $value['company_email']['email'][0] : "-"); ?>
                                                         </span>
                                                        </p>
                                                    </div>
                                                    <div class="col-xs-6 col-sm-4 col-md-4 pull-right boxA">
                                                        <p><b><i class="fa fa-internet-explorer" aria-hidden="true"></i></b>
                                                                <span>
                                                                    <?php echo($value['company_website']['url'][0] != "" ? $value['company_website']['url'][0] : "-"); ?>
                                                                </span>
                                                        </p>
                                                    </div>
                                                    <div class="col-xs-6 col-sm-4 col-md-4 pull-right boxA">
                                                        <p><b><i class="fa fa-phone-square" aria-hidden="true"></i></b>
                                                    <span> <?php echo($value['company_phone']['number'][0] != "" ? $value['company_phone']['number'][0] : "-"); ?>
                                                    </span>
                                                        </p>
                                                    </div>
                                                </div>
                                    </div>
                                </div>
                    </a>
                </div>

                        <?php } ?>
                    <?php } else { ?>
                        <?php foreach ($list['list']['company_products'] as $key => $value) { ?>
                            <div class="col-xs-6 col-sm-6 col-md-4 gridList BoxB boxSearch pull-right mt noPadding">
                                <div class="boxGrid-pane whiteBg boxBorder roundCorner">
                                    <div class="row margin-bottom">
                                        <div class="col-xs-12 col-sm-5 col-md-5 list1">
                                            <a href="<?php echo RELA_DIR . 'product/Detail/' . $value['Company_products_id'] . '/' . $value['title']; ?>">
                                               <img src="<?php $value['image'] ?>" alt="<?php $value['title'] ?>">
                                            </a>
                                        </div>
                                        <div class="col-xs-12 col-sm-7 col-md-7 list2 boxLeft">
                                            <a href="<?php echo RELA_DIR . 'product/Detail/' . $value['Company_products_id'] . '/' . $value['title']; ?>">
                                                <p><span> <i class="fa fa-sticky-note" aria-hidden="true"></i> <b>نامتولیدی:</b> </span><span><? echo($value['title'] != "" ? $value['title'] : "-"); ?></span>
                                                </p>
                                                <p><span> <i class="fa fa-file-text" aria-hidden="true"></i> <b>توضیحات:</b></span><span><? echo($value['description'] != "" ? $value['description'] : "-"); ?></span>
                                                </p>
                                            </a>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12 description1">
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-4 col-md-4">
                                                    <p><b><i class="fa fa-envelope" aria-hidden="true"></i></b> <b>ایمیل:</b>
                                                        <a href="mailto:<?php $value['company_email']['email'][0] ?>"><span><?php echo($value['company_email']['email'][0] !=
                                                                "" ? $value['company_email']['email'][0] : "-"); ?></span></a>
                                                    </p>
                                                </div>
                                                <div class="col-xs-12 col-sm-4 col-md-4">
                                                    <p><b><i class="fa fa-internet-explorer" aria-hidden="true"></i></b>
                                                        <b>آدرس اینترنتی:</b> <a
                                                            href="<?php $value['company_website']['url'][0] ?>"><span><?php echo($value['company_website']['url'][0] != "" ?
                                                                    $value['company_website']['url'][0] : "-"); ?> </span></a>
                                                    </p>
                                                </div>
                                                <div class="col-xs-12 col-sm-4 col-md-4">
                                                    <p><b><i class="fa fa-phone-square" aria-hidden="true"></i></b>
                                                        <b>شماره تلفن:</b>
                                                        <span><?php echo($value['company_phone']['number'][0] != "" ? $value['company_phone']['number'][0] : "-"); ?></span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <a href="<?php echo RELA_DIR . 'product/Detail/' . $value['Company_products_id'] . '/' . $value['title']; ?>"
                                   class="btn btn-link btnDetail transition roundCorner">نمایش</a></div>
                        <?php } ?>
                    <?php } ?>
                <!-- pagination -->
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 text-right">
                        <nav>
                                <div class="pull-right">
                                    <ul class="pagination">
                                        <?php
                                        foreach ($list['pagination']['company']['list'] as $href) {
                                            ?>
                                            <li
                                                <a class="transition <?php $href['activePage'] ?>"
                                                   href="<?php RELA_DIR . $href['address'] ?>"><?php $href['label'] ?>
                                                </a>
                                            </li>
                                            <?php
                                        }
                                        ?>
                                    </ul>
                                </div>
                                <div class="jPager pull-right boxBorder roundCorner whiteBg">
                                    <?php
                                        echo "تعداد صفحه :" . $list['pagination']['company']['pageCount'] . "<br>";
                                    ?>
                                </div>
                                <div class="jPager pull-right boxBorder roundCorner whiteBg">
                                    <?php
                                        echo "تعداد رکورد :" . $list['pagination']['company']['rowCount'] . "<br>";
                                    ?>
                                </div>
                        </nav>
                    </div>
                </div>
                <!-- /end of pagination -->
            </div>
        </div>
        <!--  end showGrid and listView -->
    </div>
    <div></div>

    <!-- separator -->
    <div class="row xxsmallSpace"></div>
    <!-- /end of boxContainer -->