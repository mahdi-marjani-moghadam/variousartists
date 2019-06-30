<!-- Star Rating CSS -->
<link rel="stylesheet" href="<?=TEMPLATE_DIR?>css/components/bs-rating.css" type="text/css" />
<!-- Page Title
============================================= -->
<section id="page-title">

    <div class="container clearfix">
        <h1> <?=$blog['title_'.$lang];?>  </h1>
        <ol class="breadcrumb">
            <li><a href="<?=RELA_DIR?>blog"> وبلاگ</a></li>
            <li class="active"><?=$blog['title_'.$lang];?> </li>
        </ol>
    </div>

</section><!-- #page-title end -->

<!-- Content
============================================= -->
<section id="content">

    <div class="content-wrap">

        <div class="container clearfix">

            <!-- Portfolio Single Image
            ============================================= -->
            <div class="col artists_img nobottommargin text-center">
                <img src="<?=RELA_DIR.'statics/blog/'.$blog['image'];?>" alt="">
            </div><!-- .portfolio-single-image end -->

            <!-- Portfolio Single Content
            ============================================= -->
            <div class="col portfolio-single-content col_last nobottommargin">

                <!-- Portfolio Single - Description
                ============================================= -->

                <p ><?=$blog['description_'.$lang]?></p>

                <!-- Portfolio Single - Description End -->

                <div class="line"></div>
نویسنده:‌<?=$blog['artists_name']?><br>
تاریخ انتشار:‌<?=convertDate($blog['date'])?>

            </div><!-- .portfolio-single-content end -->

        </div>

    </div>

</section><!-- #content end -->




