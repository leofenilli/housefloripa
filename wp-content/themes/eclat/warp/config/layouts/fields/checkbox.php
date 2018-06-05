<?php
/**
* @package   Warp Theme Framework
* @author    Elartica Team http://www.elartica.com
* @copyright Copyright (C) Elartica Team
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

// set attributes
$attributes = array('type' => 'checkbox', 'name' => $name);

// is checked ?
if ($node->attr('value') == $value) {
	$attributes = array_merge($attributes, array('checked' => 'checked'));
}

//printf('<p class="uk-form-controls-condensed '.($node->attr("center") ? 'uk-text-center':'').'"><label><input %s/> %s</label></p>', $control->attributes(array_merge($node->attr(), $attributes), array('label', 'description', 'default', 'column')), $node->attr('label'));
printf('<p class="uk-form-controls-condensed '.($node->attr("center") ? 'uk-text-center':'').'"><input class="onoff" %s/> <label>%s</label></p>', $control->attributes(array_merge($node->attr(), $attributes), array('label', 'description', 'default', 'column')), $node->attr('label'));