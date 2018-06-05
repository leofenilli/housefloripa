<?php
/**
* @package   Warp Theme Framework
* @author    Elartica Team http://www.elartica.com
* @copyright Copyright (C) Elartica Team
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

return array(

    'helper' => array(
       'system'  => 'Warp\Wordpress\Helper\SystemHelper',
       'option'  => 'Warp\Wordpress\Helper\OptionHelper',
       'widgets' => 'Warp\Wordpress\Helper\WidgetsHelper'
    ),

    'path' => array(
        'config'  => array(get_template_directory().'/warp/systems/wordpress/config'),
        'layouts' => array(get_template_directory().'/warp/systems/wordpress/layouts')
    ),

    'menu' => array(
        'pre' => 'Warp\Wordpress\Menu\Pre'
    )

);
