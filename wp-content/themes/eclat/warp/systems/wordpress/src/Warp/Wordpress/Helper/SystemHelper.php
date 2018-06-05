<?php
/**
* @package   Warp Theme Framework
* @author    Elartica Team http://www.elartica.com
* @copyright Copyright (C) Elartica Team
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

namespace Warp\Wordpress\Helper;

use Warp\Warp;
use Warp\Helper\AbstractHelper;
use Warp\Wordpress\MenuWalker\MenuWalker;

/*
 * Wordpress system helper class, provides Wordpress integration (http://wordpress.org).
 */
class SystemHelper extends AbstractHelper
{
    /*
     * System root path.
     *
     * @var string
     */
    public $path;

    /*
     * System root url.
     *
     * @var string
     */
    public $url;

    /*
     * Cache path.
     *
     * @var string
     */
    public $cache_path;

    /*
     * Cache time.
     *
     * @var int
     */
    public $cache_time;

    /*
     * Theme XML.
     *
     * @var Document
     */
    public $xml;

    /*
     * Query information.
     *
     * @var string[]
     */
    public $query;

    /**
     * Dynamic style GET variable.
     *
     * @var string
     */
    protected $style = 'style';

    /**
     * Constructor.
     *
     * @param Warp $warp
     */
    public function __construct(Warp $warp)
    {
        parent::__construct($warp);

        // init vars
        $this->path       = rtrim(str_replace(DIRECTORY_SEPARATOR, '/', ABSPATH), '/');
        $this->url        = rtrim(site_url(), '/');
        $this->cache_path = rtrim(str_replace(DIRECTORY_SEPARATOR, '/', get_template_directory()), '/').'/cache';
        $this->cache_time = 86400;

        // set config or load defaults
        /*if (defined('WP_ALLOW_MULTISITE') && WP_ALLOW_MULTISITE) {
            if ($settings = $this['option']->get('warp_theme_options', false) and is_array($settings)) {
                $this['config']->setValues($settings);
            } else {
                $this['config']->load($this['path']->path('theme:config.default.json'));
            }
        } else {*/
            $this['config']->load($this['path']->path('theme:config.json') ?: $this['path']->path('theme:config.default.json'));
        //}

        // set cache directory
        if (!file_exists($this->cache_path)) {
            mkdir($this->cache_path, 0755);
        }
    }

    /**
     * Initialize system configuration.
     */
    public function init()
    {
        // set paths
        $this['path']->register($this->path, 'site');
        $this['path']->register($this->path.'/wp-admin', 'admin');
        $this['path']->register($this->cache_path, 'cache');

        // get theme xml
        $this->xml = $this['dom']->create($this['path']->path('theme:theme.xml'), 'xml');

        // get widget positions
	    $warp = $this->warp;
	    $warp->xml = $this->xml;
        add_action( 'widgets_init', function() use ($warp){
            foreach ($warp->xml->find('positions > position') as $position) {
	            $warp['widgets']->register($position->text());
            }
        });

        // add actions
        add_action('wp_ajax_warp_search', array($this, 'ajaxSearch'));
        add_action('wp_ajax_nopriv_warp_search', array($this, 'ajaxSearch'));

        // register main menu
        register_nav_menus(array('main_menu' => 'Main Navigation Menu'));;

        // init site/admin
        if (!is_admin()) $this->initSite();
        if (is_admin()) $this->initAdmin();
        if (in_array( $GLOBALS['pagenow'], array( 'wp-login.php' ) )) {
            add_action('login_head', array($this, 'add_head_login_style'));
        }

        // load helper function
        get_template_part('warp/systems/wordpress/src/Warp/Wordpress/Helper/FunctionHelper');
        get_template_part('warp/systems/wordpress/src/Warp/Wordpress/Helper/MetaBoxHelper');

        // plugin recommendations
        get_template_part('warp/systems/wordpress/src/Warp/Wordpress/TGM/class-tgm-plugin-activation');
        get_template_part('warp/systems/wordpress/src/Warp/Wordpress/TGM/plugins');

        // load widgets
        get_template_part('warp/systems/wordpress/src/Warp/Wordpress/Widgets/Breadcrumbs');
        get_template_part('warp/systems/wordpress/src/Warp/Wordpress/Widgets/Sidebar');

        if (class_exists('WooCommerce'))
        {
            // load helper function WooCommerce
            get_template_part('warp/systems/wordpress/src/Warp/Wordpress/Helper/AttributeTypes');

            // load widgets WooCommerce
            get_template_part('warp/systems/wordpress/src/Warp/Wordpress/Widgets/Woocommerce_Login');
            get_template_part('warp/systems/wordpress/src/Warp/Wordpress/Widgets/Woocommerce_Cart');
            get_template_part('warp/systems/wordpress/src/Warp/Wordpress/Widgets/Woocommerce_Categories');
            get_template_part('warp/systems/wordpress/src/Warp/Wordpress/Widgets/Woocommerce_Leyered_Nav');

            if (class_exists('pw_woocommerc_brans_Wc_Brands')) {
                get_template_part('warp/systems/wordpress/src/Warp/Wordpress/Widgets/Woocommerce_Brands');
            }
        }
    }

    /**
     * Initialize site.
     */
    public function initSite()
    {
        // add action
        add_action('wp', array($this, '_wp'));
        add_action('get_sidebar', array($this, '_getSidebar'));
        add_action('wp_head', array($this, '_loadHeaderFiles'));

        // remove auto-linebreaks ?
        if (!$this['config']->get('wpautop', 0)) {
            remove_filter('the_content', 'wpautop');
        }

        // set custom menu walker
        add_filter('wp_nav_menu_args', function($args) {

            if (empty($args['walker'])) {
                $args['walker'] = new MenuWalker;
            }

            return $args; }
        );

        // filter widgets that should not be displayed
        $warp = $this->warp;
        add_filter('widget_display_callback', function($instance, $widget) use ($warp) {
            return $warp['widgets']->get($widget->id)->display ? $instance : false;
        }, 10, 3);

        // disable the admin bar for mobiles
        if ($this['config']->get('mobile') && $this['browser']->isMobile()) {
            add_theme_support('admin-bar', array('callback' => '__return_false'));
        }
    }

    /**
     * Initialize administration area.
     */
    public function initAdmin()
    {
        // add actions
        add_action('admin_init', array($this, '_adminInit'));
        add_action('admin_menu', array($this, '_adminMenu'));
        add_action('wp_ajax_warp_save', array($this, 'ajaxSave'));
        add_action('wp_ajax_warp_save_files', array($this, 'ajaxSaveFiles'));
        add_action('wp_ajax_warp_get_styles', array($this, 'ajaxGetStyles'));

        // add notices
        if (isset($_GET['page']) && $_GET['page'] == 'warp') {

            // get warp xml
            $xml = $this['dom']->create($this['path']->path('warp:warp.xml'), 'xml');

            // cache writable ?
            if (!file_exists($this->cache_path) || !is_writable($this->cache_path)) {
                $messages[] = "Cache not writable, please check directory permissions ({$this->cache_path})";
            }

            // update check

            if ($url = $xml->first('updateUrl')->text()) {

                global $wp_filesystem;

                if (empty($wp_filesystem)) {
                    require_once (ABSPATH . '/wp-admin/includes/file.php');
                    WP_Filesystem();
                }

                // create check urls
                $urls['tmpl'] = sprintf('%s?application=%s&version=%s&format=raw', $url, get_template(), $this->xml->first('version')->text());

                foreach ($urls as $type => $url)
                {
                    // only check once a day
                    $hash = md5($url.date('Y-m-d'));
                    if ($this['option']->get("{$type}_check") != $hash) {
                        if ($request = $wp_filesystem->get_contents($url)) {
                            $this['option']->set("{$type}_check", $hash);
                            $this['option']->set("{$type}_data", $request);
                        }
                    }

                    // decode response and set message
                    if (($data = json_decode($this['option']->get("{$type}_data"))) && $data->status == 'update-available') {
                        $messages[] = $data->message;
                    }

                }
            }

            // set messages
            if (isset($messages)) {
                $this['template']->set('messages', $messages);
            }
        }
    }

    /**
     * Get current query information.
     *
     * @global \WP_Query $wp_query
     *
     * @return string[]
     */
    public function getQuery()
    {
        global $wp_query;

        // create, if not set
        if (empty($this->query)) {

            // init vars
            $obj   = $wp_query->get_queried_object();
            $type  = get_post_type();

            if(!$type && isset($obj->post_type)) {
                $type = $obj->post_type;
            } else if(!$type && isset($obj->taxonomy) && $obj->taxonomy == "product_cat") {
                $type = "product";
            }


            $query = array();

            if (is_home()) {
                $query[] = 'home';
            }

            if (is_front_page()) {
                $query[] = 'front_page';
            }

            if ($type == 'post') {

                if (is_single()) {
                    $query[] = 'single';
                }

                if (is_archive() && ! is_category()) {
                    $query[] = 'archive';
                }

                if (is_search()) {
                    $query[] = 'search';
                }

            } else {
                if (is_single()) {
                    $query[] = $type ? $type.'-single' : 'single';
                } elseif (is_search()) {
                    $query[] = $type ? $type.'-search' : 'search';
                } elseif (is_archive()) {
                    $query[] = $type ? $type.'-archive' : 'archive';
                }
            }

            if (is_page()) {
                $query[] = $type;
                $query[] = $type.'-'.$obj->ID;
            }

            if (is_category()) {
                $query[] = 'cat-'.$obj->term_id;
            }

            // WooCommerce
            if (class_exists('WooCommerce')) {

                if (is_shop() && !is_search()) {
                    $query[] = 'page';
                    $query[] = 'page-'.wc_get_page_id('shop');
                }

                if (is_product_category() || is_product_tag()) {
                    $query[] = 'cat-'.$obj->term_id;

                }

                if(isset($obj->taxonomy) && isset($obj->term_id) && $obj->taxonomy == 'product_brand') {
                    $query[] = 'cat-'.$obj->term_id;
                    $query[] = 'product-brand';
                }

            }

            // WPML support
            if (defined('ICL_LANGUAGE_CODE') && function_exists('icl_get_default_language') && ICL_LANGUAGE_CODE != ($lang = icl_get_default_language())) {

                if ($type == 'page') {
                    $query[] = 'page-'.icl_object_id($obj->ID, $type, true, $lang);
                }

                if ($type == 'category') {
                    $query[] = 'cat-'.icl_object_id($obj->term_id, $type, true, $lang);
                }
            }

            $this->query = $query;

        }

        return $this->query;
    }

    /**
     * Retrieve current post count.
     *
     * @global \WP_Query $wp_query
     *
     * @return int
     */
    public function getPostCount()
    {
        global $wp_query;

        return $wp_query->post_count;
    }

    /**
     * Is current view a blog?
     *
     * @return boolean
     */
    public function isBlog()
    {
        if (class_exists('WooCommerce') && is_woocommerce()) {
            return false;
        }

        return true;
    }

    /**
     * Checks for default widgets in theme preview.
     *
     * @param string $position
     * @return boolean
     */
    public function isPreview($position)
    {
        // preview postions
        $positions = array('logo', 'right');

        return is_preview() && in_array($position, $positions);
    }

    /*
     * Search ajax callback.
     */
    public function ajaxSearch()
    {
        global $wp_query;

        $result = array('results' => array());
        $query  = isset($_REQUEST['s']) ? $_REQUEST['s'] : '';

        if (strlen($query) >= 3) {

            $wp_query->query_vars['posts_per_page'] = $this['config']->get('search_results', 5);
            $wp_query->query_vars['post_status'] = 'publish';
            $wp_query->query_vars['s'] = $query;
            $wp_query->is_search = true;

            foreach ($wp_query->get_posts() as $post) {

                $content = !empty($post->post_excerpt) ? strip_tags(do_shortcode($post->post_excerpt)) : strip_tags(do_shortcode($post->post_content));

                if (strlen($content) > 180) {
                    $content = substr($content, 0, 179).'...';
                }

                $result['results'][] = array(
                    'title' => $post->post_title,
                    'text'  => $content,
                    'url'   => get_permalink($post->ID)
                );
            }
        }

        die(json_encode($result));
    }

    /**
     * WP action callback.
     */
    public function _wp()
    {

        global $wp_query, $post;

        // set config
        $this['config']->set('language', get_bloginfo("language"));
        $this['config']->set('direction', $GLOBALS['wp_locale']->is_rtl() ? 'rtl' : 'ltr');
        $this['config']->set('site_url', esc_url( home_url() ));
        $this['config']->set('site_name', get_option('blogname'));
        $this['config']->set('datetime', date('Y-m-d'));
        $this['config']->set('actual_date', date_i18n($this['config']->get('date_format', 'l, j F Y')));
        $this['config']->set('page_class', implode(' ', array_map(function($element) { return "wp-{$element}"; }, $this->getQuery())));

        // branding ?
        if ($this['config']->get('warp_branding', true)) {
            $this['template']->set('warp_branding', $this['config']['branding']);
        }

        $this['template']->set('warp_title', get_the_title());

        if (is_single()) {
            if ( get_post_type() == 'product' && class_exists('WooCommerce') && is_singular() ) {
                $taxonomy = 'product_cat';
                $terms = get_the_terms($post->ID, $taxonomy);
                if (is_object($terms[0])) {
                    $this['template']->set('warp_title', $terms[0]->name);
                }
            } else if ($cats = get_the_category()) {
                $cat = $cats[0];
                if (is_object($cat)) {
                    $this['template']->set('warp_title', $cat->name);
                }
            }
        } elseif (is_category()) {
            $cat_obj = $wp_query->get_queried_object();
            $this['template']->set('warp_title', $cat_obj->name);
        } elseif (is_tag()) {
            $this['template']->set('warp_title', esc_html__('Posts Tagged ', 'eclat').' "'.single_tag_title('', false).'"');
        } elseif (is_date()) {
            if (is_day()) {
                $this['template']->set('warp_title', esc_html__('Archive for ', 'eclat').get_the_date());
            } elseif(is_month()){
                $this['template']->set('warp_title', esc_html__('Archive for ', 'eclat').get_the_date('F, Y'));
            } elseif(is_year()){
                $this['template']->set('warp_title', esc_html__('Archive for ', 'eclat').get_the_date('Y'));
            }
        } elseif (is_author()) {
            $this['template']->set('warp_title', esc_html__('Author Archive', 'eclat'));
        } elseif (is_search()) {
            $this['template']->set('warp_title', esc_html__('Search Results for', 'eclat').' "'.stripslashes(strip_tags(get_search_query())).'"');
        } elseif (is_tax()) {
	        $term_id = $wp_query->queried_object_id;
	        $taxonomy = get_query_var('taxonomy');
	        $product_cat_name = get_term( $term_id, $taxonomy );
	        $this['template']->set('warp_title', $product_cat_name->name);
        } elseif (is_archive()) {
            // woocommerce shop page
            if (class_exists('WooCommerce') && is_shop()) {
                $title = wc_get_page_id( 'shop' ) ? get_the_title( wc_get_page_id( 'shop' ) ) : '';
                $this['template']->set('warp_title', $title);
            }
        } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) {
            $this['template']->set('warp_title', esc_html__('Blog Archives', 'eclat'));
        } elseif($wp_query->is_posts_page && get_option('page_for_posts') == $wp_query->queried_object_id){
            $this_posts_page = get_page(get_option('page_for_posts'));
            $this['template']->set('warp_title', $this_posts_page->post_title);
        };

        // set layouts
        if ($layouts = $this['config']['layouts']) {

            $layout = 'default';
            $query  = $this->getQuery();

            // set query layout ?
            if( get_option('show_on_front') == 'page') {
                foreach ($layouts as $key => $data) {
                    if (isset($data['assignment']) && array_intersect($data['assignment'], $query)) {
                        $layout = $key;
                        break;
                    }
                }
            }

            $this['config']->set('warp_layout', $layout);
            $this['config']->setValues($layouts[$layout]);
        }

        $show_sidebar = false;

        foreach ($this['config']->get('sidebars', array()) as $name => $sidebar) {
            if ($this['widgets']->count($name)) {
                $show_sidebar = true;
                continue;
            }
        }

        $this['config']->set('show_sidebar', $show_sidebar);

        // add dynamic style
        if ($this['config']['dynamic_style']) {

            if (!session_id()) session_start();

            if (isset($_GET[$this->style])) {
                $_SESSION['_style'] = preg_replace('/[^A-Z0-9-]/i', '', $_GET[$this->style]);

                if (function_exists('w3tc_flush_all')){
                    w3tc_flush_all();
                }
            }

            if (isset($_SESSION['_style']) && $this['path']->path(sprintf('theme:styles/%s', $_SESSION['_style']))) {
                $this['config']['style'] = $_SESSION['_style'];
            }

        }

        // set theme style paths
        if ($style = $this['config']->get('style')) {
            foreach (array('css' => 'theme:styles/%s/css', 'js' => 'theme:styles/%s/js', 'layouts' => 'theme:styles/%s/layouts') as $name => $resource) {
                if ($p = $this['path']->path(sprintf($resource, $style))) {
                    $this['path']->register($p, $name);
                }
            }
        }
    }

    /*
     * Load in Header theme files
     */
    public function _loadHeaderFiles()
    {
        if ( ! function_exists( '_wp_render_title_tag' ) )
        {
            ?><title><?php wp_title( '|', true, 'right' ); ?></title><?php
        }
    }

    /*
     * Catches default sidebar content and makes it available for the sidebar widget.
     */
    public function _getSidebar($name = null)
    {
        $templates = isset($name) ? array("sidebar-{$name}.php", 'sidebar.php') : array('sidebar.php');

        ob_start();

        if (locate_template($templates, true, true) == '') {
            load_template(ABSPATH.WPINC.'/theme-compat/sidebar.php', true);
            $clear = true;
        }

        $output = ob_get_clean();

        if (isset($clear)) {
            $output = '';
        }

        $this['template']->set('sidebar.output', $output);
    }

    /*
     * Admin save ajax callback.
     */
    public function ajaxSave()
    {
        // init vars
        $post = function_exists('wp_magic_quotes') ? array_map('stripslashes_deep', $_POST) : $_POST;
        $config = isset($post['config']) ? $post['config'] : '{}';

        $message = 'failed';

        if ($config and null !== $json = json_decode($config, true)) {
            if (defined('WP_ALLOW_MULTISITE') && WP_ALLOW_MULTISITE) {
                if ($this['option']->set('warp_theme_options', $json)) {
                    $message = 'success';
                }
            } else {
                global $wp_filesystem;
                // Initialize the WP filesystem, no more using 'file-put-contents' function
                if (empty($wp_filesystem)) {
                    require_once (ABSPATH . '/wp-admin/includes/file.php');
                    WP_Filesystem();
                }

                if($wp_filesystem->put_contents( $this['path']->path('theme:').'/config.json', $config ) ) {
                    $message = 'success';
                }
            }
        }

        die(json_encode(compact('message')));
    }

    /*
     * Admin save files ajax callback.
     */
    public function ajaxSaveFiles()
    {
        global $wp_filesystem;

        // Initialize the WP filesystem, no more using 'file-put-contents' function
        if (empty($wp_filesystem)) {
            require_once (ABSPATH . '/wp-admin/includes/file.php');
            WP_Filesystem();
        }

        // init vars
        $upload = isset($_FILES['files']) ? $_FILES['files'] : false;

        if (!$upload) {
            die(json_encode(array('message' => 'No file was uploaded.')));
        }

        if ($upload['error']) {
            $message = 'failed';
            switch ($upload['error']) {
                case UPLOAD_ERR_INI_SIZE:
                    $message = 'The uploaded file exceeds the upload_max_filesize directive in php.ini.';
                    break;
                case UPLOAD_ERR_FORM_SIZE:
                    $message = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.';
                    break;
                case UPLOAD_ERR_PARTIAL:
                    $message = 'The uploaded file was only partially uploaded.';
                    break;
                case UPLOAD_ERR_NO_FILE:
                    $message = 'No file was uploaded.';
                    break;
                case UPLOAD_ERR_NO_TMP_DIR:
                    $message = 'Missing a temporary folder.';
                    break;
                case UPLOAD_ERR_CANT_WRITE:
                    $message = 'Failed to write file to disk.';
                    break;
                case UPLOAD_ERR_EXTENSION:
                    $message = 'A PHP extension stopped the file upload. PHP does not provide a way to ascertain which extension caused the file upload to stop; examining the list of loaded extensions with phpinfo() may help.';
                    break;
            }
            die(json_encode(compact('message')));
        }

        if (false === $contents = $wp_filesystem->get_contents($upload['tmp_name'])) {
            die(json_encode(array('message' => 'Unable to read contents from temporary file.')));
        }

        if (null === $files = json_decode($contents, true)) {
            die(json_encode(array('message' => 'Unable to decode JSON from temporary file.')));
        }
        $path  = $this['path']->path('theme:');

        $message = 'success';

        foreach ($files as $file => $data) {

            @mkdir(dirname($path.$file), 0777, true);

            if($wp_filesystem->put_contents( $path.$file, (string) $data ) === false ) {
                $message = sprintf('Unable to write file (%s).', $path.$file);
                break;
            }
        }

        // delete obsolete styles
        if ($message == 'success' && $path = $this['path']->path('theme:styles')) {
            foreach (glob("$path/*/style.less") as $dir) {

                $dir = dirname($dir);

                if (!isset($files['/styles/'.basename($dir).'/style.less']) && $wp_filesystem) {
                    $wp_filesystem->delete($dir, true);
                }
            }
        }

        die(json_encode(compact('message')));
    }

    /*
     * Admin get styles ajax callback.
     */
    public function ajaxGetStyles()
    {
        // render styles config
        die($this['template']->render('config:layouts/styles'));
    }

    /*
     * Admin init action callback.
     */
    public function _adminInit()
    {
        // add css/js
        $siteurl = sprintf('/%s/i', preg_quote(parse_url(site_url(), PHP_URL_PATH), '/'));

        if (isset($_GET['page']) && $_GET['page'] == 'warp') {
            wp_enqueue_script('warp-js-jquery-mustache', preg_replace($siteurl, '', $this['path']->url('warp:vendor/jquery/jquery-mustache.js'), 1));
            wp_enqueue_script('warp-js-jquery-cookie', preg_replace($siteurl, '', $this['path']->url('warp:vendor/jquery/jquery-cookie.js'), 1));
            wp_enqueue_script('warp-js-jquery-less', preg_replace($siteurl, '', $this['path']->url('warp:vendor/jquery/jquery-less.js'), 1));
            wp_enqueue_script('warp-js-jquery-rtl', preg_replace($siteurl, '', $this['path']->url('warp:vendor/jquery/jquery-rtl.js'), 1));
            wp_enqueue_script('warp-js-spectrum', preg_replace($siteurl, '', $this['path']->url('warp:vendor/spectrum/spectrum.js'), 1));
            wp_enqueue_script('warp-js-uikit', preg_replace($siteurl, '', $this['path']->url('warp:vendor/uikit/js/uikit.js'), 1));
            wp_enqueue_script('warp-js-less', preg_replace($siteurl, '', $this['path']->url('warp:vendor/less/less.js'), 1));
            wp_enqueue_script('warp-js-config', preg_replace($siteurl, '', $this['path']->url('config:js/config.js'), 1));
            wp_enqueue_script('warp-js-admin', preg_replace($siteurl, '', $this['path']->url('config:js/admin.js'), 1));
            wp_enqueue_script('warp-js-jquery-onoff', preg_replace($siteurl, '', $this['path']->url('config:js/jquery-onoff.min.js'), 1));
            wp_enqueue_script('warp-js-onoff', preg_replace($siteurl, '', $this['path']->url('config:js/onoff.js'), 1));
            wp_enqueue_script('warp-js-datetimepicker', preg_replace($siteurl, '', $this['path']->url('config:js/datetimepicker.js'), 1));
            wp_enqueue_style('warp-css-spectrum', preg_replace($siteurl, '', $this['path']->url('warp:vendor/spectrum/spectrum.css'), 1));
            wp_enqueue_style('warp-css-uikit', preg_replace($siteurl, '', $this['path']->url('warp:vendor/uikit/css/uikit.warp.min.css'), 1));
            wp_enqueue_style('warp-css-datetimepicker', preg_replace($siteurl, '', $this['path']->url('config:css/datetimepicker.css'), 1));
            wp_enqueue_style('warp-css-config', preg_replace($siteurl, '', $this['path']->url('config:css/config.css'), 1));
            wp_enqueue_style('warp-css-jquery-onoff', preg_replace($siteurl, '', $this['path']->url('config:css/jquery-onoff.css'), 1));
        }

        wp_enqueue_style('warp-css-admin', preg_replace($siteurl, '', $this['path']->url('config:css/admin.css'), 1));
        wp_enqueue_style('warp-css-eclatico', preg_replace($siteurl, '', $this['path']->url('warp:vendor/uikit/fonts/eclatico.css'), 1));

        if (class_exists('WPBakeryVisualComposerAbstract')) {
            wp_enqueue_style('warp-visual-composer', preg_replace($siteurl, '', $this['path']->url('config:css/visual-composer.css'), 1));
        }
    }

    /*
     * add css/js in the login page
     */
    public function add_head_login_style()
    {
        $siteurl = sprintf('/%s/i', preg_quote(parse_url(site_url(), PHP_URL_PATH), '/'));

        wp_enqueue_script('warp-js-login-theme', preg_replace($siteurl, '', $this['path']->url('js:login.js'), 1), array( 'jquery' ));
        wp_enqueue_style('warp-css-login-theme', preg_replace($siteurl, '', $this['path']->url('css:theme.css'), 1));
        wp_enqueue_style('warp-css-login-custom', preg_replace($siteurl, '', $this['path']->url('css:custom.css'), 1));
    }

    /*
     * Admin menu action callback.
     */
    public function _adminMenu()
    {
        // init vars
        $name = $this->xml->first('name')->text();
        $icon = $this['path']->url('config:images/eclat-icon-16.png');
        $self = $this;

        /*add_object_page('', $name, apply_filters('warp_edit_theme_options', 'edit_theme_options'), 'warp', function() use ($self) {
            echo $self['template']->render('config:layouts/theme_options', array('xml' => $self->xml));
        }, $icon);*/

        add_theme_page('', $name, apply_filters('warp_edit_theme_options', 'edit_theme_options'), 'warp', function() use ($self) {
            echo $self['template']->render('config:layouts/theme_options', array('xml' => $self->xml));
        });
    }
}

/** mb_strpos function for servers not using the multibyte string extension */
if (!function_exists('mb_strpos')) {
    function mb_strpos($haystack, $needle, $offset = 0)
    {
        return strpos($haystack, $needle, $offset);
    }
}
