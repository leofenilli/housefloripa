<?php
/**
* @package   Eclat
* @author    Elartica Team http://www.elartica.com
* @copyright Copyright (C) Elartica Team
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

// get warp
$warp = require(get_template_directory().'/warp.php');

// get content from output buffer and set a slot for the template renderer
$warp['template']->set('content', ob_get_clean());

// load main theme file, located in /layouts/theme.php
echo $warp['template']->render('theme');
