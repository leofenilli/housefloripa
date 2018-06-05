<?php

// [google_map]

vc_map(array(
   "name"			=> esc_html__( "Google Map", "eclat-shortcodes" ),
   "category"		=> "Content",
   "description"	=> esc_html__( "Map block", "eclat-shortcodes" ),
   "base"			=> "google_map",
   "class"			=> "",
   "icon"			=> "google_map",

   
   "params" 	=> array(
		
       array(
           "type" 			=> "textfield",
           "heading" 		=> esc_html__( "Latitude", "eclat-shortcodes" ),
           "param_name" 	=> "lat",
           "value" 		=> "51.51526"
       ),

       array(
           "type" 			=> "textfield",
           "heading" 		=> esc_html__( "Longitude", "eclat-shortcodes" ),
           "param_name" 	=> "long",
           "value" 		=> "-0.13218"
       ),

       array(
           "type" 			=> "textfield",
           "heading" 		=> esc_html__( "Height", "eclat-shortcodes" ),
           "param_name" 	=> "height",
           "value" 		=> "400px"
       ),

       array(
           "type" 			=> "textfield",
           "heading" 		=> esc_html__( "Zoom Level", "eclat-shortcodes" ),
           "param_name" 	=> "zoom",
           "value" 		=> "17"
       ),

       array(
           "type"			=> "dropdown",
           "heading"		=> esc_html__( "Get Directions Button", "eclat-shortcodes" ),
           "param_name"	    => "get_directions_button",
           "value"			=> array(
               esc_html__( "Enabled", "eclat-shortcodes" )	=> "enabled",
               esc_html__( "Disabled", "eclat-shortcodes" )	=> "disabled"
           ),
           "std"			=> "enabled",
       ),

       array(
           "type" 			=> "textfield",
           "heading" 		=> esc_html__( "Button Text", "eclat-shortcodes" ),
           "param_name" 	=> "button_text",
           "value" 		    => "Get Directions",
           "dependency" 	=> Array('element' => "get_directions_button", 'value' => array('enabled'))
       ),

       array(
           "type"			=> "attach_image",
           "heading"		=> esc_html__("Marker Image", "eclat-shortcodes"),
           "param_name"	    => "marker",
           "value"			=> "",
           "description"    => esc_html__( "Please upload small image (40x60px)", "eclat-shortcodes")
       ),

       array(
           "type"			=> "dropdown",
           "heading"		=> esc_html__( "Control Elements", "eclat-shortcodes" ),
           "param_name"	    => "control_elements",
           "value"			=> array(
               esc_html__( "Enabled", "eclat-shortcodes" )	=> "enabled",
               esc_html__( "Disabled", "eclat-shortcodes" )	=> "disabled"
           ),
           "std"			=> "enabled",
       ),

       array(
           "type"			=> "dropdown",
           "heading"		=> esc_html__( "Do you want to change the map style?", "eclat-shortcodes" ),
           "param_name"	    => "use_my_style",
           "value"			=> array(
               esc_html__( "Yes", "eclat-shortcodes" )	=> "yes",
               esc_html__( "No", "eclat-shortcodes" )	=> "no"
           ),
           "std"			=> "yes",
       ),

       array(
           "type"			=> "colorpicker",
           "heading"		=> esc_html__( "Landscape Color", "eclat-shortcodes" ),
           "param_name"	    => "landscape",
           "value"			=> "#e9e9e9",
           "dependency" 	=> array(
               'element'   => "use_my_style",
               'value'     => array('yes')
           )
       ),

       array(
           "type"			=> "colorpicker",
           "heading"		=> esc_html__( "Water Color", "eclat-shortcodes" ),
           "param_name"	    => "water",
           "value"			=> "#f5f5f5",
           "dependency" 	=> array(
               'element'   => "use_my_style",
               'value'     => array('yes')
           )
       ),

       array(
           "type"			=> "colorpicker",
           "heading"		=> esc_html__( "Road Highway Color", "eclat-shortcodes" ),
           "param_name"	    => "road_highway",
           "value"			=> "#ffffff",
           "dependency" 	=> array(
               'element'   => "use_my_style",
               'value'     => array('yes')
           )
       ),

       array(
           "type"			=> "colorpicker",
           "heading"		=> esc_html__( "Road Arterial Color", "eclat-shortcodes" ),
           "param_name"	    => "road_arterial",
           "value"			=> "#ffffff",
           "dependency" 	=> array(
               'element'   => "use_my_style",
               'value'     => array('yes')
           )
       ),

       array(
           "type"			=> "colorpicker",
           "heading"		=> esc_html__( "Road Local Color", "eclat-shortcodes" ),
           "param_name"	    => "road_local",
           "value"			=> "#ffffff",
           "dependency" 	=> array(
               'element'   => "use_my_style",
               'value'     => array('yes')
           )
       ),

       array(
           "type"			=> "colorpicker",
           "heading"		=> esc_html__( "Points of Interes Color", "eclat-shortcodes" ),
           "param_name"	    => "poi",
           "value"			=> "#f5f5f5",
           "dependency" 	=> array(
               'element'   => "use_my_style",
               'value'     => array('yes')
           )
       ),

   )
   
));