/* Copyright (C) Elartica Team, http://www.gnu.org/licenses/gpl.html GNU/GPL */

jQuery(function($) {

    "use strict";

    var win    = $(window),
        html = $('html'),
        body = $('body'),
        login_form = $('#loginform'),
        lost_password_form = $('#lostpasswordform'),
        register_form = $('#registerform');

    html.addClass('uk-height-1-1');
    body.wrapInner('<div class="uk-vertical-align-middle uk-container-center uk-animation-fade"></div>').addClass('uk-height-1-1 uk-vertical-align uk-text-center');

    if(login_form.length)
    {
        var username = login_form.find('p').eq(0);
        var password = login_form.find('p').eq(1);

        var username_label = username.find('label').text();
        username.remove();

        var password_label = password.find('label').text();
        password.remove();

        login_form.html('<div class="form-group"><input id="user_pass" class="form-control" type="password" value="" name="pwd"><label for="user_pass"><span>' + password_label + '</span></label></div>' + login_form.html());
        login_form.html('<div class="form-group"><input id="user_login" class="form-control" type="text" value="" name="log"><label for="user_login"><span>' + username_label + '</span></label></div>' + login_form.html());

        $('#nav a').addClass('animate-border');

        var form_group = login_form.find('.form-group').eq(1);
        if ($('#nav').length) {
            form_group.after('<div class="uk-form-row">' + $('#nav').html() + '</div>');
            $('#nav').remove();
        }
        form_group.after('<div class="uk-form-row">' + $('p.submit').html() + '</div>');
        form_group.after('<div class="uk-form-row">' + $('p.forgetmenot').html() + '</div>');

        $('.message').addClass('uk-alert uk-alert-inline').removeClass('message');

        $('p.submit').remove();
        $('p.forgetmenot').remove();
    }
    else if(lost_password_form.length)
    {
        var lost_username = lost_password_form.find('p').eq(0);

        var lost_username_label = lost_username.find('label').text();
        lost_username.remove();

        lost_password_form.html('<div class="form-group"><input id="user_login" class="form-control" type="text" value="" name="user_login"><label for="user_login"><span>' + lost_username_label + '</span></label></div>' + lost_password_form.html());

        $('#nav a').addClass('animate-border');

        var lost_form_group = lost_password_form.find('.form-group').eq(0);
        if ($('#nav').length) {
            lost_form_group.after('<div class="uk-form-row">' + $('#nav').html() + '</div>');
            $('#nav').remove();
        }
        lost_form_group.after('<div class="uk-form-row">' + $('p.submit').html() + '</div>');

        $('.message').addClass('uk-alert').removeClass('message');

        $('p.submit').remove();
    }
    else if(register_form.length)
    {
        var reg_username = register_form.find('p').eq(0);
        var reg_email = register_form.find('p').eq(1);

        var reg_username_label = reg_username.find('label').text();
        reg_username.remove();

        var reg_email_label = reg_email.find('label').text();
        reg_email.remove();

        register_form.html('<div class="form-group"><input id="user_email" class="form-control" type="email" value="" name="user_email"><label for="user_email"><span>' + reg_email_label + '</span></label></div>' + register_form.html());
        register_form.html('<div class="form-group"><input id="user_login" class="form-control" type="text" value="" name="user_login"><label for="user_login"><span>' + reg_username_label + '</span></label></div>' + register_form.html());

        $('#nav a').addClass('animate-border');

        var reg_form_group = register_form.find('.form-group').eq(1);
        if ($('#nav').length) {
            reg_form_group.after('<div class="uk-form-row">' + $('#nav').html() + '</div>');
            $('#nav').remove();
        }
        reg_form_group.after('<div class="uk-form-row">' + $('p.submit').html() + '</div>');

        $('.message').html( $('.message').html() + '<br />' + $('#reg_passmail').text());

        $('.message').addClass('uk-alert').removeClass('message');

        //$('#reg_passmail').before('<div class="uk-alert uk-margin-remove uk-alert-inline">' + $('#reg_passmail').text() + '</div>');

        $('#reg_passmail').remove();
        $('p.submit').remove();
        $('.clear').remove();
    }

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

    $('form .form-control').on('focus', function(){
        form_input_check($(this).parents('form'));
    }).on('blur', function(){
        form_input_check($(this).parents('form'));
    });


});
