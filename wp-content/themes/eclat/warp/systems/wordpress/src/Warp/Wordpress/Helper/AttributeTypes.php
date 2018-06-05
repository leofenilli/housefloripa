<?php
/**
 * @package   Warp Theme Framework
 * @author    Elartica Team http://www.elartica.com
 * @copyright Copyright (C) Elartica Team
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

//new attribute types
add_action('woocommerce_admin_attribute_types', 'eclat_attribute_types');

//product attribute taxonomies
add_action('init', 'eclat_attribute_taxonomies');

//print attribute field type
add_action('eclat_wccp_print_attribute_field', 'eclat_print_attribute_type', 10, 3);

//save new term
add_action('created_term', 'eclat_attribute_save', 10, 3);
add_action('edit_term', 'eclat_attribute_save', 10, 3);

//choose variations in product page
add_action('woocommerce_product_option_terms', 'eclat_product_option_terms', 10, 2);

//enqueue static content
add_action('admin_enqueue_scripts', 'eclat_at_enqueue');

if( !function_exists( 'eclat_at_enqueue' ) )
{
    /**
     * Enqueue static content
     */
    function eclat_at_enqueue()
    {
        wp_enqueue_style( 'wp-color-picker');
        wp_enqueue_script( 'wp-color-picker');
    }
}

if( !function_exists( 'eclat_attribute_types' ) )
{
    /**
     * New attribute types
     */
    function eclat_attribute_types()
    {
        global $wpdb;

        $edit = absint($_GET['edit']);
        $attribute_to_edit = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM " . $wpdb->prefix . "woocommerce_attribute_taxonomies WHERE attribute_id = '%s'", $edit) );
        $att_type = $attribute_to_edit->attribute_type;
        ?>

        <option value="colorpicker" <?php selected($att_type, 'colorpicker'); ?>><?php esc_html_e('Colorpicker', 'eclat') ?></option>

    <?php
    }
}

if( !function_exists( 'eclat_attribute_taxonomies' ) )
{
    /**
     * Init product attribute taxonomies
     */
    function eclat_attribute_taxonomies()
    {
        if ($attribute_taxonomies = wc_get_attribute_taxonomies())
        {
            foreach ($attribute_taxonomies as $tax)
            {
                add_action('pa_' . $tax->attribute_name . '_add_form_fields', 'eclat_add_attribute_field');
                add_action('pa_' . $tax->attribute_name . '_edit_form_fields', 'eclat_edit_attribute_field', 10, 2);

                add_filter('manage_edit-pa_' . $tax->attribute_name . '_columns', 'eclat_product_attribute_columns');
                add_filter('manage_pa_' . $tax->attribute_name . '_custom_column', 'eclat_product_attribute_column', 10, 3);
            }
        }
    }
}

if( !function_exists( 'eclat_add_attribute_field' ) )
{
    /**
     * Add field for each product attribute taxonomy
     *
     * @param string $taxonomy.
     */
    function eclat_add_attribute_field( $taxonomy )
    {
        global $wpdb;

        $attribute = substr($taxonomy, 3);
        $attribute = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM " . $wpdb->prefix . "woocommerce_attribute_taxonomies WHERE attribute_name = '%s'", $attribute ) );

        do_action('eclat_wccp_print_attribute_field', $attribute);
    }
}

if( !function_exists( 'eclat_edit_attribute_field' ) )
{
    /**
     * Edit field for each product attribute taxonomy
     *
     * @param string $taxonomy.
     * @param object $term.
     */
    function eclat_edit_attribute_field( $term, $taxonomy )
    {
        global $wpdb;

        $attribute = substr($taxonomy, 3);
        $attribute = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM " . $wpdb->prefix . "woocommerce_attribute_taxonomies WHERE attribute_name = '%s'", $attribute ) );

        $value = get_woocommerce_term_meta($term->term_id, $taxonomy . '_eclat_wccp_value');

        do_action('eclat_wccp_print_attribute_field', $attribute, true, $value);
    }
}

if( !function_exists( 'eclat_print_attribute_type' ) )
{
    /**
     * Print Color Picker
     *
     * @param string $attribute.
     * @param bool $table.
     * @param string $value.
     */
    function eclat_print_attribute_type( $attribute, $table = false, $value = '' )
    {
        $type = $attribute->attribute_type;
        //$label = $type == 'colorpicker' ? 'Color' : 'Label';

        ?>

        <?php if( $table ) { ?>
        <tr class="form-field">
            <th scope="row" valign="top"><label for="term-value"><?php $type == 'colorpicker' ? esc_html_e( 'Color', 'eclat' ) : esc_html_e( 'Label', 'eclat' ); ?></label></th>
            <td>
        <?php } else { ?>
        <div class="form-field">
            <label for="term-value"><?php $type == 'colorpicker' ? esc_html_e( 'Color', 'eclat' ) : esc_html_e( 'Label', 'eclat' ); ?></label>
        <?php } ?>

        <input type="text" name="term-value" id="term-value"<?php echo $type == 'colorpicker' ? ' class="eclat_cp_section_color"' : ''; ?> value="<?php echo $value ? $value : ""; ?>" data-type="<?php echo $type ?>" />

        <script type="text/javascript">
            jQuery(document).ready(function($) {
                $('.eclat_cp_section_color').wpColorPicker();
            });
        </script>

        <?php if( $table ) { ?>
            </td>
        </tr>
        <?php } else { ?>
        </div>
        <?php }
    }
}

if( !function_exists( 'eclat_attribute_save' ) )
{
    /**
     * Save attribute field
     *
     * @param string $taxonomy.
     * @param int $term_id.
     */
    function eclat_attribute_save( $term_id, $tt_id, $taxonomy )
    {
        if (isset($_POST['term-value'])) {
            update_woocommerce_term_meta($term_id, $taxonomy . '_eclat_wccp_value', $_POST['term-value']);
        }
    }
}

if( !function_exists( 'eclat_product_attribute_columns' ) )
{
    /**
     * Create new column for product attributes
     *
     * @param array $columns.
     * @return array
     */
    function eclat_product_attribute_columns( $columns )
    {
        $temp_cols = array();
        $temp_cols['cb'] = $columns['cb'];
        $temp_cols['eclat_wccp_value'] = esc_html__('Value', 'eclat');
        unset($columns['cb']);
        $columns = array_merge($temp_cols, $columns);
        return $columns;
    }
}

if( !function_exists( 'eclat_product_attribute_column' ) )
{
    /**
     * Print the column content
     *
     * @param string $columns.
     * @param string $column.
     * @param int $id.
     * @return string
     */
    function eclat_product_attribute_column( $columns, $column, $id )
    {
        global $taxonomy, $wpdb;

        if ($column == 'eclat_wccp_value')
        {
            $attribute = substr($taxonomy, 3);
            $attribute = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM " . $wpdb->prefix . "woocommerce_attribute_taxonomies WHERE attribute_name = '%s'", $attribute ) );
            $att_type 	= $attribute->attribute_type;

            $value = get_woocommerce_term_meta($id, $taxonomy . '_eclat_wccp_value');

            switch ($att_type){
                case 'colorpicker':
                    $columns .= '<span class="eclat-wccp-color" style="width: 30px; height: 30px; border-radius: 2px; display: block; background-color:'. $value .'"></span>';
                    break;
            }
        }

        return $columns;
    }
}

if( !function_exists( 'eclat_product_option_terms' ) )
{
    /**
     * Print select for product variations
     *
     * @param object $tax.
     * @param int $i.
     * @return string
     */
    function eclat_product_option_terms( $tax, $i )
    {
        global $woocommerce, $thepostid;

        if( in_array( $tax->attribute_type, array( 'colorpicker' ) ) ) {

            if ( function_exists('wc_attribute_taxonomy_name') ) {
                $attribute_taxonomy_name = wc_attribute_taxonomy_name( $tax->attribute_name );
            } else {
                $attribute_taxonomy_name = $woocommerce->attribute_taxonomy_name( $tax->attribute_name );
            }

            ?>
            <select multiple="multiple" data-placeholder="<?php esc_html_e( 'Select terms', 'eclat' ); ?>" class="multiselect attribute_values wc-enhanced-select" name="attribute_values[<?php echo $i; ?>][]">
                <?php
                $all_terms = get_terms( $attribute_taxonomy_name, 'orderby=name&hide_empty=0' );
                if ( $all_terms ) {
                    foreach ( $all_terms as $term ) {
                        /*$has_term = has_term( (int) $term->term_id, $attribute_taxonomy_name, $thepostid ) ? 1 : 0;
                        echo '<option value="' . esc_attr( $term->slug ) . '" ' . selected( $has_term, 1, false ) . '>' . $term->name . '</option>';*/
                        echo '<option value="' . esc_attr( $term->slug ) . '" ' . selected( has_term( absint( $term->term_id ), $attribute_taxonomy_name, $thepostid ), true, false ) . '>' . $term->name . '</option>';
                    }
                }
                ?>
            </select>
            <button class="button plus select_all_attributes"><?php esc_html_e( 'Select all', 'eclat' ); ?></button>
            <button class="button minus select_no_attributes"><?php esc_html_e( 'Select none', 'eclat' ); ?></button>
            <button class="button fr plus add_new_attribute" data-attribute="<?php echo $attribute_taxonomy_name; ?>"><?php esc_html_e( 'Add new', 'eclat' ); ?></button>
        <?php
        }
    }
}

?>