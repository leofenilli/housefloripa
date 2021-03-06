<?php
/**
* @package   Warp Theme Framework
* @author    Elartica Team http://www.elartica.com
* @copyright Copyright (C) Elartica Team
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

namespace Warp\Asset\Filter;

/**
 * Replace stylesheets image urls with base64 image strings.
 */
class CssImageBase64Filter implements FilterInterface
{
    /**
     * On load filter callback.
     *
     * @param  object $asset
     */
    public function filterLoad($asset) {}

    /**
     * On content filter callback.
     *
     * @param object $asset
     */
    public function filterContent($asset)
    {
        $images  = array();
        $content = $asset->getContent();

        // get images and the related path
        if (preg_match_all('/url\(\s*[\'"]?([^\'"]+)[\'"]?\s*\)/Ui', $asset->getContent(), $matches)) {
            foreach ($matches[0] as $i => $url) {
                if ($path = realpath($asset['base_path'].'/'.ltrim(preg_replace('/'.preg_quote($asset['base_url'], '/').'/', '', $matches[1][$i], 1), '/'))) {
                    $images[$url] = isset($images[$url]) ? false : $path;
                }
            }
        }

        $asset->setContent($content);
    }
}
