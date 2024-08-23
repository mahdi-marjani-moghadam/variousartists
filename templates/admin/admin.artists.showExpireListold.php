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
  function call (extention,number,id)
  {
    var dataString = 'extention='+ extention+'&number='+ number;
   $("#loading").show();
  $.ajax({
  type:'POST',
  url:'<?=RELA_DIR?>zamin/?component=company&action=call',
  type: "POST",
  data: dataString,
  cache: false,
  success: function (data)
  {
    $("#loading").hide();
    if(data=='yes')
  	{
  		window.location='<?=RELA_DIR?>zamin/?component=company&action=edit&id='+id;

  	}else
  	{

  	}
  }
  });

  }
</script>
<div class="content-control">
  <!--control-nav-->
  <ul class="control-nav pull-right">
    <li><a class="rtl text-24"><i class="sidebar-icon fa fa-adn"></i>  لیست کمپانی های منقضی شده</a></li>
  </ul><!--/control-nav-->
</div><!-- /content-control -->

<div class="content-body">
  <!-- separator -->
  <div class="row xsmallSpace"></div>
  <div id="panel-1" class="panel panel-default border-blue">
    <div class="panel-heading bg-blue">
      <h3 class="panel-title rtl">لیست کمپانی های منقضی شده</h3>
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
        <!-- separator -->
        <div class="row smallSpace"></div>
          <div class="table-responsive table-responsive-datatables">
            <table id="example" class="companyTable table table-striped table-bordered rtl" cellspacing="0" width="100%">
              <thead>
              <tr>
                <th>ردیف</th>
                <th>نام کمپانی</th>
                <th>شماره نماینده</th>
                <th>آخرین بروزرسانی</th>
                <th>تاریخ انقضاء</th>
                <th>وضعیت</th>
                <th>تصویر</th>
                <th>ابزار</th>
              </tr>
              </thead>
              <tbody>
              <?php
              $cn = 1;
              if (isset($list['list'])) {
                  foreach ($list['list'] as $id => $fields) {
                      ?>
                  <tr>
                      <td><?php echo $fields['Company_id'];?></td>
                      <td><?php echo $fields['company_name'];?></td>
                      <td>
                        <?php if(count($fields['company_phone']['subject'])) { ?>
                        <br>

                        <?=$fields['company_phone']['subject'][0]?>
                        <div class="call" onclick="return call(<?=$fields['company_phone']['number'][0]?>,<?=$admin_info['extention']?>,<?=$fields['Company_id']?>);" ><?=$fields['company_phone']['number'][0]?></div>
  						<?
                          if($fields['company_phone']['state'][0] == 'سایر')
                            echo "";
                          else
                            echo $fields['company_phone']['state'][0].' ';

                          echo $fields['company_phone']['value'][0];
                        ?>
                        <br>
                        <?php if(count($fields['company_phone']['subject']) > 1) { ?>
                        <b style="cursor:pointer;" data-toggle="popover" title="شماره تلفن های ثبت شده" data-placement="left" data-content="
                        <?php for ($i = 1;$i < count($fields['company_phone']['subject']); $i++)
                        {
                            echo $fields['company_phone']['subject'][$i].' '.$fields['company_phone']['number'][$i].' ';

                            if($fields['company_phone']['state'][$i] == 'سایر')
                              echo "";
                            else
                              echo $fields['company_phone']['state'][$i].' ';

                            echo $fields['company_phone']['value'][$i].'<br>';
                        }
                        ?>">بیشتر</b>
                        <?php } ?>
                        <?php } ?>
                      </td>
                      <td><?= convertDate($fields['refresh_date']) ?></td>
                      <td><?= convertDate(date('Y-m-d',strtotime(COMPANY_EXPIRE_PERIOD,strtotime($fields['refresh_date'])))) ?></td>
                      <td dir="ltr" align="center">
                      <?php echo $fields['status']; ?>
                      </td>
                    <td><img height="60" src="<?php echo $fields['logo'];?>"></td>
                    <td>
                        <a href="<?=RELA_DIR?>zamin/?component=company&action=edit&id=<?php echo $fields['Company_id'];?>">ویرایش</a> <br/>
                        <a href="<?=RELA_DIR?>zamin/?component=product&id=<?php echo $fields['Company_id'];?>">لیست محصولات</a><br/>
                        <a href="<?=RELA_DIR?>zamin/?component=honour&id=<?php echo $fields['Company_id'];?>">لیست افتخارات</a><br/>
                        <a href="<?=RELA_DIR?>zamin/?component=licence&id=<?php echo $fields['Company_id'];?>">لیست مجوز ها</a><br/>
                        <a href="<?=RELA_DIR?>zamin/?component=company&action=delete&id=<?php echo $fields['Company_id'];?>">حذف</a>
                    </td>
                  </tr>
              <?php

                  }
              }
              ?>
              </tbody>
              <tfoot>
                <th><input type="hidden" name="search_1" class="search_init form-control" /></th>
                <th><input type="text" name="search_2" class="search_init form-control" /></th>
                <th><input type="text" name="search_3" class="search_init form-control" /></th>
                <th><input type="text" name="search_4" class="search_init form-control" /></th>
                <th><input type="text" name="search_5" class="search_init form-control" /></th>
                <th><input type="text" name="search_6" class="search_init form-control" /></th>
                <th><input type="hidden" name="search_7" class="search_init form-control" /></th>
              </tfoot>
            </table>
          </div>
    </div>
    <div class="panel-footer clearfix">
    </div>
  </div>
</div><!--/content-body -->
