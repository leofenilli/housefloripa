<?php

// [alert_box]

vc_map(array(
    "name"			=> esc_html__("Alert Box", "eclat-shortcodes"),
    "category"		=> 'Content',
    "description"	=> esc_html__("Notification box", "eclat-shortcodes"),
    "base"			=> "alert_box",
    "class"			=> "",
    "icon"			=> "alert_box",


    "params" 	=> array(

        array(
            "type"			=> "dropdown",
            "holder"		=> "div",
            "class" 		=> "hide_in_vc_editor",
            "admin_label" 	=> true,
            "heading"		=> esc_html__("Type of your message", "eclat-shortcodes"),
            "param_name"	=> "type",
            "value"			=> array(
                esc_html__("Info", "eclat-shortcodes")	    => "",
                esc_html__("Success", "eclat-shortcodes")	=> "uk-alert-success",
                esc_html__("Warning", "eclat-shortcodes")	=> "uk-alert-warning",
                esc_html__("Error", "eclat-shortcodes")	    => "uk-alert-danger"
            ),
            "std"			=> "",
        ),

        array(
            "type"			=> "dropdown",
            "holder"		=> "div",
            "class" 		=> "hide_in_vc_editor",
            "admin_label" 	=> true,
            "heading"		=> esc_html__("Style of your message", "eclat-shortcodes"),
            "param_name"	=> "style",
            "value"			=> array(
                esc_html__("Standard", "eclat-shortcodes")	=> "",
                esc_html__("Small", "eclat-shortcodes")	    => "uk-alert-small",
                esc_html__("Border", "eclat-shortcodes")	=> "uk-alert-border",
                esc_html__("No Icon", "eclat-shortcodes")	=> "uk-alert-no-icon"
            ),
            "std"			=> "",
        ),

        array(
            "type"			=> "dropdown",
            "holder"		=> "div",
            "class" 		=> "hide_in_vc_editor",
            "admin_label" 	=> true,
            "heading"		=> esc_html__("Inline", "eclat-shortcodes"),
            "param_name"	=> "inline",
            "value"			=> array(
                esc_html__("No", "eclat-shortcodes")    => "",
                esc_html__("Yes", "eclat-shortcodes")   => "uk-alert-inline"
            ),
            "std"			=> "",
        ),

        array(
            "type"			=> "dropdown",
            "holder"		=> "div",
            "class" 		=> "hide_in_vc_editor",
            "admin_label" 	=> true,
            "heading"		=> esc_html__("Show close link", "eclat-shortcodes"),
            "param_name"	=> "close",
            "value"			=> array(
                esc_html__("Yes", "eclat-shortcodes")	=> "yes",
                esc_html__("No", "eclat-shortcodes")    => "no"
            ),
            "std"			=> "yes",
        ),

        array(
            "type"          => "textfield",
            "class"         => "hide_in_vc_editor",
            "admin_label"   => true,
            "heading"       => esc_html__("Title", "eclat-shortcodes"),
            "param_name"    => "title",
            "value"         => ""
        ),

        array(
            "type" 			=> "textarea",
            "holder" 		=> "div",
            "class" 		=> "hide_in_vc_editor",
            "admin_label" 	=> true,
            "heading" 		=> esc_html__("Message text", "eclat-shortcodes"),
            "param_name" 	=> "text",
            "value" 		=> "",
        ),

        array(
            "type"          => "dropdown",
            "class"         => "hide_in_vc_editor",
            "admin_label"   => true,
            "heading"       => esc_html__("Use Scrollspy", "eclat-shortcodes"),
            "param_name"    => "scrollspy",
            "value"         => array(
                esc_html__("No", "eclat-shortcodes")    => "no",
                esc_html__("Yes", "eclat-shortcodes")   => "yes"
            )
        ),

        array(
            "type"          => "dropdown",
            "class"         => "hide_in_vc_editor",
            "admin_label"   => true,
            "heading"       => esc_html__("Scrollspy Class", "eclat-shortcodes"),
            "param_name"    => "scrollspy_class",
            "value"         => array(
                esc_html__("The element fades in", "eclat-shortcodes")                      => "uk-animation-fade",
                esc_html__("The element scales up", "eclat-shortcodes")                     => "uk-animation-scale-up",
                esc_html__("The element scales down", "eclat-shortcodes")                   => "uk-animation-scale-down",
                esc_html__("The element slides in from the top", "eclat-shortcodes")        => "uk-animation-slide-top",
                esc_html__("The element slides in from the bottom", "eclat-shortcodes")     => "uk-animation-slide-bottom",
                esc_html__("The element slides in from the left", "eclat-shortcodes")       => "uk-animation-slide-left",
                esc_html__("The element slides in from the Right", "eclat-shortcodes")      => "uk-animation-slide-right",
                esc_html__("The element shakes", "eclat-shortcodes")                        => "uk-animation-shake",
                esc_html__("The element scales down without fading in", "eclat-shortcodes") => "uk-animation-scale"
            ),
            "dependency" 	=> Array(
                'element'   => "scrollspy",
                'value'     => array('yes')
            )
        ),

        array(
            "type"          => "dropdown",
            "class"         => "hide_in_vc_editor",
            "admin_label"   => true,
            "heading"       => esc_html__("Scrollspy Repeat", "eclat-shortcodes"),
            "param_name"    => "scrollspy_repeat",
            "value"         => array(
                esc_html__("True", "eclat-shortcodes")      => "true",
                esc_html__("False", "eclat-shortcodes")     => "false"
            ),
            "dependency" 	=> Array(
                'element'   => "scrollspy",
                'value'     => array('yes')
            ),
            "description"   => esc_html__("Applies the class everytime the element appears in the viewport.", "eclat-shortcodes")
        ),

        array(
            "type"          => "textfield",
            "class"         => "hide_in_vc_editor",
            "admin_label"   => true,
            "heading"       => esc_html__("Scrollspy Delay", "eclat-shortcodes"),
            "param_name"    => "scrollspy_delay",
            "value"         => "300",
            "dependency" 	=> Array(
                'element'   => "scrollspy",
                'value'     => array('yes')
            ),
            "description" => esc_html__("Adds a delay in milliseconds to the animation.", "eclat-shortcodes")
        )

    )

));