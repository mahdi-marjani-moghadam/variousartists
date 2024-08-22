<script type="text/javascript" src="../common/ckfinder/ckfinder.js"></script>
<script type="text/javascript">

    function BrowseServer( startupPath, functionData )
    {
        var finder = new CKFinder();
        finder.basePath = '../';
        finder.startupPath = startupPath;
        finder.selectActionFunction = SetFileField;
        finder.selectActionData = functionData;

        finder.popup();
    }

    function SetFileField( fileUrl, data )
    {
        document.getElementById( data["selectActionData"] ).value = fileUrl;
    }
    function ShowThumbnails( fileUrl, data )
    {
        // this = CKFinderAPI
        var sFileName = this.getSelectedFile().name;
        document.getElementById( 'thumbnails' ).innerHTML +=
            '<div class="thumb">' +
            '<img src="' + fileUrl + '" />' +
            '<div class="caption">' +
            '<a href="' + data["fileUrl"] + '" target="_blank">' + sFileName + '</a> (' + data["fileSize"] + 'KB)' +
            '</div>' +
            '</div>';

        document.getElementById( 'preview' ).style.display = "";
        // It is not required to return any value.
        // When false is returned, CKFinder will not close automatically.
        return false;
    }
</script>
<div class="content-control">
    <!--control-nav-->
    <ul class="control-nav pull-right">
        <li><a class="rtl text-24"><i class="sidebar-icon fa fa-tasks"></i> افزودن سالن جدید</a></li>
    </ul><!--/control-nav-->
</div><!-- /content-control -->

<div class="content-body">
  <div id="panel-tablesorter" class="panel panel-warning">
    <div class="panel-heading bg-white">
      <h3 class="panel-title rtl">فرم</h3>
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
    {
    ?>
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 alert alert-warning">
    <?= $msg ?>
      </div>
    <?php
    }
    ?>
    <div class="panel-body">
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-8  center-block">
          <form name="queue" id="queue" role="form" data-validate="form" class="form-horizontal form-bordered" autocomplete="off" novalidate="novalidate" method="post">
            <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                  <label class="col-xs-12 col-sm-4 pull-right control-label rtl" for="title_fa">عنوان(فارسی):</label>
                  <div class="col-xs-12 col-sm-8 pull-right">
                    <input type="text" class="form-control" name="title_fa" id="title_fa" autocomplete="off" required="required"  value="<?=$list['title_fa']?>">
                  </div>
                </div>
              </div>
              <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                  <label class="col-xs-12 col-sm-4 pull-right control-label rtl" for="title_en">عنوان(انگلیسی):</label>
                  <div class="col-xs-12 col-sm-8 pull-right">
                    <input type="text" class="form-control" name="title_en" id="title_en" autocomplete="off" required="required"  value="<?=$list['title_en']?>">
                  </div>
                </div>
              </div>
              <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                  <label class="col-xs-12 col-sm-4 pull-right control-label rtl" for="parent_id">دسته بندی والد:</label>
                  <div class="col-xs-12 col-sm-8 pull-right">
                   <select class="valid" name="parent_id" id="parent_id">

                    <?
                    foreach($list['salon'] as $salon_id => $value)
                    {
                    ?>
                      <option <?php echo $value['Salon_id'] == $list['parent_id'] ? 'selected' : '' ?> value="<?=$value['Salon_id']?>">
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
                        <label class="col-xs-12 col-sm-4 pull-right control-label rtl" for="address_fa">آدرس:fa </label>
                        <div class="col-xs-12 col-sm-8 pull-right">
                            <textarea class="form-control" name="address_fa" id="address_fa" autocomplete="off" ><?=$list['address_fa']?></textarea>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6">
                    <div class="form-group">
                        <label class="col-xs-12 col-sm-4 pull-right control-label rtl" for="address_en"> آدرس:en </label>
                        <div class="col-xs-12 col-sm-8 pull-right">
                            <textarea class="form-control" name="address_en" id="address_en" autocomplete="off" ><?=$list['address_en']?></textarea>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6">
                    <div class="form-group">
                        <label class="col-xs-12 col-sm-4 pull-right control-label rtl" for="min_sandali">ابتدای شماره صندلی</label>
                        <div class="col-xs-12 col-sm-8 pull-right">
                            <input type="number" name="min_sandali" class="form-control " id="min_sandali" value="<?=$list['min_sandali']?>">
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6">
                    <div class="form-group">
                        <label class="col-xs-12 col-sm-4 pull-right control-label rtl" for="max_sandali">انتهای شماره صندلی</label>
                        <div class="col-xs-12 col-sm-8 pull-right">
                            <input type="number" name="max_sandali" class="form-control " id="max_sandali" value="<?=$list['max_sandali']?>">

                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6">
                    <div class="form-group">
                        <label class="col-xs-12 col-sm-4 pull-right control-label rtl" for="price">قیمت(ریال)</label>
                        <div class="col-xs-12 col-sm-8 pull-right">
                            <input  name="price" class="form-control " id="price"><?=$list['price']?>
                            </input>
                        </div>
                    </div>
                </div>
              <div class="col-xs-12 col-sm-12 col-md-6">
                  <div class="form-group">
                      <label class="col-xs-12 col-sm-4 pull-right control-label rtl" for="xImagePath">تصویر:</label>
                      <div class="col-xs-12 col-sm-8 pull-right">
                          <input type="file" name="image">
                      </div>
                  </div>
              </div>
              <div class="row xsmallSpace hidden-xs"></div>
            <div class="row">
              <div class="col-md-12">
                <p class="pull-right margin-right">
                    <input name="action" type="hidden" id="action" value="add" />

                  <button type="submit" name="update" id="submit" class="btn btn-icon btn-success rtl">
                    <i class="fa fa-plus"></i>
ثبت
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
</div>