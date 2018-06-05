<?php
/**
* @package   Eclat
* @author    Elartica Team http://www.elartica.com
* @copyright Copyright (C) Elartica Team
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

// get theme configuration
include(get_template_directory().'/layouts/theme.config.php');

$error_page = (isset($error) && $error == '404');

?>
<!DOCTYPE HTML>
<html <?php language_attributes(); ?> dir="<?php echo $this['config']->get('direction'); ?>"  data-config='<?php echo $this['config']->get('body_config','{}'); ?>'>

<head>
<?php echo $this['template']->render('head'); ?>
</head>

<body class="<?php echo $this['config']->get('body_classes'); ?>">

    <?php if ($this['config']->get('page_loader', true) && (is_home() || is_front_page())) : ?>
    <div id="loader-page" class="loader-page">
        <div class="loader-logo">
            <div></div>
        </div>
        <div class="loader">
            <svg class="loader-inner" width="140px" height="140px" viewBox="0 0 80 80">
                <path class="loader-circlebg" d="M40,10C57.351,10,71,23.649,71,40.5S57.351,71,40.5,71 S10,57.351,10,40.5S23.649,10,40.5,10z"/>
                <path id="loader-circle" class="loader-circle" d="M40,10C57.351,10,71,23.649,71,40.5S57.351,71,40.5,71 S10,57.351,10,40.5S23.649,10,40.5,10z"/>
            </svg>
        </div>
    </div>
    <?php endif; ?>

    <div id="wrapper">
        <?php if ($this['widgets']->count('toolbar-l + toolbar-r')) : ?>
            <div class="tm-toolbar" <?php echo (!$this['config']->get('eclat_topbar', true) ? ' style="display: none;"' : ''); ?>>
                <div class="uk-container uk-container-center">

                    <?php if ($this['widgets']->count('offcanvas')) : ?>
                        <a href="#offcanvas" class="uk-navbar-toggle uk-hidden-large" data-uk-offcanvas></a>
                    <?php endif; ?>

                    <?php if ($this['widgets']->count('toolbar-l')) : ?>
                        <div class="uk-float-left">
                            <?php echo $this['widgets']->render('toolbar-l'); ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($this['widgets']->count('toolbar-r')) : ?>
                        <div class="uk-float-right"><?php echo $this['widgets']->render('toolbar-r'); ?></div>
                    <?php endif; ?>

                    <?php if ($this['widgets']->count('menu')) : ?>
                        <?php echo $this['widgets']->render('menu'); ?>
                    <?php endif; ?>

                </div>
            </div>
        <?php endif; ?>

        <?php if ($this['widgets']->count('logo + menu + search')) : ?>
            <nav class="tm-navbar uk-navbar">
                <div class="uk-container uk-container-center tm-container-80">
                    <?php if ($this['widgets']->count('logo') && !$this['config']->get('eclat_header_inline', true)) : ?>
                        <div class="tm-logo-center uk-text-center">
                            <a class="tm-logo" href="<?php echo $this['config']->get('site_url'); ?>">
                                <?php echo $this['widgets']->render('logo'); ?>
                            </a>
                        </div>
                    <?php endif; ?>
                    <div class="uk-flex uk-flex-middle uk-flex-space-between">
                        <?php if ($this['widgets']->count('logo') && $this['config']->get('eclat_header_inline', true)) { ?>
                            <div class="tm-logo-inline">
                                <a class="tm-logo" href="<?php echo $this['config']->get('site_url'); ?>">
                                    <?php echo $this['widgets']->render('logo'); ?>
                                </a>
                            </div>
                        <?php } else if($this['widgets']->count('logo')) { ?>
                            <div class="tm-logo-inline"></div>
                        <?php } ?>

                        <?php if ($this['widgets']->count('menu')) : ?>
                            <?php echo $this['widgets']->render('menu'); ?>
                        <?php endif; ?>

                        <?php if ($this['widgets']->count('search')) : ?>
                            <div class="tm-search uk-text-right">
                                <?php echo $this['widgets']->render('search'); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </nav>
        <?php endif; ?>

        <?php if ($this['widgets']->count('slider') && !$error_page) : ?>
            <div class="main-slider">
                <?php echo $this['widgets']->render('slider'); ?>
            </div>
        <?php endif; ?>

        <?php if ($this['widgets']->count('top-a') && !$error_page) : ?>
            <div class="uk-container uk-container-center">
                <section class="<?php echo $grid_classes['top-a']; echo $display_classes['top-a']; ?>" data-uk-grid-match="{target:'> div > .uk-panel'}" data-uk-grid-margin>
                    <?php echo $this['widgets']->render('top-a', array('layout'=>$this['config']->get('grid.top-a.layout'))); ?>
                </section>
            </div>
        <?php endif; ?>

        <?php if ($this['widgets']->count('top-b') && !$error_page) : ?>
            <div class="uk-container uk-container-center">
                <section class="<?php echo $grid_classes['top-b']; echo $display_classes['top-b']; ?>" data-uk-grid-match="{target:'> div > .uk-panel'}" data-uk-grid-margin>
                    <?php echo $this['widgets']->render('top-b', array('layout'=>$this['config']->get('grid.top-b.layout'))); ?>
                </section>
            </div>
        <?php endif; ?>

        <?php if ($this['widgets']->count('breadcrumbs') && $this['config']->get('page_title', true) && !$error_page) : ?>
            <div class="tm-breadcrumbs">
                <div class="uk-container uk-container-center tm-container-80">
                    <div class="uk-flex uk-flex-middle uk-flex-space-between">
                        <?php if ($this['config']->get('page_title', true)) :
                            $system_query = $this['system']->getQuery();
                            ?>
                            <?php if( in_array('single', $system_query) || in_array('product-single', $system_query) ) : ?>
                                <h2><?php $this->output('warp_title'); ?></h2>
                            <?php else :?>
                                <h1><?php $this->output('warp_title'); ?></h1>
                            <?php endif; ?>
                        <?php endif; ?>
                        <?php if ($this['widgets']->count('breadcrumbs')) : ?>
                            <?php echo $this['widgets']->render('breadcrumbs'); ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php if (($this['widgets']->count('main-top + main-bottom + sidebar-a + sidebar-b') || $this['config']->get('system_output', true)) && !$error_page) : ?>
            <?php if(!in_array($this['config']->get('warp_layout'), array('full-width', 'full-width-with-title'))) : ?>
            <div class="uk-container uk-container-center">
                <div class="tm-middle uk-grid" data-uk-grid-margin>
            <?php endif; ?>

                <?php if ($this['widgets']->count('main-top + main-bottom') || $this['config']->get('system_output', true)) : ?>
                <div class="<?php echo $columns['main']['class'] ?>">

                    <?php if ($this['widgets']->count('main-top')) : ?>
                    <section class="<?php echo $grid_classes['main-top']; echo $display_classes['main-top']; ?>" data-uk-grid-match="{target:'> div > .uk-panel'}" data-uk-grid-margin><?php echo $this['widgets']->render('main-top', array('layout'=>$this['config']->get('grid.main-top.layout'))); ?></section>
                    <?php endif; ?>

                    <?php if ($this['config']->get('system_output', true)) : ?>
                    <main class="tm-content">
                        <?php echo $this['template']->render('content'); ?>
                    </main>
                    <?php endif; ?>

                    <?php if ($this['widgets']->count('main-bottom')) : ?>
                    <section class="<?php echo $grid_classes['main-bottom']; echo $display_classes['main-bottom']; ?>" data-uk-grid-match="{target:'> div > .uk-panel'}" data-uk-grid-margin><?php echo $this['widgets']->render('main-bottom', array('layout'=>$this['config']->get('grid.main-bottom.layout'))); ?></section>
                    <?php endif; ?>

                </div>
                <?php endif; ?>
            <?php if(!in_array($this['config']->get('warp_layout'), array('full-width', 'full-width-with-title'))) : ?>
                <?php foreach($columns as $name => &$column) : ?>
                    <?php if ($name != 'main' && $this['widgets']->count($name)) : ?>
                        <aside class="<?php echo $column['class'] ?>">
                            <div class="tm-sidebar-inner">
                                <?php echo $this['widgets']->render($name) ?>
                            </div>
                        </aside>
                    <?php endif ?>
                <?php endforeach ?>

                </div>
            </div>
            <?php endif; ?>
        <?php endif; ?>

        <?php if($error_page) :?>
            <div class="uk-container uk-container-center">
                <?php echo $this['template']->render('404'); ?>
            </div>
        <?php endif; ?>

        <?php if ($this['widgets']->count('tweets')) : ?>
            <div class="uk-container uk-container-center">
                <?php echo $this['widgets']->render('tweets'); ?>
            </div>
        <?php endif; ?>

        <?php if ($this['widgets']->count('bottom-a')) : ?>
        <section class="<?php echo $grid_classes['bottom-a']; echo $display_classes['bottom-a']; ?>" data-uk-grid-match="{target:'> div > .uk-panel'}" data-uk-grid-margin><?php echo $this['widgets']->render('bottom-a', array('layout'=>$this['config']->get('grid.bottom-a.layout'))); ?></section>
        <?php endif; ?>

    </div>
    <?php if ($this['widgets']->count('footer + debug + bottom-b') || $this['config']->get('totop_scroller', true)) : ?>
    <footer id="footer" class="tm-footer"<?php echo (!$this['config']->get('eclat_footer_bg', true ) ? ' style="background-image: none;"' : ''); ?>>
        <div class="uk-container uk-container-center">
            <?php if ($this['widgets']->count('bottom-b')) : ?>
                <section class="<?php echo $grid_classes['bottom-b']; echo $display_classes['bottom-b']; ?>" data-uk-grid-match="{target:'> div > .uk-panel'}" data-uk-grid-margin><?php echo $this['widgets']->render('bottom-b', array('layout'=>$this['config']->get('grid.bottom-b.layout'))); ?></section>
            <?php endif; ?>
            <?php if ($this['widgets']->count('footer + social')) : ?>
                <div class="tm-footer-line uk-clearfix">
                <?php if ($this['widgets']->count('footer')) : ?>
                    <div class="tm-copyright uk-float-left">
                        <?php echo $this['widgets']->render('footer');?>
                    </div>
                <?php endif; ?>
                <?php if ($this['widgets']->count('social')) : ?>
                    <div class="tm-social-menu uk-float-right">
                        <?php echo $this['widgets']->render('social');?>
                    </div>
                <?php endif; ?>
                </div>
            <?php endif; ?>
            <?php echo $this['widgets']->render('debug'); ?>
        </div>
    </footer>
    <?php endif; ?>

    <?php if ($this['config']->get('totop_scroller', true)) : ?>
        <a class="tm-totop-scroll" data-uk-smooth-scroll href="#wrapper"></a>
    <?php endif; ?>

	<?php if ($this['widgets']->count('offcanvas + offcanvas-login + offcanvas-nav')) : ?>
	<div id="offcanvas" class="uk-offcanvas">
		<div class="uk-offcanvas-bar">
            <?php echo $this['widgets']->render('offcanvas-login'); ?>
            <?php if ($this['widgets']->count('offcanvas-nav')) : ?>
                <div class="uk-offcanvas-nav uk-clearfix uk-hidden-large">
                    <?php echo $this['widgets']->render('offcanvas-nav'); ?>
                </div>
            <?php endif; ?>
            <?php echo $this['widgets']->render('offcanvas'); ?>
        </div>
	</div>
	<?php endif; ?>

    <?php if ($this['widgets']->count('offcanvas-filter')) : ?>
    <div id="offcanvas-filter" class="uk-offcanvas">
        <div class="uk-offcanvas-bar uk-offcanvas-filter">
            <div class="uk-offcanvas-filter-inner">
                <?php echo $this['widgets']->render('offcanvas-filter'); ?>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <?php if ($this['widgets']->count('custom-modal')) : ?>
    <div id="custom-modal" class="uk-modal">
        <div class="uk-modal-dialog">
            <a class="uk-modal-close uk-close"></a>
            <div class="custom-modal-content">
                <?php echo $this['widgets']->render('custom-modal'); ?>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <?php echo $this->render('footer'); ?>

</body>
</html>