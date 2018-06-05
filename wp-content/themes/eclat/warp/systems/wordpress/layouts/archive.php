<?php if (have_posts()) : ?>

    <?php echo $this->render('_posts'); ?>

    <?php
    if(false){
        the_posts_pagination( array( 'mid_size' => 2 ) );
    } else {
        echo $this->render("_pagination", array("type"=>"posts"));
    }
    ?>

<?php else : ?>

    <?php if (is_category()) : ?>
        <div class="uk-alert uk-alert-warning uk-alert-inline" data-uk-alert>
            <a class="uk-alert-close uk-close" href=""></a><h3><?php esc_html_e('Warning!', 'eclat'); ?></h3>
            <p><?php printf(esc_html__("Sorry, but there aren't any posts in the %s category yet.", "eclat"), single_cat_title('', false)); ?></p>
        </div>
    <?php elseif (is_date()) : ?>
        <div class="uk-alert uk-alert-warning uk-alert-inline" data-uk-alert>
            <a class="uk-alert-close uk-close" href=""></a><h3><?php esc_html_e('Warning!', 'eclat'); ?></h3>
            <p><?php esc_html_e("Sorry, but there aren't any posts with this date.", "eclat"); ?></p>
        </div>
    <?php elseif (is_author()) : ?>
        <?php $userdata = get_userdatabylogin(get_query_var('author_name')); ?>
        <div class="uk-alert uk-alert-warning uk-alert-inline" data-uk-alert>
            <a class="uk-alert-close uk-close" href=""></a><h3><?php esc_html_e('Warning!', 'eclat'); ?></h3>
            <p><?php printf(esc_html__("Sorry, but there aren't any posts by %s yet.", "eclat"), $userdata->display_name); ?></p>
        </div>
    <?php else : ?>
        <div class="uk-alert uk-alert-warning uk-alert-inline" data-uk-alert>
            <a class="uk-alert-close uk-close" href=""></a><h3><?php esc_html_e('Warning!', 'eclat'); ?></h3>
            <p><?php esc_html_e("No posts found.", "eclat"); ?></p>
        </div>
    <?php endif; ?>

    <?php //get_search_form(); ?>

<?php endif; ?>