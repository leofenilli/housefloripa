<?php

// [last_tweets]
vc_map(array(
    "name"			=> esc_html__( "Last Tweets", "eclat-shortcodes" ),
    "category"		=> 'Social',
    "description"	=> esc_html__( "Display the last tweets posts into your site.", "eclat-shortcodes" ),
    "base"			=> "last_tweets",
    "class"			=> "",
    "icon"			=> "last_tweets",


    "params" 	=> array(

        array(
            "type"			=> "textfield",
            "class" 		=> "hide_in_vc_editor",
            "admin_label" 	=> true,
            "heading"		=> esc_html__( "Username", "eclat-shortcodes" ),
            "param_name"	=> "username",
            "value"			=> ""
        ),

        array(
            "type"			=> "textfield",
            "class" 		=> "hide_in_vc_editor",
            "admin_label" 	=> true,
            "heading"		=> esc_html__( "Consumer key", "eclat-shortcodes" ),
            "param_name"	=> "consumer_key",
            "value"			=> ""
        ),

        array(
            "type"			=> "textfield",
            "class" 		=> "hide_in_vc_editor",
            "admin_label" 	=> true,
            "heading"		=> esc_html__( "Consumer secret", "eclat-shortcodes" ),
            "param_name"	=> "consumer_secret",
            "value"			=> ""
        ),

        array(
            "type"			=> "textfield",
            "class" 		=> "hide_in_vc_editor",
            "admin_label" 	=> true,
            "heading"		=> esc_html__( "Access token", "eclat-shortcodes" ),
            "param_name"	=> "access_token",
            "value"			=> ""
        ),

        array(
            "type"			=> "textfield",
            "class" 		=> "hide_in_vc_editor",
            "admin_label" 	=> true,
            "heading"		=> esc_html__( "Access token secret", "eclat-shortcodes" ),
            "param_name"	=> "access_token_secret",
            "value"			=> ""
        ),

        array(
            "type"			=> "textfield",
            "class" 		=> "hide_in_vc_editor",
            "admin_label" 	=> true,
            "heading"		=> esc_html__( "Items", "eclat-shortcodes" ),
            "param_name"	=> "items",
            "value"			=> "3",
            "std"			=> "3"
        ),

        array(
            "type"			=> "dropdown",
            "class" 		    => "hide_in_vc_editor",
            "admin_label" 	=> true,
            "heading"		=> esc_html__( "Show Time", "eclat-shortcodes" ),
            "param_name"	    => "time",
            "value"			=> array(
                esc_html__( "Yes", "eclat-shortcodes" )	=> "true",
                esc_html__( "No", "eclat-shortcodes" )	=> "false"
            ),
            "std"			=> "true"
        ),

        array(
            "type"			=> "dropdown",
            "class" 		    => "hide_in_vc_editor",
            "admin_label" 	=> true,
            "heading"		=> esc_html__( "Show Username", "eclat-shortcodes" ),
            "param_name"	    => "name",
            "value"			=> array(
                esc_html__( "Yes", "eclat-shortcodes" )	=> "true",
                esc_html__( "No", "eclat-shortcodes" )	=> "false"
            ),
            "std"			=> "true"
        ),

        array(
            "type"			=> "dropdown",
            "class" 		    => "hide_in_vc_editor",
            "admin_label" 	=> true,
            "heading"		=> esc_html__( "Show actions link", "eclat-shortcodes" ),
            "param_name"	    => "actions",
            "value"			=> array(
                esc_html__( "Yes", "eclat-shortcodes" )	=> "true",
                esc_html__( "No", "eclat-shortcodes" )	=> "false"
            ),
            "std"			=> "true"
        ),

        array(
            "type"			=> "dropdown",
            "class" 		    => "hide_in_vc_editor",
            "admin_label" 	=> true,
            "heading"		=> esc_html__( "Show Follow link", "eclat-shortcodes" ),
            "param_name"	    => "follow",
            "value"			=> array(
                esc_html__( "Yes", "eclat-shortcodes" )	=> "true",
                esc_html__( "No", "eclat-shortcodes" )	=> "false"
            ),
            "std"			=> "true"
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
            "description"   => esc_html__( "You can add animations which can be used to display the next set of items.", "eclat-shortcodes" )
        ),

        array(
            "type"			=> "dropdown",
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
?>