<?php if (have_posts()) : ?>

    <?php
        // loop result
        while (have_posts()) {
            the_post();

            ?>
                <article id="item-<?php the_ID(); ?>" class="uk-article search-result">

                    <div class="uk-article-top-meta">
                        <div class="uk-article-date"><span class="tm-icon-date"></span><span class="time"><?php echo '<time datetime="'.get_the_date('Y-m-d').'">'.get_the_date().'</time>'; ?></span></div>
                        <h2 class="uk-article-title"><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
                    </div>

                    <?php the_excerpt(); ?>

                    <ul class="uk-subnav uk-subnav-line">
                        <li><a class="animate-border" href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php esc_html_e('Continue Reading', 'eclat'); ?></a></li>
                        <?php edit_post_link('<span class="uk-icon-pencil"></span>', '<li>','</li>'); ?>
                    </ul>

                    <div class="uk-flex uk-flex-middle uk-flex-space-between">
                        <div class="uk-article-meta">
                            <?php
                            printf(esc_html__('Written by %s. Posted in %s', 'eclat'), '<a href="'.get_author_posts_url(get_the_author_meta('ID')).'" title="'.get_the_author().'">'.get_the_author().'</a>', get_the_category_list(', '));
                            ?>
                        </div>
                        <?php if(comments_open() || get_comments_number()) : ?>
                            <div class="uk-article-comments"><span class="tm-icon-comment"></span><?php comments_popup_link('0', '1', '%', '', ""); ?></div>
                        <?php endif; ?>
                    </div>

                </article>
            <?php
        }
    ?>

    <?php
    if(false){
        the_posts_pagination( array( 'mid_size' => 2 ) );
    } else {
        echo $this->render("_pagination", array("type"=>"posts"));
    }
    ?>

<?php else : ?>

    <div class="uk-alert uk-alert-warning uk-alert-inline" data-uk-alert>
        <a class="uk-alert-close uk-close" href=""></a><h3><?php esc_html_e('Warning!', 'eclat'); ?></h3>
        <p><?php esc_html_e('No posts found. Try a different search?', 'eclat'); ?></p>
    </div>
    <?php //get_search_form(); ?>

<?php endif; ?>