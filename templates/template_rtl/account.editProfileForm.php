
                                <div class="col-md-12 col-xs-12 col-sm-12">
                                    <div class="col-md-10 col-md-offset-1 col-sm-12 col-xs-12" style="overflow: scroll">
                                        <form name="queue" id="queue" role="form" enctype="multipart/form-data" data-validate="form" class="form-horizontal form-bordered"  novalidate="novalidate" method="post">

                                            <div class="row">



                                            <div class="col-md-6 col-sm-12 col-xs-12">
                                                <label for="artists_name_en">نام کامل(لاتین):</label>
                                                <input type="text" id="artists_name_en" name="artists_name_en" value="<?=$list['artists_name_en']?>" class="form-control" />
                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12">
                                                <label for="artists_name">گروه :</label>
                                                <select name="category_id[]" id="category_id" data-input="select2"  multiple class="form-control">
                                                    <?
                                                    foreach($list['category'] as $category_id => $value)
                                                    {
                                                        ?>
                                                        <option  <?php echo (in_array($category_id, $list['category_id'])) ? 'selected' : '' ?> value="<?=$category_id?>">
                                                            <?=$value['export']?>
                                                        </option>
                                                        <?
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                            <div class="col-md-6 col-sm-12 col-xs-12">
                                                <label for="artists_phone1">تلفن:</label>
                                                <input type="text" id="artists_phone1" name="artists_phone1" value="<?=$list['artists_phone1']?>" class="form-control" />
                                            </div>




                                            <div class="col-md-6 col-sm-12 col-xs-12">
                                                <label for="email">ایمیل:</label>
                                                <input type="text" id="email" name="email" value="<?=$list['email']?>" class="form-control" />
                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12">
                                                <label for="instagram"><i class="icon icon-instagram2"></i> اینستاگرام: </label>
                                                <input type="text" id="instagram" name="instagram" value="<?=$list['instagram']?>" class="form-control" />
                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12">
                                                <label for="site"><i class="icon icon-ie"></i>  سایت: </label>
                                                <input type="text" id="site" name="site" value="<?=$list['site']?>" class="form-control" />
                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12">
                                                <label for="facebook"><i class="icon icon-facebook-sign"></i> فیس بوک: </label>
                                                <input type="text" id="facebook" name="facebook" value="<?=$list['facebook']?>" class="form-control" />
                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12">
                                                <label for="soundcloud"><i class="icon icon-soundcloud"></i> ساند کلاد: </label>
                                                <input type="text" id="soundcloud" name="soundcloud" value="<?=$list['soundcloud']?>" class="form-control" />
                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12">
                                                <label for="telegram"><i class="icon icon-email2"></i>  تلگرام: </label>
                                                <input type="text" id="telegram" name="telegram" value="<?=$list['telegram']?>" class="form-control" />
                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12">
                                                <label for="description_fa">توضیحات(فارسی):</label>
                                                <textarea class="form-control" id="description_fa" name="description_fa"><?=$list['description_fa']?></textarea>

                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12 ">
                                                <label for="description_en">توضیحات(انگلیسی):</label>
                                                <textarea class="form-control" id="description_en" name="description_en"><?=$list['description_en']?></textarea>

                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12 ">
                                                <label for="logo">تصویر:</label>
                                                <input type="file" name="logo" >
                                                <img class="img-thumbnail" src="<?=RELA_DIR.'statics/files/'.$list['Artists_id'].'/'.$list['logo']?>" >
                                                <br>
                                            </div>


</div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <p class="pull-right">
                                                        <input name="action" type="hidden" id="action" value="edit" />
                                                        <input name="Artists_id" type="hidden" value="<?=$list['Artists_id']?>" />
                                                        <button type="submit" name="submit" id="submit" class="btn btn-icon btn-success rtl">
                                                            <i class="fa fa-plus"></i>
ویرایش
                                                        </button>
                                                    </p>
                                                </div>
                                            </div>

                                        </form>
                                    </div>
                                </div>