<script type="text/javascript" language="javascript" class="init">

    $(document).ready(function () {

// DataTable
        var table = $('#example').DataTable();

// Apply the search
        table.columns().every(function () {
            var that = this;

            $('input', this.footer()).on('keyup change', function () {
                if (that.search() !== this.value) {
                    that
                        .search(this.value)
                        .draw();
                }
            });
        });
////
// Apply the search

    });
</script>
<div class="content-control">
    <!--control-nav-->
    <ul class="control-nav pull-right">
        <li><a class="rtl text-24"><i class="sidebar-icon fa fa-tasks"></i> لیست دسته بندی</a></li>
    </ul>
    <!--/control-nav-->
</div><!-- /content-control -->

<div class="content-body">
    <!-- separator -->
    <div class="xsmallSpace"></div>
    <div id="panel-1" class="panel panel-default border-blue">
        <div class="panel-heading bg-blue">
            <h3 class="panel-title rtl">لیست دسته بندی </h3>
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
                <a href="<?= RELA_DIR ?>zamin/?component=salon&action=add" class="btn btn-primary btn-sm btn-icon text-13"><i class="fa fa-plus"></i> افزودن دسته بندی جدید</a>
            </div>
            <!-- separator -->
            <div class="row smallSpace"></div>
            <div class="table-responsive table-responsive-datatables">
                <table id="example" class="companyTable table table-striped table-bordered rtl" cellspacing="0"
                       width="100%">
                    <thead>
                    <tr>
                        <th>ردیف</th>
                        <th>نام دسته بندی</th>
                        <th>آدرس </th>
                        <th>شماره صندلی</th>
                        <th>تصویر</th>
                        <th>ویرایش</th>
                    </tr>
                    </thead>
                    <tfoot>
                        <th><input type="text" name="search_1" value="" class="search_init form-control"/></th>
                        <th><input type="text" name="search_2" value="" class="search_init form-control"/></th>
                        <th><input type="text" name="search_3" value="" class="search_init form-control"/></th>
                        <th><input type="text" name="search_4" value="" class="search_init form-control"/></th>
                        <th><input type="text" name="search_5" value="" class="search_init form-control"/></th>
                        <th><input type="text" name="search_6" value="" class="search_init form-control"/></th>
                    </tfoot>
                    <tbody>
                    <?php foreach ($list['list'] as $id => $fields) {
                    ?>
                        <tr>
                            <td><?php echo $fields['dataTableCount']; ?></td>
                            <td><?php echo $fields['export']; ?></td>
                            <td><?php echo $fields['address']; ?></td>
                            <td> :از<?php echo $fields['min_sandali']; ?> تا: <? echo $fields['max_sandali'];?></td>

                            <td style="" dir="ltr" align="center">
                                <img height="60px" src="<?=RELA_DIR?>statics/salon/<?= $fields['image'] ?>"/>
                            </td>
                            <td>
                                <a href="<?= RELA_DIR ?>zamin/?component=salon&action=edit&id=<?php echo $fields['Salon_id']; ?>">ویرایش</a>
                                <a href="<?= RELA_DIR ?>zamin/?component=salon&action=delete&id=<?php echo $fields['Salon_id']; ?>">حذف</a>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                    </tbody>
                </table>
                موارد یافت شده
                    <?php echo $list['recordsCount']; ?>
            </div>
        </div>
        <div class="panel-footer clearfix">
        </div>
    </div>
</div>

<!--/content -->
