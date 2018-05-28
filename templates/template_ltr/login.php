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
</script>
<!-- Content
		============================================= -->
<section id="content" class="page-title-dark " style="  /* background-image: url(<?=RELA_DIR?>templates/<?=CURRENT_SKIN?>/img/login-bg.jpg);  background-position: 50% -129.6px;*/" data-stellar-background-ratio="0.2" >

    <div class="content-wrap">

        <div class="container clearfix">

            <div class="tabs divcenter nobottommargin clearfix" id="tab-login-register" data-active="<?=($PARAM[1]== 'register')?'2':1;?>" style="max-width: 500px; ">

                <ul class="tab-nav tab-nav2 center clearfix">
                    <li class="inline-block "><a href="#tab-login">Login</a></li>
                    <li class="inline-block "><a href="#tab-register">Register</a></li>
                </ul>

                <div class="tab-container">

                    <div class="tab-content clearfix" id="tab-login" style="background: rgba(255,255,255,0.2)">
                        <div class="panel panel-default nobottommargin">
                            <div class="panel-body" style="padding: 40px;">



                                <? if($msg2 != ''): ?>
                                <?=$msg2?>
                                <? endif;?>
                                <? if($msg != ''): ?>

                                <div id="alertMessage"><div class="alert alert-danger rtl"><?=$msg?></div></div>
                                <? endif;?>
                                <form id="login-form" name="login-form" class="nobottommargin" action="<?=RELA_DIR?>login" method="post">
                                <input type="hidden"  name="action" value="login">
                                    <h3>Enter Information</h3>

                                    <div class="col_full">
                                        <label for="login-form-username">email: </label>
                                        <input type="text" id="username" name="username" value="<?=$_REQUEST['username']?>" class="form-control" />
                                    </div>

                                    <div class="col_full">
                                        <label for="login-form-password">Password: </label>
                                        <input type="password" id="password" name="password" value="<?=$_REQUEST['password']?>" class="form-control" />
                                    </div>

                                    <div class="col_full nobottommargin">
                                        <button class="button button-3d button-black nomargin" id="login-form-submit" name="login-form-submit" value="login">Login</button>
                                        <a  class="fright" style="" data-toggle="modal" data-target=".bs-example-modal-sm">Forgot password</a>

                                        <!-- Small modal -->

                                        <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">

                                            <div class="modal-dialog ">
                                                <div class="modal-body">
                                                    <div class="modal-content">

                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                <h4 class="modal-title" id="myModalLabel"><?=translate('Forgot pass')?></h4>
                                                            </div>
                                                            <div class="modal-body " >
                                                                <div id="loading" style="display: none;"><?=translate('Loading ...')?></div>
                                                                <div id="showMessage"></div>

                                                                <label for="email"><?=translate('Email')?></label>
                                                                <input id="forgotEmail" style="margin-bottom: 30px"  class="form-control">
                                                                <a id="forgot-pass" class="btn btn-info" ><?=translate('Send')?>  </a>

                                                            </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>




                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="tab-content clearfix" id="tab-register" style="background: rgba(255,255,255,0.3)">
                        <div class="panel panel-default nobottommargin">
                            <div class="panel-body" style="padding: 40px;">
                                <? if($msg != ''): ?>

                                    <div id="alertMessage"><div class="alert alert-danger rtl"><?=$msg?></div></div>
                                <? endif;?>
                                <h3>I`m new artist</h3>

                                <form id="register-form" name="register-form" enctype="multipart/form-data" class="nobottommargin" action="<?=RELA_DIR?>login/register" method="post">

                                    <div class="col_full">
                                        <label for="username">Email: </label>
                                        <input type="text" id="username" name="username" value="<?=$_REQUEST['username']?>" class="form-control" />
                                    </div>

                                    <div class="col_full">
                                        <label for="password">Password: </label>
                                        <input type="text" id="password" name="password" value="<?=$_REQUEST['password']?>" class="form-control" />
                                    </div>
                                    <div class="col_full">
                                        <label for="nickname">Nick name:</label>
                                        <input type="text" id="nickname" name="nickname" value="<?=$_REQUEST['nickname']?>" class="form-control" />
                                    </div>
                                    <div class="col_full">
                                        <label for="artists_name_fa">Name(persian):</label>
                                        <input type="text" id="artists_name_fa" name="artists_name_fa" value="<?=$_REQUEST['artists_name_fa']?>" class="form-control" />
                                    </div>
                                    <div class="col_full">
                                        <label for="artists_name_en">Name(english):</label>
                                        <input type="text" id="artists_name_en" name="artists_name_en" value="<?=$_REQUEST['artists_name_en']?>" class="form-control" />
                                    </div>
                                    <div class="col_full">
                                        <label for="birthday">Birthday:</label>
                                        <input type="text" id="birthday" name="birthday" value="<?=$_REQUEST['birthday']?>" class="form-control datepicker" />
                                    </div>
                                    <div class="col_full">
                                        <label for="artists_name">Category:</label>
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
                                    <div class="col_full">
                                        <label for="genre">Genre:</label>
                                        <input type="text" id="genre" name="genre" value="<?=$_REQUEST['genre']?>" class="form-control" />
                                    </div>
                                    <div class="col_full">
                                        <label for="artists_phone1">Phone:</label>
                                        <input type="text" id="artists_phone1" name="artists_phone1" value="<?=$_REQUEST['artists_phone1']?>" class="form-control" />
                                    </div>




                                    <!--<div class="col_full">
                                        <label for="email">Email:</label>
                                        <input type="text" id="email" name="email" required value="<?/*=$_REQUEST['email']*/?>" class="form-control" />
                                    </div>-->
                                    <div class="col_full">
                                        <label for="site"><i class="icon icon-ie"></i> Site address: </label>
                                        <input type="text"style="direction: ltr" id="site" name="site" value="<?=($_REQUEST['site'] =='')?'':$_REQUEST['site'];?>" class="form-control" />
                                    </div>
                                    <div class="col_full">
                                        <label for="instagram"><i class="icon icon-instagram2"></i>Instagram Id:</label>
                                        <input type="text" id="instagram" style="direction: ltr" name="instagram" value="<?=($_REQUEST['instagram'] =='')?'':$_REQUEST['instagram'];?>" class="form-control" />
                                    </div>
                                    <div class="col_full">
                                        <label for="soundcloud"><i class="icon icon-soundcloud"></i>Sound cloud Id:</label>
                                        <input type="text" id="soundcloud" style="direction: ltr" name="soundcloud"  value="<?=($_REQUEST['soundcloud'] =='')?'':$_REQUEST['soundcloud'];?>"  class="form-control" />
                                    </div>
                                    <div class="col_full">
                                        <label for="beeptunes">  Beeptunes Id: </label>
                                        <input type="text" id="beeptunes" style="direction: ltr" name="beeptunes"  value="<?=($_REQUEST['beeptunes'] =='')?'':$_REQUEST['beeptunes'];?>" placeholder=""      class="form-control" />
                                    </div>

                                    <div class="col_full">
                                        <label for="facebook"><i class="icon icon-facebook-sign"></i>Facebook Id:</label>
                                        <input type="text" id="facebook" name="facebook" value="<?=($_REQUEST['facebook'] =='')?'':$_REQUEST['facebook'];?>" class="form-control  " style="direction: ltr"  />
                                    </div>


                                    <div class="col_full">
                                        <label for="telegram"><i class="icon icon-email2"></i>Telegram Id:</label>
                                        <input type="text" style="direction: ltr"   id="telegram" name="telegram" value="<?=($_REQUEST['telegram'] =='')?'':$_REQUEST['telegram'];?>" class="form-control" />
                                    </div>
                                    <div class="col_full">
                                        <label for="description_fa">Biography (persian): </label>
                                        <textarea class="form-control" id="description_fa" name="description_fa"><?=$_REQUEST['description_fa']?></textarea>

                                    </div>
                                    <div class="col_full">
                                        <label for="description_en">Biography (english): </label>
                                        <textarea class="form-control" id="description_en" name="description_en"><?=$_REQUEST['description_en']?></textarea>

                                    </div>

                                    <div class="col_full">
                                        <label  for="city_id">City: </label>
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

                                    <div class="col_full">
                                        <label for="logo">Image:</label>
                                        <input type="file" class="form-control" style="font-size: 12px" id="logo" name="logo">
                                        <br>
                                        Square pic whit jpg format


                                    </div>




                                    <div class="col_full nobottommargin">
                                        <button class="button button-3d button-black nomargin" >Register</button>
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
