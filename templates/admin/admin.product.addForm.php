
<div class="content-control">
  <!--control-nav-->
  <ul class="control-nav pull-right">
    <li><a class="rtl text-24">افزودن اثر<i class="sidebar-icon fa fa-info"></i></a></li>
  </ul><!--/control-nav-->
</div><!-- /content-control -->

<div class="content-body">
  <div id="panel-tablesorter" class="panel panel-warning">
    <div class="panel-heading bg-white">
      <h3 class="panel-title rtl">فرم افزودن اثر</h3>
      <div class="panel-actions">
      <button data-expand="#panel-tablesorter" title="" class="btn-panel rtl" data-original-title="تمام صفحه">
          <i class="fa fa-expand"></i>
        </button>
        <button data-collapse="#panel-tablesorter" title="" class="btn-panel rtl" data-original-title="باز و بسته شدن">
          <i class="fa fa-caret-down"></i>
        </button>
      </div><!-- /panel-actions -->
    </div><!-- /panel-heading -->

    <?php if($msg!=null)
    { ?>
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 alert alert-warning">
        <?= $msg ?>
      </div>
      <?php
    }
    ?>
    <div class="panel-body">

      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-8  center-block">
          <form name="queue" enctype="multipart/form-data" id="queue" role="form" data-validate="form" class="form-horizontal form-bordered"  novalidate="novalidate" method="post">

            <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                  <label class="col-xs-12 col-sm-4 pull-right control-label rtl" for="title_fa">عنوان(فارسی):</label>
                  <div class="col-xs-12 col-sm-8 pull-right">
                    <input type="text" class="form-control" name="title_fa" id="title_fa"  placeholder="  " required value="<?=$list['title_fa']?>">
                  </div>
                </div>
              </div>

            </div>
            <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                  <label class="col-xs-12 col-sm-4 pull-right control-label rtl" for="title_en">عنوان(انگلیسی):</label>
                  <div class="col-xs-12 col-sm-8 pull-right">
                    <input type="text" class="form-control" name="title_en" id="title_en"  placeholder="  " required value="<?=$list['title_en']?>">
                  </div>
                </div>
              </div>

            </div>

            <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                  <label class="col-xs-12 col-sm-12 pull-right control-label rtl" for="description_fa">توضیحات (فارسی):</label>
                  <div class="col-xs-12 col-sm-12 pull-right">
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
                  <label class="col-xs-12 col-sm-12 pull-right control-label rtl" for="description_en">توضیحات(انگلیسی):</label>
                  <div class="col-xs-12 col-sm-12 pull-right">
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
            </div>

            <div class="row xsmallSpace hidden-xs"></div>

            <div class="row">

              <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                  <label class="col-xs-12 col-sm-4 pull-right control-label rtl" for="xImagePath">تصویر:</label>
                  <div class="col-xs-12 col-sm-8 pull-right">
                    <input type="file" name="image">

                  </div>
                </div>
              </div>
              <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                  <label class="col-xs-12 col-sm-4 pull-right control-label rtl" for="xImagePath">فایل:</label>
                  <div class="col-xs-12 col-sm-8 pull-right">
                    <input type="file" name="file">

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
                    <select name="category_id[]" data-input="select2" multiple>
                      <?
                      foreach($list['category'] as $category_id => $value)
                      {
                        ?>
                        <option  <?php echo in_array($value['Category_id'],$list['category_id'] ) ? 'selected' : '' ?> value="<?=$value['Category_id']?>">
                          <?=$value['export']?>
                        </option>
                        <?
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
                                <?
                                foreach($list['genre'] as $genre_id => $value)
                                {
                                    ?>
                                    <option  <?php echo in_array($value['Genre_id'],$list['genre_id'] ) ? 'selected' : '' ?> value="<?=$value['Genre_id']?>">
                                        <?=$value['export']?>
                                    </option>
                                    <?
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
              <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                  <label class="col-xs-12 col-sm-4 pull-right control-label rtl" for="category_id">وضعیت:</label>
                  <div class="col-xs-12 col-sm-8 pull-right">
                    <select name="status" data-input="select2" placeholder=" select">
                      <option  <?php echo ($list['status'] == 0 ) ? 'selected' : '' ?> value="0">غیر فعال</option>
                      <option  <?php echo ($list['status'] == 1 ) ? 'selected' : '' ?> value="1"> فعال</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <div class="row xsmallSpace hidden-xs"></div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-6">
                    <div class="form-group">
                        <label class="col-xs-12 col-sm-4 pull-right control-label rtl" for="creation_date">تاریخ تولید:</label>
                        <div class="col-xs-12 col-sm-8 pull-right">
                            <input type="text" class="form-control date" autocomplete="off" name="creation_date" id="creation_date"  required value="<?=$list['creation_date']?>">
                        </div>
                    </div>
                </div>
              <div class="col-md-12">
                <p class="pull-right">
                                    <input name="action" type="hidden" id="action" value="add" />
                    <input name="company_id" type="hidden" id="company_id" value="<?=$list['company_id']?>" />
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
    </div>
  </div>
</div>
