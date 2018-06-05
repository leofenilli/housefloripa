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

    <h1><?php esc_html_e('Not Found', 'eclat'); ?></h1>
    <p><?php esc_html_e("Sorry, but you are looking for something that isn't here.", "eclat"); ?></p>
    <?php get_search_form(); ?>

<?php endif; ?>