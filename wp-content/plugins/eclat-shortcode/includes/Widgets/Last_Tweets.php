<?php
/**
 * @package   Warp Theme Framework
 * @author    MyTheme http://www.mytheme.com
 * @copyright Copyright (C) MyTheme GmbH
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

class Warp_Last_Tweets extends WP_Widget
{
    public function Warp_Last_Tweets()
    {
        $widget_ops = array('description' => esc_html__( 'Display the last tweets posts into your site.', 'eclat-shortcodes' ));
        parent::__construct(false, esc_html__( 'Eclat - Last Tweets', 'eclat-shortcodes' ), $widget_ops);
    }

    public function widget($args, $instance)
    {
        extract( $args );

        $title = apply_filters( 'widget_title', $instance['title'] );

        echo $before_widget;

        echo $before_title . esc_html( $title ) . $after_title;

        $username            = ( isset( $instance['username'] ) && $instance['username'] != '' ) ? $instance['username'] : '';
        $access_token        = ( isset( $instance['access_token'] ) && $instance['access_token'] != '' ) ? $instance['access_token'] : '';
        $access_token_secret = ( isset( $instance['access_token_secret'] ) && $instance['access_token_secret'] != '' ) ? $instance['access_token_secret'] : '';
        $consumer_key        = ( isset( $instance['consumer_key'] ) && $instance['consumer_key'] != '' ) ? $instance['consumer_key'] : '';
        $consumer_secret     = ( isset( $instance['consumer_secret'] ) && $instance['consumer_secret'] != '' ) ? $instance['consumer_secret'] : '';

        $twitter_data = eclat_shortcode_get_tweets_posts( esc_attr( $access_token ), esc_attr( $access_token_secret ), esc_attr( $consumer_key ), esc_attr( $consumer_secret ), esc_attr( $instance['limit'] ) );

        if ( ! isset( $twitter_data->errors ) && count( $twitter_data ) )
        {
            echo '<div class="tm-list-tweets">
                <span class="tm-icon-twitter"></span>
                <div data-uk-slideset="{default: 1, autoplay: true}">
                <ul class="uk-slideset tm-last-tweets">';

            foreach ($twitter_data as $tweet)
            {
                if (!empty($tweet))
                {
                    //$time = strftime('%d.%m.%Y %H:%M:%S', strtotime($tweet->created_at));
                    $time = eclat_shortcode_get_time_ago(strtotime($tweet->created_at));

                    echo '<li class="tweet_' .  esc_attr( $tweet->id_str ) . '">';

                    if ($instance['time']) {
                        echo '<div class="tm-last-tweets-meta">' .  esc_attr( $time ) . '</div>';
                    }
                    if ($instance['name']) {
                        echo '<div class="tm-last-tweets-user">@' . esc_html( $tweet->user->name ) . '</div>';
                    }

                    echo '<div class="tm-last-tweets">' . esc_html( $tweet->text ) . '</div>';

                    if ($instance['actions']) {
                        echo '<div class="tm-last-tweets-actions">
                            <a target="_blank" title="' . esc_html__('Reply', 'eclat-shortcodes') . '" href="https://twitter.com/intent/tweet?in_reply_to=' . esc_attr( $tweet->id_str ) . '"><span class="tm-icon-back"></span></a>
                            <a target="_blank" title="' . esc_html__('Retweet', 'eclat-shortcodes') . '" href="https://twitter.com/intent/retweet?tweet_id=' . esc_attr( $tweet->id_str ) . '"><span class="tm-icon-refresh"></span></a>
                            <a target="_blank" title="' . esc_html__('Favourite', 'eclat-shortcodes') . '" href="https://twitter.com/intent/favorite?tweet_id=' . esc_attr( $tweet->id_str ) . '"><span class="tm-icon-star"></span></a>
                        </div>';
                    }

                    echo '</li>';
                }

            }
            echo '</ul>';
            echo '</div>';

            if ( isset( $instance['follow'] ) && $instance['follow'] == 'true' )
            {
                echo '<p id="follow-twitter"><a class="animate-border" href="https://twitter.com/intent/user?screen_name=' . $username . '" target="_blank">' . apply_filters( 'follow_us_twitter_widget', esc_html__( 'Follow us on Twitter', 'eclat-shortcodes' ) ) . '</a>';
            }

            echo '</div>';
        }

        echo $after_widget;
    }

    public function form($instance)
    {
        $defaults = array(
            'title'               => esc_html__( 'Last Tweets', 'eclat-shortcodes' ),
            'username'            => '',
            'consumer_key'        => '',
            'consumer_secret'     => '',
            'access_token'        => '',
            'access_token_secret' => '',
            'limit'               => 3,
            'time'                => 'true',
            'name'                => 'true',
            'actions'             => 'true',
            'follow'              => 'true'
        );

        $instance = wp_parse_args( (array) $instance, $defaults ); ?>

        <p>
            <label>
                <?php _e( 'Title', 'eclat-shortcodes' ); ?>:<br />
                <input class="widefat" type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
            </label>
        </p>

        <p>
            <label>
                <?php _e( 'Username', 'eclat-shortcodes' ); ?>:<br />
                <input class="widefat" type="text" id="<?php echo $this->get_field_id( 'username' ); ?>" name="<?php echo $this->get_field_name( 'username' ); ?>" value="<?php echo $instance['username']; ?>" />
            </label>
        </p>

        <p>
            <label>
                <?php _e( 'Consumer key', 'eclat-shortcodes' ); ?>:<br />
                <input class="widefat" type="text" id="<?php echo $this->get_field_id( 'consumer_key' ); ?>" name="<?php echo $this->get_field_name( 'consumer_key' ); ?>" value="<?php echo $instance['consumer_key']; ?>" />
            </label>
        </p>

        <p>
            <label>
                <?php _e( 'Consumer secret', 'eclat-shortcodes' ); ?>:<br />
                <input class="widefat" type="text" id="<?php echo $this->get_field_id( 'consumer_secret' ); ?>" name="<?php echo $this->get_field_name( 'consumer_secret' ); ?>" value="<?php echo $instance['consumer_secret']; ?>" />
            </label>
        </p>

        <p>
            <label>
                <?php _e( 'Access token', 'eclat-shortcodes' ); ?>:<br />
                <input class="widefat" type="text" id="<?php echo $this->get_field_id( 'access_token' ); ?>" name="<?php echo $this->get_field_name( 'access_token' ); ?>" value="<?php echo $instance['access_token']; ?>" />
            </label>
        </p>

        <p>
            <label>
                <?php _e( 'Access token secret', 'eclat-shortcodes' ); ?>:<br />
                <input class="widefat" type="text" id="<?php echo $this->get_field_id( 'access_token_secret' ); ?>" name="<?php echo $this->get_field_name( 'access_token_secret' ); ?>" value="<?php echo $instance['access_token_secret']; ?>" />
            </label>
        </p>

        <p>
            <label>
                <?php _e( 'Limit', 'eclat-shortcodes' ); ?>:
                <select id="<?php echo $this->get_field_id( 'limit' ); ?>" name="<?php echo $this->get_field_name( 'limit' ); ?>">

                    <?php for ( $i = 1; $i <= 10; $i ++ ) : $selected = ( $instance['limit'] == $i ) ? ' selected="selected"' : '' ?>
                        <option value="<?php echo $i ?>"<?php echo $selected ?>><?php echo $i ?></option>
                    <?php endfor ?>

                </select>
            </label>
        </p>

        <p>
            <label>
                <?php $checked = ( $instance['time'] == 'true' ) ? ' checked=""' : '' ?>
                <input type="checkbox" id="<?php echo $this->get_field_id( 'time' ); ?>" name="<?php echo $this->get_field_name( 'time' ); ?>" value="true"<?php echo $checked ?> />
                <?php _e( 'Show Time', 'eclat-shortcodes' ); ?>
            </label>
        </p>

        <p>
            <label>
                <?php $checked = ( $instance['time'] == 'true' ) ? ' checked=""' : '' ?>
                <input type="checkbox" id="<?php echo $this->get_field_id( 'name' ); ?>" name="<?php echo $this->get_field_name( 'name' ); ?>" value="true"<?php echo $checked ?> />
                <?php _e( 'Show Username', 'eclat-shortcodes' ); ?>
            </label>
        </p>

        <p>
            <label>
                <?php $checked = ( $instance['time'] == 'true' ) ? ' checked=""' : '' ?>
                <input type="checkbox" id="<?php echo $this->get_field_id( 'actions' ); ?>" name="<?php echo $this->get_field_name( 'actions' ); ?>" value="true"<?php echo $checked ?> />
                <?php _e( 'Show actions link', 'eclat-shortcodes' ); ?>
            </label>
        </p>

        <p>
            <label>
                <?php $checked = ( $instance['follow'] == 'true' ) ? ' checked=""' : '' ?>
                <input type="checkbox" id="<?php echo $this->get_field_id( 'follow' ); ?>" name="<?php echo $this->get_field_name( 'follow' ); ?>" value="true"<?php echo $checked ?> />
                <?php _e( 'Show Follow link', 'eclat-shortcodes' ); ?>
            </label>
        </p>
    <?php
    }

    public function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['title'] = strip_tags( $new_instance['title'] );
        $instance['username'] = strip_tags( $new_instance['username'] );
        $instance['consumer_key'] = $new_instance['consumer_key'];
        $instance['consumer_secret'] = $new_instance['consumer_secret'];
        $instance['access_token'] = $new_instance['access_token'];
        $instance['access_token_secret'] = $new_instance['access_token_secret'];
        $instance['time'] = $new_instance['time'];
        $instance['name'] = $new_instance['name'];
        $instance['actions'] = $new_instance['actions'];
        $instance['limit'] = strip_tags( $new_instance['limit'] );
        $instance['follow'] = $new_instance['follow'];

        return $instance;
    }
}


add_action( 'widgets_init', function(){
    register_widget('Warp_Last_Tweets');
});

