<?php
/**
* @package   Warp Theme Framework
* @author    Elartica Team http://www.elartica.com
* @copyright Copyright (C) Elartica Team
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

if($value == 0){
    echo '<div class="uk-alert uk-alert-warning" data-uk-alert="">You must select a page</div>';
}

printf('<p class="uk-form-controls-condensed"><select %s>', $control->attributes(compact('name')));
printf('<option value="%s">%s</option>', 0, 'Non selected');

if ($pages = get_pages())
{
    foreach ($pages as $page)
    {
        if( isset($page->ID) && $page->ID != 0 )
        {
            $attr = '';
            if( $page->ID == $value) {
                $attr = ' selected="selected"';
            }
            printf('<option value="%s"%s>%s</option>', $page->ID, $attr, $page->post_title);
        }
    }
}

echo '</select>';

if ($label = $node->attr('label')) {
    printf('<span class="uk-form-help-inline">%s</span>', $node->attr('label'));
}

echo '</p>';