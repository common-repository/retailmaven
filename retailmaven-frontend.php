<?php
add_action( 'wp_enqueue_scripts', 'retailmaven_load_js' );

function retailmaven_load_js() {
  if ( retailmaven_check_is_post( ) ) { // Check if it's a post
    $tracking_code = get_option( 'retailmaven_code' );
    $saved_cats = get_option( 'retailmaven_categories' );
    $debug = get_option( 'retailmaven_debug_mode' );
    $cats_satisfy = retailmaven_check_categories( false, $tracking_code, $saved_cats );
    if ( $cats_satisfy ) {
      $maven_script = RETAILMAVEN_JS_URL . $tracking_code;
      $nonce = '0.3';
      if ( ! empty( $debug ) ) {
        if ( $debug === 'yes' ) {
          $nonce = $nonce . '%26debug=true%26rmaven=test';
        }
      }

      wp_enqueue_script( 'retailmaven-script', $maven_script, array(), $nonce, true );
    }
  }
}

// Adds async=true and comment to identify retailmaven script
add_filter( 'script_loader_tag', 'retailmaven_script_loader', 10, 2 );

function retailmaven_script_loader( $tag, $handle ) {
  if ( 'retailmaven-script' !== $handle ) {
    return $tag;
  } else {
    $tag = str_replace( '<script', '<!-- RetailMaven (https://retailmaven.co) -->' . PHP_EOL .'<script', $tag );

    $new_tag = str_replace( ' src', ' data-cfasync="false" async="true" src', $tag );
    $pattern = '/%26debug=true%26rmaven=test/i';
    $replacement = '&debug=true&rmaven=' . rand();

    return preg_replace($pattern, $replacement, $new_tag);
  }
}
?>