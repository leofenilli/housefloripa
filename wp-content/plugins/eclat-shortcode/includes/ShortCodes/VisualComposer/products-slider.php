<?php

// [products_slider]
vc_map(array(
    "name"			=> esc_html__( "Products Slider", "eclat-shortcodes" ),
    "category"		=> 'WooCommerce',
    "description"	=> esc_html__( "Add a products slider", "eclat-shortcodes" ),
    "base"			=> "products_slider",
    "class"			=> "",
    "icon"			=> "icon-wpb-woocommerce",


    "params" 	=> array(

        //best_selling_products
        array(
            "type"			=> "dropdown",
            "class" 		=> "hide_in_vc_editor",
            "admin_label" 	=> true,
            "heading"		=> esc_html__( "Show Best Selling Products", "eclat-shortcodes" ),
            "param_name"	=> "best_selling_products",
            "value"			=> array(
                esc_html__( "Yes", "eclat-shortcodes" )	=> "yes",
                esc_html__( "No", "eclat-shortcodes" )	=> "no"
            ),
            "std"			=> "yes"
        ),

        array(
            "type"			=> "textfield",
            "class" 		=> "hide_in_vc_editor",
            "admin_label" 	=> true,
            "heading"		=> esc_html__( "Title tab", "eclat-shortcodes" ),
            "param_name"	=> "best_selling_products_title",
            "value"			=> "",
            "dependency" 	=> Array(
                "element"   => "best_selling_products",
                "value"     => array("yes")
            )
        ),

        array(
            "type"			=> "textfield",
            "class" 		=> "hide_in_vc_editor",
            "admin_label" 	=> true,
            "heading"		=> esc_html__( "Items", "eclat-shortcodes" ),
            "param_name"	=> "best_selling_products_items",
            "value"			=> "10",
            "std"			=> "10",
            "dependency" 	=> Array(
                "element"   => "best_selling_products",
                "value"     => array("yes")
            )
        ),

        //recent_products
        array(
            "type"			=> "dropdown",
            "class" 		=> "hide_in_vc_editor",
            "admin_label" 	=> true,
            "heading"		=>  esc_html__( "Show Recent products", "eclat-shortcodes" ),
            "param_name"	=> "recent_products",
            "value"			=> array(
                esc_html__( "Yes", "eclat-shortcodes" )	=> "yes",
                esc_html__( "No", "eclat-shortcodes" )	=> "no"
            ),
            "std"			=> "yes",
        ),

        array(
            "type"			=> "textfield",
            "class" 		=> "hide_in_vc_editor",
            "admin_label" 	=> true,
            "heading"		=> esc_html__( "Title tab", "eclat-shortcodes" ),
            "param_name"	=> "recent_products_title",
            "value"			=> "",
            "dependency" 	=> array(
                "element"   => "recent_products",
                "value"     => array("yes")
            )
        ),

        array(
            "type"			=> "textfield",
            "class" 		=> "hide_in_vc_editor",
            "admin_label" 	=> true,
            "heading"		=> esc_html__( "Items", "eclat-shortcodes" ),
            "param_name"	=> "recent_products_items",
            "value"			=> "10",
            "std"			=> "10",
            "dependency" 	=> array(
                "element"   => "recent_products",
                "value"     => array("yes")
            )
        ),

        array(
            "type"			=> "dropdown",
            "class" 		=> "hide_in_vc_editor",
            "admin_label" 	=> true,
            "heading"		=> esc_html__( "Order by", "eclat-shortcodes" ),
            "param_name"	=> "recent_products_orderby",
            "value"			=> apply_filters( "woocommerce_catalog_orderby", array(
                esc_html__( "Random", "eclat-shortcodes" )              => "rand",
                esc_html__( "Sort alphabetically", "eclat-shortcodes" )	=> "title",
                esc_html__( "Sort by most recent", "eclat-shortcodes" ) => "date"
            ) ),
            "std"           => "date",
            "dependency" 	=> array(
                "element"   => "recent_products",
                "value"     => array("yes")
            )
        ),

        array(
            "type"			=> "dropdown",
            "class" 		=> "hide_in_vc_editor",
            "admin_label" 	=> true,
            "heading"		=> esc_html__( "Sorting", "eclat-shortcodes" ),
            "param_name"	=> "recent_products_order",
            "value"			=> array(
                esc_html__( "Descending", "eclat-shortcodes" )  => "desc",
                esc_html__( "Crescent", "eclat-shortcodes" )	=> "asc"
            ),
            "std"           => "desc",
            "dependency" 	=> array(
                "element"   => "recent_products",
                "value"     => array("yes")
            )
        ),

        //top_rated_products
        array(
            "type"			=> "dropdown",
            "class" 		=> "hide_in_vc_editor",
            "admin_label" 	=> true,
            "heading"		=> esc_html__( "Show Top Rated Products", "eclat-shortcodes" ),
            "param_name"	=> "top_rated_products",
            "value"			=> array(
                esc_html__( "Yes", "eclat-shortcodes" )	=> "yes",
                esc_html__( "No", "eclat-shortcodes" )	=> "no"
            ),
            "std"			=> "yes"
        ),

        array(
            "type"			=> "textfield",
            "class" 		=> "hide_in_vc_editor",
            "admin_label" 	=> true,
            "heading"		=> esc_html__( "Title tab", "eclat-shortcodes" ),
            "param_name"	=> "top_rated_products_title",
            "value"			=> "",
            "dependency" 	=> array(
                "element"   => "top_rated_products",
                "value"     => array("yes")
            )
        ),

        array(
            "type"			=> "textfield",
            "class" 		=> "hide_in_vc_editor",
            "admin_label" 	=> true,
            "heading"		=> esc_html__( "Items", "eclat-shortcodes" ),
            "param_name"	=> "top_rated_products_items",
            "value"			=> "10",
            "std"			=> "10",
            "dependency" 	=> array(
                "element"   => "top_rated_products",
                "value"     => array("yes")
            )
        ),

        array(
            "type"			=> "dropdown",
            "class" 		=> "hide_in_vc_editor",
            "admin_label" 	=> true,
            "heading"		=> esc_html__( "Order by", "eclat-shortcodes" ),
            "param_name"	=> "top_rated_products_orderby",
            "value"			=> apply_filters( "woocommerce_catalog_orderby", array(
                esc_html__( "Random", "eclat-shortcodes" )              => "rand",
                esc_html__( "Sort alphabetically", "eclat-shortcodes" )	=> "title",
                esc_html__( "Sort by most recent", "eclat-shortcodes" ) => "date"
            ) ),
            "std"           => "title",
            "dependency" 	=> array(
                "element"   => "top_rated_products",
                "value"     => array("yes")
            )
        ),

        array(
            "type"			=> "dropdown",
            "class" 		=> "hide_in_vc_editor",
            "admin_label" 	=> true,
            "heading"		=> esc_html__( "Sorting", "eclat-shortcodes" ),
            "param_name"	=> "top_rated_products_order",
            "value"			=> array(
                esc_html__( "Descending", "eclat-shortcodes" )  => "desc",
                esc_html__( "Crescent", "eclat-shortcodes" )	=> "asc"
            ),
            "std"           => "desc",
            "dependency" 	=> array(
                "element"   => "top_rated_products",
                "value"     => array("yes")
            )
        ),

        //sale_products
        array(
            "type"			=> "dropdown",
            "class" 		=> "hide_in_vc_editor",
            "admin_label" 	=> true,
            "heading"		=> esc_html__( "Show Sale Products", "eclat-shortcodes" ),
            "param_name"	=> "sale_products",
            "value"			=> array(
                esc_html__( "Yes", "eclat-shortcodes" )	=> "yes",
                esc_html__( "No", "eclat-shortcodes" )	=> "no"
            ),
            "std"			=> "yes"
        ),

        array(
            "type"			=> "textfield",
            "class" 		=> "hide_in_vc_editor",
            "admin_label" 	=> true,
            "heading"		=> esc_html__( "Title tab", "eclat-shortcodes" ),
            "param_name"	=> "sale_products_title",
            "value"			=> "",
            "dependency" 	=> array(
                "element"   => "sale_products",
                "value"     => array("yes")
            )
        ),

        array(
            "type"			=> "textfield",
            "class" 		=> "hide_in_vc_editor",
            "admin_label" 	=> true,
            "heading"		=> esc_html__( "Items", "eclat-shortcodes" ),
            "param_name"	=> "sale_products_items",
            "value"			=> "10",
            "std"			=> "10",
            "dependency" 	=> array(
                "element"   => "sale_products",
                "value"     => array("yes")
            )
        ),

        array(
            "type"			=> "dropdown",
            "class" 		=> "hide_in_vc_editor",
            "admin_label" 	=> true,
            "heading"		=> esc_html__( "Order by", "eclat-shortcodes" ),
            "param_name"	=> "sale_products_orderby",
            "value"			=> apply_filters( "woocommerce_catalog_orderby", array(
                esc_html__( "Random", "eclat-shortcodes" )              => "rand",
                esc_html__( "Sort alphabetically", "eclat-shortcodes" )	=> "title",
                esc_html__( "Sort by most recent", "eclat-shortcodes" ) => "date"
            ) ),
            "std"           => "title",
            "dependency" 	=> array(
                "element"   => "sale_products",
                "value"     => array("yes")
            )
        ),

        array(
            "type"			=> "dropdown",
            "class" 		=> "hide_in_vc_editor",
            "admin_label" 	=> true,
            "heading"		=> esc_html__( "Sorting", "eclat-shortcodes" ),
            "param_name"	=> "sale_products_order",
            "value"			=> array(
                esc_html__( "Descending", "eclat-shortcodes" )  => "desc",
                esc_html__( "Crescent", "eclat-shortcodes" )	=> "asc"
            ),
            "std"           => "desc",
            "dependency" 	=> array(
                "element"   => "sale_products",
                "value"     => array("yes")
            )
        ),

        //featured_products
        array(
            "type"			=> "dropdown",
            "class" 		=> "hide_in_vc_editor",
            "admin_label" 	=> true,
            "heading"		=> esc_html__( "Show Featured Products", "eclat-shortcodes" ),
            "param_name"	=> "featured_products",
            "value"			=> array(
                esc_html__( "Yes", "eclat-shortcodes" )	=> "yes",
                esc_html__( "No", "eclat-shortcodes" )	=> "no"
            ),
            "std"			=> "yes"
        ),

        array(
            "type"			=> "textfield",
            "class" 		=> "hide_in_vc_editor",
            "admin_label" 	=> true,
            "heading"		=> esc_html__( "Title tab", "eclat-shortcodes" ),
            "param_name"	=> "featured_products_title",
            "value"			=> "",
            "dependency" 	=> array(
                "element"   => "featured_products",
                "value"     => array("yes")
            )
        ),

        array(
            "type"			=> "textfield",
            "class" 		=> "hide_in_vc_editor",
            "admin_label" 	=> true,
            "heading"		=> esc_html__( "Items", "eclat-shortcodes" ),
            "param_name"	=> "featured_products_items",
            "value"			=> "10",
            "std"			=> "10",
            "dependency" 	=> array(
                "element"   => "featured_products",
                "value"     => array("yes")
            )
        ),

        array(
            "type"			=> "dropdown",
            "class" 		=> "hide_in_vc_editor",
            "admin_label" 	=> true,
            "heading"		=> esc_html__( "Order by", "eclat-shortcodes" ),
            "param_name"	=> "featured_products_orderby",
            "value"			=> apply_filters( "woocommerce_catalog_orderby", array(
                esc_html__( "Random", "eclat-shortcodes" )              => "rand",
                esc_html__( "Sort alphabetically", "eclat-shortcodes" )	=> "title",
                esc_html__( "Sort by most recent", "eclat-shortcodes" ) => "date"
            ) ),
            "std"           => "date",
            "dependency" 	=> array(
                "element"   => "featured_products",
                "value"     => array("yes")
            )
        ),

        array(
            "type"			=> "dropdown",
            "class" 		=> "hide_in_vc_editor",
            "admin_label" 	=> true,
            "heading"		=> esc_html__( "Sorting", "eclat-shortcodes" ),
            "param_name"	=> "featured_products_order",
            "value"			=> array(
                esc_html__( "Descending", "eclat-shortcodes" )  => "desc",
                esc_html__( "Crescent", "eclat-shortcodes" )	=> "asc"
            ),
            "std"           => "desc",
            "dependency" 	=> array(
                "element"   => "featured_products",
                "value"     => array("yes")
            )
        )

    )

));
?>