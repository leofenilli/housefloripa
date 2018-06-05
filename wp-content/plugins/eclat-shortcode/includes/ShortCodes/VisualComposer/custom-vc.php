<?php

// remove elements
vc_remove_element("vc_wp_search");
vc_remove_element("vc_wp_meta");
vc_remove_element("vc_wp_recentcomments");
vc_remove_element("vc_wp_calendar");
vc_remove_element("vc_wp_pages");
vc_remove_element("vc_wp_tagcloud");
vc_remove_element("vc_wp_custommenu");
vc_remove_element("vc_wp_text");
vc_remove_element("vc_wp_posts");
vc_remove_element("vc_wp_links");
vc_remove_element("vc_wp_categories");
vc_remove_element("vc_wp_archives");
vc_remove_element("vc_wp_rss");

// [vc_row]
vc_add_param("vc_row", array(
    "type"          => "dropdown",
    "class"         => "hide_in_vc_editor",
    "admin_label"   => true,
    "heading"       => esc_html__( "Row Type", "eclat-shortcodes"),
    "param_name"    => "type",
    "value"         => array(
        esc_html__( "Full Width", "eclat-shortcodes") => "full_width",
        esc_html__( "Boxed", "eclat-shortcodes")      => "boxed"
    )
));

vc_add_param("vc_row", array(
    "type"          => "dropdown",
    "class"         => "hide_in_vc_editor",
    "admin_label"   => true,
    "heading"       => esc_html__( "Use Scrollspy", "eclat-shortcodes"),
    "param_name"    => "scrollspy",
    "value"         => array(
        esc_html__( "No", "eclat-shortcodes")        => "no",
        esc_html__( "Yes", "eclat-shortcodes")       => "yes"
    )
));

vc_add_param("vc_row", array(
    "type"          => "dropdown",
    "class"         => "hide_in_vc_editor",
    "admin_label"   => true,
    "heading"       => esc_html__( "Scrollspy Class", "eclat-shortcodes"),
    "param_name"    => "scrollspy_class",
    "value" => array(
        esc_html__( "The element fades in", "eclat-shortcodes") => "uk-animation-fade",
        esc_html__( "The element scales up", "eclat-shortcodes") => "uk-animation-scale-up",
        esc_html__( "The element scales down", "eclat-shortcodes") => "uk-animation-scale-down",
        esc_html__( "The element slides in from the top", "eclat-shortcodes") => "uk-animation-slide-top",
        esc_html__( "The element slides in from the bottom", "eclat-shortcodes") => "uk-animation-slide-bottom",
        esc_html__( "The element slides in from the left", "eclat-shortcodes") => "uk-animation-slide-left",
        esc_html__( "The element slides in from the Right", "eclat-shortcodes") => "uk-animation-slide-right",
        esc_html__( "The element shakes", "eclat-shortcodes") => "uk-animation-shake",
        esc_html__( "The element scales down without fading in", "eclat-shortcodes") => "uk-animation-scale"
    ),
    "dependency" 	=> Array('element' => "scrollspy", 'value' => array('yes'))
));

vc_add_param("vc_row", array(
    "type"          => "dropdown",
    "class"         => "hide_in_vc_editor",
    "admin_label"   => true,
    "heading"       => esc_html__( "Scrollspy Repeat", "eclat-shortcodes"),
    "param_name"    => "scrollspy_repeat",
    "value"         => array(
        esc_html__( "True", "eclat-shortcodes")      => "true",
        esc_html__( "False", "eclat-shortcodes")     => "false"
    ),
    "dependency" 	=> Array('element' => "scrollspy", 'value' => array('yes')),
    "description"   => esc_html__( "Applies the class everytime the element appears in the viewport.", "eclat-shortcodes")
));

vc_add_param("vc_row", array(
    "type"          => "textfield",
    "class"         => "hide_in_vc_editor",
    "admin_label"   => true,
    "heading"       => esc_html__( "Scrollspy Delay", "eclat-shortcodes"),
    "param_name"    => "scrollspy_delay",
    "value"         => "300",
    "dependency" 	=> Array('element' => "scrollspy", 'value' => array('yes')),
    "description"   => esc_html__( "Adds a delay in milliseconds to the animation.", "eclat-shortcodes")
));

vc_add_param("vc_row_inner", array(
    "type"          => "dropdown",
    "class"         => "hide_in_vc_editor",
    "admin_label"   => true,
    "heading"       => esc_html__( "Row Type", "eclat-shortcodes"),
    "param_name"    => "type",
    "value"         => array(
        esc_html__( "Full Width", "eclat-shortcodes") => "full_width",
        esc_html__( "Boxed", "eclat-shortcodes")      => "boxed"
    )
));

// [vc_column]
vc_add_param("vc_column", array(
    "type"          => "dropdown",
    "class"         => "hide_in_vc_editor",
    "admin_label"   => true,
    "heading"       => esc_html__( "Use Scrollspy", "eclat-shortcodes"),
    "param_name"    => "scrollspy",
    "value"         => array(
        esc_html__( "No", "eclat-shortcodes")        => "no",
        esc_html__( "Yes", "eclat-shortcodes")       => "yes"
    )
));

vc_add_param("vc_column", array(
    "type"          => "dropdown",
    "class"         => "hide_in_vc_editor",
    "admin_label"   => true,
    "heading"       => esc_html__( "Scrollspy Class", "eclat-shortcodes"),
    "param_name"    => "scrollspy_class",
    "value" => array(
        esc_html__( "The element fades in", "eclat-shortcodes") => "uk-animation-fade",
        esc_html__( "The element scales up", "eclat-shortcodes") => "uk-animation-scale-up",
        esc_html__( "The element scales down", "eclat-shortcodes") => "uk-animation-scale-down",
        esc_html__( "The element slides in from the top", "eclat-shortcodes") => "uk-animation-slide-top",
        esc_html__( "The element slides in from the bottom", "eclat-shortcodes") => "uk-animation-slide-bottom",
        esc_html__( "The element slides in from the left", "eclat-shortcodes") => "uk-animation-slide-left",
        esc_html__( "The element slides in from the Right", "eclat-shortcodes") => "uk-animation-slide-right",
        esc_html__( "The element shakes", "eclat-shortcodes") => "uk-animation-shake",
        esc_html__( "The element scales down without fading in", "eclat-shortcodes") => "uk-animation-scale"
    ),
    "dependency" 	=> Array('element' => "scrollspy", 'value' => array('yes'))
));

vc_add_param("vc_column", array(
    "type"          => "dropdown",
    "class"         => "hide_in_vc_editor",
    "admin_label"   => true,
    "heading"       => esc_html__( "Scrollspy Repeat", "eclat-shortcodes"),
    "param_name"    => "scrollspy_repeat",
    "value"         => array(
        esc_html__( "True", "eclat-shortcodes")      => "true",
        esc_html__( "False", "eclat-shortcodes")     => "false"
    ),
    "dependency" 	=> Array('element' => "scrollspy", 'value' => array('yes')),
    "description"   => esc_html__( "Applies the class everytime the element appears in the viewport.", "eclat-shortcodes")
));

vc_add_param("vc_column", array(
    "type"          => "textfield",
    "class"         => "hide_in_vc_editor",
    "admin_label"   => true,
    "heading"       => esc_html__( "Scrollspy Delay", "eclat-shortcodes"),
    "param_name"    => "scrollspy_delay",
    "value"         => "300",
    "dependency" 	=> Array('element' => "scrollspy", 'value' => array('yes')),
    "description"   => esc_html__( "Adds a delay in milliseconds to the animation.", "eclat-shortcodes")
));

vc_add_param("vc_column_inner", array(
    "type"          => "dropdown",
    "class"         => "hide_in_vc_editor",
    "admin_label"   => true,
    "heading"       => esc_html__( "Use Scrollspy", "eclat-shortcodes"),
    "param_name"    => "scrollspy",
    "value"         => array(
        esc_html__( "No", "eclat-shortcodes")        => "no",
        esc_html__( "Yes", "eclat-shortcodes")       => "yes"
    )
));

vc_add_param("vc_column_inner", array(
    "type"          => "dropdown",
    "class"         => "hide_in_vc_editor",
    "admin_label"   => true,
    "heading"       => esc_html__( "Scrollspy Class", "eclat-shortcodes"),
    "param_name"    => "scrollspy_class",
    "value" => array(
        esc_html__( "The element fades in", "eclat-shortcodes") => "uk-animation-fade",
        esc_html__( "The element scales up", "eclat-shortcodes") => "uk-animation-scale-up",
        esc_html__( "The element scales down", "eclat-shortcodes") => "uk-animation-scale-down",
        esc_html__( "The element slides in from the top", "eclat-shortcodes") => "uk-animation-slide-top",
        esc_html__( "The element slides in from the bottom", "eclat-shortcodes") => "uk-animation-slide-bottom",
        esc_html__( "The element slides in from the left", "eclat-shortcodes") => "uk-animation-slide-left",
        esc_html__( "The element slides in from the Right", "eclat-shortcodes") => "uk-animation-slide-right",
        esc_html__( "The element shakes", "eclat-shortcodes") => "uk-animation-shake",
        esc_html__( "The element scales down without fading in", "eclat-shortcodes") => "uk-animation-scale"
    ),
    "dependency" 	=> Array('element' => "scrollspy", 'value' => array('yes'))
));

vc_add_param("vc_column_inner", array(
    "type"          => "dropdown",
    "class"         => "hide_in_vc_editor",
    "admin_label"   => true,
    "heading"       => esc_html__( "Scrollspy Repeat", "eclat-shortcodes"),
    "param_name"    => "scrollspy_repeat",
    "value"         => array(
        "True"      => "true",
        "False"     => "false"
    ),
    "dependency" 	=> Array('element' => "scrollspy", 'value' => array('yes')),
    "description"   => esc_html__( "Applies the class everytime the element appears in the viewport.", "eclat-shortcodes")
));

vc_add_param("vc_column_inner", array(
    "type"          => "textfield",
    "class"         => "hide_in_vc_editor",
    "admin_label"   => true,
    "heading"       => esc_html__( "Scrollspy Delay", "eclat-shortcodes"),
    "param_name"    => "scrollspy_delay",
    "value"         => "300",
    "dependency" 	=> Array('element' => "scrollspy", 'value' => array('yes')),
    "description"   => esc_html__( "Adds a delay in milliseconds to the animation.", "eclat-shortcodes")
));

// [vc_tabs]
vc_remove_param("vc_tabs", "interval");

vc_add_param("vc_tabs", array(
    "type"          => "textfield",
    "class"         => "hide_in_vc_editor",
    "admin_label"   => true,
    "heading"       => esc_html__( "Tads ID", "eclat-shortcodes"),
    "param_name"    => "tabs_id",
    "value"         => "",
    "description"   => esc_html__( "Related items container.", "eclat-shortcodes")
));

vc_add_param("vc_tabs", array(
    "type"          => "dropdown",
    "class"         => "hide_in_vc_editor",
    "admin_label"   => true,
    "heading"       => esc_html__( "Animation", "eclat-shortcodes"),
    "param_name"    => "animation",
    "value" => array(
        esc_html__( "The items fades in", "eclat-shortcodes") => "fade",
        esc_html__( "The items scale up", "eclat-shortcodes") => "scale",
        esc_html__( "The items slide in from the top", "eclat-shortcodes") => "slide-top",
        esc_html__( "The items slide in from the bottom.", "eclat-shortcodes") => "slide-bottom",
        esc_html__( "The items slide in from the left", "eclat-shortcodes") => "slide-left",
        esc_html__( "The items slide in from the right", "eclat-shortcodes") => "slide-right",
        esc_html__( "The items slide horizontally, the direction depending on the adjacency of the item", "eclat-shortcodes") => "slide-horizontal",
        esc_html__( "The items slide vertically, the direction depending on the adjacency of the item", "eclat-shortcodes") => "slide-vertical"
    ),
    "description"   => esc_html__( "You can add different animations to items when toggling between them.", "eclat-shortcodes")
));

// [vc_tab]
vc_remove_param("vc_tab", "tab_id");

vc_add_param("vc_tab", array(
    "type"          => "textfield",
    "class"         => "hide_in_vc_editor",
    "admin_label"   => true,
    "heading"       => esc_html__( "Title block", "eclat-shortcodes"),
    "param_name"    => "title_block",
    "value"         => "",
    "description"   => esc_html__( "Title before tabs.", "eclat-shortcodes")
));

vc_add_param("vc_tab", array(
    "type"          => "dropdown",
    "class"         => "hide_in_vc_editor",
    "admin_label"   => true,
    "heading"       => esc_html__( "Slider content?", "eclat-shortcodes"),
    "param_name"    => "slider",
    "value"         => array(
        esc_html__( "No", "eclat-shortcodes")    => "",
        esc_html__( "Yes", "eclat-shortcodes")   => "data-uk-slider"
    ),
    "description"   => esc_html__( "Choose YES in this parameter if the slider used inside", "eclat-shortcodes")
));

// [vc_tta_accordion]
vc_remove_param("vc_tta_accordion", "title");
vc_remove_param("vc_tta_accordion", "style");
vc_remove_param("vc_tta_accordion", "shape");
vc_remove_param("vc_tta_accordion", "color");
vc_remove_param("vc_tta_accordion", "no_fill");
vc_remove_param("vc_tta_accordion", "spacing");
vc_remove_param("vc_tta_accordion", "gap");
vc_remove_param("vc_tta_accordion", "c_align");
vc_remove_param("vc_tta_accordion", "autoplay");
vc_remove_param("vc_tta_accordion", "collapsible_all");
vc_remove_param("vc_tta_accordion", "c_icon");
vc_remove_param("vc_tta_accordion", "c_position");
vc_remove_param("vc_tta_accordion", "active_section");
vc_remove_param("vc_tta_accordion", "el_class");
vc_remove_param("vc_tta_accordion", "css");

vc_add_param("vc_tta_accordion", array(
    "type"          => "dropdown",
    "heading"       => esc_html__( "Template", "eclat-shortcodes" ),
    "param_name"    => "template",
    "value"         => array(
        esc_html__( "Default VC", "eclat-shortcodes" ) => "default",
        esc_html__( "This Theme", "eclat-shortcodes" ) => "this_theme",
    ),
    "description"   => esc_html__( "Select the template you will use", "eclat-shortcodes" ),
    "std"			=> "this_theme"
));

vc_add_param("vc_tta_accordion", array(
    "type"          => "dropdown",
    "heading"       => esc_html__( "Accordion Style", "eclat-shortcodes"),
    "param_name"    => "accordion_style",
    "value"         => array(
        esc_html__( "Default", "eclat-shortcodes")	=> "",
        esc_html__( "Primary", "eclat-shortcodes")	=> "uk-accordion-primary"
    ),
    "description"   => esc_html__( "Select accordion display style.", "eclat-shortcodes" ),
    "dependency" 	=> Array("element" => "template", "value" => array("this_theme")),
    "std"			=> ""
));

vc_add_param("vc_tta_accordion", array(
    "type"          => "dropdown",
    "heading"       => esc_html__( "Navigation Style", "eclat-shortcodes"),
    "param_name"    => "nav_style",
    "value"         => array(
        esc_html__( "Default", "eclat-shortcodes")	=> "",
        esc_html__( "Round", "eclat-shortcodes")	=> "uk-accordion-round"
    ),
    "description"   => esc_html__( "Select accordion nav display style.", "eclat-shortcodes" ),
    "dependency" 	=> Array("element" => "template", "value" => array("this_theme")),
    "std"			=> ""
));

vc_add_param("vc_tta_accordion", array(
    "type"          => "dropdown",
    "heading"       => esc_html__( "Show First?", "eclat-shortcodes"),
    "param_name"    => "showfirst",
    "value"         => array(
        esc_html__( "Yes", "eclat-shortcodes")	=> "true",
        esc_html__( "No", "eclat-shortcodes")	=> "false"
    ),
    "description"   => esc_html__( "Show first item on init", "eclat-shortcodes" ),
    "dependency" 	=> Array("element" => "template", "value" => array("this_theme")),
    "std"			=> "true"
));

vc_add_param("vc_tta_accordion", array(
    "type"			=> "dropdown",
    "heading"		=> esc_html__( "Collapse", "eclat-shortcodes"),
    "param_name"	=> "collapse",
    "value"			=> array(
        esc_html__( "Yes", "eclat-shortcodes")	=> "true",
        esc_html__( "No", "eclat-shortcodes")	=> "false"
    ),
    "description" => esc_html__( "Allow multiple open items", "eclat-shortcodes" ),
    "dependency" 	=> Array("element" => "template", "value" => array("this_theme")),
    "std"			=> "true",
));

vc_add_param("vc_tta_accordion", array(
    "type"			=> "dropdown",
    "heading"		=> esc_html__( "Animate", "eclat-shortcodes"),
    "param_name"	=> "animate",
    "value"			=> array(
        esc_html__( "Yes", "eclat-shortcodes")	=> "true",
        esc_html__( "No", "eclat-shortcodes")	=> "false"
    ),
    'description' => esc_html__( "Animate toggle", "eclat-shortcodes" ),
    "dependency" 	=> Array("element" => "template", "value" => array("this_theme")),
    "std"			=> "true",
));

vc_add_param("vc_tta_accordion", array(
    "type"			=> "textfield",
    "heading"		=> esc_html__( "Duration", "eclat-shortcodes"),
    "param_name"	=> "duration",
    "value"			=> "300",
    "dependency" 	=> Array("element" => "template", "value" => array("this_theme")),
    'description' => esc_html__( "Animation duration", "eclat-shortcodes" )
));

vc_add_param("vc_tta_accordion", array(
    'type' => 'dropdown',
    'param_name' => 'style',
    'value' => array(
        esc_html__( 'Classic', 'js_composer' ) => 'classic',
        esc_html__( 'Modern', 'js_composer' ) => 'modern',
        esc_html__( 'Flat', 'js_composer' ) => 'flat',
        esc_html__( 'Outline', 'js_composer' ) => 'outline',
    ),
    'heading' => esc_html__( 'Style', 'js_composer' ),
    'description' => esc_html__( 'Select accordion display style.', 'js_composer' ),
    "dependency" 	=> Array("element" => "template", "value" => array("default"))
));

vc_add_param("vc_tta_accordion", array(
    'type' => 'dropdown',
    'param_name' => 'shape',
    'value' => array(
        esc_html__( 'Rounded', 'js_composer' ) => 'rounded',
        esc_html__( 'Square', 'js_composer' ) => 'square',
        esc_html__( 'Round', 'js_composer' ) => 'round',
    ),
    'heading' => esc_html__( 'Shape', 'js_composer' ),
    'description' => esc_html__( 'Select accordion shape.', 'js_composer' ),
    "dependency" 	=> Array("element" => "template", "value" => array("default"))
));

vc_add_param("vc_tta_accordion", array(
    'type' => 'dropdown',
    'param_name' => 'color',
    'value' => getVcShared( 'colors-dashed' ),
    'std' => 'grey',
    'heading' => esc_html__( 'Color', 'js_composer' ),
    'description' => esc_html__( 'Select accordion color.', 'js_composer' ),
    'param_holder_class' => 'vc_colored-dropdown',
    "dependency" 	=> Array("element" => "template", "value" => array("default"))
));

vc_add_param("vc_tta_accordion", array(
    'type' => 'checkbox',
    'param_name' => 'no_fill',
    'heading' => esc_html__( 'Do not fill content area?', 'js_composer' ),
    'description' => esc_html__( 'Do not fill content area with color.', 'js_composer' ),
    "dependency" 	=> Array("element" => "template", "value" => array("default"))
));

vc_add_param("vc_tta_accordion", array(
    'type' => 'dropdown',
    'param_name' => 'spacing',
    'value' => array(
        esc_html__( 'None', 'js_composer' ) => '',
        '1px' => '1',
        '2px' => '2',
        '3px' => '3',
        '4px' => '4',
        '5px' => '5',
        '10px' => '10',
        '15px' => '15',
        '20px' => '20',
        '25px' => '25',
        '30px' => '30',
        '35px' => '35',
    ),
    'heading' => esc_html__( 'Spacing', 'js_composer' ),
    'description' => esc_html__( 'Select accordion spacing.', 'js_composer' ),
    "dependency" 	=> Array("element" => "template", "value" => array("default"))
));

vc_add_param("vc_tta_accordion", array(
    'type' => 'dropdown',
    'param_name' => 'gap',
    'value' => array(
        esc_html__( 'None', 'js_composer' ) => '',
        '1px' => '1',
        '2px' => '2',
        '3px' => '3',
        '4px' => '4',
        '5px' => '5',
        '10px' => '10',
        '15px' => '15',
        '20px' => '20',
        '25px' => '25',
        '30px' => '30',
        '35px' => '35',
    ),
    'heading' => esc_html__( 'Gap', 'js_composer' ),
    'description' => esc_html__( 'Select accordion gap.', 'js_composer' ),
    "dependency" 	=> Array("element" => "template", "value" => array("default"))
));

vc_add_param("vc_tta_accordion", array(
    'type' => 'dropdown',
    'param_name' => 'c_align',
    'value' => array(
        esc_html__( 'Left', 'js_composer' ) => 'left',
        esc_html__( 'Right', 'js_composer' ) => 'right',
        esc_html__( 'Center', 'js_composer' ) => 'center',
    ),
    'heading' => esc_html__( 'Alignment', 'js_composer' ),
    'description' => esc_html__( 'Select accordion section title alignment.', 'js_composer' ),
    "dependency" 	=> Array("element" => "template", "value" => array("default"))
));

vc_add_param("vc_tta_accordion", array(
    'type' => 'dropdown',
    'param_name' => 'autoplay',
    'value' => array(
        esc_html__( 'None', 'js_composer' ) => 'none',
        '1' => '1',
        '2' => '2',
        '3' => '3',
        '4' => '4',
        '5' => '5',
        '10' => '10',
        '20' => '20',
        '30' => '30',
        '40' => '40',
        '50' => '50',
        '60' => '60',
    ),
    'std' => 'none',
    'heading' => esc_html__( 'Autoplay', 'js_composer' ),
    'description' => esc_html__( 'Select auto rotate for accordion in seconds (Note: disabled by default).', 'js_composer' ),
    "dependency" 	=> Array("element" => "template", "value" => array("default"))
));

vc_add_param("vc_tta_accordion", array(
    'type' => 'checkbox',
    'param_name' => 'collapsible_all',
    'heading' => esc_html__( 'Allow collapse all?', 'js_composer' ),
    'description' => esc_html__( 'Allow collapse all accordion sections.', 'js_composer' ),
    "dependency" 	=> Array("element" => "template", "value" => array("default"))
));

vc_add_param("vc_tta_accordion", array(
    'type' => 'dropdown',
    'param_name' => 'c_icon',
    'value' => array(
        esc_html__( 'None', 'js_composer' ) => '',
        esc_html__( 'Chevron', 'js_composer' ) => 'chevron',
        esc_html__( 'Plus', 'js_composer' ) => 'plus',
        esc_html__( 'Triangle', 'js_composer' ) => 'triangle',
    ),
    'std' => 'plus',
    'heading' => esc_html__( 'Icon', 'js_composer' ),
    'description' => esc_html__( 'Select accordion navigation icon.', 'js_composer' ),
    "dependency" 	=> Array("element" => "template", "value" => array("default"))
));

vc_add_param("vc_tta_accordion", array(
    'type' => 'dropdown',
    'param_name' => 'c_position',
    'value' => array(
        esc_html__( 'Left', 'js_composer' ) => 'left',
        esc_html__( 'Right', 'js_composer' ) => 'right',
    ),
    'heading' => esc_html__( 'Position', 'js_composer' ),
    'description' => esc_html__( 'Select accordion navigation icon position.', 'js_composer' ),
    "dependency" 	=> Array("element" => "template", "value" => array("default"))
));

vc_add_param("vc_tta_accordion", array(
    'type' => 'textfield',
    'param_name' => 'active_section',
    'heading' => esc_html__( 'Active section', 'js_composer' ),
    'value' => 1,
    'description' => esc_html__( 'Enter active section number (Note: to have all sections closed on initial load enter non-existing number).', 'js_composer' ),
    "dependency" 	=> Array("element" => "template", "value" => array("default"))
));

vc_add_param("vc_tta_accordion", array(
    'type' => 'textfield',
    'heading' => esc_html__( 'Extra class name', 'js_composer' ),
    'param_name' => 'el_class',
    'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' ),
    "dependency" 	=> Array("element" => "template", "value" => array("default"))
));

vc_add_param("vc_tta_accordion", array(
    'type' => 'css_editor',
    'heading' => esc_html__( 'CSS box', 'js_composer' ),
    'param_name' => 'css',
    'group' => esc_html__( 'Design Options', 'js_composer' ),
));

// [vc_tta_tabs]
vc_remove_param("vc_tta_tabs", "style");
vc_remove_param("vc_tta_tabs", "shape");
vc_remove_param("vc_tta_tabs", "color");
vc_remove_param("vc_tta_tabs", "no_fill_content_area");
vc_remove_param("vc_tta_tabs", "spacing");
vc_remove_param("vc_tta_tabs", "gap");
vc_remove_param("vc_tta_tabs", "tab_position");
vc_remove_param("vc_tta_tabs", "alignment");
vc_remove_param("vc_tta_tabs", "autoplay");
vc_remove_param("vc_tta_tabs", "active_section");
vc_remove_param("vc_tta_tabs", "pagination_style");
vc_remove_param("vc_tta_tabs", "pagination_color");
vc_remove_param("vc_tta_tabs", "el_class");
vc_remove_param("vc_tta_tabs", "css");

vc_add_param("vc_tta_tabs", array(
    "type"          => "dropdown",
    "heading"       => esc_html__( "Template", "eclat-shortcodes" ),
    "param_name"    => "template",
    "value"         => array(
        esc_html__( "Default VC", "eclat-shortcodes" ) => "default",
        esc_html__( "This Theme", "eclat-shortcodes" ) => "this_theme",
    ),
    "description"   => esc_html__( "Select the template you will use", "eclat-shortcodes" ),
    "std"			=> "this_theme"
));

vc_add_param("vc_tta_tabs", array(
    "type"          => "textfield",
    "class"         => "hide_in_vc_editor",
    "admin_label"   => true,
    "heading"       => esc_html__( "Tads ID","eclat-shortcodes" ),
    "param_name"    => "tabs_id",
    "value"         => "",
    "dependency" 	=> Array("element" => "template", "value" => array("this_theme")),
    "description"   => esc_html__( "Related items container.", "eclat-shortcodes" )
));

vc_add_param("vc_tta_tabs", array(
    "type"          => "dropdown",
    "heading"       => esc_html__( "Tab Style", "eclat-shortcodes" ),
    "param_name"    => "tab_style",
    "value"         => array(
        esc_html__( "Standard tab", "eclat-shortcodes" ) => "uk-tab",
        esc_html__( "Standard tab bottom", "eclat-shortcodes" ) => "uk-tab uk-tab-bottom",
        esc_html__( "Standard tab left", "eclat-shortcodes" ) => "uk-tab uk-tab-left",
        esc_html__( "Standard tab right", "eclat-shortcodes" ) => "uk-tab uk-tab-right",
        esc_html__( "Tab link", "eclat-shortcodes" ) => "uk-tab-link",
        esc_html__( "Tab subnav", "eclat-shortcodes" ) => "uk-tab-subnav",
    ),
    "dependency" 	=> Array("element" => "template", "value" => array("this_theme")),
    "description"   => esc_html__( "Select tabs display style.", "eclat-shortcodes" ),
    "std"			=> "uk-tab"
));

vc_add_param("vc_tta_tabs", array(
    "type"          => "dropdown",
    "heading"       => esc_html__( "Width tabs navigate", "eclat-shortcodes" ),
    "param_name"    => "width_tabs",
    "value"         => array(
        "1/2" => "2",
        "1/3" => "3",
        "1/4" => "4",
    ),
    "dependency" 	=> Array("element" => "tab_style", "value" => array("uk-tab uk-tab-left", "uk-tab uk-tab-right")),
    "description"   => esc_html__( "Use the Grid component to display content correctly with a vertical tabbed navigation.", "eclat-shortcodes" ),
    "std"			=> "1/4"
));

vc_add_param("vc_tta_tabs", array(
    "type"          => "dropdown",
    "class"         => "hide_in_vc_editor",
    "admin_label"   => true,
    "heading"       => esc_html__( "Animation", "eclat-shortcodes" ),
    "param_name"    => "animation",
    "value" => array(
        esc_html__( "The items fades in", "eclat-shortcodes" ) => "fade",
        esc_html__( "The items scale up", "eclat-shortcodes" ) => "scale",
        esc_html__( "The items slide in from the top", "eclat-shortcodes" ) => "slide-top",
        esc_html__( "The items slide in from the bottom.", "eclat-shortcodes" ) => "slide-bottom",
        esc_html__( "The items slide in from the left", "eclat-shortcodes" ) => "slide-left",
        esc_html__( "The items slide in from the right", "eclat-shortcodes" ) => "slide-right",
        esc_html__( "The items slide horizontally, the direction depending on the adjacency of the item", "eclat-shortcodes" ) => "slide-horizontal",
        esc_html__( "The items slide vertically, the direction depending on the adjacency of the item", "eclat-shortcodes" ) => "slide-vertical"
    ),
    "dependency" 	=> Array("element" => "template", "value" => array("this_theme")),
    "description"   => esc_html__( "You can add different animations to items when toggling between them.", "eclat-shortcodes" )
));

vc_add_param("vc_tta_tabs", array(
    'type' => 'dropdown',
    'param_name' => 'style',
    'value' => array(
        esc_html__( 'Classic', 'js_composer' ) => 'classic',
        esc_html__( 'Modern', 'js_composer' ) => 'modern',
        esc_html__( 'Flat', 'js_composer' ) => 'flat',
        esc_html__( 'Outline', 'js_composer' ) => 'outline',
    ),
    'heading' => esc_html__( 'Style', 'js_composer' ),
    'description' => esc_html__( 'Select tabs display style.', 'js_composer' ),
    "dependency" 	=> Array("element" => "template", "value" => array("default"))
));
vc_add_param("vc_tta_tabs", array(
    'type' => 'dropdown',
    'param_name' => 'shape',
    'value' => array(
        esc_html__( 'Rounded', 'js_composer' ) => 'rounded',
        esc_html__( 'Square', 'js_composer' ) => 'square',
        esc_html__( 'Round', 'js_composer' ) => 'round',
    ),
    'heading' => esc_html__( 'Shape', 'js_composer' ),
    'description' => esc_html__( 'Select tabs shape.', 'js_composer' ),
    "dependency" 	=> Array("element" => "template", "value" => array("default"))
));
vc_add_param("vc_tta_tabs", array(
    'type' => 'dropdown',
    'param_name' => 'color',
    'heading' => esc_html__( 'Color', 'js_composer' ),
    'description' => esc_html__( 'Select tabs color.', 'js_composer' ),
    'value' => getVcShared( 'colors-dashed' ),
    'std' => 'grey',
    'param_holder_class' => 'vc_colored-dropdown',
    "dependency" 	=> Array("element" => "template", "value" => array("default"))
));
vc_add_param("vc_tta_tabs", array(
    'type' => 'checkbox',
    'param_name' => 'no_fill_content_area',
    'heading' => esc_html__( 'Do not fill content area?', 'js_composer' ),
    'description' => esc_html__( 'Do not fill content area with color.', 'js_composer' ),
    "dependency" 	=> Array("element" => "template", "value" => array("default"))
));
vc_add_param("vc_tta_tabs", array(
    'type' => 'dropdown',
    'param_name' => 'spacing',
    'value' => array(
        esc_html__( 'None', 'js_composer' ) => '',
        '1px' => '1',
        '2px' => '2',
        '3px' => '3',
        '4px' => '4',
        '5px' => '5',
        '10px' => '10',
        '15px' => '15',
        '20px' => '20',
        '25px' => '25',
        '30px' => '30',
        '35px' => '35',
    ),
    'heading' => esc_html__( 'Spacing', 'js_composer' ),
    'description' => esc_html__( 'Select tabs spacing.', 'js_composer' ),
    'std' => '1',
    "dependency" 	=> Array("element" => "template", "value" => array("default"))
));
vc_add_param("vc_tta_tabs", array(
    'type' => 'dropdown',
    'param_name' => 'gap',
    'value' => array(
        esc_html__( 'None', 'js_composer' ) => '',
        '1px' => '1',
        '2px' => '2',
        '3px' => '3',
        '4px' => '4',
        '5px' => '5',
        '10px' => '10',
        '15px' => '15',
        '20px' => '20',
        '25px' => '25',
        '30px' => '30',
        '35px' => '35',
    ),
    'heading' => esc_html__( 'Gap', 'js_composer' ),
    'description' => esc_html__( 'Select tabs gap.', 'js_composer' ),
    "dependency" 	=> Array("element" => "template", "value" => array("default"))
));
vc_add_param("vc_tta_tabs", array(
    'type' => 'dropdown',
    'param_name' => 'tab_position',
    'value' => array(
        esc_html__( 'Top', 'js_composer' ) => 'top',
        esc_html__( 'Bottom', 'js_composer' ) => 'bottom',
    ),
    'heading' => esc_html__( 'Position', 'js_composer' ),
    'description' => esc_html__( 'Select tabs navigation position.', 'js_composer' ),
    "dependency" 	=> Array("element" => "template", "value" => array("default"))
));
vc_add_param("vc_tta_tabs", array(
    'type' => 'dropdown',
    'param_name' => 'alignment',
    'value' => array(
        esc_html__( 'Left', 'js_composer' ) => 'left',
        esc_html__( 'Right', 'js_composer' ) => 'right',
        esc_html__( 'Center', 'js_composer' ) => 'center',
    ),
    'heading' => esc_html__( 'Alignment', 'js_composer' ),
    'description' => esc_html__( 'Select tabs section title alignment.', 'js_composer' ),
    "dependency" 	=> Array("element" => "template", "value" => array("default"))
));
vc_add_param("vc_tta_tabs", array(
    'type' => 'dropdown',
    'param_name' => 'autoplay',
    'value' => array(
        esc_html__( 'None', 'js_composer' ) => 'none',
        '1' => '1',
        '2' => '2',
        '3' => '3',
        '4' => '4',
        '5' => '5',
        '10' => '10',
        '20' => '20',
        '30' => '30',
        '40' => '40',
        '50' => '50',
        '60' => '60',
    ),
    'std' => 'none',
    'heading' => esc_html__( 'Autoplay', 'js_composer' ),
    'description' => esc_html__( 'Select auto rotate for tabs in seconds (Note: disabled by default).', 'js_composer' ),
    "dependency" 	=> Array("element" => "template", "value" => array("default"))
));
vc_add_param("vc_tta_tabs", array(
    'type' => 'textfield',
    'param_name' => 'active_section',
    'heading' => esc_html__( 'Active section', 'js_composer' ),
    'value' => 1,
    'description' => esc_html__( 'Enter active section number (Note: to have all sections closed on initial load enter non-existing number).', 'js_composer' ),
    "dependency" 	=> Array("element" => "template", "value" => array("default"))
));
vc_add_param("vc_tta_tabs", array(
    'type' => 'dropdown',
    'param_name' => 'pagination_style',
    'value' => array(
        esc_html__( 'None', 'js_composer' ) => '',
        esc_html__( 'Square Dots', 'js_composer' ) => 'outline-square',
        esc_html__( 'Radio Dots', 'js_composer' ) => 'outline-round',
        esc_html__( 'Point Dots', 'js_composer' ) => 'flat-round',
        esc_html__( 'Fill Square Dots', 'js_composer' ) => 'flat-square',
        esc_html__( 'Rounded Fill Square Dots', 'js_composer' ) => 'flat-rounded',
    ),
    'heading' => esc_html__( 'Pagination style', 'js_composer' ),
    'description' => esc_html__( 'Select pagination style.', 'js_composer' ),
    "dependency" 	=> Array("element" => "template", "value" => array("default"))
));
vc_add_param("vc_tta_tabs", array(
    'type' => 'dropdown',
    'param_name' => 'pagination_color',
    'value' => getVcShared( 'colors-dashed' ),
    'heading' => esc_html__( 'Pagination color', 'js_composer' ),
    'description' => esc_html__( 'Select pagination color.', 'js_composer' ),
    'param_holder_class' => 'vc_colored-dropdown',
    'std' => 'grey',
    "dependency" 	=> Array("element" => "template", "value" => array("default"))
));
vc_add_param("vc_tta_tabs", array(
    'type' => 'textfield',
    'heading' => esc_html__( 'Extra class name', 'js_composer' ),
    'param_name' => 'el_class',
    'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' ),
    "dependency" 	=> Array("element" => "template", "value" => array("default"))
));
vc_add_param("vc_tta_tabs", array(
    'type' => 'css_editor',
    'heading' => esc_html__( 'CSS box', 'js_composer' ),
    'param_name' => 'css',
    'group' => esc_html__( 'Design Options', 'js_composer' )
));



// [vc_tta_section]
vc_remove_param("vc_tta_section", "tab_id");

vc_add_param("vc_tta_section", array(
    "type"          => "textfield",
    "class"         => "hide_in_vc_editor",
    "admin_label"   => true,
    "heading"       =>  esc_html__("Title block", "eclat-shortcodes" ),
    "param_name"    => "title_block",
    "value"         => "",
    "description"   =>  esc_html__("Title before tabs.", "eclat-shortcodes" )
));

vc_add_param("vc_tta_section", array(
    "type"          => "dropdown",
    "class"         => "hide_in_vc_editor",
    "admin_label"   => true,
    "heading"       =>  esc_html__("Slider content?", "eclat-shortcodes" ),
    "param_name"    => "slider",
    "value"         => array(
        esc_html__("No", "eclat-shortcodes" )   => "",
        esc_html__("Yes" , "eclat-shortcodes" ) => "data-uk-slider"
    ),
    "description"   =>  esc_html__("Choose YES in this parameter if the slider used inside", "eclat-shortcodes" )
));

// [vc_widget_sidebar]
vc_remove_param("vc_widget_sidebar", "title");

// [vc_accordion]
vc_remove_param("vc_accordion", "title");

// [vc_progress_bar]
vc_remove_param("vc_progress_bar", "title");
vc_remove_param("vc_progress_bar", "options");
vc_remove_param("vc_progress_bar", "bgcolor");
vc_remove_param("vc_progress_bar", "custombgcolor");
vc_remove_param("vc_progress_bar", "customtxtcolor");
vc_remove_param("vc_progress_bar", "units");
vc_remove_param("vc_progress_bar", "el_class");

vc_add_param("vc_progress_bar", array(
    "type"          => "dropdown",
    "heading"       =>  esc_html__("Color", "eclat-shortcodes" ),
    "param_name"    => "bgcolor",
    "value"         => array(
        esc_html__("Default", "eclat-shortcodes" )   => "",
        esc_html__("Success", "eclat-shortcodes" )   => "uk-progress-success",
        esc_html__("Warning", "eclat-shortcodes" )   => "uk-progress-warning",
        esc_html__("Danger", "eclat-shortcodes" )   => "uk-progress-danger",
        esc_html__("Custom Color", "eclat-shortcodes") => "custom"
    ),
    "description"   =>  esc_html__("Select bar background color.", "eclat-shortcodes" ),
    "admin_label" => true,
));

vc_add_param("vc_progress_bar", array(
    'type' => 'colorpicker',
    'heading' => esc_html__( 'Bar custom background color', 'eclat-shortcodes' ),
    'param_name' => 'custombgcolor',
    'description' => esc_html__( 'Select custom background color for bars.', 'eclat-shortcodes' ),
    'dependency' => array( 'element' => 'bgcolor', 'value' => array( 'custom' ) )
));

vc_add_param("vc_progress_bar", array(
    'type' => 'colorpicker',
    'heading' => esc_html__( 'Bar custom text color', 'eclat-shortcodes' ),
    'param_name' => 'customtxtcolor',
    'description' => esc_html__( 'Select custom text color for bars.', 'eclat-shortcodes' ),
    'dependency' => array( 'element' => 'bgcolor', 'value' => array( 'custom' ) )
));

vc_add_param("vc_progress_bar", array(
    'type' => 'colorpicker',
    'heading' => esc_html__( 'Bar custom text color', 'eclat-shortcodes' ),
    'param_name' => 'customtxtcolor',
    'description' => esc_html__( 'Select custom text color for bars.', 'eclat-shortcodes' ),
    'dependency' => array( 'element' => 'bgcolor', 'value' => array( 'custom' ) )
));

vc_add_param("vc_progress_bar", array(
    "type"          => "dropdown",
    "heading"       =>  esc_html__("Size", "eclat-shortcodes" ),
    "param_name"    => "size",
    "value"         => array(
        esc_html__("Default", "eclat-shortcodes" )   => "",
        esc_html__("Small", "eclat-shortcodes" )   => "uk-progress-small",
        esc_html__("Mini", "eclat-shortcodes" )   => "uk-progress-mini",
    ),
    "description"   =>  esc_html__("Change the size of the bar.", "eclat-shortcodes" ),
    "admin_label" => true,
));

vc_add_param("vc_progress_bar", array(
    "type"          => "dropdown",
    "heading"       =>  esc_html__("Striped", "eclat-shortcodes" ),
    "param_name"    => "striped",
    "value"         => array(
        esc_html__("No", "eclat-shortcodes" )   => "",
        esc_html__("Yes", "eclat-shortcodes" )   => "uk-progress-striped",
        esc_html__("Yes active", "eclat-shortcodes" )   => "uk-progress-striped uk-active",
    ),
    "description"   =>  esc_html__("Add striped progress bar.", "eclat-shortcodes" ),
    "admin_label" => true,
));

vc_add_param("vc_progress_bar", array(
    'type' => 'textfield',
    'heading' => esc_html__( 'Units', 'eclat-shortcodes' ),
    'param_name' => 'units',
    'description' => esc_html__( 'Enter measurement units (Example: %, px, points, etc. Note: graph value and units will be appended to graph title).', 'eclat-shortcodes' )
));

vc_add_param("vc_progress_bar", array(
    'type' => 'textfield',
    'heading' => esc_html__( 'Extra class name', 'eclat-shortcodes' ),
    'param_name' => 'el_class',
    'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'eclat-shortcodes' )
));


// [rev_slider_vc]
if (function_exists('rev_slider_shortcode')) {
    vc_remove_param("rev_slider_vc", "title");
}