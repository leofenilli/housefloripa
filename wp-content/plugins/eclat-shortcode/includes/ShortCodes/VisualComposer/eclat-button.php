<?php

// [eclat_button]
vc_map(array(
   "name"			=> esc_html__( "Button", "eclat-shortcodes" ),
   "category"		=> "Content",
   "description"	=> esc_html__( "Insert button", "eclat-shortcodes" ),
   "base"			=> "eclat_button",
   "class"			=> "",
   "icon"			=> "eclat_button",

   "params" 	    => array(

       array(
           'type' => 'textfield',
           'heading' => esc_html__( 'Text', 'eclat-shortcodes' ),
           'holder' => 'button',
           'class' => 'uk-button',
           'param_name' => 'title',
           'value' => esc_html__( 'Text on the button', 'eclat-shortcodes' ),
           'description' => esc_html__( 'Enter text on the button.', 'eclat-shortcodes' )
       ),

       array(
           'type' => 'vc_link',
           'heading' => esc_html__( 'URL (Link)', 'eclat-shortcodes' ),
           'param_name' => 'href',
           'description' => esc_html__( 'Enter button link.', 'eclat-shortcodes' )
       ),

       array(
           'type' => 'dropdown',
           'heading' => esc_html__( 'Alignment', 'eclat-shortcodes' ),
           'param_name' => 'align',
           'value' => array(
               esc_html__( 'Inline', 'eclat-shortcodes' ) => "inline",
               esc_html__( 'Left', 'eclat-shortcodes' ) => 'left',
               esc_html__( 'Center', 'eclat-shortcodes' ) => 'center',
               esc_html__( 'Right', 'eclat-shortcodes' ) => "right"
           ),
           'description' => esc_html__( 'Select button alignment.', 'eclat-shortcodes' )
       ),

       array(
           'type' => 'dropdown',
           'heading' => esc_html__( 'Size', 'eclat-shortcodes' ),
           'param_name' => 'size',
           'value' => array(
               esc_html__( 'Regular', 'eclat-shortcodes' ) => '',
               esc_html__( 'Large', 'eclat-shortcodes' ) => 'uk-button-large',
               esc_html__( 'Small', 'eclat-shortcodes' ) => 'uk-button-small',
               esc_html__( 'Mini', 'eclat-shortcodes' ) => 'uk-button-mini'
           ),
           'description' => esc_html__( 'Select button size.', 'eclat-shortcodes' )
       ),

       array(
           'type' => 'dropdown',
           'heading' => esc_html__( 'Style', 'eclat-shortcodes' ),
           'param_name' => 'style',
           'value' => array(
               esc_html__( 'Default', 'eclat-shortcodes' ) => '',
               esc_html__( 'Primary', 'eclat-shortcodes' ) => 'uk-button-primary',
               esc_html__( 'Border', 'eclat-shortcodes' ) => 'uk-button-border',
               esc_html__( 'Link', 'eclat-shortcodes' ) => 'uk-button-link',
               esc_html__( 'Success', 'eclat-shortcodes' ) => 'uk-button-success',
               esc_html__( 'Danger', 'eclat-shortcodes' ) => 'uk-button-danger'
           ),
           'description' => esc_html__( 'Select button style.', 'eclat-shortcodes' )
       ),

       array(
           'type' => 'dropdown',
           'heading' => esc_html__( 'Shape', 'eclat-shortcodes' ),
           'param_name' => 'shape',
           'value' => array(
               esc_html__( 'Square', 'eclat-shortcodes' ) => '',
               esc_html__( 'Rounded', 'eclat-shortcodes' ) => 'uk-button-rounded',
               esc_html__( 'Round', 'eclat-shortcodes' ) => 'uk-button-round',
           ),
           'description' => esc_html__( 'Select button shape.', 'eclat-shortcodes' )
       ),

       array(
           "type" 			=> "iconpicker",
           "heading" 		=> esc_html__( "Icon", "eclat-shortcodes" ),
           "param_name" 	=> "icon",
           'settings' => array(
               'type'       => 'eclat-icons',
           )
       ),

       array(
           "type"          => "dropdown",
           "heading"       => esc_html__("Use Scrollspy", "eclat-shortcodes"),
           "param_name"    => "scrollspy",
           "value"         => array(
               esc_html__("No", "eclat-shortcodes")    => "no",
               esc_html__("Yes", "eclat-shortcodes")   => "yes"
           )
       ),

       array(
           "type"          => "dropdown",
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
           "dependency" 	=> array(
               'element'   => "scrollspy",
               'value'     => array('yes')
           )
       ),

       array(
           "type"          => "dropdown",
           "heading"       => esc_html__("Scrollspy Repeat", "eclat-shortcodes"),
           "param_name"    => "scrollspy_repeat",
           "value"         => array(
               esc_html__("True", "eclat-shortcodes")      => "true",
               esc_html__("False", "eclat-shortcodes")     => "false"
           ),
           "dependency"    => array(
               'element'   => "scrollspy",
               'value'     => array('yes')
           ),
           "description"   => esc_html__("Applies the class everytime the element appears in the viewport.", "eclat-shortcodes")
       ),

       array(
           "type"          => "textfield",
           "heading"       => esc_html__("Scrollspy Delay", "eclat-shortcodes"),
           "param_name"    => "scrollspy_delay",
           "value"         => "300",
           "dependency"    => array(
               'element'   => "scrollspy",
               'value'     => array('yes')
           ),
           "description" => esc_html__("Adds a delay in milliseconds to the animation.", "eclat-shortcodes")
       ),

       array(
           "type" 			=> "textfield",
           "class" 		    => "hide_in_vc_editor",
           "heading" 		=> esc_html__( "Extra class name", "eclat-shortcodes" ),
           "param_name" 	=> "el_class",
           "value" 		    => ""
       )

   )
   
));