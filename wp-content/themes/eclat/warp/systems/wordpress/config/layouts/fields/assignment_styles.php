<?php
/**
* @package   Warp Theme Framework
* @author    Elartica Team http://www.elartica.com
* @copyright Copyright (C) Elartica Team
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

    $options  = array();
    $styles = array('*' => 'All', 'default' => 'Default');

    $selected = is_array($value) ? $value : array('*');

    if (count($selected) > 1 && in_array('*', $selected)) {
        $selected = array('*');
    }

    if ($path = $this['path']->path('theme:styles')) {
        foreach (glob("$path/*") as $dir) {
            $style = basename($dir);
            $styles[$style] = $style;
        }
    }

    // set default options
    foreach ($styles as $val => $style) {
        $attributes = in_array($val, $selected) ? array('value' => $val, 'selected' => 'selected') : array('value' => $val);
        $options[]  = sprintf('<option %s>%s</option>', $control->attributes($attributes), $style);
    }

?>
<div class="uk-text-center">
    <div data-uk-dropdown="{mode:'click'}" class="uk-button-dropdown">
        <button type="button" class="uk-button uk-icon-bars"></button>
        <input type="hidden" name="<?php echo $name ?>[]" value="">
        <select class="uk-dropdown uk-dropdown-flip tm-assign-select" name="<?php echo $name ?>[]" multiple="multiple">
            <?php echo implode("", $options) ?>
        </select>
    </div>
</div>
