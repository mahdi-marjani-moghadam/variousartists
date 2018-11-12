<script type="text/javascript" language="javascript" class="init">

    $(document).ready(function () {
        var $modal = $('.customMobile');


        //	dtatatable
        var dataTable = $('#example');

        var oTable = dataTable.DataTable({
            "processing": true,
            "serverSide": false,
            "ajax": "<?=RELA_DIR?>zamin/?component=shop&action=shopListAjax&status=<?=$list['status']?>",
            "ordering": false,
            "searching":false
        });


        oTable.columns().every(function () {
            var that = this;

            $('	:input', this.footer()).on('keyup change', function () {
                that.search(this.value).draw();
            });
        });

        //	dtatatable

        // Apply the search

    });




</script>

<div class="content-control">
    <!--control-nav-->
    <ul class="control-nav pull-right">
        <li><a class="rtl text-24"><i class="sidebar-icon fa fa-adn"></i> فروش </a></li>
    </ul>
    <!--/control-nav-->
</div>
<!-- /content-control -->

<div class="content-body">
    <!-- separator -->
    <div class="row xsmallSpace"></div>
    <div id="panel-1" class="panel panel-default border-blue">
        <div class="panel-heading bg-blue">
            <h3 class="panel-title rtl ">لیست فروش</h3>
            <div class="panel-actions">
                <button data-expand="#panel-1" title="نمایش" class="btn-panel"><i class="fa fa-expand"></i></button>
                <button data-collapse="#panel-1" title="بازکردن" class="btn-panel"><i class="fa fa-caret-down"></i>
                </button>
            </div>
        </div>
        <div class="panel-body">

            <!-- separator -->
            <div class="row smallSpace"></div>
            <div class="table-responsive table-responsive-datatables">
                <table id="example" class="companyTable table table-striped table-bordered rtl" cellspacing="0"
                       width="100%">
                    <thead>
                    <tr>
                        <th></th>
                        <th>رویداد</th>
                        <th>مکان</th>
                        <th>موقعیت</th>
                        <th>کاربر</th>
                        <th>صندلی</th>
                        <th>زمان رویداد</th>
                        <th>تاریخ رویداد</th>
                        <th>وضعیت</th>
                        <th>قیمت</th>
                        <th>تاریخ خرید</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <th><input type="hidden" name="search_1" class="search_init form-control"/></th>
                    <th><input type="hidden" name="search_1" class="search_init form-control"/></th>
                    <th><input type="hidden" name="search_2" class="search_init form-control"/></th>
                    <th><input type="hidden" name="search_3" class="search_init form-control"/></th>
                    <th><input type="hidden" name="search_4" class="search_init form-control"/></th>
                    <th><input type="hidden" name="search_5" class="search_init form-control"/></th>
                    <th><input type="hidden" name="search_6" class="search_init form-control"/></th>
                    <th><input type="hidden" name="search_7" class="search_init form-control"/></th>
                    <th><select style="width: 60px !important; display: none" name="search_8" class="search_init " id="search_9">
                            <option value="">همه</option>
                            <option value="1">فعال</option>
                            <option value="0">غیر فعال</option>
                        </select>
                    </th>
                    <th><input type="hidden" name="search_9" class="search_init form-control"/></th>
                    <th><input type="hidden" name="search_10" class="search_init form-control"/></th>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="panel-footer clearfix"></div>
    </div>
</div>
<!--/content-body -->

<div class="modal fade customMobile" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Modal title</h4>
            </div>
            <div class="modal-body">
                <p class="phoneHolder"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->