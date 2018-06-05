/* Copyright (C) YOOtheme GmbH, http://www.gnu.org/licenses/gpl.html GNU/GPL */

jQuery(function($)
{
    $(document).ready(function ()
    {
        $('input[type=checkbox]').each(function(){
            var input_name = $(this).attr('name'),
                input_next = $(this).next();

            if(input_next.attr('type') == 'hidden' && input_next.attr('name') == input_name )
            {
                $(this).on('change', function()
                {
                    if($(this).is(':checked')){
                        input_next.val('1');
                    } else {
                        input_next.val('0');
                    }
                });
            }

            if($(this).hasClass('onoff'))
            {
                $(this).onoff();
            }
        });
    });
});

