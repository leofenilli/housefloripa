<meta charset="<?php bloginfo('charset'); ?>">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<?php if($this['config']->get('responsive', true)): ?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php endif; ?>
<?php if ( ! function_exists( 'has_site_icon' ) || (function_exists( 'has_site_icon' ) && ! has_site_icon() ) ) { ?>
<link rel="shortcut icon" href="<?php echo $this['path']->url('theme:favicon.ico'); ?>">
<link rel="apple-touch-icon-precomposed" href="<?php echo $this['path']->url('theme:apple_touch_icon.png'); ?>">
<?php
}

// add feed link
if (strlen($this['config']->get('rss_url',''))) {
    printf("<link href=\"%s\" rel=\"alternate\" type=\"application/rss+xml\" title=\"RSS 2.0\">\n", $this['config']->get('rss_url'));
}

// set body classes
$this['config']->set('body_classes', implode(' ', get_body_class($this['config']->get('body_classes'))));

$this->output('head');

do_action('get_header', array());
wp_head();