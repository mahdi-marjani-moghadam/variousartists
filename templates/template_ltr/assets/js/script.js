/**
 * Created by omidkh on 2/9/2016 AD.
 */
$(document).ready(function()
{
    var $body = $('body'),
        $html = $('html'),
        $toggleNav = $('#toggleNav'),
        $newsContainer = $('#newsContainer'),
        $bestProduct = $('.bestProduct'),
        $navbarCollapse = $('.container.mainLink .navbar .navbar-collapse'),
        width = $(window).width(),
        height = $(window).height(),
        $slider = $('#slider'),
        $sliderPro=$('#slider-pro'),
        $searchParam = $body.find('#searchParam'),
        $validationForm = $('form[data-toggle="validator"]'),
        cityHolder = $('.container-location-city .city-list.is-open '),
        $marker = $(".marker"),
        $menucompany = $('.menucompany'),
        $tabMenu = $('.tab .tabMenu'),
        $searchKeyboard=$('.keyboard'),
        $tab = $('.tab .menucompany .angle-up-arrow');

    //mmenu
    $('nav.menu').each(function () {
        var placeholder = $(this).attr('data-placeholder');
        var title = $(this).attr('data-title');
        $(this).mmenu({
            "searchfield": {
                "placeholder": placeholder,
                "noResults": "جستجویی پیدا نشد",
                "add": true,
                "search": true,
                "resultsPanel": true,
                "showSubPanels": false,
                "showTextItems": true
            },
            extensions	: [ 'effect-slide-menu', 'pageshadow' ],
            searchField	: false,
            counters	: true,
            navbars		: [
                {
                    position: 'top',
                    content : [ 'searchfield']
                }
            ],
            navbar:{
                add: true,
                title: title,
                titleLink: "parent"
            }
        },
        {
            clone: false,
            offCanvas: {
                menuWrapperSelector: $(this).parent()
            },
            "searchfield": {
                "clear": true
            }
        });
    });
    $('.mm-search input')
        .addClass('keyboard2')
        .after('<img class="icon hidden-xs hidden-sm" src="/templates/template_fa/assets/images/keyboard.png">');

    //end of mmenu

    //on screen keyboard
    if(width > 992){
        $('.keyboard').keyboard({
            layout: 'ms-Persian',
            initialFocus : true,
            autoAccept : true,
            tabNavigation : true,
            usePreview: false,
            rtl: true,
            language: "fa",
            openOn: '',
            appendLocally : true
        });
        $('.keyboard2').keyboard({
            layout: 'ms-Persian',
            initialFocus : true,
            autoAccept : true,
            tabNavigation : true,
            usePreview: false,
            rtl: true,
            language: "fa",
            openOn: '',
            appendTo : '.categoryContainer',
            visible : function(event, keyboard, el) {
            },
            hidden : function(event, keyboard, el) {
            },
            beforeVisible: function(event, keyboard, el) {
                /*keyboard.$keyboard.addClass('transition');*/
                var x = $(this).offset(),
                    y = keyboard.$keyboard.width(),
                    z = 0;
                z = x.left - y - 10;
                keyboard.$keyboard.offset({top: x.top,left: z});
            }
        });
        // Typing Extension
        $('.icon').click(function () {
            var kb = $(this).prev().getkeyboard();
            // typeIn( text, delay, callback );
            kb.reveal();
        });
        $(document).on('scroll',function(){
            /*var xx=$('.keyboard2').offset();*/
            $('.ui-keyboard')
                .offset({top:127})
                .css("z-index", "9")
        });
        }//end of on screen keyboard

    //filter product
    $('.product-filter button').bind('click',function() {
        $(this).find('i').toggleClass('fa-rotate-180');
    });//end of filter product

    //search bar
    $('.search-bar button').bind('click',function() {
        $(this).find('.fa-angle-down').toggleClass('fa-rotate-180');
    });//end of search bar

    //login slider
    if($sliderPro.length){
        $sliderPro.sliderPro({
            width: '100%',
            height: '400px',
            arrows: true,
            buttons: false,
            waitForLayers: true,
            fade: true,
            autoplay: true,
            autoScaleLayers: false
        });
    }//end of login slider

    //hamburger menu
    $("#js-hamburger").on("click", function(e) {
        e.stopPropagation();
        $(this).toggleClass('is-active');
        $('.menu-content').toggleClass("is-open");
    });
    $(".menu-content").on("click", function(e) {
        e.stopPropagation();
    });
    //end of hamburger menu

    //keyDown
    $(this).keydown(function( e ) {
        var keycode = e.which ? e.which : e.keycode;
        if (keycode == 111 || keycode == 191 ) {
            $('.place').focus();
            return false;
        }
    });
    // end of keyDown

    $body.click(function() {
        //hamburger menu
        var menuHolder = $('.menu-content.is-open');
        if(menuHolder.hasClass('is-open')) {
            menuHolder.removeClass('is-open');
        }
        var hamburgerHolder = $('.hamburger.is-active');
        if(hamburgerHolder.hasClass('is-active')) {
            hamburgerHolder.removeClass('is-active');
        }
        if( $('.product-filter .btn-group').hasClass('open') ){
            $('.product-filter .btn-group i').removeClass('fa-rotate-180');
        }
        if( $('.search-bar .btn-group').hasClass('open') ){
            $('.search-bar .btn-group i').removeClass('fa-rotate-180');
        }
    });

    $('.container-location-city, .loginBtnContainer , .city-list').bind('click',function(e) {
        e.stopPropagation();
    });

    $('.showSort').click(function(e){
        e.preventDefault();
        var $find = $(this).find('i');
        if($find.hasClass('fa-sort-amount-asc')){
            $find.removeClass('fa-sort-amount-asc').addClass('fa-sort-amount-desc')
        }
        else{
            $find.addClass('fa-sort-amount-asc').removeClass('fa-sort-amount-desc')
        }
    });

    $marker.tooltip({placement: 'bottom'});
    if(width<500){
        $marker.tooltip( "disable" );
    }

    var mainPage = $('.mainPage');
    if(mainPage.length){
                                                                                                                                                                                                                                                                                               $('#categoryContainer').addClass('active');
    }
    
    $(window).scroll(function() {
        var $header1 = $('header.pageHeader');
        if($(this).scrollTop() > 80){
            $header1.addClass("sticky");
            $body.addClass('sticky');
        }
        else if($(this).scrollTop() < 20){
            $header1.removeClass("sticky");
            $body.removeClass('sticky');
        }
        var $tab = $('.tab');
        if($(this).scrollTop() > 320){
            $tab.addClass("stick");
            $body.addClass('stick');
        }
        else if($(this).scrollTop() < 350){
            $tab.removeClass("stick");
            $body.removeClass('stick');
        }
    });
    
    $('#myTabs a').click(function(e) {
        e.preventDefault();
        $(this).tab('show')
    });
    
    $body.on('submit', '#searchParam', function(e) {
        e.preventDefault();
        sublit_search();
    });

    // search function
    function sublit_search(a) {
        var question = $("#q").val(),
            type = $("#type").val(),
            address_search = $searchParam.attr("action"),
            final_address = baseURL + 'search/type/' + type;
        if (question.length > 0) {
            final_address += '/q/' + question;
        }
        window.location.href = final_address;
    }
    $toggleNav.bind('click', function() {
        var self = $(this),
            $mainLinks = $('.pageHeader .container.mainLink .navbar .navbar-nav>li');
        self.toggleClass('active');
        $body.toggleClass('fixed');
        $navbarCollapse.fadeToggle("fast");
        $navbarCollapse.toggleClass('in');

        if (self.hasClass('active')) {
            var speed = 1000;
            $mainLinks.each(function() {
                $(this).stop().slideDown(speed);
                speed += 400;
            });
        } else {
            $mainLinks.each(function() {
                $(this).stop().slideUp(10);
            });
        }
    });

    $('#q').focus(function() {
        $(this).parents('.search-wrap').addClass('active');
    }).blur(function() {
        $(this).parents('.search-wrap').removeClass('active');
    });

    if ($slider.length) {
        $slider.sliderPro({
            width: 860,
            height: 450,
            arrows: true,
            buttons: false,
            waitForLayers: true,
            thumbnailWidth: 215,
            thumbnailHeight: 100,
            thumbnailPointer: true,
            autoplay: false,
            autoScaleLayers: false,
            breakpoints: {
                1920: {
                    thumbnailWidth: 210
                },
                1200: {
                    thumbnailWidth: 190
                },
                768: {
                    thumbnailWidth: 190
                },
                500: {
                    thumbnails: false
                }
            }
        });
    }

        $('#categoryContainer header .hamburgerIcon').bind('click', function() {
            var self = $(this),
                categoryContainer = $('.mmenuHolder');
            
            if(self.hasClass('active')){
                self.removeClass('active');
                categoryContainer.removeClass('active');
            } else {
                self.addClass('active');
                categoryContainer.addClass('active');
            }
        });

        $('#categoryContainer .City').bind('click', function () {
            var self = $(this),
                $mmenuHolder1 = $('.mmenuHolder1');

            if (self.hasClass('active')) {
                self.removeClass('active');
                $mmenuHolder1.removeClass('active');
                $('.angle-up-arrow').removeClass("is-open");
            } else {
                self.addClass('active');
                $mmenuHolder1.addClass('active');
                $('.mmenuHolder').removeClass('active');
                $('.angle-up-arrow').addClass("is-open");
            }
        });

    $body.on('keypress', '.onlyNum', function(e) {
        var self = $(this),
            key = e.which ? e.which : e.keyCode;

        return !!((key > 47 && key < 58) || (key > 1775 && key < 1786) ||
        (key == 37 || key == 38 || key == 39 || key == 40 || key == 9 || key == 16 || key == 17 || key == 8));
    });
    $('.searchContainer a').bind('click', function(e) {
        e.preventDefault();
        var $searchContainer = $body.find('#searchContainer');

        if ($searchContainer.length && !$searchContainer.hasClass('hideSearch')) {

            $('html, body').animate({
                    scrollTop: $searchContainer.offset().top - 120
                },
                'slow',
                function() {
                    $("#searchContainer").find("#q").focus();
                });

        } else {
            var middleWidth = width / 2,
                middleHeight = parseInt(height / 3),
                searchWidth = parseInt($body.find('#searchContainer').width() / 2),
                searchHeight = parseInt($body.find('#searchContainer').height() / 2),
                totalWidth = middleWidth - searchWidth,
                totalHeight = middleHeight - searchHeight;

            $body.toggleClass('fixed');

            if (!$body.find('.overlay').length)
            {
                $('<div class="overlay transition"></div>').prependTo($body);
            }

            if ($('.overlay').is(":visible")) {
                $('.overlay').fadeOut(400);
            } else {
                $('.overlay').fadeIn(100);
            }

            $searchContainer.css('left', totalWidth + 'px');
            if ($searchContainer.hasClass('active')) {
                $searchContainer.removeClass('active');
                $searchContainer.css('top', '-100%');
            } else {
                $searchContainer.addClass('active');
                $searchContainer.css('top', totalHeight + 'px');
            }
        }
    });

    if ($newsContainer.length) {
        $newsContainer.find('.content').sliderPro({
            width: '100%',
            height: width < 768 ? 110 : 100,
            orientation: 'vertical',
            visibleSize: '100%',
            arrows: true,
            buttons: false,
            fadeArrows: false,
            autoplay: true
        });
        $('.newsContainer .sp-arrow.sp-next-arrow').append('<i class="fa fa-angle-left" aria-hidden="true"></i>');
        $('.newsContainer .sp-arrow.sp-previous-arrow').append('<i class="fa fa-angle-right" aria-hidden="true"></i>');
    }
    
    if ($bestProduct.length) {
        $bestProduct.find('.content1').sliderPro({
            width: $(window).width() < 768 ? "100%" :  "32%",
            height: 100,
            orientation: 'horizontal',
            visibleSize: '100%',
            arrows: true,
            buttons: false,
            fadeArrows: false,
            autoplay: true,
            responsive:true
        });
        $('.bestProduct .sp-arrow.sp-next-arrow').append('<i class="fa fa-angle-left" aria-hidden="true"></i>');
        $('.bestProduct .sp-arrow.sp-previous-arrow').append('<i class="fa fa-angle-right" aria-hidden="true"></i>');
    }   
    
    $body.find('input[required]').each(function() {
        $(this).parent('.form-group').append('<span class="requiredIcon">*</span>');
    });
    $(window).resize(function() {
        $('.navbar-collapse').hide()
    });
    $body.on('click', '.overlay,#searchContainer .hamburgerMenu', function() {
        $('.overlay').fadeOut(300);
        $body.find('#searchContainer').removeClass('active');
        $body.find('#searchContainer').css('top', '-100%');
        $body.removeClass('fixed');
    });

    if ($validationForm.length) {
        $validationForm.validator().on('submit', function(e) {
            var self_ = $(this),
                $field = $(e.relatedTarget);

            if (e.isDefaultPrevented()) {
                $field.parents('.form-group').append('<div class="errorHandler">' + $field.data("error") + '</div>');
                $field.parents('.form-group').removeClass('has-success').addClass('has-error');
                $field.parents('.form-group').find('.requiredIcon').html('<i class="fa fa-check"></i>')
            } else {
                return true;
            }
        }).on('valid.bs.validator', function(e) {
            var self_ = $(this),
                $field = $(e.relatedTarget);

            $field.parents('.form-group').find('.errorHandler').remove();
            $field.parents('.form-group').removeClass('has-error').addClass('has-success');
            $field.parents('.form-group').find('.requiredIcon').html('<i class="fa fa-check"></i>')
        }).on('invalid.bs.validator', function(e) {
            var self_ = $(this),
                $field = $(e.relatedTarget);

            $field.parents('.form-group').append('<div class="errorHandler">' + $field.data("error") + '</div>');
            $field.parents('.form-group').removeClass('has-success').addClass('has-error');
            $field.parents('.form-group').find('.requiredIcon').html('*')
        });
    }
    //scroll on detailCompany
    function smk_jump_to_it( _selector, _speed ){
        var offset = width > 768 ? 130 : 170;

        _speed = parseInt(_speed, 10) === _speed ? _speed : 300;

        $('.ui-keyboard').addClass('hidden-xs').addClass('hidden-sm');
        $(_selector).on('click', function(event){
            event.preventDefault();
            $('.link_classname').removeClass('active');
            $menucompany.removeClass('active');
            $tabMenu.removeClass('active');
            $tab.removeClass('is-open');
            $(this).addClass('active');
            var url = $(this).find('a').attr('href'); //cache the url.
            // Animate the jump
            $("html, body").animate({
                scrollTop: parseInt( $(url).offset().top ) - offset
            }, _speed);
        });
    }
    smk_jump_to_it( '.link_classname',700);
    //end of scroll on detailCompany

    //tabMenu detailCompany
    $menucompany.bind('click', function() {
        var self = $(this);
        if(self.hasClass('active')){
            self.removeClass('active');
            $tabMenu.removeClass('active');
            $tab.removeClass('is-open');
        } else {
            self.addClass('active');
            $tabMenu.addClass('active');
            $tab.addClass('is-open');
        }
    });
    $(window).resize(function() {
       width = $(window).width();
        var xxx=$('.keyboard2').offset(),
            yyy = $('.ui-keyboard').width(),
            zzz=0;
        zzz = xxx.left - yyy - 10;
       $('.ui-keyboard')
           .addClass('hidden-sm').addClass('hidden-xs')
           .offset({top: 127,left: zzz});
    });


});