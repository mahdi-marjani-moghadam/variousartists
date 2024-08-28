
<div class="col-md-12 col-xs-12 col-sm-12">
    <div class="col-md-10 col-md-offset-1 col-sm-12 col-xs-12" style="overflow: scroll">
        <form name="queue" id="queue" role="form" enctype="multipart/form-data" data-validate="form" class="form-horizontal form-bordered"  novalidate="novalidate" method="post">

            <div class="row">

                <div class="col-md-6 col-sm-12 col-xs-12">
                    <label for="artists_name_fa"><?php echo name_fa?></label>
                    <input type="text" id="artists_name_fa" name="artists_name_fa" value="<?php echo $list['artists_name_fa']?>" class="form-control" />
                </div>
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <label for="artists_name_en"><?php echo name_en?></label>
                    <input type="text" id="artists_name_en" name="artists_name_en" value="<?php echo $list['artists_name_en']?>" class="form-control" />
                </div>
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <label for="nickname"><?php echo 'Nick name'?></label>
                    <input type="text" id="nickname" name="nickname" value="<?php echo $list['nickname']?>" class="form-control" />
                </div>


                <div class="col-md-6 col-sm-12 col-xs-12">
                    <label for="artists_phone1"><?php echo telephone?></label>
                    <input type="text" id="artists_phone1" name="artists_phone1" value="<?php echo $list['artists_phone1']?>" class="form-control" />
                </div>
                <?php if($member_info['type'] == 1):?>
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <span class="pull-left"><input type="checkbox" name="show_birthday" id="show_birthday" <?php echo ($list['show_birthday']=='on')?'checked':'';?>><label for="check_birthday"> <?php echo show_birthday_for_public?></label></span>
                        <label for="birthday"><?php echo birthday?></label>
                        <input  type="date" id="birthday" name="birthday" value="<?php echo $list['birthday']?>" class="form-control " />
                    </div>

                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <label for="">گروه :</label>
                        <select name="category_id[]" id="category_id" data-input="select2"  multiple class="form-control">
                            <?php 
                            foreach($list['category'] as $category_id => $value)
                            {
                                ?>
                                <option  <?php echo (in_array($category_id, $list['category_id'])) ? 'selected' : '' ?> value="<?php echo $category_id?>">
                                    <?php echo $value['export']?>
                                </option>
                                <?php 
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <label for=""><?php echo genre?> </label>
                        <select name="genre_id[]" id="genre_id" data-input="select2"  multiple class="form-control">
                            <?php 
                            foreach($list['genre'] as $category_id => $value)
                            {
                                ?>
                                <option  <?php echo (in_array($category_id, $list['genre_id'])) ? 'selected' : '' ?> value="<?php echo $category_id?>">
                                    <?php echo $value['export']?>
                                </option>
                                <?php 
                            }
                            ?>
                        </select>
                    </div>
                <?php endif; ?>

                <div class="col-md-6 col-sm-12 col-xs-12">
                    <label for="email"><?php echo email?></label>
                    <input type="text" id="email" name="email" value="<?php echo $list['email']?>" class="form-control" />
                </div>
                <?php if($member_info['type'] == 1):?>
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <label for="instagram"><i class="icon icon-instagram2"></i><?php echo instagram?></label>
                        <input type="text" id="instagram" name="instagram" value="<?php echo $list['instagram']?>" class="form-control" />
                    </div>

                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <label for="site"><i class="icon icon-ie"></i><?php echo site?></label>
                        <input type="text" id="site" name="site" value="<?php echo $list['site']?>" class="form-control" />
                    </div>
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <label for="facebook"><i class="icon icon-facebook-sign"></i><?php echo facebook?></label>
                        <input type="text" id="facebook" name="facebook" value="<?php echo $list['facebook']?>" class="form-control" />
                    </div>
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <label for="soundcloud"><i class="icon icon-soundcloud"></i><?php echo sound_cloud?></label>
                        <input type="text" id="soundcloud" name="soundcloud" value="<?php echo $list['soundcloud']?>" class="form-control" />
                    </div>
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <label for="telegram"><i class="icon icon-email2"></i><?php echo telegram?></label>
                        <input type="text" id="telegram" name="telegram" value="<?php echo $list['telegram']?>" class="form-control" />
                    </div>
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <label   for="password"><?php echo password?></label>
                        <input type="password" autocomplete="off" class="form-control" name="password" id="password"  value="">
                        <?php echo edited_password_if_filling?>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-4 pull-right control-label rtl"
                                   for="description_fa"><?php echo description_fa?></label>
                            <div class="col-xs-12 col-sm-8 pull-right">
                                <?php

                                include_once ROOT_DIR.'common/ckeditor/ckeditor.php';
                                include_once ROOT_DIR.'common/ckfinder/ckfinder.php';
                                $ckeditor = new CKEditor();
                                $ckeditor->basePath = RELA_DIR.'common/ckeditor/';




                                $config['language'] = 'fa';
                                $config['filebrowserBrowseUrl'] = RELA_DIR.'common/ckfinder/ckfinder.html';
                                $config['filebrowserImageBrowseUrl'] = RELA_DIR.'common/ckfinder/ckfinder.html?type=Images';
                                $config['filebrowserUploadUrl'] = RELA_DIR.'common/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
                                $config['filebrowserImageUploadUrl'] = RELA_DIR.'common/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';

                                $tt = $ckeditor->editor('description_fa',$list['description_fa'],$config);

                                echo $tt;
                                ?>

                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-4 pull-right control-label rtl"
                                   for="description_en"><?php echo description_en?></label>
                            <div class="col-xs-12 col-sm-8 pull-right">
                                <?php

                                include_once ROOT_DIR.'common/ckeditor/ckeditor.php';
                                include_once ROOT_DIR.'common/ckfinder/ckfinder.php';
                                $ckeditor = new CKEditor();
                                $ckeditor->basePath = RELA_DIR.'common/ckeditor/';




                                $config['language'] = 'en';
                                $config['filebrowserBrowseUrl'] = RELA_DIR.'common/ckfinder/ckfinder.html';
                                $config['filebrowserImageBrowseUrl'] = RELA_DIR.'common/ckfinder/ckfinder.html?type=Images';
                                $config['filebrowserUploadUrl'] = RELA_DIR.'common/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
                                $config['filebrowserImageUploadUrl'] = RELA_DIR.'common/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';

                                $tt = $ckeditor->editor('description_en',$list['description_en'],$config);

                                echo $tt;
                                ?>

                            </div>
                        </div>
                    </div>


                    <div class="col-md-6 col-sm-12 col-xs-12 ">
                        <label for="logo"><?php echo image?></label>
                        <input type="file" name="logo" >
                        <img width="100" class="img-thumbnail" src="<?php echo RELA_DIR.'statics/files/'.$list['Artists_id'].'/'.$list['logo']?>" >
                        <br>
                    </div>
                <?php endif;?>


            </div>

            <div class="row">
                <div class="col-md-12">
                    <p class="pull-right">
                        <input name="action" type="hidden" id="action" value="edit" />
                        <input name="Artists_id" type="hidden" value="<?php echo $list['Artists_id']?>" />
                        <button type="submit" name="submit" id="submit" class="btn btn-icon btn-success rtl">
                            <i class="fa fa-plus"></i><?php echo edit?></button>
                    </p>
                </div>
            </div>

        </form>
    </div>
</div>