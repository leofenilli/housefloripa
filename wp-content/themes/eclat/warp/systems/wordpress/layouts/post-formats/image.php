<?php
/**
 * @package   Warp Theme Framework
 * @author    Elartica Team http://www.elartica.com
 * @copyright Copyright (C) Elartica Team
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

if (has_post_thumbnail()) :
    $full_img_url = wp_get_attachment_url(get_post_thumbnail_id());
    ?>
    <a data-uk-lightbox title="<?php the_title(); ?>" class="tm-lightbox-hover" href="<?php echo preg_replace('/-e[0-9]{13}/', '', $full_img_url);?>"><?php the_post_thumbnail('blog_big', array('class' => '')); ?></a>
<?php endif; ?>