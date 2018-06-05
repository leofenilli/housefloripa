<?php
/**
* @package   Warp Theme Framework
* @author    Elartica Team http://www.elartica.com
* @copyright Copyright (C) Elartica Team
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

foreach ($node->children('option') as $option) {

	// set attributes
	$attributes = array('type' => 'radio', 'name' => $name, 'value' => $option->attr('value'));

	// is checked ?
	if ($option->attr('value') == $value) {
		$attributes = array_merge($attributes, array('checked' => 'checked'));
	}

	printf('<p class="uk-form-controls-condensed"><label><input %s> %s</label></p>', $control->attributes($attributes), $option->text());
}