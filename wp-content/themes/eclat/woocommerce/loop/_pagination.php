<?php
/**
* @package   Eclat Theme
* @author    Elartica Team http://www.elartica.com
* @copyright Copyright (C) Elartica Team
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

if (!isset($page) && !isset($pages)) {
    $page = max( 1, get_query_var( 'paged' ) );
    $posts_per_page = intval(get_query_var('posts_per_page'));
    $pages = $wp_query->max_num_pages;
    $page = !empty($page) ? intval($page) : 1;
}

$output = array();

if ($pages > 1) {

    $current = $page;
    $max     = 3;
    $end     = $pages;
    $range   = ($current + $max < $end) ? range($current, $current + $max) : range($current - ($current + $max - $end), $end);


    $output[] = '<ul class="uk-pagination">';

    $range_start = max($page - $max, 1);
    $range_end   = min($page + $max - 1, $pages);

    if ($page < $pages) {
        $link     = get_pagenum_link($page+1);
        $output[] = '<li class="next_page"><a href="'.$link.'"><span class="tm-icon-arrow-long-right"></span></a></li>';
    }

    if ($page > 1) {

        $link     = get_pagenum_link($page-1);
        $output[] = '<li class="prev_page"><a href="'.$link.'"><span class="tm-icon-arrow-long-left"></span></a></li>';
    }

    for ($i = 1; $i <= $end; $i++) {


        if($i==1 || $i==$end || in_array($i, $range)) {

            if ($i == $page) {
                $output[] = '<li class="uk-active"><span>'.$i.'</span></li>';
            } else {
                $link  = get_pagenum_link($i);
                $output[] = '<li class="page_num"><a href="'.$link.'">'.$i.'</a></li>';
            }

        }else{
            $output[] = '#';
        }
    }

    $output[] = '</ul>';

    $output   = preg_replace('/>#+</', '><li><span>...</span></li><', implode("", $output));

    echo $output;
}
