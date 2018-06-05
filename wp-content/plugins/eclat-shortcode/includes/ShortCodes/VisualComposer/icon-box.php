<?php

add_filter('vc_iconpicker-type-eclat-icons', function($icons){
    $eclat_icons = array(
        array( "eclat tm-icon-arrow-left" => esc_html__( "Arrow Left", "eclat-shortcodes" ) ),
        array( "eclat tm-icon-arrow-right" => esc_html__( "Arrow Right", "eclat-shortcodes" ) ),
        array( "eclat tm-icon-arrow-long-down" => esc_html__( "Arrow Long Down", "eclat-shortcodes" ) ),
        array( "eclat tm-icon-arrow-long-up" => esc_html__( "Arrow Long Up", "eclat-shortcodes" ) ),
        array( "eclat tm-icon-arrow-long-left" => esc_html__( "Arrow Long Left", "eclat-shortcodes" ) ),
        array( "eclat tm-icon-arrow-long-right" => esc_html__( "Arrow Long Right", "eclat-shortcodes" ) ),
        array( "eclat tm-icon-back" => esc_html__( "Arrow Back", "eclat-shortcodes" ) ),
        array( "eclat tm-icon-cart" => esc_html__( "Cart", "eclat-shortcodes" ) ),
        array( "eclat tm-icon-cancel" => esc_html__( "Cancel", "eclat-shortcodes" ) ),
        array( "eclat tm-icon-cancel-oval" => esc_html__( "Cancel Oval", "eclat-shortcodes" ) ),
        array( "eclat tm-icon-config" => esc_html__( "Config", "eclat-shortcodes" ) ),
        array( "eclat tm-icon-check" => esc_html__( "Check", "eclat-shortcodes" ) ),
        array( "eclat tm-icon-clock" => esc_html__( "Clock", "eclat-shortcodes" ) ),
        array( "eclat tm-icon-comment" => esc_html__( "Comment", "eclat-shortcodes" ) ),
        array( "eclat tm-icon-compare" => esc_html__( "Compare", "eclat-shortcodes" ) ),
        array( "eclat tm-icon-cup" => esc_html__( "Cup", "eclat-shortcodes" ) ),
        array( "eclat tm-icon-date" => esc_html__( "Date", "eclat-shortcodes" ) ),
        array( "eclat tm-icon-grid" => esc_html__( "Grid", "eclat-shortcodes" ) ),
        array( "eclat tm-icon-gallery" => esc_html__( "Gallery", "eclat-shortcodes" ) ),
        array( "eclat tm-icon-heart" => esc_html__( "Heart", "eclat-shortcodes" ) ),
        array( "eclat tm-icon-heart-bold" => esc_html__( "Heart Bold", "eclat-shortcodes" ) ),
        array( "eclat tm-icon-info" => esc_html__( "Info", "eclat-shortcodes" ) ),
        array( "eclat tm-icon-info-bold" => esc_html__( "Info Bold", "eclat-shortcodes" ) ),
        array( "eclat tm-icon-image" => esc_html__( "Image", "eclat-shortcodes" ) ),
        array( "eclat tm-icon-like" => esc_html__( "Like", "eclat-shortcodes" ) ),
        array( "eclat tm-icon-like2" => esc_html__( "Like", "eclat-shortcodes" ) ),
        array( "eclat tm-icon-lane" => esc_html__( "Lane", "eclat-shortcodes" ) ),
        array( "eclat tm-icon-list" => esc_html__( "List", "eclat-shortcodes" ) ),
        array( "eclat tm-icon-mail" => esc_html__( "Mail", "eclat-shortcodes" ) ),
        array( "eclat tm-icon-marker" => esc_html__( "Marker", "eclat-shortcodes" ) ),
        array( "eclat tm-icon-minus" => esc_html__( "Minus", "eclat-shortcodes" ) ),
        array( "eclat tm-icon-plus" => esc_html__( "Plus", "eclat-shortcodes" ) ),
        array( "eclat tm-icon-purce" => esc_html__( "Purce", "eclat-shortcodes" ) ),
        array( "eclat tm-icon-quote" => esc_html__( "Quote", "eclat-shortcodes" ) ),
        array( "eclat tm-icon-refresh" => esc_html__( "Refresh", "eclat-shortcodes" ) ),
        array( "eclat tm-icon-sale" => esc_html__( "Sale", "eclat-shortcodes" ) ),
        array( "eclat tm-icon-search" => esc_html__( "Search", "eclat-shortcodes" ) ),
        array( "eclat tm-icon-share" => esc_html__( "Share", "eclat-shortcodes" ) ),
        array( "eclat tm-icon-smile" => esc_html__( "Smile", "eclat-shortcodes" ) ),
        array( "eclat tm-icon-star" => esc_html__( "Star", "eclat-shortcodes" ) ),
        array( "eclat tm-icon-star-active" => esc_html__( "Star Active", "eclat-shortcodes" ) ),
        array( "eclat tm-icon-tag" => esc_html__( "Tag", "eclat-shortcodes" ) ),
        array( "eclat tm-icon-tell" => esc_html__( "Tell", "eclat-shortcodes" ) ),
        array( "eclat tm-icon-user" => esc_html__( "User", "eclat-shortcodes" ) ),
        array( "eclat tm-icon-video" => esc_html__( "Video", "eclat-shortcodes" ) ),
        array( "eclat tm-icon-wallet" => esc_html__( "Wallet", "eclat-shortcodes" ) ),
        array( "eclat tm-icon-warning" => esc_html__( "Warning", "eclat-shortcodes" ) ),
    );

    return array_merge( $icons, $eclat_icons );
});

// [icon_box]
vc_map(array(
   "name"			=> esc_html__( "Icon Box", "eclat-shortcodes" ),
   "category"		=> "Content",
   "description"	=> esc_html__( "Place Icon Box", "eclat-shortcodes" ),
   "base"			=> "icon_box",
   "class"			=> "",
   "icon"			=> "icon_box",

   
   "params" 	=> array(
		
       array(
           "type" 			=> "textfield",
           "class" 		    => "hide_in_vc_editor",
           "admin_label" 	=> true,
           "heading" 		=> esc_html__( "Title", "eclat-shortcodes" ),
           "param_name" 	=> "title",
           "value" 		    => ""
       ),

       array(
           "type"			=> "dropdown",
           "class" 		    => "hide_in_vc_editor",
           "admin_label" 	=> true,
           "heading"		=> esc_html__( "Separator", "eclat-shortcodes" ),
           "param_name" 	=> "separator",
           "value"			=> array(
               esc_html__( "Without Separator", "eclat-shortcodes" ) => "without_separator",
               esc_html__( "With Separator", "eclat-shortcodes" ) 	 => "with_separator"
           ),
           "std"			=> "without_separator"
       ),

       array(
           "type" 			=> "iconpicker",
           "class" 		    => "hide_in_vc_editor",
           "admin_label" 	=> true,
           "heading" 		=> esc_html__( "Icon", "eclat-shortcodes" ),
           "param_name" 	=> "eclat_icon",
           'settings' => array(
               'type'       => 'eclat-icons',
            )
       ),

       array(
           "type"			=> "dropdown",
           "class" 		    => "hide_in_vc_editor",
           "admin_label" 	=> true,
           "heading"		=> esc_html__( "Icon Position", "eclat-shortcodes" ),
           "param_name"	    => "icon_position",
           "value"			=> array(
               esc_html__( "Top", "eclat-shortcodes" )	 => "top",
               esc_html__( "Left", "eclat-shortcodes" )  => "left",
               esc_html__( "Right", "eclat-shortcodes" ) => "right"
           ),
           "std"			=> "top"
       ),

       array(
           "type"			=> "dropdown",
           "class" 		    => "hide_in_vc_editor",
           "admin_label" 	=> true,
           "heading"		=> esc_html__( "Icon Style", "eclat-shortcodes" ),
           "param_name"	    => "icon_style",
           "value"			=> array(
               esc_html__( "Normal", "eclat-shortcodes" )	        => "normal",
               esc_html__( "Outlined", "eclat-shortcodes" )	        => "outlined",
               esc_html__( "Background Color", "eclat-shortcodes" )	=> "bg_color"
           ),
           "std"			=> "normal"
       ),

       array(
           "type"			=> "colorpicker",
           "class" 		    => "hide_in_vc_editor",
           "admin_label" 	=> true,
           "heading"		=> esc_html__( "Icon Color", "eclat-shortcodes" ),
           "param_name"	    => "icon_color",
           "value"			=> "#333"
       ),

       array(
           "type"			=> "colorpicker",
           "class" 		    => "hide_in_vc_editor",
           "admin_label" 	=> true,
           "heading"		=> esc_html__( "Icon Background Color", "eclat-shortcodes" ),
           "param_name"	    => "icon_bg_color",
           "value"			=> "",
           "dependency" 	=> Array(
               "element"    => "icon_style",
               "value"      => array("bg_color")
           )
       ),

       array(
           "type" 			=> "textarea_html",
           "class" 		    => "hide_in_vc_editor",
           "admin_label" 	=> true,
           "heading" 		=> esc_html__( "Description", "eclat-shortcodes" ),
           "param_name" 	=> "content",
           "value" 		    => ""
       ),

       array(
           "type" 			=> "textfield",
           "class" 		    => "hide_in_vc_editor",
           "admin_label" 	=> true,
           "heading" 		=> esc_html__( "Link Text", "eclat-shortcodes" ),
           "param_name" 	=> "link_name",
           "value" 		    => ""
       ),

       array(
           "type" 			=> "textfield",
           "class" 		    => "hide_in_vc_editor",
           "admin_label" 	=> true,
           "heading" 		=> esc_html__( "Link URL", "eclat-shortcodes" ),
           "param_name" 	=> "link_url",
           "value" 		    => ""
       ),

       array(
           "type" 			=> "textfield",
           "class" 		    => "hide_in_vc_editor",
           "admin_label" 	=> true,
           "heading" 		=> esc_html__( "Extra class name", "eclat-shortcodes" ),
           "param_name" 	=> "el_class",
           "value" 		    => ""
       )

   )
   
));