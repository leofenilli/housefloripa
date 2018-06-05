<?php
/**
* @package   Warp Theme Framework
* @author    Elartica Team http://www.elartica.com
* @copyright Copyright (C) Elartica Team
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

// init vars
if(is_front_page()){
    $colcount = $this['config']->get('multicolumns', 1);
} elseif( $this['config']->get('show_sidebar')){
    $colcount = $this['config']->get('multicolumns_sidebars', 1);
} else {
    $colcount = $this['config']->get('multicolumns_full', 1);
}
$posts_fp = $this['config']->get('posts_on_frontpage');
$count    = $this['system']->getPostCount();
$rows     = ceil($count / $colcount);
$columns  = array();
$row      = 0;
$column   = 0;
$i        = 0;

if (is_front_page() && ($posts_fp && $posts_fp !== 'default')) {
    query_posts( 'posts_per_page='.$posts_fp );
}

// create columns
while (have_posts()) {
    the_post();

    if ($this['config']->get('multicolumns_order', 1) == 0) {
        // order down
        if ($row >= $rows) {
            $column++;
            $row  = 0;
            $rows = ceil(($count - $i) / ($colcount - $column));
        }
        $row++;
    } else {
        // order across
        $column = $i % $colcount;
    }

    if (!isset($columns[$column])) {
        $columns[$column] = '';
    }

    $post_format = get_post_format();
    if ( false === $post_format )
        $post_format = 'standard';

    if($colcount > 1) {
        $post_template = '_post_grid';
        if($post_format == 'quote'){
            $post_template = '_post_quote';
        }
        $columns[$column] .= $this->render($post_template, array('post_format' => $post_format));
    } else {
        $post_template = '_post_list';
        if($post_format == 'quote'){
            $post_template = '_post_quote';
        }
        $columns[$column] .= $this->render($post_template, array('post_format' => $post_format));
    }

    $i++;
}

// render columns
if ($count = count($columns)) {
    echo '<div class="uk-grid">';
    for ($i = 0; $i < $count; $i++) {
        echo '<div class="uk-width-medium-1-'.$count.'">'.$columns[$i].'</div>';
    }
    echo '</div>';
}