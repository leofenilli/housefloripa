<?php
/**
* @package   Eclat
* @author    Elartica Team http://www.elartica.com
* @copyright Copyright (C) Elartica Team
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

// start output buffer to capture content for use in footer.php
ob_start();

do_action('wp_enqueue_scripts');