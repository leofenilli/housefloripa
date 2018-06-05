/* Copyright (C) Elartica Team, http://www.gnu.org/licenses/gpl.html GNU/GPL */

jQuery(function($) {

    "use strict";

    var config = $('html').data('config') || {},
        win    = $(window),
        toolbar = $('.tm-toolbar'),
        navbar = $('.tm-navbar');


    // Toolbar
    if (toolbar.length && toolbar.is(':visible') && config.sticky == 1) {

        $.UIkit.sticky(toolbar, (function(){

            var cfg = {top: 0, newtop: 0, media: 0};

            if (navbar.length && config.sticky_always == 1) {
                cfg.top = navbar.innerHeight() * -1;
                cfg.animation = 'uk-animation-slide-top';
                cfg.clsactive = ' tm-navbar-attached';
            } else if($('#wpadminbar').length) {
                cfg.top = $('#wpadminbar').innerHeight();
            }

            if($('body').hasClass('tm-combine-slider')) {
                cfg.top = $('.tm-main').offset().top * -1;
            }

            if($('#wpadminbar').length) {
                cfg.newtop = $('#wpadminbar').innerHeight();
            }

            return cfg;

        })());
    }

    jQuery('.tm-isblog').find('.uk-article-title').each(function(){
        jQuery(this).parent('div').prepend(jQuery(this));
        jQuery(this).css('margin-bottom', '10px')
    });

    $('.tm-toolbar .uk-navbar-nav').find('.uk-dropdown').addClass('uk-dropdown-center');

    // Navbar
    if (navbar.length) {
        navbar.find('.uk-dropdown').addClass('uk-dropdown-center');
    }

    var check_header_style = function(){
        if($('body').hasClass('tm-combine-slider') && navbar.length && $('.tm-navbar .tm-logo-center').length) {
            $('.tm-breadcrumbs').css('padding-top', navbar.innerHeight()+'px');
        } else {
            $('.tm-breadcrumbs').removeAttr('style');
        }
    };

    check_header_style();

    $('#show_search_form').on('click', function(){
        var search_icon = $(this).find("span");
        var search_block = $(this).prev();
        if(search_icon.hasClass('tm-icon-search')) {
            search_icon.removeClass('tm-icon-search').addClass('tm-icon-cancel');
        } else {
            search_icon.removeClass('tm-icon-cancel').addClass('tm-icon-search');
        }
        search_block.toggleClass('active');
    });

    // Progress bar
    $('.uk-progress-bar').on('inview.uk.scrollspy', function(){
        $(this).css('width', $(this).data('value')+'%' );
    });

    // Banner animation
    $('.tm-banner-block').on('inview.uk.scrollspy', function(){
        $(this).addClass('uk-active');
    });

    // Form
    $('span.wpcf7-form-control-wrap').replaceWith(function(){
        var this_id = $(this).next().attr('for');
        $(this).find('input, textarea').attr('id', this_id).addClass('form-control');
        return $(this).html();
    });

    var form_input_check = function(form){
        form.find('.form-group').each(function(){
            var input_val = $(this).find('.form-control').val();
            if(input_val) {
                $(this).addClass('input_check');
            } else {
                $(this).removeClass('input_check');
            }
        });
    };

    $('form .form-control').on('focus keyup', function(){
        form_input_check($(this).parents('form'));
    }).on('blur', function(){
        form_input_check($(this).parents('form'));
    });

    if($('form.eclat-newsletter').length) {

        $('form.eclat-newsletter').attr('action', 'http://'+window.location.hostname+'/?na=s');

        $('form.eclat-newsletter').submit(function () {
            var email = $(this).find('input[type="email"]'),
                re = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-]{1,})+\.)+([a-zA-Z0-9]{2,})+$/;

            if (!re.test(email.val())) {
                email.addClass('error').focus();
                return false;
            }

            return true;
        });
    }

    // Product Tab
    $('[data-uk-switcher]').on('show.uk.switcher', function(event, area){
        var tab_index = area.index();
        var active_tab = area.parent();
        var switcher_title = active_tab.prev();
        var switcher_content = active_tab.next();
        var new_title = switcher_content.find('> li').eq(tab_index).data('title');
        if(switcher_title.is('h2') && new_title) {
            switcher_title.text(new_title);
        }
    });

    // Category menu
    $('.widget_categories li').each(function () {
        var $this = $(this);
        if($this.hasClass('current-cat') || $this.hasClass('current-cat-parent')){
            $this.has('ul').prepend('<span class="open-child-menu uk-active"><span class="tm-icon-minus"></span></span>');
        } else {
            $this.has('ul').prepend('<span class="open-child-menu"><span class="tm-icon-plus"></span></span>');
        }
    });

    $(document).on('click', 'span.open-child-menu', function () {
        var $this = $(this);
        if ($this.hasClass('uk-active')) {
            $(this)
                .removeClass('uk-active')
                .html('<span class="tm-icon-plus"></span>')
                .siblings('ul')
                .slideUp('800');
        } else {
            $(this)
                .addClass('uk-active')
                .html('<span class="tm-icon-minus"></span>')
                .siblings('ul')
                .slideDown('800');
        }
    });

    // Offcanvas menu
    $('ul.uk-nav-offcanvas li').each(function () {
        var $this = $(this);
        if($this.hasClass('uk-active')){
            $this.has('ul').prepend('<span class="offcanvas-menu-toggle uk-active"><span class="tm-icon-arrow-up"></span></span>');
        } else {
            $this.has('ul').prepend('<span class="offcanvas-menu-toggle"><span class="tm-icon-arrow-down"></span></span>');
        }
    });

    $('span.offcanvas-menu-toggle').on('click', function () {
        var $this = $(this);
        if ($this.hasClass('uk-active')) {
            $(this)
                .removeClass('uk-active')
                .html('<span class="tm-icon-arrow-down"></span>')
                .siblings('ul')
                .slideUp('800');
        } else {
            $(this)
                .addClass('uk-active')
                .html('<span class="tm-icon-arrow-up"></span>')
                .siblings('ul')
                .slideDown('800');
        }
        return false;
    });

    //parse option
    var owl_get_option = function(str, notevil)
    {
        try {
            if (notevil) {
                return JSON.parse(str
                        // wrap keys without quote with valid double quote
                        .replace(/([\$\w]+)\s*:/g, function(_, $1){return '"'+$1+'":';})
                        // replacing single quote wrapped ones to double quote
                        .replace(/'([^']+)'/g, function(_, $1){return '"'+$1+'"';})
                );
            } else {
                return (new Function("", "var json = " + str + "; return JSON.parse(JSON.stringify(json));"))();
            }
        } catch(e) { return false; }
    };
    var owl_option = function(el)
    {
        var slider_param = el.data('owl-slideset'),
            start = (slider_param ? slider_param.indexOf("{") : -1),
            options = {};

        if (start != -1) {
            try {
                options = owl_get_option(slider_param.substr(start));
            } catch (e) {}
        }

        return options;
    };

    // product category slider
    if($('.owl-product-categories-slider').length){
        $('.owl-product-categories-slider').each(function(index)
        {
            var options = owl_option($(this));

            $(this).owlCarousel({
                /*items: options.large,*/
                transitionStyle: options.animation,
                navigation: true,
                addClassActive: true,
                navigationText: ["", ""],
                autoPlay: options.autoplay ? options.autoplayInterval : options.autoplay,
                rewindSpeed: 1000,
                stopOnHover: options.pauseOnHover,
                itemsCustom: [[0, options.default], [468, options.small], [768, options.medium], [1200, options.large]]
            });
        });
    }

    // product slider
    if($('.owl-product-slider').length){
        $('.owl-product-slider').each(function(index)
        {
            var options = owl_option($(this));

            $(this).owlCarousel({
                /*items: options.large,*/
                transitionStyle: options.animation,
                navigation: true,
                addClassActive: true,
                navigationText: ["", ""],
                autoPlay: options.autoplay ? options.autoplayInterval : options.autoplay,
                rewindSpeed: 1000,
                stopOnHover: options.pauseOnHover,
                itemsCustom: [[0, options.default], [468, options.small], [980, options.medium], [1180, options.large], [1600, options.xlarge]]
            });
        });
    }

    // testimonials slider
    if($('.owl-testimonials-slider').length){
        $('.owl-testimonials-slider').each(function(index)
        {
            var options = owl_option($(this));

            $(this).owlCarousel({
                items: options.default,
                transitionStyle: options.animation,
                navigation: true,
                addClassActive: true,
                navigationText: ["", ""],
                singleItem : true,
                autoHeight : true,
                autoPlay: options.autoplay ? options.autoplayInterval : options.autoplay,
                rewindSpeed: 1000,
                stopOnHover: options.pauseOnHover
            });
        });
    }

    // slider resize
    var slider_resize = function()
    {
        if($('.tm-products-slider').length)
        {
            var slidenav_el_height = $('.tm-products-slider .uk-slidenav-position').find('li').eq(0).find('.tm-product-slider-inner').height()+50,
                slidenav_el_height_owl = $('.tm-products-slider .uk-slidenav-position').find('.owl-item').eq(0).find('.tm-product-slider-inner').height()+50;

            $('.tm-products-slider .uk-slidenav-position li').each(function(index){
                if(index%2){
                    $(this).find('.tm-product-slider-spacer').css('height', slidenav_el_height);
                }
            });

            $('.tm-products-slider .owl-wrapper .owl-item').each(function(index){
                if(index%2){
                    $(this).find('.tm-product-slider-spacer').css('height', slidenav_el_height_owl);
                }
            });
        }
    };

    if($('.tm-products-slider').length){
        $('.tm-products-slider img').eq(0).bindImageLoad(function (){
            slider_resize();
        });
    }

    // Fix footer
    var footer_move = function()
    {
        $("#wrapper").css('margin-bottom', $("#footer").outerHeight(true));
    };

    footer_move();
    win.on('resize', function(){
        window.resizeEvt;
        win.resize(function(){
            clearTimeout(window.resizeEvt);
            window.resizeEvt = setTimeout(function(){
                footer_move();
                slider_resize();
            }, 250);
        });
    });

    // Scroll to top
    win.scroll(function () {
        if (win.scrollTop() > 200) {
            $('.tm-totop-scroll').addClass('uk-active');
        } else {
            $('.tm-totop-scroll').removeClass('uk-active');
        }
    });

    // SVG Social icon
    var SVGSocial_init = function()
    {
        function SVGSocial( el, options ) {
            this.el = el;
            this.init();
        }

        SVGSocial.prototype.init = function() {
            this.trigger = this.el.querySelector( 'button.trigger' );
            this.shapeEl = this.el.querySelector( 'span.morph-shape' );

            var s = Snap( this.shapeEl.querySelector( 'svg' ) );
            this.pathEl = s.select( 'path' );
            this.paths = {
                reset : this.pathEl.attr( 'd' ),
                active : this.shapeEl.getAttribute( 'data-morph-active' )
            };

            this.isOpen = false;

            this.initEvents();
        };

        SVGSocial.prototype.initEvents = function() {
            this.trigger.addEventListener( 'click', this.toggle.bind(this) );
        };

        SVGSocial.prototype.toggle = function() {
            var self = this;

            if( this.isOpen ) {
                $('#svg_social').removeClass('active')
            }
            else {
                setTimeout( function() { $('#svg_social').addClass('active') }, 175 );
            }

            this.pathEl.stop().animate( { 'path' : this.paths.active }, 150, mina.easein, function() {
                self.pathEl.stop().animate( { 'path' : self.paths.reset }, 800, mina.elastic );
            } );

            this.isOpen = !this.isOpen;
        };

        new SVGSocial( document.getElementById( 'svg_social' ) );
    };

    if($('#svg_social').length){
        SVGSocial_init();
    }

    // custom-modal
    if($('#custom-modal').length && ($.cookie("custom_modal_cookie") != 'hide' || $.cookie("custom_modal_length") != $('#custom-modal').text().length)){
        var modal = UIkit.modal("#custom-modal", {center:true});

        if ( !modal.isActive() ) {
            modal.show();
        }

        $('#custom-modal').on({
            'hide.uk.modal': function(){
                $.cookie("custom_modal_cookie", 'hide', {expires: 365, path: '/' });
                $.cookie("custom_modal_length", $('#custom-modal').text().length, {expires: 365, path: '/' });
            }
        });
    }
});

(function ($){

    "use strict";

    $.fn.bindImageLoad = function (callback){
        function isImageLoaded(img){
            if (!img.complete){
                return false;
            }

            if (typeof img.naturalWidth !== "undefined" && img.naturalWidth === 0){
                return false;
            }

            return true;
        }

        return this.each(function (){
            var ele = $(this);
            if (ele.is("img") && $.isFunction(callback)){
                ele.one("load", callback);
                if (isImageLoaded(this)){
                    ele.trigger("load");
                }
            }
        });
    };
})(jQuery);
