<?php
/**
* @package   Warp Theme Framework
* @author    Elartica Team http://www.elartica.com
* @copyright Copyright (C) Elartica Team
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

class Warp_Sidebar extends \WP_Widget
{
    public function Warp_Sidebar()
    {
        $widget_ops = array('description' => 'Display default Wordpress Sidebar');
        parent::__construct(false, 'Warp - Sidebar', $widget_ops);
    }

    public function widget($args, $instance)
    {
        global $warp, $wp_query;

        extract($args);

        $title = $instance['title'];

        echo $before_widget;

        if ($title) {
            echo $before_title . $title . $after_title;
        }

        $output = $warp['template']->get('sidebar.output', '');

        echo $output;

        echo $after_widget;

    }

    public function update($new_instance, $old_instance)
    {
        return $new_instance;
    }

    public function form($instance)
    {
        $title = esc_attr($instance['title']);
        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id('title') ) ?>"><?php esc_html_e('Title:','eclat') ?></label>
            <input type="text" name="<?php echo  esc_attr( $this->get_field_name('title') ) ?>"  value="<?php echo  esc_attr( $title ) ?>" class="widefat" id="<?php echo esc_attr( $this->get_field_id('title') ) ?>">
        </p>
<?php
    }
}

register_widget('Warp_Sidebar');
