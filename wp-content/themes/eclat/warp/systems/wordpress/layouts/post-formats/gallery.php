<?php
/**
 * @package   Warp Theme Framework
 * @author    Elartica Team http://www.elartica.com
 * @copyright Copyright (C) Elartica Team
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

$attachments = get_posts( array(
        'post_type' 	=> 'attachment',
        'numberposts' 	=> -1,
        'post_status' 	=> null,
        'post_parent' 	=> get_the_ID(),
        'post_mime_type'=> 'image',
        'orderby'		=> 'menu_order',
        'order'			=> 'ASC'
    )
);
?>
    <div class="tm-post-format uk-slidenav-position" data-uk-slideshow="{animation: 'scale'}">
        <ul class="uk-slideshow">
            <?php foreach($attachments as $attachment) { ?>
                <li><?php echo wp_get_attachment_image( $attachment->ID, 'blog_big' ); ?></li>
            <?php } ?>
        </ul>
        <a href="#" class="uk-slidenav uk-slidenav-contrast uk-slidenav-previous" data-uk-slideshow-item="previous" style="color: rgba(255,255,255,0.4)"></a>
        <a href="#" class="uk-slidenav uk-slidenav-contrast uk-slidenav-next" data-uk-slideshow-item="next" style="color: rgba(255,255,255,0.4)"></a>
    </div>