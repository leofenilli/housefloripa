<?php
/**
* @package   Warp Theme Framework
* @author    Elartica Team http://www.elartica.com
* @copyright Copyright (C) Elartica Team
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

global $wp_registered_widgets;


// render default modules
switch ($position) {

    case 'logo':

        $wp_registered_widgets['text-0'] = array(
            'id' => 'text-0',
            'name' => 'Text'
        );

        echo '<!--widget-text-0-->Logo<!--widget-end-->';
        break;

    case 'sidebar-a':

        $wp_registered_widgets['search-0'] = array(
            'id' => 'search-0',
            'name' => 'Search'
        );

        $wp_registered_widgets['archives-0'] = array(
            'id' => 'archives-0',
            'name' => 'Archives'
        );

        echo "<!--widget-search-0--><!--title-start-->Search<!--title-end-->";
        get_search_form();
        echo "<!--widget-end-->\n";
        echo "<!--widget-archives-0--><!--title-start-->Archive<!--title-end--><ul>";
        wp_get_archives('type=monthly');
        echo "</ul><!--widget-end-->";
        break;

}
