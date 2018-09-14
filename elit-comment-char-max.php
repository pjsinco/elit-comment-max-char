<?php
/**
 * Plugin Name: Elit Comment Max Char
 * Description: Limit the character count of comments
 * Author: Patrick Sinco
 */

if ( ! defined('WPINC') ) {
  die;
}

function elit_comment_max_char_settings_init() {
  register_setting( 'discussion', 'elit_comment_max_char' );

  add_settings_section(
    'elit_comment_max_char_settings_section',
    'Limit Length of Comments',
    'elit_comment_max_char_settings_section_cb',
    'discussion'
  );

  add_settings_field(
    'elit_comment_max_char_settings_field',
    'Maximum Characters',
    'elit_comment_max_char_settings_field_cb',
    'discussion',
    'elit_comment_max_char_settings_section'
  );
}
add_action('admin_init' , 'elit_comment_max_char_settings_init');

function elit_comment_max_char_settings_section_cb() {
  echo '<p>Limit the number of characters in a comment</p>';
}

function elit_comment_max_char_settings_field_cb() {
  $setting = get_option( 'elit_comment_max_char' );
?>
  <input type="text" name="elit_comment_max_char" value="<?php echo isset( $setting ) ? esc_attr( $setting ) : ''; ?>">
  <?php 
}

function elit_comment_max_char_enqueue_scripts() {
  if (! is_single() || ! comments_open() ) { return; }

  $css_file = 'elit-comment-char-max.css';
  $css_path = "public/styles/$css_file";
  $js_file = 'elit-comment-char-max.min.js';
  $js_path = "public/scripts/$js_file";

  wp_enqueue_style(
    'elit-comment-max-char-styles',
    plugins_url( $css_path, __FILE__ ),
    array(),
    filemtime( plugin_dir_path( __FILE__ ) . '/' . $css_path ),
    'all'
  );

  wp_enqueue_script(
    'elit-comment-max-char-script',
    plugins_url( $js_path, __FILE__ ),
    array( 'jquery' ),
    filemtime( plugin_dir_path( __FILE__ ) . '/' . $js_path ),
    true
  );

  wp_localize_script( 
    'elit-comment-max-char-script', 
    'commentMaxChar', 
    array( 'max' => get_option( 'elit_comment_max_char' ) )
  );

}
add_action( 'wp_enqueue_scripts' , 'elit_comment_max_char_enqueue_scripts' );

