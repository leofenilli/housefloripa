<?php
/**
 * @package   Warp Theme Framework
 * @author    Elartica Team http://www.elartica.com
 * @copyright Copyright (C) Elartica Team
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */


//call the wp function add_metabox to add the metabox
add_action('add_meta_boxes', function()
{
    add_meta_box(
        'eclat_meta_box',
        'Meta Box',
        'show_meta_boxes',
        'post',
        'normal',
        'high');
});

function get_meta_boxes_fields(){
    $meta_boxes_fields = array(
        'video-id' => array(
            'label' => esc_html__( 'Video ID', 'eclat' ),
            'desc' => esc_html__( 'Insert the video ID.', 'eclat' ),
            'type' => 'text',
        ),
        'video-host' => array(
            'label' => esc_html__( 'Video host', 'eclat' ),
            'desc' => esc_html__( 'Select where is the video hosted.', 'eclat' ),
            'type' => 'select',
            'options' => array(
                array(
                    'label' => esc_html__( 'Youtube', 'eclat' ),
                    'value' => 'youtube'
                ),
                array(
                    'label' => esc_html__( 'Vimeo', 'eclat' ),
                    'value' => 'vimeo'
                )
            )
        )/*,
        'audio-url' => array(
            'label' => esc_html__( 'Audio URL', 'eclat' ),
            'desc'  => esc_html__( 'Insert the <a target="_blank" href="http://soundcloud.com/">SoundCloud.com</a> song URL.', 'eclat' ),
            'type'  => 'text',
        ),
        'audio-iframe' => array(
            'label' => esc_html__( 'Use iFrame', 'eclat' ),
            'desc'  => esc_html__( 'Use iFrame instead of Flash.', 'eclat' ),
            'type'  => 'checkbox'
        ),
        'audio-comments' => array(
            'label' => esc_html__( 'Show Comments', 'eclat' ),
            'desc'  => esc_html__( 'Show comments of the song.', 'eclat' ),
            'type'  => 'checkbox',
        ),
        'audio-color' => array(
            'label' => esc_html__( 'Color', 'eclat' ),
            'desc' => esc_html__( 'Template color.', 'eclat' ),
            'type' => 'colorpicker',
        )*/
    );
    return $meta_boxes_fields;
}

function show_meta_boxes()
{
    $meta_boxes_fields = get_meta_boxes_fields();
    global $post;
    echo '<input type="hidden" name="eclat_meta_boxes_nonce" value="'.wp_create_nonce('eclat_meta_boxes_nonce').'" />';

    echo '<table class="form-table">';
    foreach ($meta_boxes_fields as $key => $field)
    {
        $meta = get_post_meta($post->ID, $key, true);
        echo '<tr>
                <th><label for="'.$key.'">'.$field['label'].'</label></th>
                <td>';
        switch($field['type']) {
            case 'text':
                echo '<input type="text" name="'.$key.'" id="'.$key.'" value="'.$meta.'" size="30" /><br /><span class="description">'.$field['desc'].'</span>';
                break;
            case 'checkbox':
                echo '<input type="checkbox" name="'.$key.'" id="'.$key.'" '.($meta ? 'checked="checked"' : '').'/><label for="'.$key.'">'.$field['desc'].'</label>';
                break;
            case 'colorpicker':
                wp_enqueue_script('wp-color-picker');
                wp_enqueue_style( 'wp-color-picker' );
                echo '<input name="'.$key.'" type="text" id="'.$key.'" value="'.($meta ? $meta : '#fab000').'" data-default-color="#fab000" size="30">
                <script type="text/javascript">
                jQuery(document).ready(function($) { $("#'.$key.'").wpColorPicker(); });
                </script>
                ';
                break;
            case 'select':
                echo '<select name="'.$key.'" id="'.$key.'">';
                foreach ($field['options'] as $option) {
                    echo '<option', $meta == $option['value'] ? ' selected="selected"' : '', ' value="'.$option['value'].'">'.$option['label'].'</option>';
                }
                echo '</select><br /><span class="description">'.$field['desc'].'</span>';
                break;
        }
        echo '</td></tr>';
    }
    echo '</table>';
}

//call the wp function save_post to save the metabox
add_action('save_post', function($post_id)
{
    $meta_boxes_fields = get_meta_boxes_fields();

    if(!isset($_REQUEST['eclat_meta_boxes_nonce']))
        return $post_id;

    $nonce = $_REQUEST['eclat_meta_boxes_nonce'];

    if (!wp_verify_nonce($nonce, 'eclat_meta_boxes_nonce'))
        return $post_id;

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return $post_id;

    if ('page' == $_REQUEST['post_type'])
    {
        if (!current_user_can('edit_page', $post_id))
            return $post_id;
    }
    elseif (!current_user_can('edit_post', $post_id))
    {
        return $post_id;
    }

    foreach ($meta_boxes_fields as $key => $field)
    {
        $old = get_post_meta($post_id, $key, true);
        $new = $_REQUEST[$key];

        if ($new && $new != $old)
        {
            update_post_meta($post_id, $key, $new);
        }
        elseif ('' == $new && $old)
        {
            delete_post_meta($post_id, $key, $old);
        }
    }
});

?>