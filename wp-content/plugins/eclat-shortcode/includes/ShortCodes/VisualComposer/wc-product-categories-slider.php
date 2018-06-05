<?php

// [product_categories_slider]
vc_map(array(
   "name"			=> esc_html__( "Product Categories - Slider", "eclat-shortcodes" ),
   "category"		=> 'WooCommerce',
   "description"	=> esc_html__( "Add a product categories slider", "eclat-shortcodes" ),
   "base"			=> "product_categories_slider",
   "class"			=> "",
   "icon"			=> "product_categories_slider",
   
   "params" 	=> array(
      
       array(
           "type"			=> "textfield",
           "holder"		    => "div",
           "class" 		    => "hide_in_vc_editor",
           "admin_label" 	=> true,
           "heading"		=> esc_html__( "How many product categories to display?", "eclat-shortcodes" ),
           "param_name"	    => "number",
           "value"			=> ""
       ),
		
       array(
           "type"			=> "dropdown",
           "holder"		    => "div",
           "class" 		    => "hide_in_vc_editor",
           "admin_label" 	=> true,
           "heading"		=> esc_html__( "Order By", "eclat-shortcodes" ),
           "param_name"	    => "orderby",
           "value"			=> array(
               esc_html__( "None", "eclat-shortcodes" )			        => "none",
               esc_html__( "Sort by ID", "eclat-shortcodes" )		    => "ID",
               esc_html__( "Sort alphabetically", "eclat-shortcodes" )	=> "name",
               esc_html__( "Sort by most recent", "eclat-shortcodes" )	=> "date",
               esc_html__( "Menu Order", "eclat-shortcodes" )	        => "menu_order",
               esc_html__( "Random", "eclat-shortcodes" )	            => "rand"
           ),
           "std"			=> "date"
       ),
		
       array(
           "type"			=> "dropdown",
           "holder"		    => "div",
           "class" 		    => "hide_in_vc_editor",
           "admin_label" 	=> true,
           "heading"		=> esc_html__( "Sorting", "eclat-shortcodes" ),
           "param_name"	    => "order",
           "value"			=> array(
               esc_html__( "Descending", "eclat-shortcodes" ) => "desc",
               esc_html__( "Crescent", "eclat-shortcodes" )	  => "asc"
           ),
           "std"			=> "desc"
       ),
		
       array(
           "type"			=> "dropdown",
           "holder"		    => "div",
           "class" 		    => "hide_in_vc_editor",
           "admin_label" 	=> true,
           "heading"		=> esc_html__( "Hide Empty", "eclat-shortcodes" ),
           "param_name"	    => "hide_empty",
           "value"			=> array(
               esc_html__( "Yes", "eclat-shortcodes" )	=> "1",
               esc_html__( "No", "eclat-shortcodes" )	=> "0"
           ),
           "std"			=> "1"
       ),
		
       array(
           "type"			=> "textfield",
           "holder"		    => "div",
           "class" 		    => "hide_in_vc_editor",
           "admin_label" 	=> true,
           "heading"		=> esc_html__( "Parent", "eclat-shortcodes" ),
           "description"	=> esc_html__( "Set the parent paramater to 0 to only display top level categories.", "eclat-shortcodes" ),
           "param_name"	    => "parent",
           "value"			=> ""
       ),

       array(
           "type"			=> "textfield",
           "holder"		    => "div",
           "class" 		    => "hide_in_vc_editor",
           "admin_label" 	=> true,
           "heading"		=> esc_html__( "IDs", "eclat-shortcodes" ),
           "description"	=> esc_html__( "Set ids to a comma separated list of category ids to only show those.", "eclat-shortcodes" ),
           "param_name"	    => "ids",
           "value"			=> ""
       ),

       array(
           "type"			=> "dropdown",
           "class" 		=> "hide_in_vc_editor",
           "admin_label" 	=> true,
           "heading"		=>  esc_html__( "How to use the slider?", "eclat-shortcodes" ),
           "param_name"	=> "slider",
           "value"			=> array(
               esc_html__( "Default uikit Slideset", "eclat-shortcodes" ) => "default",
               esc_html__( "Owl Carousel", "eclat-shortcodes" )	          => "owl"
           ),
           "std"			=> "default"
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
           "dependency" 	=> Array(
               "element"   => "slider",
               "value"     => array("default")
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
       ),

       array(
           "type"          => "dropdown",
           "class"         => "hide_in_vc_editor",
           "admin_label"   => true,
           "heading"       => esc_html__( "Animation", "eclat-shortcodes" ),
           "param_name"    => "animation",
           "value" => array(
               esc_html__( "The items fade in and out.", "eclat-shortcodes" ) => "fade",
               esc_html__( "The items scale up and down.", "eclat-shortcodes" ) => "scale",
               esc_html__( "The items slide to and from the top.", "eclat-shortcodes" ) => "slide-top",
               esc_html__( "The items slide to and from the bottom.", "eclat-shortcodes" ) => "slide-bottom",
               esc_html__( "The items slide to the side.", "eclat-shortcodes" ) => "slide-horizontal",
               esc_html__( "The items slide vertically.", "eclat-shortcodes" ) => "slide-vertical"
           ),
           "dependency" 	=> Array(
               "element"   => "slider",
               "value"     => array("default")
           ),
           "description"   => esc_html__( "You can add animations which can be used to display the next set of items.", "eclat-shortcodes" )
       ),

       array(
           "type"          => "dropdown",
           "class"         => "hide_in_vc_editor",
           "admin_label"   => true,
           "heading"       => esc_html__( "Animation", "eclat-shortcodes" ),
           "param_name"    => "animation_owl",
           "value" => array(
               esc_html__( "The items fade in and out.", "eclat-shortcodes" ) => "fade",
               esc_html__( "The items slide to the side.", "eclat-shortcodes" ) => "backSlide",
               esc_html__( "The items slide to and from the top.", "eclat-shortcodes" ) => "goDown",
               esc_html__( "The items scale up and down.", "eclat-shortcodes" ) => "fadeUp",
           ),
           "dependency" 	=> Array(
               "element"   => "slider",
               "value"     => array("owl")
           ),
           "description"   => esc_html__( "You can add animations which can be used to display the next set of items.", "eclat-shortcodes" )
       ),

       array(
           "type"			=> "dropdown",
           "holder"		    => "div",
           "class" 		    => "hide_in_vc_editor",
           "admin_label" 	=> true,
           "heading"		=> esc_html__( "Auto play", "eclat-shortcodes" ),
           "param_name"	    => "autoplay",
           "value"			=> array(
               esc_html__( "No", "eclat-shortcodes" )	=> "false",
               esc_html__( "Yes", "eclat-shortcodes" )	=> "true"
           ),
           "std"			=> "false",
           "description" => esc_html__( "Defines whether or not the items should switch automatically.", "eclat-shortcodes" )
       ),

       array(
           "type"			=> "dropdown",
           "holder"		    => "div",
           "class" 		    => "hide_in_vc_editor",
           "admin_label" 	=> true,
           "heading"		=> esc_html__( "Pause on hover", "eclat-shortcodes" ),
           "param_name"	    => "pause",
           "value"			=> array(
               esc_html__( "Yes", "eclat-shortcodes" )	=> "true",
               esc_html__( "No", "eclat-shortcodes" )	=> "false"
           ),
           "std"			=> "true",
           "dependency" 	=> Array(
               "element"   => "autoplay",
               "value"     => array("true")
           ),
           "description" => esc_html__( "Pause autoplay when hovering.", "eclat-shortcodes" )
       ),

       array(
           "type"			=> "textfield",
           "class" 		=> "hide_in_vc_editor",
           "admin_label" 	=> true,
           "heading"		=> esc_html__( "Autoplay Interval", "eclat-shortcodes" ),
           "param_name"	=> "autoplayinterval",
           "value"			=> "7000",
           "std"			=> "7000",
           "dependency" 	=> Array(
                "element"   => "autoplay",
                "value"     => array("true")
            ),
           "description" => esc_html__( "Defines the timespan between switching items.", "eclat-shortcodes" )
       ),

   )
   
));