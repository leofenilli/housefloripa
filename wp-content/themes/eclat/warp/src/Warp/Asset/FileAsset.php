<?php
/**
* @package   Warp Theme Framework
* @author    Elartica Team http://www.elartica.com
* @copyright Copyright (C) Elartica Team
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

namespace Warp\Asset;

/**
 * File asset.
 */
class FileAsset extends AbstractAsset
{
    /**
     * @var string
     */
    protected $path;

    /**
     * Constructor.
     *
     * @param string $url
     * @param string $path
     * @param array  $options
     */
    public function __construct($url, $path, $options = array())
    {
        parent::__construct($options);

        $this->type = 'File';
        $this->url = $url;
        $this->path = $path;
    }

    /**
     * Get asset file path.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Load asset callback.
     *
     * @param object $filter
     */
    public function load($filter = null)
    {
        if (file_exists($this->path)) {

            global $wp_filesystem;

            // Initialize the WP filesystem, no more using 'file-put-contents' function
            if (empty($wp_filesystem)) {
                require_once (ABSPATH . '/wp-admin/includes/file.php');
                WP_Filesystem();
            }

            $this->doLoad(preg_replace('{^\xEF\xBB\xBF|\x1A}', '', $wp_filesystem->get_contents($this->path)), $filter); // load with UTF-8 BOM removal
        }
    }

    /**
     * Get unique asset hash.
     *
     * @param string $salt
     *
     * @return string
     */
    public function hash($salt = '')
    {
        return md5($this->path.filemtime($this->path).$salt);
    }
}
