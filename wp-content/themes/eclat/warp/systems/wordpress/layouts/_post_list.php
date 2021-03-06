<article id="item-<?php the_ID(); ?>" class="uk-article <?php echo $post_format; ?>" data-permalink="<?php the_permalink(); ?>">
    <?php if($post_format != "standard") : ?>
        <span class="post-format-ico tm-icon-<?php echo $post_format; ?>"></span>
    <?php endif; ?>

    <?php if (has_post_thumbnail()) : ?>
        <div class="uk-article-thumbnail">
            <a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail('blog_big', array('class' => '')); ?></a>
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

    <?php the_content(''); ?>

    <ul class="uk-subnav uk-subnav-line">
        <li><a class="animate-border" href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php esc_html_e('Continue Reading', 'eclat'); ?></a></li>
        <?php edit_post_link('<span class="uk-icon-pencil"></span>', '<li>','</li>'); ?>
    </ul>

    <div class="uk-flex uk-flex-middle uk-flex-space-between">
        <div class="uk-article-meta">
            <?php printf(
                esc_html__('Written by %s. Posted in %s', 'eclat'),
                '<a href="'.get_author_posts_url(get_the_author_meta('ID')).'" title="'.get_the_author().'">'.get_the_author().'</a>',
                get_the_category_list(', ')
            ); ?>
        </div>
        <?php if(comments_open() || get_comments_number()) : ?>
            <div class="uk-article-comments"><span class="tm-icon-comment"></span><?php comments_popup_link('0', '1', '%', '', ""); ?></div>
        <?php endif; ?>
    </div>

</article>