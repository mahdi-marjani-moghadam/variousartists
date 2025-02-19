
<script type="text/javascript" language="javascript" class="init">

    $(document).ready(function () {
        var $modal = $('.customMobile');

        // DataTable
        /*    var table = $('#example').DataTable();

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
         } );*/


        //	dtatatable
        var dataTable = $('#example');

        var oTable = dataTable.DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "<?php echo RELA_DIR?>zamin/?component=event&action=searchGallery&status=<?php echo $list['status']?>&event_id=<?php echo $_GET['id']?>",
            "ordering": false
        });

        /*$('#example').dataTable( {
         "columnDefs": [ {
         "targets": 'no-sort',
         "orderable": false,
         } ]
         } );*/

        // Apply the search
        //alert($("#search_9").val());

        oTable.columns().every(function () {
            var that = this;

            $('	:input', this.footer()).on('keyup change', function () {
                that.search(this.value).draw();
            });
        });

        //	dtatatable

        // Apply the search

        //show other phone

        $('#example tbody').on('click', '.company_phone', function () {
            var company_id=$(this).data('company_id');
            $("#loading").show();
            $.ajax({
                url: '<?php echo RELA_DIR?>zamin/?component=company&action=getCompanyPhone',
                type: "POST",
                data: "company_id="+company_id,
                cache: false,
                success: function (data) {
                    $("#loading").hide();
                    $("#allcompanyphone").html(data);

                    $modal.find('.phoneHolder').html('');
                    $modal.find('.phoneHolder').html(data);
                    $modal.modal('show');
                }
            });


        } );


        $('body').on('click', '.company_allphone', function () {
            var company_one_phone=$(this).data('myphonenumber');
            var company_id=$(this).data('mycompanyid');
            call(company_one_phone,company_id);
            //alert(company_id+" => "+company_one_phone);
        } );

        //end show other phone
    });




</script>

<div class="content-control">
    <!--control-nav-->
    <ul class="control-nav pull-right">
        <li><a class="rtl text-24"><i class="sidebar-icon fa fa-adn"></i> لیست تصاویر</a></li>
    </ul>
    <!--/control-nav-->
</div>
<!-- /content-control -->

<div class="content-body">
    <!-- separator -->
    <div class="row xsmallSpace"></div>
    <div id="panel-1" class="panel panel-default border-blue">
        <div class="panel-heading bg-blue">
            <h3 class="panel-title rtl ">لیست تصاویر</h3>
            <div class="panel-actions">
                <button data-expand="#panel-1" title="نمایش" class="btn-panel"><i class="fa fa-expand"></i></button>
                <button data-collapse="#panel-1" title="بازکردن" class="btn-panel"><i class="fa fa-caret-down"></i>
                </button>
            </div>
        </div>
        <div class="panel-body">
            <div class="pull-right"><a href="<?php echo  RELA_DIR ?>zamin/?component=event&action=addGallery&event_id=<?php echo $_GET['id']?>"
                                       class="btn btn-primary btn-sm btn-icon text-13"><i class="fa fa-plus"></i> افزودن  تصویر</a></div>


            <!-- separator -->
            <div class="row smallSpace"></div>
            <div class="table-responsive table-responsive-datatables">
                <table id="example" class="companyTable table table-striped table-bordered rtl" cellspacing="0"
                       width="100%">
                    <thead>
                    <tr>
                        <th>ردیف</th>
                        <th>رویداد</th>
                        <th>تصویر</th>
                        <th>ابزار</th>

                    </tr>
                    </thead>
                    <tfoot>
                    <th><input type="text" name="search_1" class="search_init form-control"/></th>
                    <th><input type="text" name="search_2" class="search_init form-control"/></th>
                    <th><input type="text" name="search_3" class="search_init form-control"/></th>
                    <th><input type="text" name="search_4" class="search_init form-control"/></th>

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