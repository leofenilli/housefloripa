<?php
/**
* @package   Warp Theme Framework
* @author    Elartica Team http://www.elartica.com
* @copyright Copyright (C) Elartica Team
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

namespace Warp\Helper;

use Warp\Dom\Document;

/**
 * Helper class for the DOM extension.
 */
class DomHelper extends AbstractHelper
{
    const HTML_DOCTYPE = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"></head><body>%s</body></html>';

    /**
     * Get DOM object from file/string.
     *
     * @param  string $input
     * @param  string $mode
     * @return Document
     */
    public function create($input, $mode = 'html')
    {
        // is file ?
        if (substr(trim($input), 0, 1) != '<' && file_exists($input) && is_file($input)) {

            global $wp_filesystem;

            // Initialize the WP filesystem, no more using 'file-put-contents' function
            if (empty($wp_filesystem)) {
                require_once (ABSPATH . '/wp-admin/includes/file.php');
                WP_Filesystem();
            }

            $input = $wp_filesystem->get_contents($input);
        }

        // create object
        $dom = new Document;

        // load xml/html
        if ($mode == 'xml') {
            $dom->loadXML($input);
        } else {

            // set doctype
            if (strpos($input, '<!DOCTYPE') === false) {
                $input = sprintf(self::HTML_DOCTYPE, $input);
            }

            $dom->loadHTML($input);
        }

        return $dom;
    }
}
