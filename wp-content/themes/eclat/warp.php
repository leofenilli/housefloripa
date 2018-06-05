<?php
/**
* @package   Eclat
* @author    Elartica Team http://www.elartica.com
* @copyright Copyright (C) Elartica Team
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

use Warp\Warp;
use Warp\Autoload\ClassLoader;
use Warp\Config\Repository;

global $warp;

if (!$warp) {

    require_once(get_template_directory().'/warp/src/Warp/Autoload/ClassLoader.php');

    // set loader
    $loader = new ClassLoader;
    $loader->add('Warp', get_template_directory().'/warp/src');
    $loader->add('Warp\Wordpress', get_template_directory().'/warp/systems/wordpress/src');
    $loader->register();

    // set config
    $config = new Repository;
    $config->load(get_template_directory().'/warp/config.php');
    $config->load(get_template_directory().'/warp/systems/wordpress/config.php');
    $config->load(get_template_directory().'/config.php');

    // set warp
    $warp = new Warp(compact('loader', 'config'));
    $warp['system']->init();
}

return $warp;