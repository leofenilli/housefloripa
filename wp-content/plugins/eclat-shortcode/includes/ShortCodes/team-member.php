<?php

// [team_member]
function team_member_shortcode($params = array(), $content = '') {
    extract(shortcode_atts(array(
        "type" => 'vertical',
        "avatar" => '',
        "img_size" => 'full',
        "name" => '',
        "position" => '',
        "email" => '',
        "twitter" => '',
        "facebook" => '',
        "linkedin" => '',
        "instagram" => '',
        "skype_name" => '',
    ), $params));

    if ( is_numeric( $avatar ) ) {
        $image = wp_get_attachment_image( $avatar, $img_size );
    } else {
        $image = '';
    }

    ob_start();

    ?>

    <div class="tm-team-member-block block_<?php echo esc_html($type); ?>">

        <?php if($type == "horizontal") { ?>
            <div class="uk-grid"><div class="uk-width-1-1 uk-width-large-1-2">
        <?php } ?>

        <div class="tm-team-member-image">
            <?php echo $image; ?>
            <div class="tm-team-member-menu">
                <ul>
                    <?php if($email != "" && false) { ?>
                        <li></li>
                    <?php } ?>
                    <?php if($twitter != "") { ?>
                        <li><a href="<?php echo esc_url($twitter); ?>" target="_blank"><span class="uk-icon-twitter"></span></a></li>
                    <?php } ?>
                    <?php if($facebook != "") { ?>
                        <li><a href="<?php echo esc_url($facebook); ?>" target="_blank"><span class="uk-icon-facebook"></span></a></li>
                    <?php } ?>
                    <?php if($linkedin != "") { ?>
                        <li><a href="<?php echo esc_url($linkedin); ?>" target="_blank"><span class="uk-icon-linkedin"></span></a></li>
                    <?php } ?>
                    <?php if($instagram != "") { ?>
                        <li><a href="<?php echo esc_url($instagram); ?>" target="_blank"><span class="uk-icon-instagram"></span></a></li>
                    <?php } ?>
                    <?php if($skype_name != "") { ?>
                        <li><a href="skype:<?php echo esc_html($skype_name); ?>?call" target="_blank"><span class="uk-icon-skype"></span></a></li>
                    <?php } ?>
                </ul>
            </div>
        </div>

        <?php if($type == "horizontal") { ?>
            </div><div class="uk-width-1-1 uk-width-large-1-2">
        <?php } ?>

        <h3><?php echo esc_html($name); ?></h3>
        <div class="tm-team-member-position"><?php echo esc_html($position); ?></div>
        <?php if($email != "") { ?>
        <div class="tm-team-member-email"><?php _e( "E-mail", "eclat-shortcodes" )?>: <a href="mailto:<?php echo esc_html($email); ?>" target="_blank"><?php echo esc_html($email); ?></a></div>
        <?php } ?>
        <div class="tm-team-member-content"><p><?php echo do_shortcode($content); ?></p></div>

        <?php if($type == "horizontal") { ?>
            </div></div>
        <?php } ?>
    </div>

    <?php

    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}

add_shortcode("team_member", "team_member_shortcode");