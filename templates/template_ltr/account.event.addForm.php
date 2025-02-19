<script type="text/javascript" src="../common/ckfinder/ckfinder.js" xmlns="http://www.w3.org/1999/html"></script>
<script type="text/javascript">
    function BrowseServer(startupPath, functionData) {
        var finder = new CKFinder();
        finder.basePath = '../';
        finder.startupPath = startupPath;
        finder.selectActionFunction = SetFileField;
        finder.selectActionData = functionData;

        finder.popup();
    }

    function SetFileField(fileUrl, data) {
        document.getElementById(data["selectActionData"]).value = fileUrl;
    }

    function ShowThumbnails(fileUrl, data) {
        // this = CKFinderAPI

        var sFileName = this.getSelectedFile().name;
        document.getElementById('thumbnails').innerHTML +=
            '<div class="thumb">' +
            '<img src="' + fileUrl + '" />' +
            '<div class="caption">' +
            '<a href="' + data["fileUrl"] + '" target="_blank">' + sFileName + '</a> (' + data["fileSize"] + 'KB)' +
            '</div>' +
            '</div>';

        document.getElementById('preview').style.display = "";
        // It is not  to return any value.
        // When false is returned, CKFinder will not close automatically.
        return false;
    }
</script>

<div class="content-body">
    <div id="panel-tablesorter" class="panel panel-warning">
        <div class="panel-heading bg-white">
            <h3 class="panel-title "><?php echo new_event ?></h3>

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
                <div class="col-xs-12 col-sm-12 col-md-12 center-block">
                    <form name="queue" id="queue" role="form" data-validate="form" enctype="multipart/form-data" class="form-horizontal form-bordered"
                        novalidate="novalidate" method="post">

                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label class="col-xs-12 col-sm-4 col-md-4  control-label "
                                        for="event_name_fa"><?php echo event_name_fa ?></label>
                                    <div class="col-xs-12 col-sm-8 col-md-8 ">
                                        <input type="text" class="form-control" name="event_name_fa" id="event_name_fa" required value="<?php echo  $list['event_name_fa'] ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label class="col-xs-12 col-sm-4 col-md-4  control-label "
                                        for="event_name_en"><?php echo event_name_en ?></label>
                                    <div class="col-xs-12 col-sm-8 col-md-8 ">
                                        <input type="text" class="form-control" name="event_name_en" id="event_name_en" required value="<?php echo  $list['event_name_en'] ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row xsmallSpace hidden-xs"></div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <label style="padding-right: 20px"
                                            for="description_fa"><?php echo description_fa ?></label>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 ">
                                        <?php

                                        include_once ROOT_DIR . 'common/ckeditor/ckeditor.php';
                                        include_once ROOT_DIR . 'common/ckfinder/ckfinder.php';
                                        $ckeditor = new CKEditor();
                                        $ckeditor->basePath = RELA_DIR . 'common/ckeditor/';




                                        $config['language'] = 'en';
                                        $config['filebrowserBrowseUrl'] = RELA_DIR . 'common/ckfinder/ckfinder.html';
                                        $config['filebrowserImageBrowseUrl'] = RELA_DIR . 'common/ckfinder/ckfinder.html?type=Images';
                                        $config['filebrowserUploadUrl'] = RELA_DIR . 'common/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
                                        $config['filebrowserImageUploadUrl'] = RELA_DIR . 'common/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';

                                        $tt = $ckeditor->editor('description_fa', $list['description_fa'], $config);

                                        echo $tt;
                                        ?>

                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <div class="col-xs-12 col-sm-12 col-md-12"><label class=" "
                                            for="description_en"><?php echo description_en ?></label>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 ">
                                        <?php

                                        include_once ROOT_DIR . 'common/ckeditor/ckeditor.php';
                                        include_once ROOT_DIR . 'common/ckfinder/ckfinder.php';
                                        $ckeditor = new CKEditor();
                                        $ckeditor->basePath = RELA_DIR . 'common/ckeditor/';




                                        $config['language'] = 'en';
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
                        </div>
                        <div class="row xsmallSpace hidden-xs"></div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label class="col-xs-12 col-sm-4 col-md-4  control-label "
                                        for="event_time"><?php echo event_time ?></label>
                                    <div class="col-xs-12 col-sm-8 col-md-8 ">
                                        <input type="text" class="form-control" name="event_time" id="event_time" required value="<?php echo  $list['event_time'] ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label class="col-xs-12 col-sm-4 col-md-4  control-label "
                                        for="date"><?php echo event_date ?></label>
                                    <div class="col-xs-12 col-sm-8 col-md-8 ">
                                        <input type="date" class="form-control   " name="date" autocomplete="off" id="date" required value="<?php echo ($list['date'] != "" ? convertDate($list['date']) : "") ?>">
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label class="col-xs-12 col-sm-4 col-md-4  control-label "
                                        for="event_time2"><?php echo event_time ?></label>
                                    <div class="col-xs-12 col-sm-8 col-md-8 ">
                                        <input type="text" class="form-control" name="event_time2" id="event_time2" value="<?php echo  $list['event_time2'] ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label class="col-xs-12 col-sm-4 col-md-4  control-label "
                                        for="date"><?php echo event_date ?></label>
                                    <div class="col-xs-12 col-sm-8 col-md-8 ">
                                        <input type="date" class="form-control " name="date2" autocomplete="off" id="date2" value="<?php echo ($list['date2'] != "" ? convertDate($list['date2']) : "") ?>">
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label class="col-xs-12 col-sm-4 col-md-4  control-label "
                                        for="event_time3"><?php echo event_time ?></label>
                                    <div class="col-xs-12 col-sm-8 col-md-8 ">
                                        <input type="text" class="form-control" name="event_time3" id="event_time3" value="<?php echo  $list['event_time3'] ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label class="col-xs-12 col-sm-4 col-md-4  control-label "
                                        for="date3"><?php echo event_date ?></label>
                                    <div class="col-xs-12 col-sm-8 col-md-8 ">
                                        <input type="date" class="form-control  " name="date3" autocomplete="off" id="date3" value="<?php echo ($list['date3'] != "" ? convertDate($list['date3']) : "") ?>">
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row xsmallSpace hidden-xs"></div>
                        <div class="row">

                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label class="col-xs-12 col-sm-4  control-label "
                                        for="category_id"><?php echo category ?></label>
                                    <div class="col-xs-12 col-sm-8 ">
                                        <select class="form-control" name="category_id[]" id="category_id" data-input="select2" multiple>
                                            <?php
                                            foreach ($list['category'] as $category_id => $value) {
                                            ?>
                                                <option <?php echo isset($list['category_id']) &&  in_array($value['Category_id'], $list['category_id']) ? 'selected' : '' ?>
                                                    value="<?php echo  $value['Category_id'] ?>">
                                                    <?php echo  $value['export'] ?>
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
                                    <label class="col-xs-12 col-sm-4  control-label "
                                        for="genre_id"><?php echo genre ?></label>
                                    <div class="col-xs-12 col-sm-8 ">
                                        <select class="form-control" name="genre_id[]" id="genre_id" data-input="select2" multiple>
                                            <?php
                                            foreach ($list['genre'] as $genre_id => $value) {
                                            ?>
                                                <option <?php echo isset($list['genre_id']) && in_array($value['Genre_id'], $list['genre_id']) ? 'selected' : '' ?>
                                                    value="<?php echo  $value['Genre_id'] ?>">
                                                    <?php echo  $value['export'] ?>
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
                                    <label class="col-xs-12 col-sm-4 col-md-4  control-label "
                                        for="event_phone"><?php echo telephone ?></label>
                                    <div class="col-xs-12 col-sm-8 col-md-8 ">
                                        <input type="text" class="form-control " name="event_phone" id="event_phone" value="<?php echo ($list['event_phone'] != "" ? ($list['event_phone']) : "") ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row xsmallSpace hidden-xs"></div>
                        <div class="row">
                            <!-- city -->
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label class="col-xs-12 col-sm-4 col-md-4  control-label "
                                        for="country_id">Country</label>
                                    <div class="col-xs-12 col-sm-8 col-md-8">
                                        <select name="country_id" id="country_id" data-input="select2" multiple>

                                            <?php
                                            foreach ($list['country'] as $province_id => $value) { ?>
                                                <option
                                                    <?php echo  $value['id'] == $list['country_id'] ? 'selected' : '' ?>
                                                    value="<?php echo  $value['id'] ?>">
                                                    <?php echo  $value["nice_name"] ?>
                                                </option><?php
                                                        }
                                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row xsmallSpace hidden-xs"></div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label class="col-xs-12 col-sm-4  control-label "
                                        for="address_fa"><?php echo address_fa ?></label>
                                    <div class="col-xs-12 col-sm-8 ">
                                        <input type="text" class="form-control" name="address_fa" id="address_fa" value="<?php echo  $list['address_fa'] ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label class="col-xs-12 col-sm-4  control-label "
                                        for="address_en"><?php echo address_en ?></label>
                                    <div class="col-xs-12 col-sm-8 ">
                                        <input type="text" class="form-control" name="address_en" id="address_en" value="<?php echo  $list['address_en'] ?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row xsmallSpace hidden-xs"></div>
                        <div class="row" style="display: none;">
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label class="col-xs-12 col-sm-4  control-label "
                                        for="meta_keyword">کلمات کلیدی:</label>
                                    <div class="col-xs-12 col-sm-8 ">
                                        <input type="text" class="form-control" name="meta_keyword" id="meta_keyword" value="<?php echo  $list['meta_keyword'] ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label class="col-xs-12 col-sm-4  control-label "
                                        for="meta_description">توضیحات متا:</label>
                                    <div class="col-xs-12 col-sm-8 ">
                                        <input type="text" class="form-control" name="meta_description" id="meta_description" value="<?php echo  $list['meta_description'] ?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row xsmallSpace hidden-xs"></div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label class="col-xs-12 col-sm-4  control-label "
                                        for="lat"> lat:</label>
                                    <div class="col-xs-12 col-sm-8 ">
                                        <input type="text" class="form-control" name="lat" id="lat" value="<?php echo  $list['lat'] ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label class="col-xs-12 col-sm-4  control-label "
                                        for="longe"> long:</label>
                                    <div class="col-xs-12 col-sm-8 ">
                                        <input type="text" class="form-control" name="longe" id="longe" value="<?php echo  $list['longe'] ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label class="col-xs-12 col-sm-4  control-label "
                                        for="organizer"> Oganizer:</label>
                                    <div class="col-xs-12 col-sm-8 ">
                                        <input type="text" class="form-control" name="organizer" id="organizer" value="<?php echo  $list['organizer'] ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row xsmallSpace hidden-xs"></div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label class="col-xs-12 col-sm-4  control-label "
                                        for="xImagePath"><?php echo image ?></label>
                                    <div class="col-xs-12 col-sm-8 ">
                                        <div class="input-group" dir="ltr">
                                            <input type="file" class="form-control" name="logo">
                                        </div>



                                    </div>
                                </div>
                            </div>

                        </div>



                        <div class="row">
                            <div class="col-md-12">
                                <p class="">
                                    <button type="submit" name="update" id="submit"
                                        class="btn btn-icon btn-success "><input name="action" type="hidden" id="action" value="add" />
                                        <i class="fa fa-plus"></i>
                                        <?php echo submit ?>
                                    </button>
                                </p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>