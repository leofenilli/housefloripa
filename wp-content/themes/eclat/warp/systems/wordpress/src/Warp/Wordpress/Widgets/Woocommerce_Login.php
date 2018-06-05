<?php
/**
 * @package   Warp Theme Framework
 * @author    Elartica Team http://www.elartica.com
 * @copyright Copyright (C) Elartica Team
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

class Warp_Woocommerce_Login extends WP_Widget
{
    public function Warp_Woocommerce_Login()
    {
        $widget_ops = array('description' => esc_html__( 'Display Login Menu in the header of the page.', 'eclat' ));
        parent::__construct(false, esc_html__( 'Eclat - Woocommerce Login', 'eclat' ), $widget_ops);
    }

    public function widget($args, $instance)
    {
        extract( $args );

        $show_logged_out = isset($instance['show_logged_out']) ? $instance['show_logged_out'] : 'yes';
        $title_logged_out = isset($instance['title_logged_out']) ? $instance['title_logged_out'] : '';
        $show_logged_in = isset($instance['show_logged_in']) ? $instance['show_logged_in'] : 'yes';
        $nav_menu = isset($instance['nav_menu']) ? wp_get_nav_menu_object($instance['nav_menu']) : '';
        $profile_link = eclat_is_shop_installed() ? get_permalink(wc_get_page_id('myaccount')) : wp_login_url();

        echo $before_widget;

        if (is_user_logged_in() && $show_logged_in == 'yes')
        {
	        /*if( function_exists( 'wp_get_current_user' ) )
	        {*/
		        $current_user = wp_get_current_user();
	        /*}
	        else
	        {
		        global $current_user;
		        get_currentuserinfo();
	        }*/

            if (!$current_user->user_firstname && !$current_user->user_lastname)
            {
                if (eclat_is_shop_installed())
                {
                    $firstname_billing = get_user_meta($current_user->ID, "billing_first_name", true);
                    $lastname_billing = get_user_meta($current_user->ID, "billing_last_name", true);

                    // if firstname and last name in billing options are both not setted
                    if (!$firstname_billing && !$lastname_billing) {
                        $user_name = $current_user->user_nicename;
                    } else {
                        $user_name = $firstname_billing . ' ' . $lastname_billing;
                    }
                }
                else
                {
                    $user_name = $current_user->user_nicename;
                }
            }
            else
            {
                $user_name = $current_user->user_firstname . ' ' . $current_user->user_lastname;
            }

            if ($user_name == ' ')
            {
                $user_name = $current_user->user_login;
            }
            ?>

            <div id="welcome-menu" data-uk-dropdown>
                <div class="tm-pointer">
                    <a href="<?php echo $profile_link ?>" class="hover-icon">
                        <span class="tm-icon-user"></span>
                        <span><?php echo esc_html__('Welcome', 'eclat'); ?>,<b> <?php echo $user_name; ?></b></span>
                    </a>
                    <span class="tm-icon-arrow-down"></span>
                </div>
                <?php
                $nav_args = array(
                    'menu' => $nav_menu,
                    'container' => 'div',
                    'container_class' => 'uk-dropdown',
                    'menu_class' => 'uk-nav uk-nav-dropdown',
                    'depth' => 1
                );

                wp_nav_menu($nav_args);
                ?>
            </div>
        <?php } else { ?>
            <a href="#uk-login-form" class="hover-icon" data-uk-modal="{center:true}"><span class="tm-icon-user"></span><span><?php echo $title_logged_out ?></span></a>
            <?php if ($show_logged_out == 'yes') { ?>
                <?php add_action( 'wp_footer', function(){
                    $how_login_form = false;
                    ?>
                    <div id="uk-login-form" class="uk-modal">
                    <div class="uk-modal-dialog">
                        <a class="uk-modal-close uk-close"></a>
                        <h2><?php esc_html_e('Login', 'eclat'); ?></h2>
                        <div class="uk-sub-title"><?php esc_html_e('Sign in with username or email address', 'eclat'); ?></div>
	                    <?php if ( ! empty( $_POST['login'] ) && ! empty( $_POST['_wpnonce'] ) && wp_verify_nonce( $_POST['_wpnonce'], 'woocommerce-login' ) && wc_notice_count( 'error' ) > 0 ) {
		                    wc_print_notices();
		                    $how_login_form = true;
	                    } ?>
                        <form method="post" class="login-form">
                            <?php do_action('woocommerce_login_form_start'); ?>
                            <div class="form-group">
                                <input type="text" class="form-control" name="username" id="username" value="<?php if (!empty($_POST['username'])) echo esc_attr($_POST['username']); ?>"/>
                                <label for="username"><span><?php esc_html_e('Username or email', 'eclat'); ?></span></label>
                            </div>
                            <div class="form-group">
                                <input class="form-control" type="password" name="password" id="password"/>
                                <label for="password"><span><?php esc_html_e('Password', 'eclat'); ?></span></label>
                            </div>
                            <?php do_action('woocommerce_login_form'); ?>
                            <div class="login-submit-block">
                                <?php wp_nonce_field('woocommerce-login'); ?>
                                <input type="submit" class="uk-button button-login alt" name="login" value="<?php esc_html_e('Login', 'eclat'); ?>"/>

                                <p class="lost_password">
                                    <?php if (function_exists('wc_lostpassword_url')): ?>
                                        <a class="animate-border" href="<?php echo esc_url(wc_lostpassword_url()); ?>"><?php esc_html_e( 'Lost your password?', 'eclat' ); ?></a><span class="ver_separator"></span>
                                    <?php endif ?>
                                    <a class="animate-border" href="<?php echo get_permalink( wc_get_page_id( 'myaccount' ) ); ?>"><?php esc_html_e( 'Sign up', 'eclat' ); ?></a>
                                </p>
                                <!--label for="rememberme" class="inline">
                                    <input name="rememberme" type="checkbox" id="rememberme" value="forever" /> <?php esc_html_e('Remember me', 'eclat'); ?>
                                </label-->
                            </div>
                            <?php do_action('woocommerce_login_form_end'); ?>
                            <?php do_action( 'wordpress_social_login' ); ?>
                        </form>
                    </div>
                </div>
		        <?php if ( $how_login_form ) { ?>
			        <script type="text/javascript">
				        jQuery(function($) {

					        "use strict";

					        var login_modal = UIkit.modal("#uk-login-form");

					        if (!login_modal.isActive()) {
						        login_modal.show();
					        }
				        });
			        </script>
		        <?php } ?>
			        
                <?php }) ?>
            <?php } ?>
        <?php }

        echo $after_widget;
    }

    public function form($instance)
    {
        $defaults = array(
            'show_logged_out' => 'yes',
            'title_logged_out' => esc_html__('Login in', 'eclat'),
            'show_logged_in' => 'yes',
            'nav_menu' => '',
        );

        $instance = wp_parse_args((array)$instance, $defaults);
        $menus = wp_get_nav_menus(array('orderby' => 'name'));

        ?>

        <p>
            <label
                for="<?php echo $this->get_field_id('show_logged_out'); ?>"><?php esc_html_e('Show Logged Out Menu', 'eclat') ?>:
                <select id="<?php echo $this->get_field_id('show_logged_out'); ?>"
                        name="<?php echo $this->get_field_name('show_logged_out'); ?>">
                    <option
                        value="yes" <?php selected($instance['show_logged_out'], 'yes') ?>><?php esc_html_e('Yes', 'eclat') ?></option>
                    <option
                        value="no" <?php selected($instance['show_logged_out'], 'no') ?>><?php esc_html_e('No', 'eclat') ?></option>
                </select>
            </label>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('title_logged_out'); ?>"><?php esc_html_e('Title Logged Out', 'eclat') ?>:
                <input type="text" id="<?php echo $this->get_field_id('title_logged_out'); ?>"
                       name="<?php echo $this->get_field_name('title_logged_out'); ?>"
                       value="<?php echo $instance['title_logged_out']; ?>" class="widefat"/>
            </label>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('show_logged_in'); ?>"><?php esc_html_e('Show Logged In Menu', 'eclat') ?>:
                <select id="<?php echo $this->get_field_id('show_logged_in'); ?>"
                        name="<?php echo $this->get_field_name('show_logged_in'); ?>">
                    <option
                        value="yes" <?php selected($instance['show_logged_in'], 'yes') ?>><?php esc_html_e('Yes', 'eclat') ?></option>
                    <option
                        value="no" <?php selected($instance['show_logged_in'], 'no') ?>><?php esc_html_e('No', 'eclat') ?></option>
                </select>
            </label>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('nav_menu'); ?>"><?php esc_html_e('Select Logged In Menu:', 'eclat'); ?></label>
            <select id="<?php echo $this->get_field_id('nav_menu'); ?>"
                    name="<?php echo $this->get_field_name('nav_menu'); ?>">
                <?php
                foreach ($menus as $menu) {
                    echo '<option value="' . $menu->term_id . '"'
                        . selected($instance['nav_menu'], $menu->term_id, false)
                        . '>' . $menu->name . '</option>';
                }
                ?>
            </select>
        </p>
    <?php
    }

    public function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['title_logged_out'] = strip_tags($new_instance['title_logged_out']);
        $instance['show_logged_out'] = $new_instance['show_logged_out'];
        $instance['show_logged_in'] = $new_instance['show_logged_in'];
        $instance['nav_menu'] = $new_instance['nav_menu'];

        return $instance;
    }
}

register_widget('Warp_Woocommerce_Login');

