<?php
/**
* @package   Warp Theme Framework
* @author    Elartica Team http://www.elartica.com
* @copyright Copyright (C) Elartica Team
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

namespace Warp\Menu;

/**
 * Subnav menu renderer.
 */
class Subnav
{
   /**
    * Process menu
    *
    * @param  object $module
    * @param  object $element
    * @return object
    */
    public function process($module, $element)
    {
        self::_process($module, $element->first('ul:first'));
        return $element;
    }

   /**
    * Helper function
    *
    * @param  object $module
    * @param  object $element
    * @param  integer $level
    */
    protected static function _process($module, $element, $level = 0)
    {
        global $warp;

        // get warp config
        $config = $warp['config'];

        if ($level == 0) {
            $element->attr('class', 'uk-subnav');
        } else {
            $element->addClass('level'.($level + 1));
        }

        foreach ($element->children('li') as $li) {

            // is active ?
            if ($active = $li->attr('data-menu-active')) {
                $active = ' uk-active';
            }

            // is parent ?
            $ul = $li->children('ul');
            $parent = $ul->length ? ' uk-parent' : null;

            // set class in li
            $li->attr('class', sprintf('level%d'.$parent.$active, $level + 1, $li->attr('data-id')).' li-menu-item-'.$li->attr('data-id'));

            // set id in li
            //$li->attr('id', 'li-menu-item-'.$li->attr('data-id'));

            // add all options that have a name starting with 'data-'
            foreach ($config->get("menus." . $li->attr('data-id'), array()) as $key => $value) {
                if (strpos($key, 'data-') === 0) {
                    // add an attribute named like the option itself
                    $li->attr($key, $value);
                }
            }

            // set class in a/span
            foreach ($li->children('a,span') as $child) {

                // set id in link
                $child->attr('class', 'menu-item-'.$child->parent()->attr('data-id'));

                // set image
                if ($image = $li->attr('data-menu-image')) {
                    if ( $li->attr('data-menu-hidelink') && $li->attr('data-menu-hidelink') == "yes" ) {
                        $child->html('<img class="uk-responsive-height" src="'.$image.'" alt="'.$child->text().'" /> <span style="display: none;">'.$child->text().'</span>');
                    } else {
                        $child->html('<img class="uk-responsive-height" src="'.$image.'" alt="'.$child->text().'" /> <span>'.$child->text().'</span>');
                    }
                }

                // set icon
                if ($icon = $li->attr('data-menu-icon')) {
                    $child->prepend('<span class="'.$icon.'"></span> ');
                }

                if ($subtitle = $li->attr('data-menu-subtitle')) {
                    $child->append('<div>'.$subtitle.'</div>');
                }

            }

            // process submenu
            if ($ul->length) {
                self::_process($module, $ul->item(0), $level + 1);
            }
        }
    }
}
