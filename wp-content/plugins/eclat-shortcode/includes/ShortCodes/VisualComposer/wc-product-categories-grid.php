<?php

// [product_categories_grid]
vc_map(array(
   "name"			=> esc_html__( "Product Categories - Grid", "eclat-shortcodes" ),
   "category"		=> 'WooCommerce',
   "description"	=> esc_html__( "Add a product categories masonry grid", "eclat-shortcodes" ),
   "base"			=> "product_categories_grid",
   "class"			=> "",
   "icon"			=> "product_categories_grid",
   
   "params" 	=> array(

       array(
           "type"			=> "textfield",
           "admin_label" 	=> true,
           "heading"		=> esc_html__( "How many product categories to display?", "eclat-shortcodes" ),
           "param_name"	    => "number",
           "value"			=> ""
       ),

       array(
           "type"			=> "dropdown",
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
           "heading"		=> esc_html__( "Parent", "eclat-shortcodes" ),
           "description"	=> esc_html__( "Set the parent paramater to 0 to only display top level categories.", "eclat-shortcodes" ),
           "param_name"	    => "parent",
           "value"			=> ""
       ),

       array(
           "type"			=> "textfield",
           "heading"		=> esc_html__( "IDs", "eclat-shortcodes" ),
           "description"	=> esc_html__( "Set ids to a comma separated list of category ids to only show those.", "eclat-shortcodes" ),
           "param_name"	    => "ids",
           "value"			=> ""
       ),

       array(
           "type"          => "textfield",
           "heading"       => esc_html__( "Gutter", "eclat-shortcodes" ),
           "param_name"    => "gutter",
           "value"         => "20",
           "description"   => esc_html__( "Gutter between columns.", "eclat-shortcodes" )
       )
   )
   
));