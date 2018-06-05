<?php
/**
* @package   Eclat
* @author    Elartica Team http://www.elartica.com
* @copyright Copyright (C) Elartica Team
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

// get warp
$warp = require(get_template_directory().'/warp.php');

if( ($warp['config']->get('site_offline') && $warp['config']->get('site_offline') == '1' && !stristr($_SERVER['REQUEST_URI'], '/wp-admin/') && !stristr($_SERVER['REQUEST_URI'], '/wp-login.php') && !is_user_logged_in()) ||  stristr($_SERVER['REQUEST_URI'], '/coming-soon/')){
    // load countdown theme file, located in /layouts/countdown.php
    echo $warp['template']->render('countdown');
} else {
    // load main theme file, located in /layouts/theme.php
    echo $warp['template']->render('theme');
}
