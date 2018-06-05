<?php
/**
* @package   Warp Theme Framework
* @author    Elartica Team http://www.elartica.com
* @copyright Copyright (C) Elartica Team
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

global $wp_registered_widgets;

$wp_registered_widgets['nav_menu-0'] = array(
    'id' => 'nav_menu-0',
    'name' => 'Main menu'
);

echo '<!--widget-nav_menu-0-->';
wp_nav_menu(array('theme_location' => 'main_menu', 'fallback_cb' => function() { wp_nav_menu(array("fallback_cb" => false)); }));
echo '<!--widget-end-->';
