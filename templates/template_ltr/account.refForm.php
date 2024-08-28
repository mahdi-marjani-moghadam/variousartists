<div id="" class="">
    <div class="panel-heading bg-white">
        <h3 class="panel-title rtl">دعوتنامه</h3>

    </div><!-- /panel-heading -->

    <?php if ($msg != null) { ?>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 alert alert-warning">
            <?php echo  $msg ?>
        </div>
    <?php
    }
    ?>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-9 col-md-offset-3 col-sm-12 col-xs-12 center-block">
                <form role="form" data-validate="form" class="" method="post">


                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label class="  control-label rtl" for="mobile">Mobile</label>
                                <div class=" ">
                                    <input placeholder="09121234567" type="text" class="form-control" name="mobile" id="mobile" required value="<?php echo  $list['mobile'] ?>">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <label class="  control-label rtl" > Message</label>
                            <p>
دوست عزیز شما توسط <?php echo $member_info['artists_name_fa'] ?> به سایت variousartist.ir دعوت شده اید. <br>
لطفا لینک زیر را بزنید و وارد سایت شوید.<br>
https://variousartist.ir/register/?ref=<?php echo $member_info['Artists_id'] ?></p>
                        </div>
                    </div>


                    <div class="row " style="padding-top: 1em;">
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <button type="submit" name="update" id="submit" class="btn btn-icon btn-success rtl">ارسال </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>