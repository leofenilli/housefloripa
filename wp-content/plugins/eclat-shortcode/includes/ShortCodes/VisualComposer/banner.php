<?php

// [banner]
vc_map(array(
   "name"			=> esc_html__("Banner", "eclat-shortcodes"),
   "category"		=> "Content",
   "description"	=> esc_html__("Add Banner", "eclat-shortcodes"),
   "base"			=> "banner",
   "class"			=> "",
   "icon"			=> "banner",

   
   "params" 	=> array(
      
       array(
           "type"			=> "textfield",
           "holder"		=> "div",
           "class" 		=> "hide_in_vc_editor",
           "admin_label" 	=> true,
           "heading"		=> esc_html__("Title", "eclat-shortcodes"),
           "param_name"	=> "title",
           "value"			=> ""
       ),

       array(
           "type"			=> "dropdown",
           "class" 		    => "hide_in_vc_editor",
           "admin_label" 	=> true,
           "heading"		=> esc_html__( "Title Position", "eclat-shortcodes" ),
           "param_name" 	=> "title_pos",
           "value"			=> array(
               esc_html__( "Top", "eclat-shortcodes" ) 	 => "top",
               esc_html__( "Top Left", "eclat-shortcodes" ) 	 => "top-left",
               esc_html__( "Top Right", "eclat-shortcodes" ) 	 => "top-right",
               esc_html__( "Bottom", "eclat-shortcodes" ) => "bottom",
               esc_html__( "Bottom Left", "eclat-shortcodes" ) => "bottom-left",
               esc_html__( "Bottom Right", "eclat-shortcodes" ) => "bottom-right"
           ),
           "std"			=> "with_separator"
       ),

       array(
           "type"			=> "colorpicker",
           "holder"		    => "div",
           "class" 		    => "hide_in_vc_editor",
           "admin_label" 	=> true,
           "heading"		=> esc_html__("Title Background", "eclat-shortcodes"),
           "param_name"	    => "title_bg",
           "value"			=> "#f0f0f0"
       ),

       array(
           "type"			=> "textfield",
           "holder"		=> "div",
           "class" 		=> "hide_in_vc_editor",
           "admin_label" 	=> true,
           "heading"		=> esc_html__("URL", "eclat-shortcodes"),
           "param_name"	=> "link_url",
           "value"			=> ""
       ),

       array(
          "type"			=> "colorpicker",
          "holder"		    => "div",
          "class" 		    => "hide_in_vc_editor",
          "admin_label" 	=> true,
          "heading"		=> esc_html__("Background Color", "eclat-shortcodes"),
          "param_name"	    => "bg_color",
          "value"			=> "#ffffff"
       ),
		
       array(
           "type"			=> "attach_image",
           "holder"		=> "div",
           "class" 		=> "hide_in_vc_editor",
           "admin_label" 	=> true,
           "heading"		=> esc_html__("Background Image", "eclat-shortcodes"),
           "param_name"	=> "bg_image",
           "value"			=> ""
       ),

       array(
           "type"			=> "textfield",
           "holder"		    => "div",
           "class" 		    => "hide_in_vc_editor",
           "admin_label" 	=> true,
           "heading"		=> esc_html__("Height", "eclat-shortcodes"),
           "param_name"	    => "height",
           "value"			=> "410px"
       )
   )
   
));