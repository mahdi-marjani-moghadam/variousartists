
                                <div class="col-md-12 col-xs-12 col-sm-12">
                                    <div class="col-md-10 col-md-offset-1 col-sm-12 col-xs-12" style="overflow: scroll">
                                        <form name="queue" id="queue" role="form" enctype="multipart/form-data" data-validate="form" class="form-horizontal form-bordered"  novalidate="novalidate" method="post">

                                            <div class="row">
                                                <div class="col-xs-12 col-sm-12 col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-xs-12 col-sm-4  control-label " for="title_fa"><?php echo title_fa?></label>
                                                        <div class="col-xs-12 col-sm-8 ">
                                                            <input type="text" class="form-control" name="title_fa" id="title_fa"  placeholder="  " required value="<?php echo $list['title_fa']?>">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xs-12 col-sm-12 col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-xs-12 col-sm-4  control-label " for="title_en"><?php echo title_en?></label>
                                                        <div class="col-xs-12 col-sm-8 ">
                                                            <input type="text" class="form-control" name="title_en" id="title_en"  placeholder="  " required value="<?php echo $list['title_en']?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12">
                                                    <div class="form-group">
                                                        <label class="col-xs-12 col-sm-12  " for="description_fa"><?php echo description_fa?></label>
                                                        <div class="col-xs-12 col-sm-12 ">

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
                                                        <label class="col-xs-12 col-sm-12  " for="description_en"><?php echo description_en?></label>
                                                        <div class="col-xs-12 col-sm-12 ">

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

                                                            $tt = $ckeditor->editor('description_en',$list['description_en'],$config);

                                                            echo $tt;
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="col-xs-12 col-sm-12 col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-xs-12 col-sm-4  control-label " for="xImagePath">Image:</label>
                                                        <div class="col-xs-12 col-sm-8 ">
                                                            <input type="file" name="image">

                                                            <img class="img-thumbnail" src="<?php echo RELA_DIR?>statics/blog/<?php echo $list['image']?>">

                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="col-xs-12 col-sm-12 col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-xs-12 col-sm-4  control-label " for="category_id">category_id:</label>
                                                        <div class="col-xs-12 col-sm-8 ">

                                                            <select name="category_id[]"  class="form-control" >
                                                                <?php 
                                                                foreach($list['category'] as $category_id => $value)
                                                                {
                                                                    ?>
                                                                    <option  <?php echo in_array($category_id,explode(",",$list['category_id']) ) ? 'selected' : '' ?> value="<?php echo $category_id?>">
                                                                        <?php echo $value['export']?>
                                                                    </option>
                                                                    <?php 
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="col-md-12">
                                                    <p class="">
                                                        <input name="action" type="hidden" id="action" value="edit" />
                                                        <input name="id" type="hidden" id="id" value="<?php echo $list['id']?>" />
                                                        <button type="submit" name="submit" id="submit" class="btn btn-icon btn-success ">
                                                            <i class="fa fa-plus"></i>
                                                            <?php echo edit?>
                                                        </button>
                                                    </p>
                                                </div>
                                            </div>

                                        </form>
                                    </div>
                                </div>