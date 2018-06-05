<?php
/**
 * @package   Warp Theme Framework
 * @author    Elartica Team http://www.elartica.com
 * @copyright Copyright (C) Elartica Team
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

if (has_post_thumbnail()) : ?>
    <div class="tm-post-format">
        <?php the_post_thumbnail('blog_big', array('class' => '')); ?>
    </div>
<?php endif; ?>