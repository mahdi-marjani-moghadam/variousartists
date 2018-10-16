<script type="text/javascript" src="../common/ckfinder/ckfinder.js"></script>

<script type="text/javascript">


    function BrowseServer( startupPath, functionData )
    {
        var finder = new CKFinder();
        finder.basePath = '../';
        finder.startupPath = startupPath;
        finder.selectActionFunction = SetFileField;
        finder.selectActionData = functionData;

        finder.popup();
    }

    function SetFileField( fileUrl, data )
    {
        document.getElementById( data["selectActionData"] ).value = fileUrl;
    }
    function ShowThumbnails( fileUrl, data )
    {
        // this = CKFinderAPI

        var sFileName = this.getSelectedFile().name;
        document.getElementById( 'thumbnails' ).innerHTML +=
            '<div class="thumb">' +
            '<img src="' + fileUrl + '" />' +
            '<div class="caption">' +
            '<a href="' + data["fileUrl"] + '" target="_blank">' + sFileName + '</a> (' + data["fileSize"] + 'KB)' +
            '</div>' +
            '</div>';

        document.getElementById( 'preview' ).style.display = "";
        // It is not required to return any value.
        // When false is returned, CKFinder will not close automatically.
        return false;
    }
    $(document).ready(function () {
        $('#check1').click(function () {

            if($(this).is(':checked')){
                $('.art').show();
            }
            else{
                $('.art').hide();
            }
        });
    });

</script>
<style> .art{display: none}</style>
<!-- Content
		============================================= -->
<section id="content" class="page-title-dark " style="  /* background-image: url(<?=RELA_DIR?>templates/<?=CURRENT_SKIN?>/img/login-bg.jpg);  background-position: 50% -129.6px;*/" data-stellar-background-ratio="0.2" >

    <div class="content-wrap">

        <div class="container clearfix">

            <div class="tabs divcenter nobottommargin clearfix" id="tab-login-register" data-active="<? if($PARAM[1]== 'register'){echo '2';}elseif($PARAM[1]== 'login'){echo 1;}elseif($PARAM[1]== 'memberregister'){echo 3;}?>" style="max-width: 500px; ">

                <div class="tab-container">
                    <div class="tab-content clearfix" id="tab-member" style="background: rgba(255,255,255,0.3)">
                        <div class="panel panel-default nobottommargin">
                            <div class="panel-body" style="padding: 40px;">
                                <? if($msg != ''): ?>

                                    <div id="alertMessage"><div class="alert alert-danger rtl"><?=$msg?></div></div>
                                <? endif;?>
                                <h3><?=create_new_account?></h3>
                                <form id="register-form" name="register-form" enctype="multipart/form-data" class="nobottommargin" action="<?=RELA_DIR?>login/memberregister" method="post">
                                    <div class="col_full">
                                        <label for="artists_phone1"><?=mobile?></label>
                                        <input type="text" id="artists_phone1" name="artists_phone1" value="<?=$_REQUEST['artists_phone1']?>" class="form-control" />
                                    </div>
                                    <div class="col_full">
                                        <label for="password"><?=password?></label>
                                        <input type="text" id="password" name="password" value="<?=$_REQUEST['password']?>" class="form-control" />
                                    </div>
                                    <div class="col_full">
                                        <label for="artists_name_fa"><?=name_fa?></label>
                                        <input type="text" id="artists_name_fa" name="artists_name_fa" value="<?=$_REQUEST['artists_name_fa']?>" class="form-control" />
                                    </div>

                                    <div class="col_full">
                                        <label for="check1"><input type="checkbox" id="check1" name="artists_name_fa" value="<?=$_REQUEST['artists_name_fa']?>"  /><?=are_you_artists_please_click_here?></label>
                                    </div>


                                    <div class="col_full art"  >
                                        <label for="email"><?=email?></label>
                                        <input type="text" id="email" name="email" value="<?=$_REQUEST['email']?>" class="form-control" />
                                    </div>
                                    <div class="col_full art">
                                        <label for="nickname">nick name:</label>
                                        <input type="text" id="nickname" name="nickname" value="<?=$_REQUEST['nickname']?>" class="form-control" />
                                    </div>
                                    <div class="col_full art">
                                        <label for="artists_name_en"><?=name_en?></label>
                                        <input type="text" id="artists_name_en" name="artists_name_en" value="<?=$_REQUEST['artists_name_en']?>" class="form-control" />
                                    </div>
                                    <div class="col_full art">
                                        <div ><?=birthday?>
                                            <span class="pull-left"><input type="checkbox" name="check_birthday" id="check_birthday"><label for="check_birthday"> <?=show_birthday_for_public?></label></span>
                                        </div>
                                        <input type="<?=($lang=='en')?'date':'';?>" autocomplete="false" id="birthday" name="birthday" value="<?=$_REQUEST['birthday']?>" class="form-control <?=($lang=='en')?'':'datepicker';?> " />
                                    </div>
                                    <div class="col_full art">
                                        <label for="artists_name"><?=category?></label>
                                        <select name="category_id[]" id="category_id" data-input="select2"  multiple class="form-control">
                                            <?
                                            foreach($list['category'] as $category_id => $value)
                                            {
                                                ?>
                                                <option  <?php echo $value['Category_id'] == $list['category_id'] ? 'selected' : '' ?> value="<?=$value['Category_id']?>">
                                                    <?=$value['export']?>
                                                </option>
                                                <?
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col_full art">
                                        <label for="genre"><?=genre?></label>
                                        <select name="genre_id[]" id="genre_id" data-input="select2"  multiple class="form-control">
                                            <?
                                            foreach($list['genre'] as $genre_id => $value)
                                            {
                                                ?>
                                                <option  <?php echo $value['Genre_id'] == $list['genre_id'] ? 'selected' : '' ?> value="<?=$value['Genre_id']?>">
                                                    <?=$value['export']?>
                                                </option>
                                                <?
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col_full art">
                                        <label for="site"><i class="icon icon-ie"></i>  <?=site?> </label>
                                        <input type="text"style="direction: ltr" id="site" name="site" value="<?=($_REQUEST['site'] =='')?'':$_REQUEST['site'];?>" placeholder="" class="form-control" />
                                    </div>
                                    <div class="col_full art">
                                        <label for="instagram"><i class="icon icon-instagram2"></i><?=instagram?> </label>
                                        <input type="text" id="instagram" style="direction: ltr" name="instagram" value="<?=($_REQUEST['instagram'] =='')?'':$_REQUEST['instagram'];?>" placeholder="" class="form-control" />
                                    </div>
                                    <div class="col_full art">
                                        <label for="soundcloud"><i class="icon icon-soundcloud"></i><?=sound_cloud?></label>
                                        <input type="text" id="soundcloud" style="direction: ltr" name="soundcloud"  value="<?=($_REQUEST['soundcloud'] =='')?'':$_REQUEST['soundcloud'];?>" placeholder=""  class="form-control" />
                                    </div>
                                    <div class="col_full art">
                                        <label for="beeptunes"><?=beeptunes?></label>
                                        <input type="text" id="beeptunes" style="direction: ltr" name="beeptunes"  value="<?=($_REQUEST['beeptunes'] =='')?'':$_REQUEST['beeptunes'];?>" placeholder=""      class="form-control" />
                                    </div>

                                    <div class="col_full art">
                                        <label for="facebook"><i class="icon icon-facebook-sign"></i><?=facebook?></label>
                                        <input type="text" id="facebook" name="facebook" value="<?=($_REQUEST['facebook'] =='')?'':$_REQUEST['facebook'];?>" placeholder="" class="form-control  " style="direction: ltr"  />
                                    </div>
                                    <div class="col_full art">
                                        <label for="telegram"><i class="icon icon-email2"></i><?=telegram?></label>
                                        <input type="text" style="direction: ltr"   id="telegram" name="telegram" value="<?=($_REQUEST['telegram'] =='')?'':$_REQUEST['telegram'];?>" placeholder="" class="form-control" />
                                    </div>
                                    <div class="col_full art">
                                        <label for="description_fa"><?=bio_fa?></label>
                                        <textarea class="form-control" id="description_fa" name="description_fa"><?=$_REQUEST['description_fa']?></textarea>

                                    </div>
                                    <div class="col_full art">
                                        <label for="description_en"><?=bio_en?></label>
                                        <textarea class="form-control" id="description_en" name="description_en"><?=$_REQUEST['description_en']?></textarea>

                                    </div>

                                    <div class="col_full" style="display: none">
                                        <label  for="city_id">محل تولد:</label>
                                        <div class="form-group">


                                            <select class="form-control" name="city_id" id="city_id" data-input="select2">

                                                <?
                                                foreach($list['provinces'] as $province_id => $value)
                                                {?>
                                                <option
                                                    <?= $value['province_id'] == $list['province_id'] ? 'selected' : '' ?>
                                                        value="<?= $value['province_id'] ?>">
                                                    <?= $value["name_$lang"] ?>
                                                    </option><?
                                                }
                                                ?>
                                            </select>

                                        </div>

                                    </div>

                                    <div class="col_full art">
                                        <label for="logo"><?=own_image?></label>
                                        <input type="file" class="form-control" style="font-size: 12px" id="logo" name="logo">
                                        <br>
                                        <?=picture_is_square_and_jpeg?>


                                    </div>




                                    <div class="col_full nobottommargin">
                                        <button class="button button-3d button-black nomargin" ><?=register?></button>
                                        <a class="pull-left" href="<?=RELA_DIR?>login"><?=login_by_account?></a>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>

</section><!-- #content end -->
