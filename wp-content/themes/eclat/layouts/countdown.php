<?php
/**
 * @package   Eclat
 * @author    Elartica Team http://www.elartica.com
 * @copyright Copyright (C) Elartica Team
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

$this['asset']->addFile('js', 'js:jquery.countdown.min.js');
$this['asset']->addFile('css', 'css:theme.css');

?>

<!DOCTYPE HTML>
<html lang="<?php echo $this['config']->get('language'); ?>" dir="<?php echo $this['config']->get('direction'); ?>" class="uk-height-1-1 tm-countdown">

    <head>
        <?php echo $this['template']->render('head'); ?>
    </head>

    <body class="uk-height-1-1 uk-vertical-align uk-text-center">

        <div class="uk-vertical-align-middle uk-container-center">

            <div class="logo"></div>
            <div class="message"><?php echo $this['config']->get('site_offline_message'); ?></div>

            <div id="countdown"></div>
            <script type="text/javascript">
                jQuery(function($)
                {
                    "use strict";

                    var date_to = '<?php echo $this['config']->get('site_offline_end_time'); ?>';
                    if ($.browser.webkit || $.browser.chrome)
                    {
                        var date_to_arr = date_to.split(" ");
                        date_to = date_to_arr[0];
                    }

                    $('#countdown').countdown(date_to, function(event)
                    {
                        var $this = $(this).html(event.strftime('<div class="uk-grid">'
                        + '<div class="uk-width-1-5"><div class="countdown_item"><span>%w</span><?php esc_html_e( 'weeks', 'eclat' )?></div></div>'
                        + '<div class="uk-width-1-5"><div class="countdown_item"><span>%d</span><?php esc_html_e( 'days', 'eclat' )?></div></div>'
                        + '<div class="uk-width-1-5"><div class="countdown_item"><span>%H</span><?php esc_html_e( 'hours', 'eclat' )?></div></div>'
                        + '<div class="uk-width-1-5"><div class="countdown_item"><span>%M</span><?php esc_html_e( 'min', 'eclat' )?></div></div>'
                        + '<div class="uk-width-1-5"><div class="countdown_item"><span>%S</span><?php esc_html_e( 'sec', 'eclat' )?></div></div></div>'));
                    });
                });
            </script>

            <?php if ($this['widgets']->count('social')) : ?>
                <div class="tm-countdown-social-menu">
                    <?php echo $this['widgets']->render('social');?>
                </div>
            <?php endif; ?>

            <?php if ($this['widgets']->count('footer')) : ?>
                <div class="tm-countdown-footer">
                    <?php echo $this['widgets']->render('footer');?>
                </div>
            <?php endif; ?>

        </div>
        <?php echo $this->render('footer'); ?>
    </body>
</html>