/* Copyright (C) Elartica Team, http://www.gnu.org/licenses/gpl.html GNU/GPL */

jQuery(function($)
{
    "use strict";

    var config = $('html').data('config') || {},
        win    = $(window),
        toolbar = $('.tm-toolbar'),
        navbar = $('.tm-navbar');

    // Chosen
    var eclat_chosen_init = function() {
        $('select.chosen, select.dropdown_product_cat, .widget_layered_nav select').chosen({disable_search_threshold: 10});
    };
    eclat_chosen_init();

    // Show Cart
    var show_cart_at_hover = function() {
        if ($.fn.hoverIntent) {
            $('.tm_cart_widget').hoverIntent(function(){
                $(this).find('.tm_cart_label').addClass('active').next('.tm_cart_wrapper').fadeIn(500);
            }, function(){
                $(this).find('.tm_cart_label').removeClass('active').next('.tm_cart_wrapper').fadeOut(500);
            });
        } else {
            $(document).on('mouseover', '.tm_cart_label', function () {
                $(this).addClass('active').next('.tm_cart_wrapper').fadeIn(500);
            }).on('mouseleave', '.tm_cart_label', function () {
                $(this).removeClass('active').next('.tm_cart_wrapper').fadeOut(500);
            });

            $(document).on('mouseenter', '.tm_cart_wrapper', function () {
                $(this).prev().addClass('active');
                $(this).stop(true, true).show();
            }).on('mouseleave', '.tm_cart_wrapper', function () {
                $(this).prev().removeClass('active');
                $(this).fadeOut(500);
            });
        }
    };
    show_cart_at_hover();

    // Number products
    $('#number-of-products').on('change', 'select', function(){
        window.location.href = $(this).val();
    });

    // List or grid type
    $('#list-or-grid').on( 'click', 'a', function() {
        var trigger = $(this),
            view = trigger.attr('class').replace('-view', '');

        $('ul.products li').removeClass('list grid').addClass( view );
        trigger.parent().find('a').removeClass('active');
        trigger.addClass('active');

        $.cookie("shop_view_cookie", view, {expires: 365, path: '/' });

        return false;
    });

    // sale product countdown
    var eclat_countdown_init = function(countdown_item, date_to){
        countdown_item.countdown(date_to, function(event) {
            var $this = $(this).html(event.strftime('<div class="uk-grid uk-grid-small">'
            + '<div class="uk-width-1-4"><div class="countdown_item"><span>%D</span>days</div></div>'
            + '<div class="uk-width-1-4"><div class="countdown_item"><span>%H</span>hours</div></div>'
            + '<div class="uk-width-1-4"><div class="countdown_item"><span>%M</span>min</div></div>'
            + '<div class="uk-width-1-4"><div class="countdown_item"><span>%S</span>sec</div></div></div>'));
        });
    };

    if($('.sale-product-countdown').length)
    {
        $('.tm-product').each(function(){
            var tip = $(this).find('.sale-product-countdown'),
                countdown_item = tip.find('div'),
                date_to = countdown_item.data('date_to');

            if(tip.length)
            {
                eclat_countdown_init(countdown_item, date_to);

                $(this).hover(
                    function () {
                        tip.appendTo('body');
                    },
                    function () {
                        tip.appendTo(this);
                    }
                ).mousemove(function (e) {
                        var x = e.pageX + 60,
                            y = e.pageY - 40;

                        tip.css({left: x, top: y});
                    });
            }
        });
    }
    if($('.single-product-countdown').length)
    {
        var countdown_item = $('.single-product-countdown').find('div'),
            date_to = countdown_item.data('date_to');

        eclat_countdown_init(countdown_item, date_to);
    }

    // Add to cart
    if( $('ul.products').length || $('ul.product_list_widget').length || $('td.product-add-to-cart').length || $('.tm-compare-container').length ) {

        var $p_spacer = new Array(),
            $i = 0,
            $j = 0;

        var add_to_cart = function ( el, parents) {

            $(document).on('click', el, function () {

                $p_spacer[$i] = $(this).parents(parents);
                $p_spacer[$i].block({message: null,
                    overlayCSS: {
                        cursor: 'none'
                    }
                });

                $i++;
            });
        };

        if( $('td.product-add-to-cart').length ) {
            add_to_cart('td.product-add-to-cart .add_to_cart_button', 'tr');
        } else {
            add_to_cart( 'li.product .add_to_cart_button', '.tm-product-spacer' );
        }


        $('body').on('added_to_cart', function () {

            if (typeof $p_spacer[$j] === 'undefined' )  return;

            var ico = $p_spacer[$j].find('.tm-icon-cart'),
                message = $('.widget_shopping_cart .ajax-product-added'),
                left_offset = $('.widget_shopping_cart .tm_cart_widget').offset().left-$('.widget_shopping_cart').offset().left;

            ico.addClass('add');

            message.css('left', left_offset+20).addClass('uk-animation-slide-top').show();

            setTimeout(function () {
                ico.removeClass('add');
                ico.parent().removeClass('added');
                message.removeClass('uk-animation-slide-top').fadeOut();
            }, 3000);

            $p_spacer[$j].unblock();

            $j++;

        });
    }

    // Delete product
    $(document).on('click', '.ajax-product-remove', function () {
        var product_id = $(this).attr("data-product_id");

        if($(this).parents('table').hasClass('shop_table')) {
            $(this).parents('table').block({
                message: null,
                overlayCSS: {
                    cursor: 'none'
                }
            });
        } else {
            $(this).parents('tr').block({
                message: null,
                overlayCSS: {
                    cursor: 'none'
                }
            });
        }
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: wc_add_to_cart_params.ajax_url,
            data: {
                action: "product_remove",
                product_id: product_id
            },
            success: function(response)
            {
                if ( ! response || response.error )
                    return;

                var this_page = window.location.toString(),
                    fragments = response.fragments,
                    cart_hash = response.cart_hash;

                // Block fragments class
                if ( fragments ) {
                    $.each( fragments, function( key, value ) {
                        $( key ).addClass( 'updating' );
                    });
                }

                // Block widgets and fragments
                $( '.shop_table.cart, .updating, .cart_totals' ).fadeTo( '400', '0.6' ).block({
                    message: null,
                    overlayCSS: {
                        opacity: 0.6
                    }
                });

                // Replace fragments
                if ( fragments ) {
                    $.each( fragments, function( key, value ) {
                        $( key ).replaceWith( value );
                    });
                }

                // Unblock
                $( '.widget_shopping_cart, .updating' ).stop( true ).css( 'opacity', '1' ).unblock();

                // Cart page elements
                $( '.shop_table.cart' ).load( this_page + ' .shop_table.cart:eq(0) > *', function(data) {

                    if($('.shop_table.cart:eq(0) > *').length == 0) {
                        $( '.shop_table.cart').parents('.woocommerce').html($(data).find('.uk-article .woocommerce').html());
                    }

                    $( '.shop_table.cart' ).stop( true ).css( 'opacity', '1' ).unblock();

                    $( document.body ).trigger( 'cart_page_refreshed' );
                });

                $( '.cart_totals' ).load( this_page + ' .cart_totals:eq(0) > *', function() {
                    $( '.cart_totals' ).stop( true ).css( 'opacity', '1' ).unblock();
                });

            }
        });

        return false;
    });

    // Product images gallery
    $(document).on('click', '.tm-main-images-slider .tm-icon-zoom', function () {
        $(this).parent().find('.zoom-product-image').trigger('click');
    });

    $('.tm-main-images-slider .uk-slider-container').owlCarousel({
        items: 1,
        navigation: true,
        lazyLoad: false,
        rewindNav: false,
        addClassActive: true,
        navigationText: ["", ""],
        itemsCustom: [1600, 1],
        afterMove: function (args) {
            var owlMain = $('.tm-main-images-slider .uk-slider-container').data('owlCarousel');
            var thumbnail_container = $('.thumbnails .uk-slider-container');
            var owlThumbs = thumbnail_container.data('owlCarousel');
            thumbnail_container.find('a').removeClass('uk-active');
            thumbnail_container.find('.owl-item').eq(owlMain.currentItem).find('a').addClass('uk-active');
            if (typeof owlThumbs != 'undefined') {
                owlThumbs.goTo(owlMain.currentItem - 1);
            }
        }
    });

    $('.thumbnails .uk-slider-container').owlCarousel({
        items: 5,
        transitionStyle: "fade",
        navigation: true,
        addClassActive: true,
        navigationText: ["", ""],
        itemsCustom: [[0, 3], [479, 4], [619, 5], [768, 4], [1200, 5], [1600, 5]]
    });

    $('.thumbnails .uk-slider-container .owl-item').click(function (e) {
        var owlMain = $('.tm-main-images-slider .uk-slider-container').data('owlCarousel');
        owlMain.goTo($(e.currentTarget).index());
    });

    $('.thumbnails .uk-slider-container a').click(function (e) {
        e.preventDefault();
    });

    // Product sidebar slider
    $('.tm-product-sidebar .product_list_widget').owlCarousel({
        items: 1,
        navigation: true,
        lazyLoad: false,
        rewindNav: false,
        addClassActive: true,
        navigationText: ["", ""],
        itemsCustom: [1600, 1],
        autoPlay: true
    });

    // Product images zoom
    var product_zoom_init = function(el){
        if (win.width() > 768) {
            el.swinxyzoom({
                mode: 'window',
                controls: false,
                size: '100%',
                dock: {position: 'right'}
            });
        }
    };
    product_zoom_init($('.tm-main-images-slider .zoom-product-image'));

    // Update sku and images
    var update_zoom_image = function(link, thumb, src, href, owlMain){
        if (win.width() > 768) {
            link.swinxyzoom("load", src, href);
        }
        if(thumb.length) {
            thumb.eq(0).find('a').attr('href', href).find('img').attr('src', src);
        }
        if(typeof owlMain != "undefined") {
            owlMain.goTo(0);
        }
    };

    $(document).on('found_variation', 'form.variations_form', function( event, variation ) {

        var $product = $(this).parents('.product'),
            $sku 	 = $product.find('.sku_wrapper .sku'),
            $img 	 = $product.find('.woocommerce-main-image img:eq(0)'),
            $link 	 = $product.find('.woocommerce-main-image'),
            o_src    = $img.attr('data-o_src'),
            o_href   = $link.attr('data-o_href'),
            v_image  = variation.image_src,
            v_link   = variation.image_link,
            owlMain  = $('.tm-main-images-slider .uk-slider-container').data('owlCarousel'),
            thumb    = $('.thumbnails .uk-slider-container .owl-item'),
            modal    = UIkit.modal("#product-quick-view");

        if ( modal.isActive() ) {
            owlMain  = $('#product-quick-view .tm-main-images-slider .uk-slider-container').data('owlCarousel');
            thumb    = $('#product-quick-view .thumbnails .uk-slider-container .owl-item');
        }

        if (!$sku.attr('data-o_sku'))
            $sku.attr('data-o_sku', $sku.text());

        if (o_src === undefined) {
            o_src = (!$img.attr('src')) ? '' : $img.attr('src');
            $img.attr('data-o_src', o_src);
        }

        if (o_href === undefined) {
            o_href = (!$link.attr('href')) ? '' : $link.attr('href');
            $link.attr('data-o_href', o_href);
        }

        if (variation.sku) {
            $sku.text(variation.sku);
        } else {
            $sku.text($sku.attr('data-o_sku'));
        }

        if (v_image && v_image.length > 1) {
            $img.attr('src', v_image);
            $link.attr('href', v_link);
            update_zoom_image($link, thumb, v_image, v_link, owlMain);
        } else {
            $img.attr('src', o_src);
            $link.attr('href', o_href);
            update_zoom_image($link, thumb, o_src, o_href, owlMain);
        }

    }).on( 'reset_image', 'form.variations_form', function( event ) {

        var $product = $(this).parents('.product'),
            $img 	 = $product.find('.woocommerce-main-image img:eq(0)'),
            $link 	 = $product.find('.woocommerce-main-image'),
            o_src    = $img.attr('data-o_src'),
            o_href   = $link.attr('data-o_href'),
            owlMain  = $('.tm-main-images-slider .uk-slider-container').data('owlCarousel'),
            thumb    = $('.thumbnails .uk-slider-container .owl-item'),
            modal    = UIkit.modal("#product-quick-view");

        if ( modal.isActive() ) {
            owlMain  = $('#product-quick-view .tm-main-images-slider .uk-slider-container').data('owlCarousel');
            thumb    = $('#product-quick-view .thumbnails .uk-slider-container .owl-item');
        }

        if ( o_src !== undefined && o_href !== undefined ) {
            $img.attr( 'src', o_src );
            $link.attr( 'href', o_href );
            update_zoom_image($link, thumb, o_src, o_href, owlMain);
        }

        return false;
    });

    var check_cookie_val = function() {
        var change_cookie_val = function(el_num, el_val){
            $(el_num).fadeOut('slow', function(){
                $(el_num).html(el_val).fadeIn();
            })
        };
        var check_static_cookie_val = function(cookie_name, el_num) {
            if(typeof $.cookie(cookie_name) !== "undefined" && $.cookie(cookie_name) != "") {
                if($(el_num).html() != $.cookie(cookie_name).split(',').length) {
                    change_cookie_val(el_num, $.cookie(cookie_name).split(',').length);
                }
            } else {
                if($(el_num).html() != '0') {
                    change_cookie_val(el_num, 0);
                }
            }
        };
        check_static_cookie_val('wish_list_id', '#wish-list-num');
        check_static_cookie_val('compare_list_id', '#compare-num');

        if($('ul.products').length) {
            if (typeof $.cookie('shop_view_cookie') !== "undefined" && $.cookie('shop_view_cookie') != "") {
                var view_cookie = $.cookie('shop_view_cookie');
                if (!$('ul.products > li').hasClass(view_cookie)) {
                    $('ul.products > li').removeClass('list').removeClass('grid').addClass(view_cookie);
                    $('#list-or-grid a').removeClass('active');
                    $('#list-or-grid a.' + view_cookie + '-view').addClass('active');
                }

            } else {
                $('ul.products > li').removeClass('list').removeClass('grid').addClass('grid');
                $('#list-or-grid a').removeClass('active');
                $('#list-or-grid a.grid-view').addClass('active');
            }
        }

    };
    check_cookie_val();

    // Remove cookie
    var remove_cookie = function(cookie_name, cookie_val){
        var temp = '',
            el_num = '';

        if(cookie_name == 'wish_list_id'){
            el_num = '#wish-list-num';
        } else {
            el_num = '#compare-num';
        }

        if(typeof $.cookie(cookie_name) !== "undefined" && $.cookie(cookie_name) != "") {

            var cookie_list_id = $.cookie(cookie_name);

            cookie_list_id = cookie_list_id.split(',');

            for(var i=0;i<cookie_list_id.length;i++){
                if(cookie_list_id[i] == cookie_val){
                    cookie_list_id.splice(i,1);
                }
            }

            temp = ( cookie_list_id instanceof Array ) ? cookie_list_id.join ( ',' ) : cookie_list_id;
            $.cookie(cookie_name, temp, {expires: 365, path: '/' });
            if(typeof $.cookie(cookie_name) !== "undefined" && $.cookie(cookie_name) != "") {
                $(el_num).html($.cookie(cookie_name).split(',').length);
            } else {
                $(el_num).html('0');
            }
        } else {
            $(el_num).html('0');
        }
    };

    /*remove_cookie('wish_list_id', 0);
     remove_cookie('compare_list_id', 0);*/

    // Wishlist
    if($('.wishlist-table tr.cart_item').size() == 0){
        $('.wishlist-table').hide();
    }

    var reset_wishlist = function(product_id, el) {
        var wish_list_href = $('.tm_wishlist_widget').find('a').attr('href'),
            wish_list_title = $('.tm_wishlist_widget').find('a').data('title'),
            message = $('.widget_shopping_cart .ajax-product-added'),
            left_offset = $('.widget_shopping_cart .tm_wishlist_widget').offset().left-$('.widget_shopping_cart').offset().left;

        $.cookie("wish_list_id", product_id, {expires: 365, path: '/' });
        $('#wish-list-num').html($.cookie("wish_list_id").split(',').length);
        el.attr('href', wish_list_href).attr('data-new-cached-title', wish_list_title).removeClass('add_wish_list').addClass('added');
        el.find('span.title').text(wish_list_title);

        message.css('left', left_offset+20).addClass('uk-animation-slide-top').show();

        setTimeout(function () {
            message.removeClass('uk-animation-slide-top').fadeOut();
        }, 3000);
    };

    $(document).on('click', '.add_wish_list', function(){

        if(!$(this).hasClass('add_wish_list') && $(this).attr("href") != "#"){
            window.location.href = $(this).attr("href");
        }

        var product_id = $(this).data('product_id');

        if(typeof $.cookie("wish_list_id") !== "undefined" && $.cookie("wish_list_id") != "") {

            var wish_list_id = $.cookie("wish_list_id"),
                temp = wish_list_id,
                is_empty = false,
                list_id = wish_list_id.split(',');

            for(var i=0;i<list_id.length;i++){
                if(list_id[i] == product_id){
                    is_empty = true;
                }
            }
            if(is_empty){

            } else {
                temp = temp + ',' + product_id;
                reset_wishlist(temp, $(this));
            }
        } else {
            reset_wishlist(product_id, $(this));
        }
        return false;
    });

    $(document).on('click', '.wishlist-product-remove', function(){
        if($('table.wishlist-table tr.cart_item').size() == 1) {
            $('table.wishlist-table').fadeOut(500, function () {
                $('table.wishlist-table').next().fadeIn();
                $(this).remove();
            });
        } else {
            var wishlist_table_tr = $(this).parents('tr');

            wishlist_table_tr.find('td').each(function(){
                $(this).css('width', $(this).width());
            });

            var wishlist_table_tr_html = wishlist_table_tr.html();

            wishlist_table_tr.html('<td style="padding: 0" colspan="'+wishlist_table_tr.find('td').size()+'"><div style="height: '+wishlist_table_tr.height()+'px"></div></td>');

            wishlist_table_tr.find('div').html('<div style="margin: -1px;"><table class="wishlist-table" cellspacing="0">'+wishlist_table_tr_html+'</table></div>').animate({
                'height': 0
            }, 500, function(){
                wishlist_table_tr.remove();
            });
        }
        remove_cookie('wish_list_id', $(this).data('product_id'));
        return false;
    });

    // Compare
    var reset_compare = function(product_id, el) {
        var compare_list_href = $('.tm_compare_widget').find('a').attr('href'),
            compare_list_title = $('.tm_compare_widget').find('a').data('title'),
            message = $('.widget_shopping_cart .ajax-product-added'),
            left_offset = $('.widget_shopping_cart .tm_compare_widget').offset().left-$('.widget_shopping_cart').offset().left;

        $.cookie("compare_list_id", product_id, {expires: 365, path: '/' });
        $('#compare-num').html($.cookie("compare_list_id").split(',').length);
        el.attr('href', compare_list_href).attr('data-new-cached-title', compare_list_title).removeClass('add_compare').addClass('added');
        el.find('span.title').text(compare_list_title);

        message.css('left', left_offset+20).addClass('uk-animation-slide-top').show();

        setTimeout(function () {
            message.removeClass('uk-animation-slide-top').fadeOut();
        }, 3000);
    };

    $(document).on('click', '.add_compare', function(){

        if(!$(this).hasClass('add_compare') && $(this).attr("href") != "#"){
            window.location.href = $(this).attr("href");
        }

        var product_id = $(this).data('product_id');

        if(typeof $.cookie("compare_list_id") !== "undefined" && $.cookie("compare_list_id") != "") {

            var compare_list_id = $.cookie("compare_list_id"),
                temp = compare_list_id,
                is_empty = false,
                list_id = compare_list_id.split(',');

            for(var i=0;i<list_id.length;i++){
                if(list_id[i] == product_id){
                    is_empty = true;
                }
            }
            if(is_empty){

            } else {
                temp = temp + ',' + product_id;
                reset_compare(temp, $(this));
            }
        } else {
            reset_compare(product_id, $(this));
        }
        return false;
    });

    // Compare page
    if ($('#carousel-compare').length) {
        var owl = $("#carousel-compare");

        if($('.my-account-menu').length) {
            owl.owlCarousel({
                navigation: true,
                slideSpeed: 500,
                paginationSpeed: 400,
                items: 2,
                itemsDesktop: [1220, 2],
                itemsDesktopSmall: [960, 2],
                itemsTablet: [768, 1],
                itemsMobile: [480, 1]
            });
        } else {
            owl.owlCarousel({
                navigation: true,
                slideSpeed: 500,
                paginationSpeed: 400,
                items: 3,
                itemsDesktop: [1220, 3],
                itemsDesktopSmall: [960, 2],
                itemsTablet: [768, 1],
                itemsMobile: [480, 1]
            });
        }

        $(document).on('click', '.compare-product-remove', function(){
            remove_cookie('compare_list_id', $(this).data('product_id'));

            var this_item = $(this).parents('.owl-item');
            var this_item_index = this_item.index();
            //this_item.wrap('<div style="overflow: hidden; float: left">').parent().animate({
            this_item.find('.tm-compare-element').css('width', this_item.width());
            this_item.animate({
                'width': 0
            }, 500, function(){
                $("#carousel-compare").data('owlCarousel').removeItem(this_item_index);
                if(typeof $.cookie("compare_list_id") !== "undefined" &&  $.cookie("compare_list_id") != "") {
                    $('#compare-num').html($.cookie("compare_list_id").split(',').length);
                } else {
                    $('#compare-num').html('0');
                    $('.tm-compare-container').fadeOut(500, function(){
                        $(this).next().fadeIn();
                    });
                }
            });
            return false;
        });

        $(document).on('click', '.remove_all_compare', function(){
            $.cookie("compare_list_id", '', {expires: 365, path: '/' });
            $('#compare-num').html('0');
            $('.tm-compare-container').fadeOut(500, function(){
                $(this).next().fadeIn();
            });
            return false;
        });
    }

    // Change quantity
    var change_quantity = function(qty_operator, qty_object)
    {
        var step = parseInt(qty_object.attr('step')),
            max = parseInt(qty_object.attr('max'));

        if(isNaN(step)){ step = 1; }

        if(isNaN(max)){ max = 100000; }

        if(qty_operator == "plus") {
            var Qtt = parseInt(qty_object.val());
            if (!isNaN(Qtt) && Qtt < max) {
                qty_object.val(Qtt + step);
            }
        }

        if(qty_operator == "minus") {
            var Qtt = parseInt(qty_object.val());
            if (!isNaN(Qtt) && Qtt > step) {
                qty_object.val(Qtt - step);
            } else qty_object.val(step);
        }

        if(qty_operator == "blur") {
            var Qtt = parseInt(qty_object.val());
            if (!isNaN(Qtt) && Qtt > max) {
                qty_object.val(max);
            }
        }

        $( 'div.woocommerce > form input[name="update_cart"]' ).prop( 'disabled', false );
    };

    $(document).on('click', '.quantity .plus', function(){
        change_quantity('plus', $(this).parent().find('.qty'));
    });
    $(document).on('click', '.quantity .minus', function(){
        change_quantity('minus', $(this).parent().find('.qty'));
    });
    $(document).on('blur', '.quantity .qty', function(){
        change_quantity('blur', $(this));
    });

    // Reset chosen
    $('body').on('woocommerce_variation_has_changed', function () {
        var select = $( this ).find( '.variations select' );

        select.each(function(){
            if($(this).val() == "") {
                $(this).chosen('destroy');
                $(this).chosen({disable_search_threshold: 10});
            }
        });
    });

    // Product quick view eclat fragment refresh
    var $eclat_fragment_refresh = {
        url: wc_cart_fragments_params.wc_ajax_url.toString().replace( '%%endpoint%%', 'get_refreshed_fragments' ),
        type: 'POST',
        success: function( data ) {
            if ( data && data.fragments ) {

                $.each( data.fragments, function( key, value ) {
                    $( key ).replaceWith( value );
                });

                $( document.body ).trigger( 'wc_fragments_refreshed' );
            }
        }
    };

    // Product quick view
    $(document).on('click', '.tm-quick-view-button', function(){
        var product_id = $(this).data('product_id'),
            modal = UIkit.modal("#product-quick-view"),
            quick_view_container = $('#product-quick-view-content'),
            product_url = $(this).prev().attr('href');

        quick_view_container.html('<div class="uk-modal-spinner-quick-view"></div>');

        modal.defaults.center = true;
        modal.options.center = true;

        toolbar.css('z-index', 1011);

        if ( modal.isActive() ) {
            modal.hide();
        } else {
            modal.show();
        }
        $.post( wc_add_to_cart_params.ajax_url, { action: 'eclat_load_product_quick_view', product_id: product_id }, function (html) {
            quick_view_container.html(html);

            modal.resize();

            // Product images gallery
            $('#product-quick-view .tm-main-images-slider .uk-slider-container').owlCarousel({
                items: 1,
                navigation: true,
                lazyLoad: false,
                rewindNav: false,
                addClassActive: true,
                navigationText: ["", ""],
                itemsCustom: [1600, 1]
            });

            eclat_chosen_init();
            product_zoom_init($('#product-quick-view .tm-main-images-slider .zoom-product-image'));

            /*if($('#svg_social').length){
                SVGSocial_init();
            }*/

            // wc_add_to_cart_variation_params is required to continue, ensure the object exists
            if ( $('#product-quick-view form.variations_form').length )
            {
                $('#product-quick-view form.variations_form').wc_variation_form();
                $('#product-quick-view form.variations_form select').change();
            }

            if($('#product-quick-view .single-product-countdown').length)
            {
                var countdown_item = $('#product-quick-view .single-product-countdown').find('div'),
                    date_to = countdown_item.data('date_to');

                eclat_countdown_init(countdown_item, date_to);
            }

            // add to cart
            //$(document).on('submit', 'form.cart', function (e) {
            $('form.cart').on('submit', function (e) {
                e.preventDefault();

                $("#product-quick-view").addClass('loader');

                var form = $(this);

                $.post(product_url, form.serialize() + '&_wp_http_referer=' + product_url, function (result) {

                    var cart_dropdown = $('.tm_cart_widget', result),
                        message = $('.widget_shopping_cart .ajax-product-added'),
                        left_offset = $('.widget_shopping_cart .tm_cart_widget').offset().left-$('.widget_shopping_cart').offset().left;

                    message.css('left', left_offset+20).addClass('uk-animation-slide-top').show();

                    setTimeout(function () {
                        message.removeClass('uk-animation-slide-top').fadeOut();
                    }, 3000);

                    // update dropdown cart
                    toolbar.find('.tm_cart_widget').replaceWith(cart_dropdown);

                    // update fragments
                    $.ajax($eclat_fragment_refresh);

                    show_cart_at_hover();

                    $("#product-quick-view").removeClass('loader');

                });
            });

        });
        return false;
    });

    $('#product-quick-view').on({
        'hide.uk.modal': function(){
            toolbar.css('z-index', 100);
        }
    });

    var propsSimHeight = function()
    {
        var container = $(".tm-compare-container"),
            propsContainer = container.find(".tm-compare-props"),
            props = propsContainer.find(".prop-one"),
            elementsContainer = container.find(".tm-compare-elements"),
            elementsContainerWrap = elementsContainer.find(".tm-elements-wrap"),
            elements = elementsContainer.find(".tm-compare-element"),
            elementsProps = elements.find(".prop-one"),
            propsArray = {},
            top_container = container.find(".top-container"),
            top_container_height = 0;

        top_container.each(function(){
            if($(this).outerHeight(true) > top_container_height){
                top_container_height = $(this).outerHeight(true);
            }
        });

        top_container.css({"height" : top_container_height, "position" : "relative"});

        props.each(function() {
            if(propsArray[$(this).data("id")] === undefined) {
                propsArray[$(this).data("id")] = [];
            }
            propsArray[$(this).data("id")].push(this);
        });

        elementsProps.each(function() {
            propsArray[$(this).data("id")].push(this);
        });

        for(var id in propsArray) {
            var colMaxHeight = 0;
            for(var element in propsArray[id]) {
                var wrap_height = $(propsArray[id][element]).find(".prop-wrap").outerHeight(true);
                if(wrap_height > colMaxHeight) {
                    colMaxHeight = wrap_height;
                }
            }
            $(propsArray[id]).css({"height" : colMaxHeight, "position" : "relative"});
        }
    };

    propsSimHeight();
    win.on('resize', function(){
        window.resizeEvt;
        win.resize(function(){
            clearTimeout(window.resizeEvt);
            window.resizeEvt = setTimeout(function(){
                propsSimHeight();
            }, 250);
        });
    });

    // hide cart
    $(document).on('click', function(e){
        if( $(e.target).closest(".tm_cart_widget").length ) return;
        $('.tm_cart_widget').find('.tm_cart_label').removeClass('active').next('.tm_cart_wrapper').fadeOut(500);
        e.stopPropagation();
    });

});
