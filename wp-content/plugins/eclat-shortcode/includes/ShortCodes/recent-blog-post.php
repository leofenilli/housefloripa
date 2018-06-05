<?php

// [recent_blog_posts]
function recent_blog_posts_shortcode($params = array(), $content = '') {
	extract(shortcode_atts(array(
		"posts" => '3',
		"category" => '',
        'scrollspy' => 'no',
        'scrollspy_class' => '',
        'scrollspy_repeat' => 'false',
        'scrollspy_delay' => '300'
	), $params));

    if($scrollspy == "yes" && $scrollspy_class != ''){
        $scrollspy_html = ' data-uk-scrollspy="{cls:\'' . esc_attr( $scrollspy_class ) . ' uk-invisible\', target:\'.uk-width-1-1\', repeat: ' . esc_attr( $scrollspy_repeat ) . ', delay:' . esc_attr( $scrollspy_delay ) . '}"';
        $scrollspy_class = ' uk-invisible';
    } else {
        $scrollspy_html = $scrollspy_class = '';
    }

    ob_start();
	?>

	
    <div class="uk-grid recent-blog-posts"<?php echo $scrollspy_html; ?>>
					
        <?php
        $args = array(
            'post_status' => 'publish',
            'post_type' => 'post',
            'category_name' => esc_attr( $category ),
            'posts_per_page' => esc_attr( $posts )
        );

        $recentPosts = new WP_Query( $args );
            
        if ( $recentPosts->have_posts() ) : ?>
                        
            <?php while ( $recentPosts->have_posts() ) : $recentPosts->the_post(); ?>
            
                <?php

                $post_format = get_post_format(get_the_ID());

                if ( false === $post_format )
                    $post_format = 'standard';

                ?>
                    
                <div class="uk-width-1-1 uk-width-medium-1-3<?php echo $scrollspy_class; ?>">

                    <article id="item-<?php the_ID(); ?>" class="uk-article <?php echo esc_attr( $post_format );?> grid" data-permalink="<?php the_permalink(); ?>">
                        <?php if($post_format != "standard") : ?>
                            <span class="post-format-ico tm-icon-<?php echo esc_attr( $post_format ); ?>"></span>
                        <?php endif; ?>

                        <?php if (has_post_thumbnail()) : ?>
                            <div class="uk-article-thumbnail">
                                <a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>">
                                    <span class="uk-visible-large"><?php the_post_thumbnail('blog_small', array('class' => '')); ?></span>
                                    <span class="uk-hidden-large"><?php the_post_thumbnail('blog_big', array('class' => '')); ?></span>
                                </a>
                                <div class="uk-article-top-meta">
                                    <div class="uk-article-date"><span class="tm-icon-date"></span><span class="time"><?php echo '<time datetime="'.get_the_date('Y-m-d').'">'.get_the_date().'</time>'; ?></span></div>
                                    <h2 class="uk-article-title"><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
                                </div>
                            </div>
                        <?php else : ?>
                            <div class="uk-article-top-meta">
                                <div class="uk-article-date"><span class="tm-icon-date"></span><span class="time"><?php echo '<time datetime="'.get_the_date('Y-m-d').'">'.get_the_date().'</time>'; ?></span></div>
                                <h2 class="uk-article-title"><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
                            </div>
                        <?php endif; ?>

                    </article>

                </div>
        
            <?php endwhile; ?>
                
        <?php

        endif;
            
        ?>
              
    </div>
	
	<?php
	wp_reset_query();
	$content = ob_get_contents();
	ob_end_clean();
	return $content;
}

add_shortcode("recent_blog_posts", "recent_blog_posts_shortcode");