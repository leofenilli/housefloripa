<?php
/**
 * @package   Warp Theme Framework
 * @author    Elartica Team http://www.elartica.com
 * @copyright Copyright (C) Elartica Team
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

$video_id = get_post_meta( get_the_ID(), 'video-id' );
if(is_array($video_id) && isset($video_id[0]))
    $video_id = preg_replace( '/[&|&amp;]feature=([\w\-]*)/', '', $video_id[0] );

$video_host = get_post_meta( get_the_ID(), 'video-host' );
if(is_array($video_host) && isset($video_host[0]))
    $video_host = $video_host[0];

$width = '100%';
$height = get_option('large_size_h');

?>
<div class="tm-post-format <?php echo $post_format ?>">
<?php
    switch ( $video_host ) {
        case 'youtube': ?>
            <div class="tm-post-video youtube">
                <iframe wmode="transparent" width="<?php echo $width; ?>" height="<?php echo $height; ?>" src="http://www.youtube.com/embed/<?php echo $video_id; ?>?wmode=transparent" frameborder="0" allowfullscreen></iframe>
            </div>
            <?php
            break;

        case 'vimeo': ?>
            <div class="tm-post-video vimeo">
                <iframe wmode="transparent" src="http://player.vimeo.com/video/<?php echo $video_id; ?>?title=0&amp;byline=0&amp;portrait=0" width="<?php echo $width; ?>" height="<?php echo $height; ?>" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
            </div>
            <?php
            break;
    }

?>
</div>