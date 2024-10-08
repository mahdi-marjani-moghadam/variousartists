<script type="text/javascript" src="../common/ckfinder/ckfinder.js"></script>
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
        // It is not required to return any value.
        // When false is returned, CKFinder will not close automatically.
        return false;
    }
</script>
<div class="content-control">
    <!--control-nav-->
    <ul class="control-nav pull-right">
        <li><a class="rtl text-24"><i class="sidebar-icon fa fa-adn"></i> ویرایش کمپانی</a></li>
    </ul><!--/control-nav-->
</div><!-- /content-control -->

<div class="content-body">
    <div id="panel-tablesorter" class="panel panel-warning">
        <div class="panel-heading bg-white">
            <h3 class="panel-title rtl">جزییات کمپانی</h3>
            <div class="panel-actions">
                <button data-expand="#panel-tablesorter" title="" class="btn-panel rtl" data-original-title="تمام صفحه">
                    <i class="fa fa-expand"></i>
                </button>
                <button data-collapse="#panel-tablesorter" title="" class="btn-panel rtl"
                        data-original-title="باز و بسته شدن">
                    <i class="fa fa-caret-down"></i>
                </button>
            </div><!-- /panel-actions -->
        </div><!-- /panel-heading -->

        <?php if($msg != null)
        { ?>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 alert alert-warning">
            <?php echo  $msg ?>
            </div>
            <?php
        }
        ?>
        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-8  center-block">
                    <form name="queue" id="queue" role="form" data-validate="form" class="form-horizontal form-bordered"
                          novalidate="novalidate" method="post">

                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label class="col-xs-12 col-sm-4 pull-right control-label rtl"
                                           for="company_name">نام کمپانی:</label>
                                    <div class="col-xs-12 col-sm-8 pull-right">
                                        <input type="text" class="form-control" name="company_name" id="company_name" required value="<?php echo  $list['company_name'] ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label class="col-xs-12 col-sm-4 pull-right control-label rtl"
                                           for="description">توضیحات:</label>
                                    <div class="col-xs-12 col-sm-8 pull-right">
                                        <input type="text" class="form-control" name="description" id="description" required value="<?php echo  $list['description'] ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row xsmallSpace hidden-xs"></div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label class="col-xs-12 col-sm-4 pull-right control-label rtl"
                                           for="certification_id">انتخاب گواهی:</label>
                                    <div class="col-xs-12 col-sm-8 pull-right">
                                        <select name="certification_id[]" id="certification_id" data-input="select2" multiple>
                                            <?php 
                                            foreach($list['certifications'] as $certification_id => $value)
                                            {
                                                ?>
                                                <option <?php echo in_array($value['Certification_id'], $list['certification_id']) ? 'selected' : '' ?>
                                                    value="<?php echo  $value['Certification_id'] ?>">
                                                    <?php echo  $value['title'] ?>
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
                                    <label class="col-xs-12 col-sm-4 pull-right control-label rtl"
                                           for="category_id">انتخاب دسته بندی:</label>
                                    <div class="col-xs-12 col-sm-8 pull-right">
                                        <select name="category_id[]" id="category_id" data-input="select2" multiple>
                                            <?php 
                                            foreach($list['category'] as $category_id => $value)
                                            {
                                                ?>
                                                <option <?php echo in_array($value['Category_id'], $list['category_id']) ? 'selected' : '' ?>
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

                        </div>
                        <div class="row xsmallSpace hidden-xs"></div>
                        <div class="row">
                            <!-- city -->
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label class="col-xs-12 col-sm-4 pull-right control-label rtl"
                                           for="city_id">انتخاب شهر:</label>
                                    <div class="col-xs-12 col-sm-8 pull-right">
                                        <select name="city_id" id="city_id" data-input="select2">
                                            <?php 
                                            foreach($list['cities'] as $city_id => $value)
                                            {
                                                ?>
                                                <option <?php echo  $value['City_id'] == $list['city_id'] ? 'selected' : '' ?>
                                                    value="<?php echo  $value['City_id'] ?>">
                                                    <?php echo  $value['name'] ?>
                                                </option>
                                                <?php 
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- state -->
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label class="col-xs-12 col-sm-4 col-md-4 pull-right control-label rtl"
                                           for="city_id">انتخاب استان:</label>
                                    <div class="col-xs-12 col-sm-8 col-md-8 pull-right">
                                        <select name="state_id" id="state_id" data-input="select2">
                                            <?php 
                                            foreach($list['states'] as $state_id => $value)
                                            {?>
                                                <option
                                                    <?php echo  $value['State_id'] == $list['state_id'] ? 'selected' : '' ?>
                                                    value="<?php echo  $value['State_id'] ?>">
                                                    <?php echo  $value['name'] ?>
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
                                    <label class="col-xs-12 col-sm-4 pull-right control-label rtl"
                                           for="meta_keyword">کلمات کلیدی:</label>
                                    <div class="col-xs-12 col-sm-8 pull-right">
                                        <input type="text" class="form-control" name="meta_keyword" id="meta_keyword" value="<?php echo  $list['meta_keyword'] ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label class="col-xs-12 col-sm-4 pull-right control-label rtl"
                                           for="meta_description">توضیحات متا:</label>
                                    <div class="col-xs-12 col-sm-8 pull-right">
                                        <input type="text" class="form-control" name="meta_description" id="meta_description" value="<?php echo  $list['meta_description'] ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row xsmallSpace hidden-xs"></div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label class="col-xs-12 col-sm-4 pull-right control-label rtl"
                                           for="registration_number">شماره ثبت:</label>
                                    <div class="col-xs-12 col-sm-8 pull-right">
                                        <input type="text" class="form-control" name="registration_number" id="registration_number" value="<?php echo  $list['registration_number'] ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label class="col-xs-12 col-sm-4 pull-right control-label rtl"
                                           for="national_id">شناسه ملی:</label>
                                    <div class="col-xs-12 col-sm-8 pull-right">
                                        <input type="text" class="form-control" name="national_id" id="national_id" value="<?php echo  $list['national_id'] ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row xsmallSpace hidden-xs"></div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label class="col-xs-12 col-sm-4 pull-right control-label rtl"
                                           for="instagram">آدرس instagram:</label>
                                    <div class="col-xs-12 col-sm-8 pull-right">
                                        <input type="text" class="form-control" name="instagram" id="instagram" value="<?php echo  $list['instagram'] ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label class="col-xs-12 col-sm-4 pull-right control-label rtl"
                                           for="twitter">آدرس twitter:</label>
                                    <div class="col-xs-12 col-sm-8 pull-right">
                                        <input type="text" class="form-control" name="twitter" id="twitter" value="<?php echo  $list['twitter'] ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row xsmallSpace hidden-xs"></div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label class="col-xs-12 col-sm-4 pull-right control-label rtl"
                                           for="telegram">آدرس telegram:</label>
                                    <div class="col-xs-12 col-sm-8 pull-right">
                                        <input type="text" class="form-control" name="telegram" id="telegram" value="<?php echo  $list['telegram'] ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label class="col-xs-12 col-sm-4 pull-right control-label rtl"
                                           for="coordinator_name">نام نماینده واحد تولیدی:</label>
                                    <div class="col-xs-12 col-sm-8 pull-right">
                                        <input type="text" class="form-control" name="coordinator_name" id="coordinator_name" value="<?php echo  $list['coordinator_name'] ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row xsmallSpace hidden-xs"></div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label class="col-xs-12 col-sm-4 pull-right control-label rtl"
                                           for="coordinator_family">نام خانوادگی نماینده واحد تولیدی:</label>
                                    <div class="col-xs-12 col-sm-8 pull-right">
                                        <input type="text" class="form-control" name="coordinator_family" id="coordinator_family" value="<?php echo  $list['coordinator_family'] ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label class="col-xs-12 col-sm-4 pull-right control-label rtl"
                                           for="coordinator_phone">شماره تلفن نماینده واحد تولیدی:</label>
                                    <div class="col-xs-12 col-sm-8 pull-right">
                                        <input type="text" class="form-control" name="coordinator_phone" id="coordinator_phone" value="<?php echo  $list['coordinator_phone'] ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row xsmallSpace hidden-xs"></div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label class="col-xs-12 col-sm-4 pull-right control-label rtl" for="status">وضعیت:</label>
                                    <div class="col-xs-12 col-sm-8 pull-right">
                                        <select name="status" id="status">
                                            <option
                                                value="1" <?php echo  ($list['status'] == 1) ? 'selected="selected"' : ''; ?>>تایید
                                            </option>
                                            <option value="0" <?php echo  ($list['status'] == 0) ? 'selected="selected"' : ''; ?>>در انتظار تایید
                                            </option>
                                            <option value="-1" <?php echo  ($list['status'] == -1) ? 'selected="selected"' : ''; ?>>تایید نشده
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label class="col-xs-12 col-sm-4 pull-right control-label rtl"
                                           for="priority">اولویت:</label>
                                    <div class="col-xs-12 col-sm-8 pull-right">
                                        <select name="priority" id="priority">
                                            <option value="1" <?php echo  ($list['priority'] == '1') ? 'selected="selected"' : ''; ?>>1
                                            </option>
                                            <option value="0" <?php echo  ($list['priority'] == '0') ? 'selected="selected"' : ''; ?>>0
                                            </option>
                                        </select>
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
                                        <div class="input-group" dir="ltr">
                                            <input name="logo" type="text" class="form-control" id="xImagePath" value="<?php echo  $list['logo']; ?>"/>
                                             <span class="input-group-btn">
                                             <input class="btn  btn-info" type="button" value="انتخاب فایل" onclick="BrowseServer( 'Images:/', 'xImagePath' );"/>
                                             </span>
                                        </div>
                                        <div id="preview" style="display:none">
                                            <strong>Selected Thumbnails</strong><br/>
                                            <div id="thumbnails"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label class="col-xs-12 col-sm-4 pull-right control-label rtl" for="refresh_date">تاریخ بروزرسانی</label>
                                    <div class="col-xs-12 col-sm-8 pull-right">
                                        <input type="text" class="form-control date" name="refresh_date" id="refresh_date" value="<?php echo  convertDate($list['refresh_date']) ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <!-- phone container -->
                        <div id="phone-container">
                            <?php foreach($list['company_phone']['subject'] as $i => $value) { ?>
                                <input type="hidden" name="company_phone[Company_phones_id][]" value="<?php echo  $list['company_phone']['Company_phones_id'][$i] ?>">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-6 col-md-3">
                                        <div class="form-group">
                                            <label class="col-xs-12 col-sm-4 pull-right control-label rtl" for="phone_subject">موضوع:</label>
                                            <div class="col-xs-12 col-sm-8 pull-right">
                                                <input type="text" class="form-control" name="company_phone[subject][]" id="phone_subject" value="<?php echo  $list['company_phone']['subject'][$i] ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-3">
                                        <div class="form-group">
                                            <label class="col-xs-12 col-sm-4 pull-right control-label rtl"
                                                   for="phone_number">شماره تلفن</label>
                                            <div class="col-xs-12 col-sm-8 pull-right">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="phone_number" name="company_phone[number][]" value="<?php echo  $list['company_phone']['number'][$i] ?>">
                                                    <div class="input-group-addon">+98</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-3">
                                        <div class="form-group">
                                            <div class="col-xs-12 col-sm-8 pull-right">
                                                <select name="company_phone[state][]" class="select-phone-state">
                                                    <option value="داخلی" <?php echo  ($list['company_phone']['state'][$i]) == 'داخلی' ? 'selected' : '' ?>>داخلی</option>
                                                    <option value="الی" <?php echo  ($list['company_phone']['state'][$i]) == 'الی' ? 'selected' : '' ?>>الی</option>
                                                    <option value="سایر" <?php echo  ($list['company_phone']['state'][$i]) == 'سایر' ? 'selected' : '' ?>>سایر</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-2">
                                        <div class="form-group">
                                            <label class="col-xs-12 col-sm-4 pull-right control-label rtl" for="phone_value">مقدار</label>
                                            <div class="col-xs-12 col-sm-8 pull-right">
                                                <input type="text" class="form-control" id="phone_value" name="company_phone[value][]" value="<?php echo  $list['company_phone']['value'][$i] ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-1">
                                        <div class="form-group">
                                            <div class="col-xs-12 col-sm-12 pull-right">
                                                <a href="#"
                                                   class="btn btn-sm btn-block btn-danger btn-remove-phone-container">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-2 pull-right">
                                <div class="form-group width2">
                                    <a href="#" id="btn-add-phone-container" class="btn btn-sm btn-block btn-info">
                                        <i class="fa fa-plus"></i>
                                        افزودن شماره تلفن
                                    </a>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <!-- email container -->
                        <div id="email-container">
                            <?php foreach($list['company_email']['subject'] as $i => $value) { ?>
                                <input type="hidden" name="company_email[Company_emails_id][]" value="<?php echo  $list['company_email']['Company_emails_id'][$i] ?>">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-6 col-md-3">
                                        <div class="form-group">
                                            <label class="col-xs-12 col-sm-4 pull-right control-label rtl"
                                                   for="email_subject">موضوع:</label>
                                            <div class="col-xs-12 col-sm-8 pull-right">
                                                <input type="text" class="form-control" name="company_email[subject][]"
                                                       id="email_subject" value="<?php echo  $list['company_email']['subject'][$i] ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-8">
                                        <div class="form-group">
                                            <label class="col-xs-12 col-sm-3 pull-right control-label rtl"
                                                   for="email_email">ادرس ایمیل</label>
                                            <div class="col-xs-12 col-sm-9 pull-right">
                                                <input type="email" class="form-control" id="email_email"
                                                       name="company_email[email][]" value="<?php echo  $list['company_email']['email'][$i] ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-1">
                                        <div class="form-group">
                                            <div class="col-xs-12 col-sm-12 pull-right">
                                                <a href="#" class="btn btn-sm btn-block btn-danger btn-remove-email-container">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-2 pull-right">
                                <div class="form-group width2">
                                    <a href="#" id="btn-add-email-container" class="btn btn-sm btn-block btn-info">
                                        <i class="fa fa-plus"></i>
                                        افزودن آدرس ایمیل
                                    </a>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <!-- address container -->
                        <div id="address-container">
                            <?php foreach($list['company_address']['subject'] as $i => $value) { ?>
                                <input type="hidden" name="company_address[Company_addresses_id][]" value="<?php echo  $list['company_address']['Company_addresses_id'][$i] ?>">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-6 col-md-3">
                                        <div class="form-group">
                                            <label class="col-xs-12 col-sm-4 pull-right control-label rtl"
                                                   for="address_subject">موضوع:</label>
                                            <div class="col-xs-12 col-sm-8 pull-right">
                                                <input type="text" class="form-control" name="company_address[subject][]" id="address_subject" value="<?php echo  $list['company_address']['subject'][$i] ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-8">
                                        <div class="form-group">
                                            <label class="col-xs-12 col-sm-3 pull-right control-label rtl" for="address_address">ادرس</label>
                                            <div class="col-xs-12 col-sm-9 pull-right">
                                            <textarea class="form-control" id="address_address" name="company_address[address][]" rows="3"><?php echo  $list['company_address']['address'][$i] ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-1">
                                        <div class="form-group">
                                            <div class="col-xs-12 col-sm-12 pull-right">
                                                <a href="#"
                                                   class="btn btn-sm btn-block btn-danger btn-remove-address-container">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-2 pull-right">
                                <div class="form-group width2">
                                    <a href="#" id="btn-add-address-container" class="btn btn-sm btn-block btn-info">
                                        <i class="fa fa-plus"></i>
                                        افزودن آدرس
                                    </a>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <!-- website container -->
                        <div id="website-container">
                            <?php foreach($list['company_website']['subject'] as $i => $value) { ?>
                                <input type="hidden" name="company_website[Company_websites_id][]" value="<?php echo  $list['company_website']['Company_websites_id'][$i] ?>">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-6 col-md-3">
                                        <div class="form-group">
                                            <label class="col-xs-12 col-sm-4 pull-right control-label rtl"
                                                   for="website_subject">موضوع:</label>
                                            <div class="col-xs-12 col-sm-8 pull-right">
                                                <input type="text" class="form-control" name="company_website[subject][]" id="website_subject" value="<?php echo  $list['company_website']['subject'][$i] ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-8">
                                        <div class="form-group">
                                            <label class="col-xs-12 col-sm-3 pull-right control-label rtl"
                                                   for="website_url">آدرس وب سایت</label>
                                            <div class="col-xs-12 col-sm-9 pull-right">
                                                <input type="text" class="form-control" id="website_url" name="company_website[url][]" value="<?php echo  $list['company_website']['url'][$i] ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-1">
                                        <div class="form-group">
                                            <div class="col-xs-12 col-sm-12 pull-right">
                                                <a href="#"
                                                   class="btn btn-sm btn-block btn-danger btn-remove-website-container">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-2 pull-right">
                                <div class="form-group width2">
                                    <a href="#" id="btn-add-website-container" class="btn btn-sm btn-block btn-info"><i class="fa fa-plus"></i>
                                        افزودن وب سایت
                                    </a>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <p class="pull-right">
                                    <input name="action" type="hidden" id="action" value="edit"/>
                                    <input name="Company_id" type="hidden" id="Company_id"
                                           value="<?php echo  $list['Company_id'] ?>"/>
                                    <input name="showStatus" type="hidden" id="Company_id"
                                           value="<?php echo $list['showStatus'] ?>"/>

                                    <button type="submit" name="update" id="submit"
                                            class="btn btn-icon btn-success rtl"><i class="fa fa-plus"></i>
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
