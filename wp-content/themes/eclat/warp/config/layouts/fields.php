<?php
/**
* @package   Warp Theme Framework
* @author    Elartica Team http://www.elartica.com
* @copyright Copyright (C) Elartica Team
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

foreach ($fields->children('field') as $field) {

    $name  = $field->attr('name');
    $type  = $field->attr('type');
	$value = isset($values[$name]) ? $values[$name] : $field->attr('default');

	echo $this['field']->render($type, sprintf(($prefix ? "{$prefix}[%s]" : "%s"), $name), $value, $field, compact('config'));
}
