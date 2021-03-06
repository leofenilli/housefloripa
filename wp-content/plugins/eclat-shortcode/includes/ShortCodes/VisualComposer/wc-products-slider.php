<?php


// [top_rated_products_slider]
vc_map(array(
    "name"			=> esc_html__( "Products Slider by Category", "eclat-shortcodes" ),
    "category"		=> 'WooCommerce',
    "description"	=> esc_html__( "Add a products slider", "eclat-shortcodes" ),
    "base"			=> "products_slider",
    "class"			=> "",
    "icon"			=> "products_slider",


    "params" 	=> array(

        //top_rated_products
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
            "heading"		=> esc_html__( "Order by", "eclat-shortcodes" ),
            "param_name"	=> "orderby",
            "value"			=> apply_filters( "woocommerce_catalog_orderby", array(
                esc_html__( "Random", "eclat-shortcodes" )              => "rand",
                esc_html__( "Sort alphabetically", "eclat-shortcodes" )	=> "title",
                esc_html__( "Sort by most recent", "eclat-shortcodes" ) => "date"
            ) ),
            "std"           => "title"
        ),

        array(
            "type"			=> "dropdown",
            "class" 		=> "hide_in_vc_editor",
            "admin_label" 	=> true,
            "heading"		=> esc_html__( "Type", "eclat-shortcodes" ),
            "param_name"	=> "serie_type",
            "value"			=> eclat_get_types(),
            "std"           => ""
        ),

        array(
            "type"			=> "dropdown",
            "class" 		=> "hide_in_vc_editor",
            "admin_label" 	=> true,
            "heading"		=> esc_html__( "Categories", "eclat-shortcodes" ),
            "param_name"	=> "categories",
            "value"			=> eclat_get_categories(),
            "std"           => ""
        ),

        array(
            "type"			=> "dropdown",
            "class" 		=> "hide_in_vc_editor",
            "admin_label" 	=> true,
            "heading"		=> esc_html__( "Sorting", "eclat-shortcodes" ),
            "param_name"	=> "order",
            "value"			=> array(
                esc_html__( "Descending", "eclat-shortcodes" )  => "desc",
                esc_html__( "Crescent", "eclat-shortcodes" )	=> "asc"
            ),
            "std"           => "desc"
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