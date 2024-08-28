
                                <div class="col-md-12 col-xs-12 col-sm-12">
                                    <div class="col-md-10 col-md-offset-1 col-sm-12 col-xs-12" style="overflow: scroll">
                                        <form name="queue" id="queue" role="form" enctype="multipart/form-data" data-validate="form" class="form-horizontal form-bordered"  novalidate="novalidate" method="post">

                                            <div class="row">
                                                <div class="col-xs-12 col-sm-12 col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-xs-12 col-sm-4 pull-right control-label rtl" for="title_fa">عنوان(فارسی):</label>
                                                        <div class="col-xs-12 col-sm-8 pull-right">
                                                            <input type="text" class="form-control" name="title_fa" id="title_fa"  placeholder="  " required value="<?php echo $list['title_fa']?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-xs-12 col-sm-4 pull-right control-label rtl" for="brif_description_fa">توضیحات مختصر(فارسی):</label>
                                                        <div class="col-xs-12 col-sm-8 pull-right">
                                                            <input type="text" class="form-control" name="brif_description_fa" id="brif_description_fa"  placeholder="" required value="<?php echo $list['brif_description_fa']?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-12 col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-xs-12 col-sm-4 pull-right control-label rtl" for="title_en">عنوان(انگلیسی):</label>
                                                        <div class="col-xs-12 col-sm-8 pull-right">
                                                            <input type="text" class="form-control" name="title_en" id="title_en"  placeholder="  " required value="<?php echo $list['title_en']?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-xs-12 col-sm-4 pull-right control-label rtl" for="brif_description_en">توضیحات مختصر(انگلیسی):</label>
                                                        <div class="col-xs-12 col-sm-8 pull-right">
                                                            <input type="text" class="form-control" name="brif_description_en" id="brif_description_en"  placeholder="" required value="<?php echo $list['brif_description_en']?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-xs-12 col-sm-12 col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-xs-12 col-sm-4 pull-right control-label rtl" for="description_fa">توضیحات (فارسی):</label>
                                                        <div class="col-xs-12 col-sm-8 pull-right">
                    <textarea name="description_fa" class="form-control"
                              id="description_fa" placeholder="" required="required"><?php echo $list['description_fa']?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-xs-12 col-sm-4 pull-right control-label rtl" for="description_en">توضیحات(انگلیسی):</label>
                                                        <div class="col-xs-12 col-sm-8 pull-right">
                    <textarea name="description_en" class="form-control"
                              id="description_en" placeholder="" required="required"><?php echo $list['description_en']?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-xs-12 col-sm-12 col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-xs-12 col-sm-4 pull-right control-label rtl" for="creation_date">تاریخ تولید:</label>
                                                        <div class="col-xs-12 col-sm-8 pull-right">
                                                            <input type="text" class="form-control datepicker" name="creation_date" id="creation_date"  placeholder=""  value="<?php echo convertDate($list['creation_date'])?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row xsmallSpace hidden-xs"></div>

                                            <div class="row">

                                                <div class="col-xs-12 col-sm-12 col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-xs-12 col-sm-4 pull-right control-label rtl" for="xImagePath">تصویر:</label>
                                                        <div class="col-xs-12 col-sm-8 pull-right">
                                                            <input type="file" name="imageT">

                                                            <img class="img-thumbnail" src="<?php echo RELA_DIR?>statics/files/<?php echo $list['artists_id']?>/<?php echo $list['image']?>">

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-xs-12 col-sm-4 pull-right control-label rtl" for="xImagePath">فایل:</label>
                                                        <div class="col-xs-12 col-sm-8 pull-right">
                                                            <input type="file" name="fileT">

                                                            <?php if($list['file_type']  == 'image' ):?>
                                                                <img class="img-thumbnail" src="<?php echo RELA_DIR?>statics/files/<?php echo $list['artists_id']?>/<?php echo $list['file']?>"/>
                                                            <?php endif;?>
                                                            <?php if ($list['file_type']  == 'video'):?>
                                                                <video controls width="100%"  >
                                                                    <source src="<?php echo RELA_DIR?>statics/files/<?php echo $list['artists_id']?>/<?php echo $list['file']?>" type="video/<?php echo $list['extension']?>"" />

                                                                </video>
                                                            <?php endif;?>
                                                            <?php if ($list['file_type']  == 'audio'):?>
                                                                <audio controls>
                                                                    <source src="<?php echo RELA_DIR?>statics/files/<?php echo $list['artists_id']?>/<?php echo $list['file']?>" type="audio/<?php echo $list['extension']?>">
                                                                    Your browser does not support the audio element.
                                                                </audio>
                                                            <?php endif;?>
                                                        </div>
                                                    </div>
                                                </div>


                                            </div>
                                            <div class="row xsmallSpace hidden-xs"></div>
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-12 col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-xs-12 col-sm-4 pull-right control-label rtl" for="category_id">category_id:</label>
                                                        <div class="col-xs-12 col-sm-8 pull-right">

                                                            <select name="category_id[]" data-input="select2" placeholder="Multiple select" multiple>
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
                                                <div class="col-xs-12 col-sm-12 col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-xs-12 col-sm-4 pull-right control-label rtl" for="category_id">genre:</label>
                                                        <div class="col-xs-12 col-sm-8 pull-right">

                                                            <select name="genre_id[]" data-input="select2"  multiple>
                                                                <?php 
                                                                foreach($list['genre'] as $genre_id => $value)
                                                                {
                                                                    ?>
                                                                    <option  <?php echo in_array($genre_id,explode(",",$list['genre_id']) ) ? 'selected' : '' ?> value="<?php echo $genre_id?>">
                                                                        <?php echo $value['export']?>
                                                                    </option>
                                                                    <?php 
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="row xsmallSpace hidden-xs"></div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <p class="pull-right">
                                                        <input name="action" type="hidden" id="action" value="edit" />
                                                        <input name="artists_products_id" type="hidden" id="artists_products_id" value="<?php echo $list['Artists_products_id']?>" />
                                                        <button type="submit" name="submit" id="submit" class="btn btn-icon btn-success rtl">
                                                            <i class="fa fa-plus"></i>
                                                            افزودن
                                                        </button>
                                                    </p>
                                                </div>
                                            </div>

                                        </form>
                                    </div>
                                </div>