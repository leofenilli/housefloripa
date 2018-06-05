<?php
/**
* @package   Eclat
* @author    Elartica Team http://www.elartica.com
* @copyright Copyright (C) Elartica Team
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

return array(

    'path' => array(
        'theme'   => array(get_template_directory()),
        'js'      => array(get_template_directory().'/js'),
        'css'     => array(get_template_directory().'/css'),
        'less'    => array(get_template_directory().'/less'),
        'layouts' => array(get_template_directory().'/layouts')
    ),

    'less' => array(

        'vars' => array(
            'less:theme.less'
        ),

        'files' => array(
            '/css/theme.css' => 'less:theme.less',
            '/css/woocommerce.css' => 'less:woocommerce.less'
        )

    ),

    'cookie' => $cookie = md5(get_template_directory()),

    'customizer' => isset($_COOKIE[$cookie])

);
