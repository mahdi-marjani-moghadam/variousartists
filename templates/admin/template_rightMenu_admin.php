
        <aside class="side-left" id="side-left">
            <ul class="sidebar">
                <!--/sidebar-item-->
                <li>
                    <a href="<?php print RELA_DIR; ?>zamin/index.php">
                        <i class="sidebar-icon fa fa-home"></i>
                        <span class="sidebar-text">خانه</span>
                    </a>
                </li><!--/sidebar-item-->
                <li>
                    <a href="#">
                        <i class="sidebar-icon fa fa-bell"></i>
                        <span class="sidebar-text">رویدادها</span>
                        <b class="fa fa-angle-left"></b>
                    </a>
                    <ul class="sidebar-child animated fadeInRight">
                        <li>
                            <a href="<?=RELA_DIR; ?>zamin/?component=event">
                                <span class="sidebar-text text-16">لیست رویدادها</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?=RELA_DIR; ?>zamin/?component=event&action=draft">
                                <span class="sidebar-text text-16">لیست رویدادهای پیش نویس</span>
                            </a>
                        </li>

                    </ul>
                </li>
                <li>
                    <a href="<?=RELA_DIR; ?>zamin/?component=shop">
                        <i class="sidebar-icon fa fa-money"></i>
                        <span class="sidebar-text">فروش</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="sidebar-icon fa fa-user"></i>
                        <span class="sidebar-text">اعضا</span>
                        <b class="fa fa-angle-left"></b>
                    </a>
                    <ul class="sidebar-child animated fadeInRight">
                        <li>
                            <a href="<?=RELA_DIR; ?>zamin/?component=artists">
                                <span class="sidebar-text text-16">لیست هنرمندان</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?=RELA_DIR; ?>zamin/?component=membership">
                                <span class="sidebar-text text-16">لیست اعضا</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#">
                        <i class="sidebar-icon fa fa-tasks"></i>
                        <span class="sidebar-text">دسته بندی</span>
                        <b class="fa fa-angle-left"></b>

                    </a>
                    <ul class="sidebar-child animated fadeInRight">
                        <li>
                            <a href="<?=RELA_DIR; ?>zamin/?component=category">
                                <span class="sidebar-text text-16">لیست دسته بندی</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?=RELA_DIR; ?>zamin/?component=category&action=add">
                                <span class="sidebar-text text-16">افزودن دسته بندی جدید</span>
                            </a>
                        </li><!--/child-item-->
                        <li>
                            <a href="<?=RELA_DIR; ?>zamin/?component=genre">
                                <span class="sidebar-text text-16">لیست سبک</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?=RELA_DIR; ?>zamin/?component=genre&action=add">
                                <span class="sidebar-text text-16">افزودن سبک جدید</span>
                            </a>
                        </li><!--/child-item-->
                    </ul><!--/sidebar-child-->
                </li><!--/sidebar-item-->
                <li>
                    <a href="#">
                        <i class="sidebar-icon fa fa-tasks"></i>
                        <span class="sidebar-text">سالن ها</span>
                        <b class="fa fa-angle-left"></b>

                    </a>
                    <ul class="sidebar-child animated fadeInRight">
                        <li>
                            <a href="<?=RELA_DIR; ?>zamin/?component=salon">
                                <span class="sidebar-text text-16">لیست سالن ها</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?=RELA_DIR; ?>zamin/?component=salon&action=add">
                                <span class="sidebar-text text-16">افزودن سالن جدید</span>
                            </a>
                        </li><!--/child-item-->
                    </ul><!--/sidebar-child-->
                </li><!--/sidebar-item-->







                <li>
                    <a href="#">
                        <i class="sidebar-icon fa fa-info"></i>
                        <span class="sidebar-text">تنظیمات</span>
                        <b class="fa fa-angle-left"></b>
                    </a>
                    <ul class="sidebar-child animated fadeInRight">
                        <li>
                            <a href="<?=RELA_DIR; ?>zamin/?component=contactus">
                                <span class="sidebar-text text-16">Inbox</span>
                            </a>
                        </li><!--/child-item-->
                        <li>
                            <a href="<?=RELA_DIR; ?>zamin/?component=banner">
                                <span class="sidebar-text text-16"> بنر</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?=RELA_DIR; ?>zamin/?component=contactus&action=edit">
                                <span class="sidebar-text text-16">تماس با ما</span>
                            </a>
                        </li><!--/child-item-->
                        <li>
                            <a href="<?=RELA_DIR; ?>zamin/?component=aboutus&action=addAboutus">
                                <span class="sidebar-text text-16"> درباره ما</span>
                            </a>
                        </li><!--/child-item-->
                        <li>
                            <a href="<?=RELA_DIR; ?>zamin/?component=services">
                                <span class="sidebar-text text-16">ویرایش خدمات</span>
                            </a>
                        </li>
                    </ul><!--/sidebar-child-->
                </li><!--/sidebar-item-->


            </ul><!--/sidebar-->
        </aside><!--/side-left-->

        <div class="content">
