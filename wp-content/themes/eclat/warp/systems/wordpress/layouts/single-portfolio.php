 <?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>

    <article class="uk-article portfolio <?php echo $post_format; ?>" data-permalink="<?php the_permalink(); ?>">

        <?php the_content(''); ?>

        <?php
            $prev = get_next_post();
            $next = get_previous_post();
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

    </article>

    <?php endwhile; ?>
 <?php endif; ?>