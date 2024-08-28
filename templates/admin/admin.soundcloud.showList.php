<script type="text/javascript" language="javascript" class="init">

    $(document).ready(function () {

// DataTable
        var table = $('#example').DataTable({
            "ordering": false,
            "searching": false
        });

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
        <li><a class="rtl text-24"><i class="sidebar-icon fa fa-bell"></i> Sound cloud</a></li>
    </ul>
    <!--/control-nav-->
</div><!-- /content-control -->

<div class="content-body">
    <!-- separator -->
    <div class="xsmallSpace"></div>
    <div id="panel-1" class="panel panel-default border-blue">
        <div class="panel-heading bg-blue">
            <h3 class="panel-title rtl">لیست</h3>

        </div>
        <div class="panel-body">
            <div class="pull-right">
                <a href="<?php echo  RELA_DIR ?>zamin/?component=soundcloud&action=add" class="btn btn-primary btn-sm btn-icon text-13"><i class="fa fa-plus"></i> افزودن   </a>
            </div>
            <!-- separator -->
            <div class="row smallSpace"></div>
            <div class="table-responsive table-responsive-datatables">
                <table id="example" class=" table-striped table-bordered rtl"  >
                    <thead>
                    <tr>
                        <th>embed</th>
                        <th>ویرایش</th>
                    </tr>
                    </thead>
                    <tfoot>
                        <th><input type="text" name="search_1" value="" class="search_init form-control"/></th>
                        <th><input type="text" name="search_2" value="" class="search_init form-control"/></th>
                    </tfoot>
                    <tbody>
                    <?php foreach ($list['list'] as $id => $fields) {
                    ?>
                        <tr>
                            <td ><?php echo $fields['embed']; ?></td>
                            <td>
                                <a href="<?php echo  RELA_DIR ?>zamin/?component=soundcloud&action=delete&id=<?php echo $fields['id']; ?>">حذف</a>
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
