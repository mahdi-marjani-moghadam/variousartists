<section id="content" class="page-title-dark "  data-stellar-background-ratio="0.2" >

<div class="content-wrap">

    <div class="container clearfix">



        <div class="col-md-12 col-xs-12 col-sm-12">

                                    <div class="col-md-6 col-md-offset-3 col-sm-12 col-xs-12" style="overflow: scroll">
                                        <h2>لطفا پسورد جدید خود را وارد نمایید</h2>

                                        <?php if($msg != ''){?>
                                        <div class="alert alert-danger">
                                        <?php echo $msg ?>
                                        </div>
                                        <?php }?>
                                        <form name="queue" id="queue"  action="<?php echo RELA_DIR?>login/changePassSubmit"  role="form" data-validate="form" class="form-horizontal form-bordered"  novalidate="novalidate" method="post">

                                            <div class="row">
                                                <div class="col-xs-12 col-sm-12 col-md-12">
                                                    <div class="form-group">
                                                        <label class="col-xs-12 col-sm-4 pull-right control-label rtl" for="pass">پسورد جدید:</label>
                                                        <div class="col-xs-12 col-sm-8 pull-right">
                                                            <input type="password" class="form-control" name="pass" id="pass" required >
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12">
                                                    <div class="form-group">
                                                        <label class="col-xs-12 col-sm-4 pull-right control-label rtl" for="pass_confirm">تکرار پسورد:</label>
                                                        <div class="col-xs-12 col-sm-8 pull-right">
                                                            <input type="password" class="form-control" name="pass_confirm" id="pass_confirm"  required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>




                                                <div class="row">
                                                <div class="col-md-12">
                                                    <p class="center">
                                                        <input name="email" type="hidden" value="<?php echo $list['email']?>" />
                                                        <input name="code" type="hidden"  value="<?php echo $list['code']?>" />
                                                        <button type="submit" name="submit" id="submit" class="btn btn-icon btn-block btn-success rtl">
                                                            <i class="fa fa-plus"></i>
                                                            تایید
                                                        </button>
                                                    </p>
                                                </div>
                                            </div>

                                        </form>
                                    </div>
                                </div>
    </div>
</div>
</section>