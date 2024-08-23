<script type="text/javascript" language="javascript" class="init">

  $(document).ready(function() {

    // DataTable
    var table = $('#example').DataTable();

    // Apply the search
    table.columns().every( function () {
      var that = this;

      $( 'input', this.footer() ).on( 'keyup change', function () {
        if ( that.search() !== this.value ) {
          that
              .search( this.value )
              .draw();
        }
      } );
    } );
    ////

    // Apply the search

  } );
</script>
<div class="content-control">
  <!--control-nav-->
  <ul class="control-nav pull-right">
    <li><a class="rtl text-24"><i class="sidebar-icon fa fa-archive"></i> لیست مقالات </a></li>
  </ul><!--/control-nav-->
</div><!-- /content-control -->

<div class="content-body">
  <div class="row xsmallSpace"></div>
  <div id="panel-1" class="panel panel-default border-blue">
    <div class="panel-heading bg-blue">
      <h3 class="panel-title rtl">لیست مقالات</h3>
      <div class="panel-actions">
        <button data-expand="#panel-1" title="نمایش" class="btn-panel">
          <i class="fa fa-expand"></i>
        </button>
        <button data-collapse="#panel-1" title="بازکردن" class="btn-panel">
          <i class="fa fa-caret-down"></i>
        </button>
      </div>
    </div>
      <div class="panel-body">
          <div class="pull-right">
              <a href="<?= RELA_DIR ?>zamin/?component=article&action=addArticle" class="btn btn-primary btn-sm btn-icon text-13"><i class="fa fa-plus"></i>افزودن مقاله جدید </a>
          </div>

          <!-- separator -->
          <div class="row smallSpace"></div>

          <div class="table-responsive table-responsive-datatables">
              <table id="example" class="companyTable table table-striped table-bordered rtl" cellspacing="0"
                     width="100%">
                  <thead>
                  <tr>
                      <th>ردیف</th>
                      <th>عنوان</th>
                      <th> دسته بندی</th>
                      <th>توضیحات مختصر</th>
                      <th>متن مقاله</th>
                      <th>کلمات کلیدی</th>
                      <th>توضیحات کلیدی</th>
                      <th>تصویر</th>
                      <th>تاریخ</th>
                      <th></th>
                  </tr>
                  </thead>
                  <tbody>
                  <?
                  $cn = 1;
                  if (isset($list['list']))
                  {
                      foreach ($list['list'] as $id => $fields)
                  {
                  ?>
                      <tr>
                          <td><?php echo $fields['Article_id']; ?></td>
                          <td><?php echo $fields['title']; ?></td>
                          <td><?php echo $fields['category_name']; ?></td>
                          <td><?php echo $fields['brif_description']; ?></td>
                          <td><?php echo $fields['description']; ?></td>
                          <td><?php echo $fields['meta_keyword']; ?></td>
                          <td><?php echo $fields['meta_description']; ?></td>
                          <td align="center"><img height="60" src="<?php echo $fields['image']; ?>"></td>
                          <td><?php echo convertDate($fields['date']); ?></td>
                          <td>
                              <a href="<?= RELA_DIR ?>zamin/?component=article&action=editArticle&id=<?php echo $fields['Article_id']; ?>">ویرایش</a>
                              <a href="<?= RELA_DIR ?>zamin/?component=article&action=deleteArticle&id=<?php echo $fields['Article_id']; ?>">حذف</a>
                          </td>

                      </tr>
                  <?
                  }
                  }
                  ?>
                  </tbody>
                  <tfoot>
                  <th><input type="hidden" name="search_1" class="search_init form-control"/></th>
                  <th><input type="text" name="search_2" class="search_init form-control"/></th>
                  <th><input type="text" name="search_3" class="search_init form-control"/></th>
                  <th><input type="text" name="search_4" class="search_init form-control"/></th>
                  <th><input type="text" name="search_5" class="search_init form-control"/></th>
                  <th><input type="text" name="search_6" class="search_init form-control"/></th>
                  <th><input type="text" name="search_7" class="search_init form-control"/></th>
                  <th><input type="text" name="search_8" class="search_init form-control"/></th>
                  <th><input type="text" name="search_9" class="search_init form-control"/></th>
                  <th><input type="hidden" name="search_10" class="search_init form-control"/></th>
                  </tfoot>
              </table>
          </div>
      </div>
    <div class="panel-footer clearfix">
    </div>
  </div>
</div><!--/content-body -->
