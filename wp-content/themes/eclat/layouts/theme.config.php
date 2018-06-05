<?php
/**
* @package   Eclat
* @author    Elartica Team http://www.elartica.com
* @copyright Copyright (C) Elartica Team
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

/*
 * Generate 3-column layout
 */
$config          = $this['config'];
$sidebars        = $config->get('sidebars', array());
$columns         = array('main' => array('width' => 60, 'alignment' => 'right'));
$sidebar_classes = '';

/*Check cookie*/
$config->set('eclat_topbar', 1);

if(isset($_COOKIE["eclat_topbar"]) && $_COOKIE["eclat_topbar"] == '1') {
    $config->set('eclat_topbar', 1);
}

if(isset($_COOKIE["eclat_header_inline"]) && $_COOKIE["eclat_header_inline"] == '0') {
    $config->set('eclat_header_inline', true);
}

if(isset($_COOKIE["eclat_footer_bg"]) && $_COOKIE["eclat_footer_bg"] == '0') {
    $config->set('eclat_footer_bg', true);
}

if($config->get('style') == 'mix' || stripos($config->get('style'), 'mix') !== false){
    $config->set('eclat_combine_slider', 0);
}

/**/
$gcf = function($a, $b = 60) use(&$gcf) {
    return (int) ($b > 0 ? $gcf($b, $a % $b) : $a);
};

$fraction = function($nominator, $divider = 60) use(&$gcf) {
    return $nominator / ($factor = $gcf($nominator, $divider)) .'-'. $divider / $factor;
};

foreach ($sidebars as $name => $sidebar) {
	if (!$this['widgets']->count($name)) {
        unset($sidebars[$name]);
        continue;
    }

    $columns['main']['width'] -= @$sidebar['width'];
    $sidebar_classes .= " tm-{$name}-".@$sidebar['alignment'];
}

if ($count = count($sidebars)) {
	$sidebar_classes .= ' tm-sidebars-'.$count;
}

$columns += $sidebars;
foreach ($columns as $name => &$column) {

    $column['width']     = isset($column['width']) ? $column['width'] : 0;
    $column['alignment'] = isset($column['alignment']) ? $column['alignment'] : 'left';

    $shift = 0;
    foreach (($column['alignment'] == 'left' ? $columns : array_reverse($columns, true)) as $n => $col) {
        if ($name == $n) break;
        if (@$col['alignment'] != $column['alignment']) {
            $shift += @$col['width'];
        }
    }
    $column['class'] = sprintf('tm-%s uk-width-large-%s%s', $name, $fraction($column['width']), $shift ? ' uk-'.($column['alignment'] == 'left' ? 'pull' : 'push').'-'.$fraction($shift) : '');
}

/*
 * Add grid classes
 */
$positions = array_keys($config->get('grid', array()));
$displays  = array('small', 'medium', 'large');
$grid_classes = array();
$display_classes = array();
foreach ($positions as $position) {

    $grid_classes[$position] = array();
    $grid_classes[$position][] = "tm-{$position} uk-grid";
    $display_classes[$position][] = '';

    if ($this['config']->get("grid.{$position}.divider", false)) {
        $grid_classes[$position][] = 'uk-grid-divider';
    }

    $widgets = $this['widgets']->load($position);

    foreach($displays as $display) {
        if (!array_filter($widgets, function($widget) use ($config, $display) { return (bool) $config->get("widgets.{$widget->id}.display.{$display}", true); })) {
            $display_classes[$position][] = "uk-hidden-{$display}";
        }
    }

    $display_classes[$position] = implode(" ", $display_classes[$position]);
    $grid_classes[$position] = implode(" ", $grid_classes[$position]);

}

/*
 * Add body classes
 */

$body_classes  = $sidebar_classes;
$body_classes .= $this['system']->isBlog() ? ' tm-isblog' : ' tm-noblog';
$body_classes .= ' '.$config->get('page_class');

if(!$config->get('eclat_combine_slider', true)){
    $body_classes .= ' tm-combine-slider';
}

if(get_post_type() == 'portfolio' || stristr($_SERVER['REQUEST_URI'], 'portfolio')) {
    $body_classes .= ' portfolio';
}
if(get_post_type() == 'testimonial' || stristr($_SERVER['REQUEST_URI'], 'testimonial') || stristr($_SERVER['REQUEST_URI'], 'testimonials')) {
    $body_classes .= ' testimonial';
}

$config->set('body_classes', trim($body_classes));

/*
 * Add social buttons
 */

$body_config = array();
$body_config['sticky'] = (int) $config->get('sticky_top_bar', 1);
$body_config['sticky_always'] = (int) $config->get('sticky_top_bar_always', 1);
$body_config['style'] = $config->get('style');

$config->set('body_config', json_encode($body_config));

// internet explorer
if ($this['useragent']->browser() == 'msie') {
	$head[] = sprintf('<!--[if IE 8]><link rel="stylesheet" href="%s"><![endif]-->', $this['path']->url('css:ie8.css'));
    $head[] = sprintf('<!--[if lte IE 8]><script src="%s"></script><![endif]-->', $this['path']->url('js:html5.js'));
}

if (isset($head)) {
	$this['template']->set('head', implode("\n", $head));
}

