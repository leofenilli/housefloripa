<?php the_post(); ?>

<?php if (get_the_author_meta('description')) : ?>
<div class="uk-panel uk-panel-box uk-margin tm-author-block">

    <div class="uk-align-medium-left">

        <?php echo get_avatar(get_the_author_meta('user_email')); ?>

    </div>

    <h2 class="uk-h3 uk-margin-remove"><?php the_author(); ?></h2>

    <div><?php the_author_meta('description'); ?></div>

</div>
<?php endif; ?>

<?php rewind_posts(); ?>
<?php if (have_posts()) : ?>

    <?php echo $this->render('_posts'); ?>

    <?php
    if(false){
        the_posts_pagination( array( 'mid_size' => 2 ) );
    } else {
        echo $this->render("_pagination", array("type"=>"posts"));
    }
    ?>

<?php endif; ?>