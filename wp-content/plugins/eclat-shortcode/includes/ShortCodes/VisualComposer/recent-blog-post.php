<?php

// [recent_blog_posts]
$args = array(
	'type'                     => 'post',
	'child_of'                 => 0,
	'parent'                   => '',
	'orderby'                  => 'name',
	'order'                    => 'ASC',
	'hide_empty'               => 1,
	'hierarchical'             => 1,
	'exclude'                  => '',
	'include'                  => '',
	'number'                   => '',
	'taxonomy'                 => 'category',
	'pad_counts'               => false
);

$categories = get_categories($args);

$output_categories = array();

$output_categories["All"] = "";

foreach($categories as $category) { 
	$output_categories[htmlspecialchars_decode($category->name)] = $category->slug;
}

vc_map(array(
   "name"			=> esc_html__( "Recent Blog Posts", "eclat-shortcodes" ),
   "category"		=> "Content",
   "description"	=> esc_html__( "Display the latest posts in the blog", "eclat-shortcodes" ),
   "base"			=> "recent_blog_posts",
   "class"			=> "",
   "icon"			=> "recent_blog_posts",

   
   "params" 	=> array(
      
       array(
           "type" => "textfield",
           "holder" => "div",
           "class" => "hide_in_vc_editor",
           "admin_label" => true,
           "heading" => esc_html__( "Number of Posts", "eclat-shortcodes" ),
           "param_name" => "posts",
           "value" => "3",
           "description" => esc_html__( "Number of posts to be displayed.", "eclat-shortcodes" )
       ),

       array(
           "type" => "dropdown",
           "holder" => "div",
           "class" => "hide_in_vc_editor",
           "admin_label" => true,
           "heading" => esc_html__( "Category", "eclat-shortcodes" ),
           "param_name" => "category",
           "value" => $output_categories
       ),

       array(
           "type"          => "dropdown",
           "class"         => "hide_in_vc_editor",
           "admin_label"   => true,
           "heading"       => esc_html__( "Use Scrollspy", "eclat-shortcodes" ),
           "param_name"    => "scrollspy",
           "value"         => array(
               esc_html__( "No", "eclat-shortcodes" )	=> "no",
               esc_html__( "Yes", "eclat-shortcodes" )	=> "yes"
           )
       ),

       array(
           "type"          => "dropdown",
           "class"         => "hide_in_vc_editor",
           "admin_label"   => true,
           "heading"       => esc_html__( "Scrollspy Class", "eclat-shortcodes" ),
           "param_name"    => "scrollspy_class",
           "value" => array(
               esc_html__( "The element fades in", "eclat-shortcodes" ) => "uk-animation-fade",
               esc_html__( "The element scales up", "eclat-shortcodes" ) => "uk-animation-scale-up",
               esc_html__( "The element scales down", "eclat-shortcodes" ) => "uk-animation-scale-down",
               esc_html__( "The element slides in from the top", "eclat-shortcodes" ) => "uk-animation-slide-top",
               esc_html__( "The element slides in from the bottom", "eclat-shortcodes" ) => "uk-animation-slide-bottom",
               esc_html__( "The element slides in from the left", "eclat-shortcodes" ) => "uk-animation-slide-left",
               esc_html__( "The element slides in from the Right", "eclat-shortcodes" ) => "uk-animation-slide-right",
               esc_html__( "The element shakes", "eclat-shortcodes" ) => "uk-animation-shake",
               esc_html__( "The element scales down without fading in", "eclat-shortcodes" ) => "uk-animation-scale"
           ),
           "dependency" 	=> Array('element' => "scrollspy", 'value' => array('yes'))
       ),

       array(
           "type"          => "dropdown",
           "class"         => "hide_in_vc_editor",
           "admin_label"   => true,
           "heading"       => esc_html__( "Scrollspy Repeat", "eclat-shortcodes" ),
           "param_name"    => "scrollspy_repeat",
           "value"         => array(
               esc_html__( "True", "eclat-shortcodes" )      => "true",
               esc_html__( "False", "eclat-shortcodes" )     => "false"
           ),
           "dependency" 	=> Array('element' => "scrollspy", 'value' => array('yes')),
           "description"   => esc_html__( "Applies the class everytime the element appears in the viewport.", "eclat-shortcodes" )
       ),

       array(
           "type"          => "textfield",
           "class"         => "hide_in_vc_editor",
           "admin_label"   => true,
           "heading"       => esc_html__( "Scrollspy Delay", "eclat-shortcodes" ),
           "param_name"    => "scrollspy_delay",
           "value"         => "300",
           "dependency" 	=> Array('element' => "scrollspy", 'value' => array('yes')),
           "description"   => esc_html__( "Adds a delay in milliseconds to the animation.", "eclat-shortcodes" )
       )
   )
   
));