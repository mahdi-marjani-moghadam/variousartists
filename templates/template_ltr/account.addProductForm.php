<div class="col-md-12 col-xs-12 col-sm-12">
    <div class="col-md-10 col-md-offset-1 col-sm-12 col-xs-12" style="overflow: scroll">
        <form name="queue" id="queue" enctype="multipart/form-data" role="form" data-validate="form" class="form-horizontal form-bordered" novalidate="novalidate" method="post">

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-6">
                    <div class="form-group">
                        <label class="col-xs-12 col-sm-4  control-label " for="title_fa">Title(persian):</label>
                        <div class="col-xs-12 col-sm-8 ">
                            <input type="text" class="form-control" name="title_fa" id="title_fa" placeholder="  " required value="<?php echo $list['title_fa'] ?>">
                        </div>
                    </div>
                </div>


                <div class="col-xs-12 col-sm-12 col-md-6">
                    <div class="form-group">
                        <label class="col-xs-12 col-sm-4  control-label " for="title_en">Title(english)</label>
                        <div class="col-xs-12 col-sm-8 ">
                            <input type="text" class="form-control" name="title_en" id="title_en" placeholder="  " required value="<?php echo $list['title_en'] ?>">
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-6">
                    <div class="form-group">
                        <label class="col-xs-12 col-sm-4  control-label " for="description_fa">Description (persian):</label>
                        <div class="col-xs-12 col-sm-8 ">
                            <textarea name="description_fa" class="form-control"
                                id="description_fa" placeholder="" required="required"><?php echo $list['description_fa'] ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6">
                    <div class="form-group">
                        <label class="col-xs-12 col-sm-4  control-label " for="description_en">Description (english):</label>
                        <div class="col-xs-12 col-sm-8 ">
                            <textarea name="description_en" class="form-control"
                                id="description_en" placeholder="" required="required"><?php echo $list['description_en'] ?></textarea>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-6">
                    <div class="form-group">
                        <label class="col-xs-12 col-sm-4  control-label " for="creation_date">Create date:</label>
                        <div class="col-xs-12 col-sm-8 ">
                            <input type="text" class="form-control datepicker" name="creation_date" id="creation_date" autocomplete="off" value="<?php echo ($list['creation_date'] != '') ? convertDate($list['creation_date']) : ''; ?>">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row xsmallSpace hidden-xs"></div>

            <div class="row">

                <div class="col-xs-12 col-sm-12 col-md-6">
                    <div class="form-group">
                        <label class="col-xs-12 col-sm-4  control-label " for="xImagePath">Image:</label>
                        <div class="col-xs-12 col-sm-8 ">
                            <input type="file" name="image">

                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6">
                    <div class="form-group">
                        <label class="col-xs-12 col-sm-4  control-label " for="xImagePath">File:</label>
                        <div class="col-xs-12 col-sm-8 ">
                            <input type="file" name="file">

                        </div>
                    </div>
                </div>


            </div>
            <div class="row xsmallSpace hidden-xs"></div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-6">
                    <div class="form-group">
                        <label class="col-xs-12 col-sm-4  control-label " for="category_id">category_id:</label>
                        <div class="col-xs-12 col-sm-8 ">
                            <select class="form-control" name="category_id[]" data-input="select2" placeholder="Multiple select" multiple>
                                <?php
                                foreach ($list['category'] ?? [] as $category_id => $value) {
                                ?>
                                    <option <?php echo is_array($list['category_id']) &&  in_array($category_id, $list['category_id']) ? 'selected' : '' ?> value="<?php echo $category_id ?>">
                                        <?php echo $value['export'] ?>
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
                        <label class="col-xs-12 col-sm-4 pull-right control-label rtl" for="genre_id">genre:</label>
                        <div class="col-xs-12 col-sm-8 pull-right">
                            <select class="form-control" name="genre_id[]" data-input="select2" multiple>
                                <?php
                                foreach ($list['genre'] ?? [] as $genre_id => $value) {
                                ?>
                                    <option <?php echo is_array($list['genre_id']) && in_array($genre_id, $list['genre_id']) ? 'selected' : '' ?> value="<?php echo $genre_id ?>">
                                        <?php echo $value['export'] ?>
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
                    <p class="">
                        <input name="action" type="hidden" id="action" value="add" />
                        <input name="company_id" type="hidden" id="company_id" value="<?php echo $list['company_id'] ?>" />
                        <button type="submit" name="submit" id="submit" class="btn btn-icon btn-success ">
                            <i class="fa fa-plus"></i>
                            Insert
                        </button>
                    </p>
                </div>
            </div>

        </form>
    </div>
</div>