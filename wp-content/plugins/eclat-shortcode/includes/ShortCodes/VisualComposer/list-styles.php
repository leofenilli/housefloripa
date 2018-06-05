<?php

// [list_styles]
vc_map(array(
    "name"			=> esc_html__( "List styles", "eclat-shortcodes" ),
    "category"		=> 'Content',
    "description"	=> esc_html__( "Sets style of your list", "eclat-shortcodes" ),
    "base"			=> "list_styles",
    "class"			=> "",
    "icon"			=> "list_styles",


    "params" 	=> array(

        array(
            "type"			=> "dropdown",
            "heading"		=> esc_html__( "Type", "eclat-shortcodes" ),
            "param_name"	=> "type",
            'admin_label'   => true,
            "value"			=> array(
                esc_html__( "Bulleted", "eclat-shortcodes")	=> "bulleted",
                esc_html__( "Numbered", "eclat-shortcodes")	=> "numbered"
            ),
            "std"			=> "bulleted"
        ),

        array(
            "type"			=> "dropdown",
            "heading"		=> esc_html__( "Style", "eclat-shortcodes" ),
            "param_name"	=> "style",
            'admin_label'   => true,
            "value"			=> array(
                esc_html__( "Circle List", "eclat-shortcodes")	        => "uk-circle-list",
                esc_html__( "Circle Primary List", "eclat-shortcodes")	=> "uk-circle-primary-list",
                esc_html__( "Check List", "eclat-shortcodes")	        => "uk-check-list",
                esc_html__( "Check Primary List", "eclat-shortcodes")	=> "uk-check-primary-list"
            ),
            "dependency" 	=> Array('element' => "type", 'value' => array('bulleted')),
            "std"			=> "uk-circle-list"
        ),

        array(
            "type"			=> "dropdown",
            "heading"		=> esc_html__( "Style", "eclat-shortcodes" ),
            "param_name"	=> "style_num",
            'admin_label'   => true,
            "value"			=> array(
                esc_html__( "Round List", "eclat-shortcodes")	        => "uk-round-list",
                esc_html__( "Round Primary List", "eclat-shortcodes")	=> "uk-round-primary-list",
                esc_html__( "Square List", "eclat-shortcodes")	        => "uk-square-list",
                esc_html__( "Square Primary List", "eclat-shortcodes")	=> "uk-square-primary-list"
            ),
            "dependency" 	=> Array('element' => "type", 'value' => array('numbered')),
            "std"			=> "uk-round-list"
        ),

        array(
            'type' => 'textarea_html',
            'holder' => 'div',
            'heading' => esc_html__( 'Text', 'eclat-shortcodes' ),
            'param_name' => 'content',
            'value' => wp_kses( __( '<ul><li>I am list block. Click edit button to change this text.</li><li>I am list block. Click edit button to change this text.</li></ul>', 'eclat-shortcodes' ), array( 'ul' => array(), 'li' => array() ) )
        )

    )

));
?>