<div class="col-md-12 col-xs-12 col-sm-12">
    <div class="col-md-10 col-md-offset-1 col-sm-12 col-xs-12" style="overflow: scroll">
        <form name="queue" id="queue" enctype="multipart/form-data" role="form" data-validate="form" class="form-horizontal form-bordered" novalidate="novalidate" method="post">

            <div class="row">
                <? if ($msg != '') : ?>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="alert alert-danger"><?= $msg ?></div>
                    </div>
                <? endif; ?>

                <div class="col-xs-12 col-sm-12 col-md-6">
                    <div class="form-group">
                        <label class="col-xs-12 col-sm-4 pull-right control-label rtl" for="title_fa"><?= title_fa ?></label>
                        <div class="col-xs-12 col-sm-8 pull-right">
                            <input type="text" class="form-control" name="title_fa" id="title_fa" placeholder=" " required value="<?= $list['title_fa'] ?>">
                        </div>
                    </div>
                </div>


                <div class="col-xs-12 col-sm-12 col-md-6">
                    <div class="form-group">
                        <label class="col-xs-12 col-sm-4 pull-right control-label rtl" for="title_en"><?= title_en ?></label>
                        <div class="col-xs-12 col-sm-8 pull-right">
                            <input type="text" class="form-control" name="title_en" id="title_en" placeholder="  " required value="<?= $list['title_en'] ?>">
                        </div>
                    </div>
                </div>



                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <label class="col-xs-12 col-sm-12  rtl" for="description_fa"><?= description_fa ?></label>
                        <div class="col-xs-12 col-sm-12 ">

                            <script src="<?= RELA_DIR ?>common/ckeditor4/ckeditor.js"></script>
                            <script src="<?= RELA_DIR ?>common/ckeditor4/samples/js/sample-fa.js"></script>

                            <textarea name="description_fa" id="editor">
                                <?= $list['description_fa'] ?>
                            </textarea>
                            <script>
                                initSample();
                            </script>

                            <?php

                            // include_once ROOT_DIR.'common/ckeditor/ckeditor.php';
                            // include_once ROOT_DIR.'common/ckfinder/ckfinder.php';
                            // $ckeditor = new CKEditor();
                            // $ckeditor->basePath = RELA_DIR.'common/ckeditor/';




                            // $config['language'] = 'fa';
                            // $config['filebrowserBrowseUrl'] = RELA_DIR.'common/ckfinder/ckfinder.html';
                            // $config['filebrowserImageBrowseUrl'] = RELA_DIR.'common/ckfinder/ckfinder.html?type=Images';
                            // $config['filebrowserUploadUrl'] = RELA_DIR.'common/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
                            // $config['filebrowserImageUploadUrl'] = RELA_DIR.'common/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';

                            // $tt = $ckeditor->editor('description_fa',$list['description_fa'],$config);

                            // echo $tt;
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <label class="col-xs-12 col-sm-12  rtl" for="description_en"><?= description_en ?></label>
                        <div class="col-xs-12 col-sm-12 ">

                            <?php

                            include_once ROOT_DIR . 'common/ckeditor/ckeditor.php';
                            include_once ROOT_DIR . 'common/ckfinder/ckfinder.php';
                            $ckeditor = new CKEditor();
                            $ckeditor->basePath = RELA_DIR . 'common/ckeditor/';


                            $config['language'] = 'fa';
                            $config['filebrowserBrowseUrl'] = RELA_DIR . 'common/ckfinder/ckfinder.html';
                            $config['filebrowserImageBrowseUrl'] = RELA_DIR . 'common/ckfinder/ckfinder.html?type=Images';
                            $config['filebrowserUploadUrl'] = RELA_DIR . 'common/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
                            $config['filebrowserImageUploadUrl'] = RELA_DIR . 'common/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';

                            $tt = $ckeditor->editor('description_en', $list['description_en'], $config);

                            echo $tt;
                            ?>
                        </div>
                    </div>
                </div>



                <div class="col-xs-12 col-sm-12 col-md-6">
                    <div class="form-group">
                        <label class="col-xs-12 col-sm-4 pull-right control-label rtl" for="xImagePath"><?= image ?></label>
                        <div class="col-xs-12 col-sm-8 pull-right">
                            <input type="file" name="image">

                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-6">
                    <div class="form-group">
                        <label class="col-xs-12 col-sm-4 pull-right control-label rtl" for="category_id">category_id:</label>
                        <div class="col-xs-12 col-sm-8 pull-right">
                            <select class="form-control" name="category_id[]" data-input="select2" placeholder="Multiple select" multiple>
                                <?
                                foreach ($list['category'] as $category_id => $value) {
                                ?>
                                    <option <?php echo in_array($category_id, $list['category_id']) ? 'selected' : '' ?> value="<?= $category_id ?>">
                                        <?= $value['export'] ?>
                                    </option>
                                <?
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <p class="pull-right">
                        <input name="action" type="hidden" id="action" value="add" />
                        <input name="company_id" type="hidden" id="company_id" value="<?= $list['company_id'] ?>" />
                        <button type="submit" name="submit" id="submit" class="btn btn-icon btn-success rtl">
                            <i class="fa fa-plus"></i>
                            <?= add ?>
                        </button>
                    </p>
                </div>
            </div>

        </form>
    </div>
</div>