<?php
/**
* @package   Warp Theme Framework
* @author    Elartica Team http://www.elartica.com
* @copyright Copyright (C) Elartica Team
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

class Warp_Breadcrumbs extends \WP_Widget
{
    public function Warp_Breadcrumbs()
    {
        $widget_ops = array('description' => 'Display your sites breadcrumb navigation');
        parent::__construct(false, 'Warp - Breadcrumbs', $widget_ops);
    }

    public function widget($args, $instance)
    {
        global $wp_query;

        extract($args);

        $title = $instance['title'];
        $home_title = trim(esc_html( $instance['home_title']));

        if (empty($home_title)) {
            $home_title = 'Home';
        }

        echo $before_widget;

        if ($title) {
            echo $before_title . esc_html( $title ) . $after_title;
        }

        if (!is_home() && !is_front_page()) {

            $output = '<ul class="uk-breadcrumb uk-hidden-small">';

            $output .= '<li><a href="'.home_url('/').'">'.$home_title.'</a></li>';

            if (is_single())
            {
                if ($cats = get_the_category())
                {
                    $cat = $cats[0];

                    if (is_object($cat))
                    {
                        if ($cat->parent != 0)
                        {
                            $cats = explode("@@@", get_category_parents($cat->term_id, true, "@@@"));

                            unset($cats[count($cats)-1]);
                            $output .= str_replace('<li>@@','<li>', '<li>'.implode("</li><li>", $cats).'</li>');
                        }
                        else
                        {
                            $output .= '<li><a href="'.get_category_link($cat->term_id).'">'.$cat->name.'</a></li>';
                        }
                    }
                }
            }

            if (is_category())
            {
                $cat_obj = $wp_query->get_queried_object();

                $cats = explode("@@@", get_category_parents($cat_obj->term_id, TRUE, '@@@'));
                unset($cats[count($cats)-1]);
                $cats[count($cats)-1] = '@@<span>'.strip_tags($cats[count($cats)-1]).'</span>';

                $output .= str_replace('<li>@@','<li class="uk-active">', '<li>'.implode("</li><li>", $cats).'</li>');
            }
            elseif (is_tag())
            {
                $output .= '<li class="uk-active"><span>'.esc_html__('Posts Tagged ', 'eclat').' "'.single_tag_title('', false).'"'.'</span></li>';
            }
            elseif (is_date())
            {
                if (is_day())
                {
                    $output .= '<li class="uk-active"><span>'.esc_html__('Archive for ', 'eclat').get_the_date().'</span></li>';
                }
                elseif(is_month())
                {
                    $output .= '<li class="uk-active"><span>'.esc_html__('Archive for ', 'eclat').get_the_date('F, Y').'</span></li>';
                }
                elseif( is_year() )
                {
                    $output .= '<li class="uk-active"><span>'.esc_html__('Archive for ', 'eclat').get_the_date('Y').'</span></li>';
                }
            }
            elseif ( is_author() )
            {
                $output .= '<li class="uk-active"><span>'.esc_html__('Author Archive', 'eclat').'</span></li>';
            }
            elseif (is_search())
            {
                $output .= '<li class="uk-active"><span>'.stripslashes(strip_tags(get_search_query())).'</span></li>';
            }
            elseif ( class_exists('WooCommerce') && is_shop() )
            {
                $shop_title = wc_get_page_id( 'shop' ) ? get_the_title( wc_get_page_id( 'shop' ) ) : '';
                $output .= '<li class="uk-active"><span>'.$shop_title.'</span></li>';
            }
            elseif (is_tax())
            {
                if(get_post_type() == 'product' && class_exists('WooCommerce'))
                {
                    $term_id = $wp_query->queried_object_id;
                    $taxonomy = get_query_var('taxonomy');

                    $shop_title = wc_get_page_id( 'shop' ) ? get_the_title( wc_get_page_id( 'shop' ) ) : '';
                    $shop_link = wc_get_page_id( 'shop' ) ? get_page_link( wc_get_page_id( 'shop' ) ) : '';
                    if($shop_title && $shop_link)
                    {
                        $output .= '<li><a href="' .$shop_link. '">' . $shop_title . '</a></li>';
                    }
                    $output .= eclat_woo_get_term_parents($term_id, $taxonomy, false, array());
                }
                else
                {
                    $taxonomy = get_taxonomy (get_query_var('taxonomy'));
                    $term = get_query_var('term');

                    $output .= '<li class="uk-active"><span>'.$taxonomy->label .': '.$term.'</span></li>';
                }
            }
            elseif ( get_post_type() == 'product' && class_exists('WooCommerce') && is_singular() )
            {
                $shop_title = wc_get_page_id( 'shop' ) ? get_the_title( wc_get_page_id( 'shop' ) ) : '';
                $shop_link = wc_get_page_id( 'shop' ) ? get_page_link( wc_get_page_id( 'shop' ) ) : '';
                if($shop_title && $shop_link)
                {
                    $output .= '<li><a href="' .$shop_link. '">' . $shop_title . '</a></li>';
                }

                global $post;

                $taxonomy = 'product_cat';

                $terms = get_the_terms($post->ID, $taxonomy);
                $links = array();

                if ($terms && !is_wp_error($terms))
                {
                    $count = 0;
                    foreach ($terms as $c)
                    {
                        $count++;
                        if ($count > 1)
                            continue;

                        $output .= eclat_woo_get_term_parents($c->term_id, $taxonomy, true, array());

                    }
                }

                $output .= '<li class="uk-active"><span>'.get_the_title($post->ID).'</span></li>';
            }
            elseif ( get_post_type() == 'portfolio' && is_singular() ) {
                $output .= '<li class="uk-active"><span>'.esc_html__( "Portfolio", "eclat" ).": ".get_the_title().'</span></li>';
            }
            elseif($wp_query->is_posts_page && get_option('page_for_posts') == $wp_query->queried_object_id){
                $this_posts_page = get_page(get_option('page_for_posts'));
                $output .= '<li class="uk-active"><span>'.$this_posts_page->post_title.'</span></li>';
            }
            else
            {
                $ancestors = get_ancestors(get_the_ID(), 'page');
                for($i = count($ancestors)-1; $i >= 0; $i--)
                {
                    $output .= '<li><a href="'.get_page_link($ancestors[$i]).'" title="'.get_the_title($ancestors[$i]).'">'.get_the_title($ancestors[$i]).'</a></li>';
                }
                $output .= '<li class="uk-active"><span>'.get_the_title().'</span></li>';
            }

            $output .= '</ul>';
        }
        elseif($wp_query->is_posts_page && get_option('page_for_posts') == $wp_query->queried_object_id){
            $this_posts_page = get_page(get_option('page_for_posts'));
            $output = '<ul class="uk-breadcrumb uk-hidden-small">';
            $output .= '<li><a href="'.home_url('/').'">'.$home_title.'</a></li>';
            $output .= '<li class="uk-active"><span>'.$this_posts_page->post_title.'</span></li>';
            $output .= '</ul>';
        }
        else
        {
            $output = '<ul class="uk-breadcrumb uk-hidden-small">';
            $output .= '<li class="uk-active"><span>'.$home_title.'</span></li>';
            $output .= '</ul>';
        }

        echo $output;

        echo $after_widget;

    }

    public function update($new_instance, $old_instance)
    {
        return $new_instance;
    }

    public function form($instance)
    {
        $title = esc_attr($instance['title']);
        $home_title = esc_attr($instance['home_title']);
        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id('title') ) ?>"><?php esc_html_e('Title:','eclat') ?></label>
            <input type="text" name="<?php echo esc_attr( $this->get_field_name('title') ) ?>" value="<?php echo esc_attr( $title ); ?>" class="widefat" id="<?php echo esc_attr( $this->get_field_id('title') ) ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id('home_title') ) ?>"><?php esc_html_e('Home title:','eclat') ?></label>
            <input type="text" placeholder="Home" name="<?php echo esc_attr( $this->get_field_name('home_title') ) ?>"  value="<?php echo esc_attr( $home_title ) ?>" class="widefat" id="<?php echo esc_attr( $this->get_field_id('home_title') ) ?>">
        </p>
        <?php
    }
}

register_widget('Warp_Breadcrumbs');
