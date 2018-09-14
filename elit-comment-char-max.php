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

  add_settings_section(
    'elit_comment_max_char_settings_section',
    'Limit Length of Comments',
    'elit_comment_max_char_settings_section_cb',
    'discussion'
  );

  add_settings_field(
    'comment_max_char',
    'Maximum',
    'elit_comment_max_char_settings_field_max_cb',
    'discussion',
    'elit_comment_max_char_settings_section'
  );

  add_settings_field(
    'comment_warn_char',
    'Warn When User Reaches',
    'elit_comment_max_char_settings_field_warn_cb',
    'discussion',
    'elit_comment_max_char_settings_section'
  );

  register_setting( 'discussion', 'comment_max_char' );
  register_setting( 'discussion', 'comment_warn_char' );
}
add_action('admin_init' , 'elit_comment_max_char_settings_init');

function elit_comment_max_char_settings_section_cb() {
  echo '<p>Limit the number of characters in a comment</p>';
}

function elit_comment_max_char_settings_field_max_cb( $args ) {
  $setting = get_option( 'comment_max_char' );
?>
  <input type="text" id="comment_max_char" name="comment_max_char" value="<?php echo isset( $setting ) ? esc_attr( $setting ) : ''; ?>">
  <label for="comment_max_char">characters</label>
  <?php 
}

function elit_comment_max_char_settings_field_warn_cb( $args ) {
  $setting = get_option( 'comment_warn_char' );
?>
  <input type="text" name="comment_warn_char" value="<?php echo isset( $setting ) ? esc_attr( $setting ) : ''; ?>">
  <label for="comment_warn_char">characters</label>
  <?php 

}

function elit_comment_max_char_enqueue_scripts() {
  if (! is_single() || ! comments_open() ) { return; }

  $js_file = 'elit-comment-char-max.min.js';
  $js_path = "public/scripts/$js_file";

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
    array( 
      'max' => get_option( 'comment_max_char' ),
      'warn' => get_option( 'comment_warn_char' ),
    )
  );

}
add_action( 'wp_enqueue_scripts' , 'elit_comment_max_char_enqueue_scripts' );

