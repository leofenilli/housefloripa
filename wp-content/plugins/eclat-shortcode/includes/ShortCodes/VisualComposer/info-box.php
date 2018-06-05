<?php

// [info_box]
vc_map(array(
    "name"			=> esc_html__( "Info Box", "eclat-shortcodes" ),
    "category"		=> "Content",
    "description"	=> esc_html__( "Place Info Box", "eclat-shortcodes" ),
    "base"			=> "info_box",
    "class"			=> "",
    "icon"			=> "info_box",


    "params" 	=> array(

        array(
            "type" 			=> "textfield",
            "class" 		=> "hide_in_vc_editor",
            "admin_label" 	=> true,
            "heading" 		=> esc_html__( "Title", "eclat-shortcodes" ),
            "param_name" 	=> "title",
            "value" 		=> ""
        ),

        array(
            "type" 			=> "textarea_html",
            "class" 		=> "hide_in_vc_editor",
            "admin_label" 	=> true,
            "heading" 		=> esc_html__( "Description", "eclat-shortcodes" ),
            "param_name" 	=> "content",
            "value" 		=> ""
        ),

        array(
            "type" 			=> "textfield",
            "class" 		=> "hide_in_vc_editor",
            "admin_label" 	=> true,
            "heading" 		=> esc_html__( "Link URL", "eclat-shortcodes" ),
            "param_name" 	=> "link_url",
            "value" 		=> ""
        ),

        array(
            "type"			=> "attach_image",
            "class" 		=> "hide_in_vc_editor",
            "admin_label" 	=> true,
            "heading"		=> esc_html__("Image", "eclat-shortcodes"),
            "param_name"	=> "image",
            "value"			=> ""
        ),

        array(
            "type" 			=> "textfield",
            "class" 		=> "hide_in_vc_editor",
            "admin_label" 	=> true,
            "heading" 		=> esc_html__( "Extra class name", "eclat-shortcodes" ),
            "param_name" 	=> "el_class",
            "value" 		=> ""
        )

    )

));
?>