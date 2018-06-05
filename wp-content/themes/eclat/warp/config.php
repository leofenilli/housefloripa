<?php
/**
* @package   Warp Theme Framework
* @author    Elartica Team http://www.elartica.com
* @copyright Copyright (C) Elartica Team
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

return array(

    'helper' => array(
        'asset'       => 'Warp\Helper\AssetHelper',
        'assetfilter' => 'Warp\Helper\AssetfilterHelper',
        'check'       => 'Warp\Helper\CheckHelper',
        'dom'         => 'Warp\Helper\DomHelper',
        'event'       => 'Warp\Helper\EventHelper',
        'field'       => 'Warp\Helper\FieldHelper',
        'http'        => 'Warp\Helper\HttpHelper',
        'menu'        => 'Warp\Helper\MenuHelper',
        'path'        => 'Warp\Helper\PathHelper',
        'template'    => 'Warp\Helper\TemplateHelper',
        'useragent'   => 'Warp\Helper\UseragentHelper'
    ),

    'path' => array(
        'warp'    => array(get_template_directory()."/warp"),
        'config'  => array(get_template_directory().'/warp/config'),
        'js'      => array(get_template_directory().'/warp/js', get_template_directory().'/warp/vendor/uikit/js'),
        'layouts' => array(get_template_directory().'/warp/layouts')
    ),

    'menu' => array(
        'pre'    => 'Warp\Menu\Menu',
        'post'   => 'Warp\Menu\Post',
        'nav'    => 'Warp\Menu\Nav',
        'navbar' => 'Warp\Menu\Navbar',
        'subnav' => 'Warp\Menu\Subnav'
    ),

    'branding' => ''

);
