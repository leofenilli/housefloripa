<?php

// [best_selling_products_slider]
vc_map(array(
    "name"			=> esc_html__( "Best Selling Products Slider", "eclat-shortcodes" ),
    "category"		=> 'WooCommerce',
    "description"	=> esc_html__( "Add a best selling products slider", "eclat-shortcodes" ),
    "base"			=> "best_selling_products_slider",
    "class"			=> "",
    "icon"			=> "best_selling_products_slider",


    "params" 	=> array(

        array(
            "type"			=> "textfield",
            "class" 		=> "hide_in_vc_editor",
            "admin_label" 	=> true,
            "heading"		=> esc_html__( "Items", "eclat-shortcodes" ),
            "param_name"	=> "items",
            "value"			=> "10",
            "std"			=> "10"
        ),

        array(
            "type"			=> "dropdown",
            "class" 		=> "hide_in_vc_editor",
            "admin_label" 	=> true,
            "heading"		=>  esc_html__( "Products Grid", "eclat-shortcodes" ),
            "param_name"	=> "grid",
            "value"			=> array(
                esc_html__( "No", "eclat-shortcodes" )	    => "no",
                esc_html__( "Normal", "eclat-shortcodes" )	=> "uk-grid",
                esc_html__( "Medium", "eclat-shortcodes" )	=> "uk-grid uk-grid-medium",
                esc_html__( "Small", "eclat-shortcodes" )	=> "uk-grid uk-grid-small"
            ),
            "std"			=> "uk-grid uk-grid-medium"
        ),

        array(
            "type"			=> "textfield",
            "class" 		=> "hide_in_vc_editor",
            "admin_label" 	=> true,
            "heading"		=> esc_html__( "Items in row - large", "eclat-shortcodes" ),
            "param_name"	=> "row_large_items",
            "value"			=> "4",
            "std"			=> "4"
        ),

        array(
            "type"			=> "textfield",
            "class" 		=> "hide_in_vc_editor",
            "admin_label" 	=> true,
            "heading"		=> esc_html__( "Items in row - medium", "eclat-shortcodes" ),
            "param_name"	=> "row_medium_items",
            "value"			=> "3",
            "std"			=> "3"
        ),

        array(
            "type"			=> "textfield",
            "class" 		=> "hide_in_vc_editor",
            "admin_label" 	=> true,
            "heading"		=> esc_html__( "Items in row - small", "eclat-shortcodes" ),
            "param_name"	=> "row_small_items",
            "value"			=> "2",
            "std"			=> "2"
        ),

        array(
            "type"			=> "textfield",
            "class" 		=> "hide_in_vc_editor",
            "admin_label" 	=> true,
            "heading"		=> esc_html__( "Items in row - phone", "eclat-shortcodes" ),
            "param_name"	=> "row_items",
            "value"			=> "1",
            "std"			=> "1"
        )

    )

));
?>