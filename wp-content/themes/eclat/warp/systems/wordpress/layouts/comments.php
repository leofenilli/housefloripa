<?php if (comments_open() || have_comments()) : ?>

    <div id="comments" class="uk-margin">


        <?php if (have_comments()) : ?>

            <h2 class="uk-h3"><?php printf( wp_kses( __('Comments <span>(%s)</span>', 'eclat'), array( 'span' => array() ) ), get_comments_number()); ?></h2>

            <?php

                $classes = array("level1");

                if (get_option('comment_registration') && !is_user_logged_in()) {
                    $classes[] = "no-response";
                }

                if (get_option('thread_comments')) {
                    $classes[] = "nested";
                }

            ?>

            <ul class="uk-comment-list">
            <?php

                // single comment
                function mytheme_comment($comment, $args, $depth)
                {
                    global $user_identity;

                    $GLOBALS['comment'] = $comment;

                    $_GET['replytocom'] = get_comment_ID();
                    ?>
                    <li>
                        <article id="comment-<?php comment_ID(); ?>" class="uk-comment <?php echo ($comment->user_id > 0) ? 'uk-comment-primary' : '';?>">
                            <div class="uk-clearfix">
                                <div class="uk-comment-first-col"><?php echo get_avatar($comment, $size='80', null, 'Avatar'); ?></div>
                                <div class="uk-comment-last-col">
                                    <header class="uk-comment-header">

                                        <h3 class="uk-comment-title"><?php echo get_comment_author_link(); ?></h3>

                                        <p class="uk-comment-meta">
                                            <time datetime="<?php echo get_comment_date('Y-m-d'); ?>"><?php printf(esc_html__('%1$s at %2$s', 'eclat'), get_comment_date(), get_comment_time()) ?></time>
                                            | <a class="permalink" href="<?php echo htmlspecialchars(get_comment_link($comment->comment_ID)) ?>">#</a>
                                            <?php edit_comment_link(esc_html__('Edit', 'eclat'),'| ','') ?>
                                        </p>

                                    </header>

                                    <div class="uk-comment-body">

                                        <?php comment_text(); ?>

                                        <?php if (comments_open() && $args['max_depth'] > $depth) : ?>
                                        <p class="js-reply"><a href="#" rel="<?php comment_ID(); ?>"><span class="uk-icon-reply"></span> <?php esc_html_e('Reply', 'eclat'); ?></a></p>
                                        <?php endif; ?>

                                        <?php if ($comment->comment_approved == '0') : ?>
                                        <div class="uk-alert uk-alert-inline" data-uk-alert>
                                            <a class="uk-alert-close uk-close" href=""></a>
                                            <h3><?php esc_html_e('Information for you', 'eclat'); ?></h3>
                                            <?php esc_html_e('Your comment is awaiting moderation.', 'eclat'); ?>
                                        </div>
                                        <?php endif; ?>

                                    </div>
                                </div>
                            </div>
                        </article>
                    <?php
                    unset($_GET['replytocom']);

                    // </li> is rendered by system
                }

                wp_list_comments('type=all&callback=mytheme_comment');
            ?>
            </ul>

            <?php echo $this->render("_pagination", array("type"=>"comments")); ?>

        <?php endif; ?>


        <div id="respond">

            <h2 class="uk-h3"><?php (comments_open()) ? comment_form_title(esc_html__('Leave a comment', 'eclat')) : esc_html_e('Comments are closed', 'eclat'); ?></h2>

            <?php if (comments_open()) : ?>

                <?php if (get_option('comment_registration') && !is_user_logged_in()) : ?>
                    <div class="uk-alert uk-alert-inline uk-alert-warning" data-uk-alert>
                        <a class="uk-alert-close uk-close" href=""></a>
                        <h3><?php esc_html_e('Oh no!', 'eclat'); ?></h3>
                        <?php printf( wp_kses( __('You must be <a href="%s">logged in</a> to post a comment.', 'eclat'), array( 'a' => array( 'href' => array() ) ) ), wp_login_url(get_permalink())); ?>
                    </div>
                <?php else : ?>

                    <form class="uk-form" action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post">

                        <?php if (is_user_logged_in()) : ?>

                            <?php global $user_identity; ?>

                            <p><?php printf( wp_kses( __('Logged in as <a href="%s">%s</a>.', 'eclat'), array( 'a' => array( 'href' => array() ) ) ), get_option('siteurl').'/wp-admin/profile.php', $user_identity); ?> <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="<?php esc_html_e('Log out of this account', 'eclat'); ?>"><?php esc_html_e('Log out &raquo;', 'eclat'); ?></a></p>

                        <?php else : ?>

                            <?php $req = get_option('require_name_email');?>
                            <div class="uk-grid uk-grid-medium">
                                <div class="uk-width-1-1 uk-width-medium-1-3">
                                    <div class="form-group uk-margin-bottom">
                                        <input type="text" class="form-control" id="comments_form_author" name="author" value="<?php echo (isset($comment_author) ? esc_attr($comment_author) : ''); ?>" <?php if ($req) echo "aria-required='true'"; ?>>
                                        <label for="comments_form_author"><span><?php esc_html_e('Name', 'eclat'); ?> <?php if ($req) echo '<abbr title="required">*</abbr>'; ?></span></label>
                                    </div>
                                </div>
                                <div class="uk-width-1-1 uk-width-medium-1-3">
                                    <div class="form-group uk-margin-bottom">
                                        <input type="text" class="form-control" id="comments_form_email" name="email" value="<?php echo (isset($comment_author_email) ? esc_attr($comment_author_email) : ''); ?>" <?php if ($req) echo "aria-required='true'"; ?>>
                                        <label for="comments_form_email"><span><?php esc_html_e('E-mail', 'eclat'); ?> <?php if ($req) echo '<abbr title="required">*</abbr>'; ?></span></label>
                                    </div>
                                </div>
                                <div class="uk-width-1-1 uk-width-medium-1-3">
                                    <div class="form-group uk-margin-bottom">
                                        <input type="text" class="form-control" id="comments_form_url" name="url" value="<?php echo (isset($comment_author_url) ? esc_attr($comment_author_url) : ''); ?>">
                                        <label for="comments_form_url"><span><?php esc_html_e('Website', 'eclat'); ?></span></label>
                                    </div>
                                </div>
                            </div>

                        <?php endif; ?>

                        <div class="uk-form-row">
                            <div class="form-group textarea">
                                <textarea name="comment" id="comment" cols="80" rows="5" tabindex="4" class="form-control"></textarea>
                                <label for="comment"><span><?php esc_html_e('Comment', 'eclat'); ?></span></label>
                            </div>
                        </div>

                        <div class="uk-form-row actions">
                            <button class="uk-button" name="submit" type="submit" id="submit" tabindex="5"><?php esc_html_e('Submit Comment', 'eclat'); ?></button>
                            <?php comment_id_fields(); ?>
                        </div>
                        <?php global $post; do_action('comment_form', $post->ID); ?>

                    </form>

                <?php endif; ?>

            <?php endif; ?>

        </div>


    </div>

    <script type="text/javascript">

        jQuery(function($) {

            var respond = $("#respond");

            $("p.js-reply > a").bind("click", function(){

                var id = $(this).attr('rel');

                respond.find(".comment-cancelReply:first").remove();

                $('<a><?php esc_html_e("Cancel", "eclat");?></a>').addClass('comment-cancelReply uk-margin-left').attr('href', "#respond").bind("click", function(){
                    respond.find(".comment-cancelReply:first").remove();
                    respond.appendTo($('#comments')).find("[name=comment_parent]").val(0);

                    return false;
                }).appendTo(respond.find(".actions:first"));

                respond.find("[name=comment_parent]").val(id);
                respond.appendTo($("#comment-"+id));

                return false;

            });
        });

    </script>

<?php endif;
