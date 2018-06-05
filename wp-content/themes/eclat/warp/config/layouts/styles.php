<?php
/**
* @package   Warp Theme Framework
* @author    Elartica Team http://www.elartica.com
* @copyright Copyright (C) Elartica Team
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

global $wp_filesystem;

// Initialize the WP filesystem, no more using 'file-put-contents' function
if (empty($wp_filesystem)) {
    require_once (ABSPATH . '/wp-admin/includes/file.php');
    WP_Filesystem();
}

// cookie, baseurl, config & styles
$data['cookie']  = $this['config']['cookie'];
$data['baseurl'] = $this['path']->url('theme:', false);
$data['config']  = $this['path']->url('less:customizer.json');
$data['styles']  = array('default' => '');

// init default
if ($default = $this['path']->path('less:style.less')) {
	$data['styles']['default'] = $wp_filesystem->get_contents($default);
}

// init filter
$filter = $this['assetfilter']->create(array('CssImportResolver', 'CssRewriteUrl'));

// less vars
foreach ($this['config']['less']['vars'] as $source) {
	foreach (explode("\n", $this['asset']->createFile($source)->getContent($filter)) as $line) {
		if ($line && preg_match('/(@[\w\-]+)\s*:\s*([^;]*);/i', $line, $matches)) {
			$data['config_vars'][$matches[1]] = $matches[2];
		}
	}
}

// less files
foreach ($this['config']['less']['files'] as $target => $source) {
    $content = $this['asset']->createFile($source)->getContent($filter);
    $data['less'][] = array('source' => $content, 'target' => $target) ;
}

// less styles
if ($path = $this['path']->path('theme:styles')) {
    foreach (glob("$path/*/style.less") as $file) {
        $data['styles'][basename(preg_replace('#/style\.less$#', '', $file))] = $wp_filesystem->get_contents($file);
    }
}

echo json_encode($data);