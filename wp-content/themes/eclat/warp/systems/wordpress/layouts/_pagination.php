<?php
/**
* @package   Warp Theme Framework
* @author    Elartica Team http://www.elartica.com
* @copyright Copyright (C) Elartica Team
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

global $wp_query, $post, $wpdb;

if (!isset($type))  $type  = 'posts';

if ($type === 'comments' && !get_option('page_comments')) return;

if (!isset($page) && !isset($pages)) {

    if ($type === 'posts') {
        $page = get_query_var('paged');
        $posts_per_page = intval(get_query_var('posts_per_page'));
        $pages = intval(ceil($wp_query->found_posts / $posts_per_page));

    } else {
        $comments = $wpdb->get_var( $wpdb->prepare(
            "SELECT COUNT(*) FROM %s WHERE comment_approved = '1' AND comment_parent = '0' AND comment_post_ID = %d",
            $wpdb->comments,
            $post->ID
        ) );

        $page = get_query_var('cpage');
        $comments_per_page = get_option('comments_per_page');
        $pages = intval(ceil($comments / $comments_per_page));
    }

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
        $link     = ($type === 'posts') ? get_pagenum_link($page+1) : get_comments_pagenum_link($page+1);
        $output[] = '<li class="next_page"><a href="'.$link.'"><span class="tm-icon-arrow-long-right"></span></a></li>';
    }

    if ($page > 1) {

        $link     = ($type === 'posts') ? get_pagenum_link($page-1) : get_comments_pagenum_link($page-1);
        $output[] = '<li class="prev_page"><a href="'.$link.'"><span class="tm-icon-arrow-long-left"></span></a></li>';
    }

    for ($i = 1; $i <= $end; $i++) {


        if($i==1 || $i==$end || in_array($i, $range)) {

            if ($i == $page) {
                $output[] = '<li class="uk-active"><span>'.$i.'</span></li>';
            } else {
                $link  = ($type === 'posts') ? get_pagenum_link($i) : get_comments_pagenum_link($i);
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
