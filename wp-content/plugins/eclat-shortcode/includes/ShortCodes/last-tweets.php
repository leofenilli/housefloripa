<?php

// [product_categories_slider]
function last_tweets_shortcode( $params = array() )
{
    extract( shortcode_atts( array(
        'username' => '',
        'consumer_key' => '',
        'consumer_secret' => '',
        'access_token' => '',
        'access_token_secret' => '',
        'items' => '',
        'time' => 'true',
        'name' => 'true',
        'actions' => 'true',
        'follow' => 'true',
        'animation' => 'fade',
        'autoplay' => 'false',
        'pause' => 'true',
        'autoplayinterval' => '7000'
    ), $params ) );

    $follow_markup = '';

    ob_start();

    $twitter_data = eclat_shortcode_get_tweets_posts( esc_attr( $access_token ), esc_attr( $access_token_secret ), esc_attr( $consumer_key ), esc_attr( $consumer_secret ), esc_attr( $items ) );

    if ( ! isset( $twitter_data->errors ) && count($twitter_data) )
    {

        $class = 'uk-slideset tm-last-tweets';

        echo '<div class="tm-list-tweets">
                <span class="tm-icon-twitter"></span>
                <div data-uk-slideset="{default: 1, animation: \''.esc_attr( $animation ).'\', duration: 200, autoplay: '.esc_attr( $autoplay ).', pauseOnHover: '.esc_attr( $pause ).', autoplayInterval: '.esc_attr( $autoplayinterval ).'}">
                <ul class="'.$class.'">';

        foreach ($twitter_data as $tweet)
        {
            if (!empty($tweet))
            {
                //$time = strftime('%d.%m.%Y %H:%M:%S', strtotime($tweet->created_at));
                $time = eclat_shortcode_get_time_ago(strtotime($tweet->created_at));
                ?>

                <li class="tweet_<?php echo esc_attr( $tweet->id_str ); ?>">

                <?php if ($time == "true") { ?>
                    <div class="tm-last-tweets-meta"><?php echo esc_attr( $time ); ?></div>
                <?php  } ?>
                <?php if ($name == "true") { ?>
                    <div class="tm-last-tweets-user">@<?php echo esc_attr( $tweet->user->name ); ?></div>
                <?php } ?>

                <div class="tm-last-tweets"><?php echo esc_html( $tweet->text ); ?></div>

                <?php if ($actions == "true") { ?>
                    <div class="tm-last-tweets-actions">
                            <a target="_blank" title="<?php _e('Reply', 'eclat-shortcodes'); ?>" href="https://twitter.com/intent/tweet?in_reply_to=<?php echo esc_attr( $tweet->id_str ); ?>"><span class="tm-icon-back"></span></a>
                            <a target="_blank" title="<?php _e('Retweet', 'eclat-shortcodes'); ?>" href="https://twitter.com/intent/retweet?tweet_id=<?php echo esc_attr( $tweet->id_str ); ?>"><span class="tm-icon-refresh"></span></a>
                            <a target="_blank" title="<?php _e('Favourite', 'eclat-shortcodes'); ?>" href="https://twitter.com/intent/favorite?tweet_id=<?php echo esc_attr( $tweet->id_str ); ?>"><span class="tm-icon-star"></span></a>
                    </div>
                <?php } ?>

                </li>
            <?php
            }
        }

        echo '</ul>';
        echo '</div>';

        if ( $follow == 'true' )
        {
            echo '<p id="follow-twitter"><a class="animate-border" href="https://twitter.com/intent/user?screen_name=' . esc_attr( $username ) . '" target="_blank">' . apply_filters( 'follow_us_twitter_widget', esc_html__( 'Follow us on Twitter', 'eclat-shortcodes' ) ) . '</a>';
        }

        echo '</div>';
    }

    $content = ob_get_contents();
    ob_end_clean();

    return $content;
}

add_shortcode("last_tweets", "last_tweets_shortcode");

