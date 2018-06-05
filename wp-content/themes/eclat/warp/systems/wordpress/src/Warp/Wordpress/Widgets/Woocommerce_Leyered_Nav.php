<?php
/**
 * @package   Warp Theme Framework
 * @author    Elartica Team http://www.elartica.com
 * @copyright Copyright (C) Elartica Team
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

class Warp_Woocommerce_Leyered_Nav extends WP_Widget
{

    public function Warp_Woocommerce_Leyered_Nav()
    {
        $widget_ops = array('classname' => 'woocommerce widget_layered_nav widget', 'description' => esc_html__( 'Shows a custom attribute in a widget which lets you narrow down the list of products when viewing product categories.', 'eclat' ));
        parent::__construct(false, esc_html__( 'Eclat - Woocommerce Layered Nav', 'eclat' ), $widget_ops);
    }

    public function widget($args, $instance)
    {
        global $_chosen_attributes, $woocommerce, $_attributes_array;

        extract( $args );

        if ( ! is_post_type_archive( 'product' ) && ! is_tax( get_object_taxonomies( 'product' ) ) ) {
            return;
        }

        $current_term = is_tax() ? get_queried_object()->term_id : '';
        $current_tax  = is_tax() ? get_queried_object()->taxonomy : '';
        $taxonomy     = isset( $instance['attribute'] ) ? wc_attribute_taxonomy_name( $instance['attribute'] ) : '';
        $query_type   = isset( $instance['query_type'] ) ? $instance['query_type'] : 'and';
        $display_type = isset( $instance['display_type'] ) ? $instance['display_type'] : 'list';

        if ( ! taxonomy_exists( $taxonomy ) ) {
            return;
        }

        $get_terms_args = array( 'hide_empty' => '1' );

        $orderby = wc_attribute_orderby( $taxonomy );

        switch ( $orderby ) {
            case 'name' :
                $get_terms_args['orderby']    = 'name';
                $get_terms_args['menu_order'] = false;
                break;
            case 'id' :
                $get_terms_args['orderby']    = 'id';
                $get_terms_args['order']      = 'ASC';
                $get_terms_args['menu_order'] = false;
                break;
            case 'menu_order' :
                $get_terms_args['menu_order'] = 'ASC';
                break;
        }

        $terms = get_terms( $taxonomy, $get_terms_args );

        if ( 0 < count( $terms ) ) {

            ob_start();

            $title = $instance['title'];

            echo $before_widget;

            if ($title) {
                echo $before_title . $title . $after_title;
            }

            // Force found when option is selected - do not force found on taxonomy attributes
            if ( ! is_tax() && is_array( $_chosen_attributes ) && array_key_exists( $taxonomy, $_chosen_attributes ) ) {
                $found = true;
            }

            if ( 'dropdown' == $display_type ) {

                // skip when viewing the taxonomy
                if ( $current_tax && $taxonomy == $current_tax ) {

                    $found = false;

                } else {

                    $taxonomy_filter = str_replace( 'pa_', '', $taxonomy );

                    $found = false;

                    echo '<select class="chosen dropdown_layered_nav_' . $taxonomy_filter . '">';

                    echo '<option value="">' . sprintf( esc_html__( 'Any %s', 'eclat' ), wc_attribute_label( $taxonomy ) ) . '</option>';

                    foreach ( $terms as $term ) {

                        // If on a term page, skip that term in widget list
                        if ( $term->term_id == $current_term ) {
                            continue;
                        }

                        // Get count based on current view - uses transients
                        $transient_name = 'wc_ln_count_' . md5( sanitize_key( $taxonomy ) . sanitize_key( $term->term_taxonomy_id ) );

                        if ( false === ( $_products_in_term = get_transient( $transient_name ) ) ) {

                            $_products_in_term = get_objects_in_term( $term->term_id, $taxonomy );

                            set_transient( $transient_name, $_products_in_term, DAY_IN_SECONDS * 30 );
                        }

                        $option_is_set = ( isset( $_chosen_attributes[ $taxonomy ] ) && in_array( $term->term_id, $_chosen_attributes[ $taxonomy ]['terms'] ) );

                        // If this is an AND query, only show options with count > 0
                        if ( 'and' == $query_type ) {

                            $count = sizeof( array_intersect( $_products_in_term, WC()->query->filtered_product_ids ) );

                            if ( 0 < $count ) {
                                $found = true;
                            }

                            if ( 0 == $count && ! $option_is_set ) {
                                continue;
                            }

                            // If this is an OR query, show all options so search can be expanded
                        } else {

                            $count = sizeof( array_intersect( $_products_in_term, WC()->query->unfiltered_product_ids ) );

                            if ( 0 < $count ) {
                                $found = true;
                            }

                        }

                        echo '<option value="' . esc_attr( $term->term_id ) . '" ' . selected( isset( $_GET[ 'filter_' . $taxonomy_filter ] ) ? $_GET[ 'filter_' . $taxonomy_filter ] : '' , $term->term_id, false ) . '>' . esc_html( $term->name ) . '</option>';
                    }

                    echo '</select>';

                    wc_enqueue_js( "
						jQuery( '.dropdown_layered_nav_$taxonomy_filter' ).change( function() {
							var term_id = parseInt( jQuery( this ).val(), 10 );
							location.href = '" . str_replace( array( '%\/page/[0-9]+%', '&amp;', '%2C' ), array( '', '&', ',' ), esc_js( add_query_arg( 'filtering', '1', remove_query_arg( array( 'page', 'filter_' . $taxonomy_filter ) ) ) ) ) . "&filter_$taxonomy_filter=' + ( isNaN( term_id ) ? '' : term_id );
						});
					" );

                }

            } elseif( 'color' == $display_type ) {

                // List display
                echo '<ul class="color-filter-list uk-clearfix">';

                foreach ( $terms as $term ) {

                    // Get count based on current view - uses transients
                    $transient_name = 'wc_ln_count_' . md5( sanitize_key( $taxonomy ) . sanitize_key( $term->term_taxonomy_id ) );

                    if ( false === ( $_products_in_term = get_transient( $transient_name ) ) ) {

                        $_products_in_term = get_objects_in_term( $term->term_id, $taxonomy );

                        set_transient( $transient_name, $_products_in_term );
                    }

                    $option_is_set = ( isset( $_chosen_attributes[ $taxonomy ] ) && in_array( $term->term_id, $_chosen_attributes[ $taxonomy ]['terms'] ) );

                    // skip the term for the current archive
                    if ( $current_term == $term->term_id ) {
                        continue;
                    }

                    // If this is an AND query, only show options with count > 0
                    if ( 'and' == $query_type ) {

                        if( isset( WC()->query->filtered_product_ids ) ) {
                            $count = sizeof(array_intersect($_products_in_term, WC()->query->filtered_product_ids));
                        } else if( isset( $term->count ) ) {
                            $count = $term->count;
                        } else {
                            $count = 0;
                        }

                        if ( 0 < $count && $current_term !== $term->term_id ) {
                            $found = true;
                        }

                        if ( 0 == $count && ! $option_is_set ) {
                            continue;
                        }

                        // If this is an OR query, show all options so search can be expanded
                    } else {

                        $count = sizeof( array_intersect( $_products_in_term, WC()->query->unfiltered_product_ids ) );

                        if ( 0 < $count ) {
                            $found = true;
                        }
                    }

                    $arg = 'filter_' . sanitize_title( $instance['attribute'] );

                    $current_filter = ( isset( $_GET[ $arg ] ) ) ? explode( ',', $_GET[ $arg ] ) : array();

                    if ( ! is_array( $current_filter ) ) {
                        $current_filter = array();
                    }

                    $current_filter = array_map( 'esc_attr', $current_filter );

                    if ( ! in_array( $term->term_id, $current_filter ) ) {
                        $current_filter[] = $term->term_id;
                    }

                    // Base Link decided by current page
                    if ( defined( 'SHOP_IS_ON_FRONT' ) ) {
                        $link = esc_url( home_url( '/' ) );
                    } elseif ( is_post_type_archive( 'product' ) || is_page( wc_get_page_id('shop') ) ) {
                        $link = get_post_type_archive_link( 'product' );
                    } else {
                        $link = get_term_link( get_query_var('term'), get_query_var('taxonomy') );
                    }

                    // All current filters
                    if ( $_chosen_attributes ) {
                        foreach ( $_chosen_attributes as $name => $data ) {
                            if ( $name !== $taxonomy ) {

                                // Exclude query arg for current term archive term
                                while ( in_array( $current_term, $data['terms'] ) ) {
                                    $key = array_search( $current_term, $data );
                                    unset( $data['terms'][$key] );
                                }

                                // Remove pa_ and sanitize
                                $filter_name = sanitize_title( str_replace( 'pa_', '', $name ) );

                                if ( ! empty( $data['terms'] ) ) {
                                    $link = add_query_arg( 'filter_' . $filter_name, implode( ',', $data['terms'] ), $link );
                                }

                                if ( 'or' == $data['query_type'] ) {
                                    $link = add_query_arg( 'query_type_' . $filter_name, 'or', $link );
                                }
                            }
                        }
                    }

                    // Min/Max
                    if ( isset( $_GET['min_price'] ) ) {
                        $link = add_query_arg( 'min_price', $_GET['min_price'], $link );
                    }

                    if ( isset( $_GET['max_price'] ) ) {
                        $link = add_query_arg( 'max_price', $_GET['max_price'], $link );
                    }

                    // Orderby
                    if ( isset( $_GET['orderby'] ) ) {
                        $link = add_query_arg( 'orderby', $_GET['orderby'], $link );
                    }

                    // Current Filter = this widget
                    if ( isset( $_chosen_attributes[ $taxonomy ] ) && is_array( $_chosen_attributes[ $taxonomy ]['terms'] ) && in_array( $term->term_id, $_chosen_attributes[ $taxonomy ]['terms'] ) ) {

                        $class = 'class="chosen"';

                        // Remove this term is $current_filter has more than 1 term filtered
                        if ( sizeof( $current_filter ) > 1 ) {
                            $current_filter_without_this = array_diff( $current_filter, array( $term->term_id ) );
                            $link = add_query_arg( $arg, implode( ',', $current_filter_without_this ), $link );
                        }

                    } else {

                        $class = '';
                        $link = add_query_arg( $arg, implode( ',', $current_filter ), $link );

                    }

                    // Search Arg
                    if ( get_search_query() ) {
                        $link = add_query_arg( 's', get_search_query(), $link );
                    }

                    // Post Type Arg
                    if ( isset( $_GET['post_type'] ) ) {
                        $link = add_query_arg( 'post_type', $_GET['post_type'], $link );
                    }

                    // Query type Arg
                    if ( $query_type == 'or' && ! ( sizeof( $current_filter ) == 1 && isset( $_chosen_attributes[ $taxonomy ]['terms'] ) && is_array( $_chosen_attributes[ $taxonomy ]['terms'] ) && in_array( $term->term_id, $_chosen_attributes[ $taxonomy ]['terms'] ) ) ) {
                        $link = add_query_arg( 'query_type_' . sanitize_title( $instance['attribute'] ), 'or', $link );
                    }

                    $color_value = get_woocommerce_term_meta($term->term_id, $term->taxonomy . '_eclat_wccp_value');

                    echo '<li ' . $class . '>';

                    echo ( $count > 0 || $option_is_set ) ? '<a style="background-color:' . $color_value . ';" href="' . esc_url( apply_filters( 'woocommerce_layered_nav_link', $link ) ) . '" data-uk-tooltip title="'.$term->name.' ('.$count.')">' : '<span style="background-color:' . $color_value . ';" data-uk-tooltip title="'.$term->name.' ('.$count.')">';

                    echo ( $count > 0 || $option_is_set ) ? '</a>' : '</span>';

                    //echo ' <span class="count">(' . $count . ')</span></li>';

                }

                echo '</ul>';

            } else {
                // List display
                echo '<ul class="filter-list">';

                foreach ( $terms as $term ) {

                    // Get count based on current view - uses transients
                    $transient_name = 'wc_ln_count_' . md5( sanitize_key( $taxonomy ) . sanitize_key( $term->term_taxonomy_id ) );

                    if ( false === ( $_products_in_term = get_transient( $transient_name ) ) ) {

                        $_products_in_term = get_objects_in_term( $term->term_id, $taxonomy );

                        set_transient( $transient_name, $_products_in_term );
                    }

                    $option_is_set = ( isset( $_chosen_attributes[ $taxonomy ] ) && in_array( $term->term_id, $_chosen_attributes[ $taxonomy ]['terms'] ) );

                    // skip the term for the current archive
                    if ( $current_term == $term->term_id ) {
                        continue;
                    }

                    // If this is an AND query, only show options with count > 0
                    if ( 'and' == $query_type ) {

                        $count = sizeof( array_intersect( $_products_in_term, WC()->query->filtered_product_ids ) );

                        if ( 0 < $count && $current_term !== $term->term_id ) {
                            $found = true;
                        }

                        if ( 0 == $count && ! $option_is_set ) {
                            continue;
                        }

                        // If this is an OR query, show all options so search can be expanded
                    } else {

                        $count = sizeof( array_intersect( $_products_in_term, WC()->query->unfiltered_product_ids ) );

                        if ( 0 < $count ) {
                            $found = true;
                        }
                    }

                    $arg = 'filter_' . sanitize_title( $instance['attribute'] );

                    $current_filter = ( isset( $_GET[ $arg ] ) ) ? explode( ',', $_GET[ $arg ] ) : array();

                    if ( ! is_array( $current_filter ) ) {
                        $current_filter = array();
                    }

                    $current_filter = array_map( 'esc_attr', $current_filter );

                    if ( ! in_array( $term->term_id, $current_filter ) ) {
                        $current_filter[] = $term->term_id;
                    }

                    // Base Link decided by current page
                    if ( defined( 'SHOP_IS_ON_FRONT' ) ) {
                        $link = home_url();
                    } elseif ( is_post_type_archive( 'product' ) || is_page( wc_get_page_id('shop') ) ) {
                        $link = get_post_type_archive_link( 'product' );
                    } else {
                        $link = get_term_link( get_query_var('term'), get_query_var('taxonomy') );
                    }

                    // All current filters
                    if ( $_chosen_attributes ) {
                        foreach ( $_chosen_attributes as $name => $data ) {
                            if ( $name !== $taxonomy ) {

                                // Exclude query arg for current term archive term
                                while ( in_array( $current_term, $data['terms'] ) ) {
                                    $key = array_search( $current_term, $data );
                                    unset( $data['terms'][$key] );
                                }

                                // Remove pa_ and sanitize
                                $filter_name = sanitize_title( str_replace( 'pa_', '', $name ) );

                                if ( ! empty( $data['terms'] ) ) {
                                    $link = add_query_arg( 'filter_' . $filter_name, implode( ',', $data['terms'] ), $link );
                                }

                                if ( 'or' == $data['query_type'] ) {
                                    $link = add_query_arg( 'query_type_' . $filter_name, 'or', $link );
                                }
                            }
                        }
                    }

                    // Min/Max
                    if ( isset( $_GET['min_price'] ) ) {
                        $link = add_query_arg( 'min_price', $_GET['min_price'], $link );
                    }

                    if ( isset( $_GET['max_price'] ) ) {
                        $link = add_query_arg( 'max_price', $_GET['max_price'], $link );
                    }

                    // Orderby
                    if ( isset( $_GET['orderby'] ) ) {
                        $link = add_query_arg( 'orderby', $_GET['orderby'], $link );
                    }

                    // Current Filter = this widget
                    if ( isset( $_chosen_attributes[ $taxonomy ] ) && is_array( $_chosen_attributes[ $taxonomy ]['terms'] ) && in_array( $term->term_id, $_chosen_attributes[ $taxonomy ]['terms'] ) ) {

                        $class = 'class="chosen"';

                        // Remove this term is $current_filter has more than 1 term filtered
                        if ( sizeof( $current_filter ) > 1 ) {
                            $current_filter_without_this = array_diff( $current_filter, array( $term->term_id ) );
                            $link = add_query_arg( $arg, implode( ',', $current_filter_without_this ), $link );
                        }

                    } else {

                        $class = '';
                        $link = add_query_arg( $arg, implode( ',', $current_filter ), $link );

                    }

                    // Search Arg
                    if ( get_search_query() ) {
                        $link = add_query_arg( 's', get_search_query(), $link );
                    }

                    // Post Type Arg
                    if ( isset( $_GET['post_type'] ) ) {
                        $link = add_query_arg( 'post_type', $_GET['post_type'], $link );
                    }

                    // Query type Arg
                    if ( $query_type == 'or' && ! ( sizeof( $current_filter ) == 1 && isset( $_chosen_attributes[ $taxonomy ]['terms'] ) && is_array( $_chosen_attributes[ $taxonomy ]['terms'] ) && in_array( $term->term_id, $_chosen_attributes[ $taxonomy ]['terms'] ) ) ) {
                        $link = add_query_arg( 'query_type_' . sanitize_title( $instance['attribute'] ), 'or', $link );
                    }

                    echo '<li ' . $class . '>';

                    echo ( $count > 0 || $option_is_set ) ? '<a href="' . esc_url( apply_filters( 'woocommerce_layered_nav_link', $link ) ) . '">' : '<span class="param-name">';

                    echo $term->name;

                    echo ( $count > 0 || $option_is_set ) ? '</a>' : '</span>';

                    echo ' <span class="count">(' . $count . ')</span></li>';

                }

                echo '</ul>';
            }

            echo $after_widget;

            if ( !$found ) {
                ob_end_clean();
            } else {
                echo ob_get_clean();
            }
        }

    }

    public function form($instance)
    {
        $attribute_array      = array();
        $attribute_taxonomies = wc_get_attribute_taxonomies();

        if ( $attribute_taxonomies ) {
            foreach ( $attribute_taxonomies as $tax ) {
                if ( taxonomy_exists( wc_attribute_taxonomy_name( $tax->attribute_name ) ) ) {
                    $attribute_array[ $tax->attribute_name ] = $tax->attribute_label;
                }
            }
        }

        $defaults = array(
            'title' => esc_html__( 'Filter by', 'eclat' ),
            'attribute' => '',
            'display_type' => 'list',
            'query_type' => 'and'
        );

        $instance = wp_parse_args((array)$instance, $defaults);

        ?>

        <p>
            <label for="<?php echo $this->get_field_id('title') ?>"><?php esc_html_e('Title:','eclat') ?></label>
            <input type="text" name="<?php echo $this->get_field_name('title') ?>"  value="<?php echo $instance['title'] ?>" class="widefat" id="<?php echo $this->get_field_id('title') ?>">
        </p>

        <p>
            <label
                for="<?php echo $this->get_field_id('attribute'); ?>"><?php esc_html_e('Attribute', 'eclat') ?>:
                <select id="<?php echo $this->get_field_id('attribute'); ?>" name="<?php echo $this->get_field_name('attribute'); ?>">
                    <?php foreach($attribute_array as $val => $label) { ?>
                    <option value="<?php echo $val?>" <?php selected($instance['attribute'], $val) ?>><?php echo $label ?></option>
                    <?php } ?>
                </select>
            </label>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('display_type'); ?>"><?php esc_html_e('Display type', 'eclat') ?>:
                <select id="<?php echo $this->get_field_id('display_type'); ?>"
                        name="<?php echo $this->get_field_name('display_type'); ?>">
                    <!--<option
                        value="list" <?php /*selected($instance['display_type'], 'list') */?>><?php /*_e('List', 'eclat') */?></option>
                    <option
                        value="dropdown" <?php /*selected($instance['display_type'], 'dropdown') */?>><?php /*_e('Dropdown', 'eclat') */?></option>-->
                    <option
                        value="color" <?php selected($instance['display_type'], 'color') ?>><?php esc_html_e('Color', 'eclat') ?></option>
                </select>
            </label>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('query_type'); ?>"><?php esc_html_e('Query type', 'eclat') ?>:
                <select id="<?php echo $this->get_field_id('query_type'); ?>"
                        name="<?php echo $this->get_field_name('query_type'); ?>">
                    <option
                        value="and" <?php selected($instance['query_type'], 'and') ?>><?php esc_html_e('AND', 'eclat') ?></option>
                    <option
                        value="or" <?php selected($instance['query_type'], 'or') ?>><?php esc_html_e('OR', 'eclat') ?></option>
                </select>
            </label>
        </p>

    <?php
    }

    public function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['attribute'] = $new_instance['attribute'];
        $instance['display_type'] = $new_instance['display_type'];
        $instance['query_type'] = $new_instance['query_type'];

        return $instance;
    }
}

register_widget('Warp_Woocommerce_Leyered_Nav');