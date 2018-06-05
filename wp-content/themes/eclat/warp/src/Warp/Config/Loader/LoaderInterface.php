<?php
/**
* @package   Warp Theme Framework
* @author    Elartica Team http://www.elartica.com
* @copyright Copyright (C) Elartica Team
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

namespace Warp\Config\Loader;

interface LoaderInterface
{
    /**
     * Load the given configuration file.
     *
     * @param string $filename
     * 
     * @return array
     */
    public function load($filename);
 
    /**
     * Determine if the configuration file is supported.
     *
     * @param string $filename
     * 
     * @return bool
     */
    public function supports($filename);
}
