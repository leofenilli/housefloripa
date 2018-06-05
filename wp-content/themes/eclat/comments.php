<?php
/**
* @package   Eclat
* @author    Elartica Team http://www.elartica.com
* @copyright Copyright (C) Elartica Team
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

// get warp
$warp = require(get_template_directory().'/warp.php');

// load template file, located in /warp/systems/wordpress/layouts/comments.php
echo $warp['template']->render('comments');
