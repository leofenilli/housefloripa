<?php
/**
 * @package   Warp Theme Framework
 * @author    Elartica Team http://www.elartica.com
 * @copyright Copyright (C) Elartica Team
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

class Warp_Woocommerce_Categories extends WP_Widget
{
    /**
     * Category ancestors
     *
     * @var array
     */
    public $cat_ancestors;

    /**
     * Current Category
     *
     * @var bool
     */
    public $current_cat;

    public function Warp_Woocommerce_Categories()
    {
        $widget_ops = array('classname' => 'woocommerce widget_categories widget', 'description' => esc_html__( 'A list or dropdown of product categories.', 'eclat' ));
        parent::__construct(false, esc_html__( 'Eclat - Woocommerce Product Categories', 'eclat' ), $widget_ops);
    }

    public function widget($args, $instance)
    {
        global $wp_query, $post, $warp;

        extract( $args );

        $title = $instance['title'];

        echo $before_widget;

        if ($title) {
            echo $before_title . esc_html( $title ) . $after_title;
        }

        $c             = isset( $instance['count'] ) ? $instance['count'] : 0;
        $h             = isset( $instance['hierarchical'] ) ? $instance['hierarchical'] : 1;
        $s             = isset( $instance['show_children_only'] ) ? $instance['show_children_only'] : 0;
        $d             = isset( $instance['dropdown'] ) ? $instance['dropdown'] : 0;
        $o             = isset( $instance['orderby'] ) ? $instance['orderby'] : 'name';
        $dropdown_args = array( 'hide_empty' => false );
        $list_args     = array( 'show_count' => $c, 'hierarchical' => $h, 'taxonomy' => 'product_cat', 'hide_empty' => false );

        // Menu Order
        $list_args['menu_order'] = false;
        if ( $o == 'order' ) {
            $list_args['menu_order'] = 'asc';
        } else {
            $list_args['orderby']    = 'title';
        }

        // Setup Current Category
        $this->current_cat   = false;
        $this->cat_ancestors = array();

        if ( is_tax( 'product_cat' ) ) {

            $this->current_cat   = $wp_query->queried_object;
            $this->cat_ancestors = get_ancestors( $this->current_cat->term_id, 'product_cat' );

        } elseif ( is_singular( 'product' ) ) {

            $product_category = wc_get_product_terms( $post->ID, 'product_cat', array( 'orderby' => 'parent' ) );

            if ( $product_category ) {
                $this->current_cat   = end( $product_category );
                $this->cat_ancestors = get_ancestors( $this->current_cat->term_id, 'product_cat' );
            }

        }

        // Show Siblings and Children Only
        if ( $s && $this->current_cat ) {

            // Top level is needed
            $top_level = get_terms(
                'product_cat',
                array(
                    'fields'       => 'ids',
                    'parent'       => 0,
                    'hierarchical' => true,
                    'hide_empty'   => false
                )
            );

            // Direct children are wanted
            $direct_children = get_terms(
                'product_cat',
                array(
                    'fields'       => 'ids',
                    'parent'       => $this->current_cat->term_id,
                    'hierarchical' => true,
                    'hide_empty'   => false
                )
            );

            // Gather siblings of ancestors
            $siblings  = array();
            if ( $this->cat_ancestors ) {
                foreach ( $this->cat_ancestors as $ancestor ) {
                    $ancestor_siblings = get_terms(
                        'product_cat',
                        array(
                            'fields'       => 'ids',
                            'parent'       => $ancestor,
                            'hierarchical' => false,
                            'hide_empty'   => false
                        )
                    );
                    $siblings = array_merge( $siblings, $ancestor_siblings );
                }
            }

            if ( $h ) {
                $include = array_merge( $top_level, $this->cat_ancestors, $siblings, $direct_children, array( $this->current_cat->term_id ) );
            } else {
                $include = array_merge( $direct_children );
            }

            $dropdown_args['include'] = implode( ',', $include );
            $list_args['include']     = implode( ',', $include );

            if ( empty( $include ) ) {
                return;
            }

        } elseif ( $s ) {
            $dropdown_args['depth']        = 1;
            $dropdown_args['child_of']     = 0;
            $dropdown_args['hierarchical'] = 1;
            $list_args['depth']            = 1;
            $list_args['child_of']         = 0;
            $list_args['hierarchical']     = 1;
        }

        // Dropdown
        if ( $d ) {
            $dropdown_defaults = array(
                'show_counts'        => $c,
                'hierarchical'       => $h,
                'show_uncategorized' => 0,
                'orderby'            => $o,
                'selected'           => $this->current_cat ? $this->current_cat->slug : ''
            );
            $dropdown_args = wp_parse_args( $dropdown_args, $dropdown_defaults );

            echo '<div class="uk-margin-top">';

            // Stuck with this until a fix for http://core.trac.wordpress.org/ticket/13258
            wc_product_dropdown_categories( apply_filters( 'woocommerce_product_categories_widget_dropdown_args', $dropdown_args ) );

            wc_enqueue_js( "
				jQuery('.dropdown_product_cat').change(function(){
					if(jQuery(this).val() != '') {
						location.href = '" . esc_url( home_url( '/' ) ) . "?product_cat=' + jQuery(this).val();
					}
				});
			" );

            echo '</div>';

            // List
        } else {

            include_once( WC()->plugin_path() . '/includes/walkers/class-product-cat-list-walker.php' );

            $list_args['walker']                     = new WC_Product_Cat_List_Walker;
            $list_args['title_li']                   = '';
            $list_args['pad_counts']                 = 1;
            $list_args['show_option_none']           = esc_html__('No product categories exist.', 'eclat' );
            $list_args['current_category']           = ( $this->current_cat ) ? $this->current_cat->term_id : '';
            $list_args['current_category_ancestors'] = $this->cat_ancestors;

            echo '<ul class="uk-list uk-list-line product-categories">';

            wp_list_categories( apply_filters( 'woocommerce_product_categories_widget_args', $list_args ) );

            echo '</ul>';
        }

        echo $after_widget;

    }

    public function form($instance)
    {
        $defaults = array(
            'title' => esc_html__( 'Product Categories', 'eclat' ),
            'orderby' => 'order',
            'dropdown' => 0,
            'count' => 0,
            'hierarchical' => 1,
            'show_children_only' => 0
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

        <p>
            <label for="<?php echo $this->get_field_id('hierarchical'); ?>"><?php esc_html_e('Show hierarchy', 'eclat'); ?>:
                <select id="<?php echo $this->get_field_id('hierarchical'); ?>"
                        name="<?php echo $this->get_field_name('hierarchical'); ?>">
                    <option
                        value="1" <?php selected($instance['hierarchical'], '1') ?>><?php esc_html_e('Yes', 'eclat') ?></option>
                    <option
                        value="0" <?php selected($instance['hierarchical'], '0') ?>><?php esc_html_e('No', 'eclat') ?></option>
                </select>
            </label>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('show_children_only'); ?>"><?php esc_html_e('Only show children of the current category', 'eclat'); ?>:
                <select id="<?php echo $this->get_field_id('show_children_only'); ?>"
                        name="<?php echo $this->get_field_name('show_children_only'); ?>">
                    <option
                        value="1" <?php selected($instance['show_children_only'], '1') ?>><?php esc_html_e('Yes', 'eclat') ?></option>
                    <option
                        value="0" <?php selected($instance['show_children_only'], '0') ?>><?php esc_html_e('No', 'eclat') ?></option>
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
        $instance['hierarchical'] = $new_instance['hierarchical'];
        $instance['show_children_only'] = $new_instance['show_children_only'];

        return $instance;
    }
}

register_widget('Warp_Woocommerce_Categories');

