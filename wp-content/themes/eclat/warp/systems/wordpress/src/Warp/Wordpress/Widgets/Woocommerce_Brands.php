<?php
/**
 * @package   Warp Theme Framework
 * @author    Elartica Team http://www.elartica.com
 * @copyright Copyright (C) Elartica Team
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

class Warp_Woocommerce_Brands extends WP_Widget
{
    public function Warp_Woocommerce_Brands()
    {
        $widget_ops = array('classname' => 'woocommerce widget_brands widget_layered_nav widget', 'description' => esc_html__( 'Display a list of your Brands on your site.', 'eclat' ));
        parent::__construct(false, esc_html__( 'Eclat - Woocommerce Brands', 'eclat' ), $widget_ops);
    }

    public function widget($args, $instance)
    {
        global $warp;

        $count         = isset( $instance['count'] ) ? $instance['count'] : 0;
        $dropdown      = isset( $instance['dropdown'] ) ? $instance['dropdown'] : 0;
        $orderby       = isset( $instance['orderby'] ) ? $instance['orderby'] : 'name';

        extract( $args );

        $title = $instance['title'];

        echo $before_widget;

        if ($title) {
            echo $before_title .  esc_html( $title ) . $after_title;
        }

        $categories = get_terms( 'product_brand', 'orderby='.$orderby.'&hide_empty=0' );

        if ( ! empty( $categories ) ) {
            if($dropdown){
                echo '<div class="uk-margin-top">';

                echo '<select name="dropdown_product_brands" class="dropdown_product_brands chosen uk-width-1-1">';
                echo '<option value="">'. esc_html__('Please Select','eclat').'</option>';
                foreach( (array) $categories as $term )
                {
                    $count_text = "";
                    if($count) {
                        $count_text = ' <span class="count">(' . esc_html($term->count) . ')</span>';
                    }

                    echo '<option value="'.esc_html( $term->slug ).'" '.selected( esc_html ( get_query_var( 'product_brand' ) ) , esc_html( $term->slug ) , 1 ).'>'.esc_html( $term->name ).$count_text.'</option>';
                }
                echo '</select>';

                wc_enqueue_js( "
                    jQuery('.dropdown_product_brands').change(function(){
                        if(jQuery(this).val() != '') {
                            location.href = '" . esc_url( home_url( '/' ) ) . "?product_brand=' + jQuery(this).val();
                        }
                    });
                " );

                echo '</div>';
            } else {
                echo '<ul class="filter-list">';

                foreach( (array) $categories as $term )
                {
                    $count_text = $class = "";
                    if($count) {
                        $count_text = '<span class="count">(' . esc_html($term->count) . ')</span>';
                    }

                    if(esc_html ( get_query_var( 'product_brand' ) ) == esc_html( $term->slug )) {
                        $class = ' class="chosen"';
                    }

                    echo '<li'.$class.'><a href="' . esc_url( get_term_link($term, $term->taxonomy) ) . '">'.esc_html( $term->name ).'</a>'.$count_text.'</li>';
                }

                echo '</ul>';
            }
        }

        echo $after_widget;

    }

    public function form($instance)
    {
        $defaults = array(
            'title' => esc_html__( 'Filter by Brand', 'eclat' ),
            'orderby' => 'order',
            'dropdown' => 0,
            'count' => 0
        );

        $instance = wp_parse_args((array)$instance, $defaults);

        ?>

        <p>
            <label for="<?php echo $this->get_field_id('title') ?>"><?php esc_html_e('Title:','eclat') ?></label>
            <input type="text" name="<?php echo $this->get_field_name('title') ?>"  value="<?php echo $instance['title'] ?>" class="widefat" id="<?php echo $this->get_field_id('title') ?>">
        </p>

        <p>
            <label
                for="<?php echo $this->get_field_id('orderby'); ?>"><?php esc_html_e('Order by', 'eclat') ?>:
                <select id="<?php echo $this->get_field_id('orderby'); ?>"
                        name="<?php echo $this->get_field_name('orderby'); ?>">
                    <option
                        value="order" <?php selected($instance['orderby'], 'order') ?>><?php esc_html_e('Category Order', 'eclat') ?></option>
                    <option
                        value="name" <?php selected($instance['orderby'], 'name') ?>><?php esc_html_e('Name', 'eclat') ?></option>
                </select>
            </label>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('dropdown'); ?>"><?php esc_html_e('Show as dropdown', 'eclat') ?>:
                <select id="<?php echo $this->get_field_id('dropdown'); ?>"
                        name="<?php echo $this->get_field_name('dropdown'); ?>">
                    <option
                        value="1" <?php selected($instance['dropdown'], '1') ?>><?php esc_html_e('Yes', 'eclat') ?></option>
                    <option
                        value="0" <?php selected($instance['dropdown'], '0') ?>><?php esc_html_e('No', 'eclat') ?></option>
                </select>
            </label>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('count'); ?>"><?php esc_html_e('Show product counts', 'eclat') ?>:
                <select id="<?php echo $this->get_field_id('count'); ?>"
                        name="<?php echo $this->get_field_name('count'); ?>">
                    <option
                        value="1" <?php selected($instance['count'], '1') ?>><?php esc_html_e('Yes', 'eclat') ?></option>
                    <option
                        value="0" <?php selected($instance['count'], '0') ?>><?php esc_html_e('No', 'eclat') ?></option>
                </select>
            </label>
        </p>

    <?php
    }

    public function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['orderby'] = $new_instance['orderby'];
        $instance['dropdown'] = $new_instance['dropdown'];
        $instance['count'] = $new_instance['count'];

        return $instance;
    }
}

register_widget('Warp_Woocommerce_Brands');

