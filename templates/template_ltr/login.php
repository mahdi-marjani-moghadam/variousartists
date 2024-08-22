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

            <div class="tabs divcenter nobottommargin clearfix" id="tab-login-register" data-active="<? if($PARAM[1]== 'register'){echo '2';}elseif($PARAM[1]== 'login'){echo 1;}elseif($PARAM[1]== 'memberregister'){echo 3;}?>" style="max-width: 500px; ">


                <div class="tab-container">

                    <div class="tab-content clearfix" id="tab-login" style="background: rgba(255,255,255,0.2)">
                        <div class="panel panel-default nobottommargin">
                            <div class="panel-body" style="padding: 40px;">



                                <? if($msg2 != ''): ?>
                                    <?=$msg2?>
                                <? endif;?>
                                <? if($msg != ''): ?>

                                    <div id="alertMessage"><div class="alert alert-danger "><?=$msg?></div></div>
                                <? endif;?>
                                <form id="login-form" name="login-form" class="nobottommargin" action="<?=RELA_DIR?>login" method="post">
                                    <input type="hidden"  name="action" value="login">
                                    <h3><?=info_login?></h3>

                                    <div class="col_full">
                                        <label for="login-form-username"><?=number_or_email?></label>
                                        <input type="text" id="username" name="username" value="<?=$_REQUEST['username']?>" class="form-control" />
                                    </div>

                                    <div class="col_full">
                                        <label for="login-form-password"><?=password?></label>
                                        <input type="password" id="password" name="password" value="<?=$_REQUEST['password']?>" class="form-control" />
                                    </div>

                                    <div class="col_full nobottommargin">
                                        <button class="button button-3d button-black nomargin" id="login-form-submit" name="login-form-submit" value="login"><?=login?></button>
                                        <a href="<?=RELA_DIR?>register"><?=register?></a>
                                        <a  class="fright" style="" data-toggle="modal" data-target=".bs-example-modal-sm"><?=forgot_password?></a>

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

                                                            <label for="email"><?=email_or_number?></label>
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


                </div>

            </div>

        </div>

    </div>

</section><!-- #content end -->
