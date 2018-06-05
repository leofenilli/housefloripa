<?php

// [team_member]
vc_map(array(
   "name"			=> esc_html__("Team Member", "eclat-shortcodes"),
   "category"		=> "Content",
   "description"	=> esc_html__("Add Team Member", "eclat-shortcodes"),
   "base"			=> "team_member",
   "class"			=> "",
   "icon"			=> "team_member",

   
   "params" 	=> array(
		
       array(
           "type"			=> "dropdown",
           "heading"		=> esc_html__("Display Type", "eclat-shortcodes"),
           "param_name"	    => "type",
           "value"			=> array(
               esc_html__( "Vertical", "eclat-shortcodes")	 => "vertical",
               esc_html__( "Horizontal", "eclat-shortcodes") => "horizontal"
           ),
           "std"			=> "vertical"
       ),

       array(
           "type"			=> "attach_image",
           "heading"		=> esc_html__("Avatar", "eclat-shortcodes"),
           "param_name"	    => "avatar",
           "value"			=> ""
       ),

       array(
           "type"			=> "textfield",
           "heading"		=> esc_html__("Image size", "eclat-shortcodes"),
           "param_name"	    => "img_size",
           "value"			=> "full",
           "description"    => esc_html__( 'Enter image size (Example: "thumbnail", "medium", "large", "full" or other sizes defined by theme). Alternatively enter size in pixels (Example: 200x100 (Width x Height)).', 'eclat-shortcodes' ),
       ),

       array(
           "type"			=> "textfield",
           "admin_label" 	=> true,
           "heading"		=> esc_html__("Name", "eclat-shortcodes"),
           "param_name"	    => "name",
           "value"			=> ""
       ),

       array(
           "type"			=> "textfield",
           "heading"		=> esc_html__("E-mail", "eclat-shortcodes"),
           "param_name"	    => "email",
           "value"			=> ""
       ),

       array(
           "type"			=> "textfield",
           "heading"		=> esc_html__("Position", "eclat-shortcodes"),
           "param_name"	    => "position",
           "value"			=> ""
       ),

       array(
           "type"			=> "textfield",
           "heading"		=> esc_html__("Twitter link", "eclat-shortcodes"),
           "param_name"	    => "twitter",
           "value"			=> ""
       ),

       array(
           "type"			=> "textfield",
           "heading"		=> esc_html__("Facebook link", "eclat-shortcodes"),
           "param_name"	    => "facebook",
           "value"			=> ""
       ),

       array(
           "type"			=> "textfield",
           "heading"		=> esc_html__("Linkedin", "eclat-shortcodes"),
           "param_name"	=> "linkedin",
           "value"			=> ""
       ),

       array(
           "type"			=> "textfield",
           "heading"		=> esc_html__("Instagram", "eclat-shortcodes"),
           "param_name"	    => "instagram",
           "value"			=> ""
       ),

       array(
           "type"			=> "textfield",
           "heading"		=> esc_html__("Skype name", "eclat-shortcodes"),
           "param_name"	    => "skype_name",
           "value"			=> ""
       ),

       array(
           'type'           => 'textarea_html',
           'holder'         => 'div',
           'heading'        => esc_html__( 'Text', 'eclat-shortcodes' ),
           'param_name'     => 'content',
           'value'          => ''
       )

   )
   
));