 <?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post();
         $post_format = get_post_format();
         if ( false === $post_format )
             $post_format = 'standard';
         ?>

    <article class="uk-article single <?php echo $post_format; ?>" data-permalink="<?php the_permalink(); ?>">

        <h1><?php the_title(); ?></h1>

        <div class="uk-article-top-meta">
            <div class="uk-flex uk-flex-middle uk-flex-space-between">
                <div class="uk-article-date">
                    <span class="tm-icon-date"></span>
                    <span>
                        <?php echo '<time datetime="'.get_the_date('Y-m-d').'">'.get_the_date().'</time>'; ?>
                    </span>
                    <span class="uk-hidden-small">
                        <?php printf(esc_html__('by %s. Posted in %s', 'eclat'), '<a href="'.get_author_posts_url(get_the_author_meta('ID')).'" title="'.get_the_author().'">'.get_the_author().'</a>', get_the_category_list(', ')); ?>
                    </span>
                    <?php edit_post_link(esc_html__('Edit this post.', 'eclat'), '<span class="uk-hidden-small"><span class="uk-icon-pencil"></span> ','</span>'); ?>
                </div>
                <?php if(comments_open() || get_comments_number()) : ?>
                    <div class="uk-article-comments"><a href="#comments" data-uk-smooth-scroll><span class="tm-icon-comment"></span><?php echo get_comments_number(); ?></a></div>
                <?php endif; ?>
            </div>
        </div>

        <?php if($post_format != "quote") :
            echo $this->render('post-formats/'.$post_format, array('post_format' => $post_format));
        endif; ?>

        <?php if($post_format == "quote") : ?>
            <blockquote>
        <?php endif; ?>

        <?php the_content(''); ?>

        <?php if($post_format == "quote") : ?>
            </blockquote>
        <?php endif; ?>

        <?php wp_link_pages(); ?>

        <?php if (pings_open()) : ?>
            <p><?php printf( wp_kses( __('<a href="%s">Trackback</a> from your site.', 'eclat'), array( 'a' => array( 'href' => array() ) ) ), get_trackback_url()); ?></p>
        <?php endif; ?>

        <div class="uk-flex uk-flex-middle <?php echo get_the_tags() ? 'uk-flex-space-between' : 'uk-flex-right'?> uk-article-tag-block">
            <?php the_tags('<div class="uk-article-tag"><span class="tm-icon-tag"></span>'.esc_html__('Tags: ', 'eclat'), '', '</div>'); ?>
            <?php eclat_get_social_share( 'tm-svg-socials', array( 'envelope-o', 'pinterest-p', 'google-plus', 'twitter', 'facebook' ) ); ?>
        </div>

        <?php
        $prev = get_previous_post();
        $next = get_next_post();
        ?>

        <?php if ($this['config']->get('post_nav', 0) && ($prev || $next)) : ?>
            <ul class="uk-article-pagination uk-clearfix">
                <?php if ($next) : ?>
                    <li class="uk-pagination-next">
                        <a href="<?php echo get_permalink($next->ID) ?>" title="<?php esc_html_e('Next', 'eclat'); ?>">
                            <span><?php echo $next->post_title?></span>
                            <span class="tm-icon-arrow-long-right"></span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if ($prev) : ?>
                    <li class="uk-pagination-previous">
                        <a href="<?php echo get_permalink($prev->ID) ?>" title="<?php esc_html_e('Prev', 'eclat'); ?>">
                            <span class="tm-icon-arrow-long-left"></span>
                            <span><?php echo $prev->post_title?></span>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        <?php endif; ?>

        <?php if (get_the_author_meta('description')) : ?>
        <div class="uk-panel uk-panel-box tm-author-block<?php echo ($this['config']->get('post_nav', 0) && ($prev || $next)) ? ' uk-no-border' : ''; ?>">

            <div class="uk-align-medium-left">

                <?php echo get_avatar(get_the_author_meta('user_email'), $size='80'); ?>

            </div>

            <h2><?php the_author(); ?></h2>

            <div><?php the_author_meta('description'); ?></div>

        </div>
        <?php endif; ?>

        <?php comments_template(); ?>

    </article>

    <?php endwhile; ?>
 <?php endif; ?>