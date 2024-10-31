<?php
add_action( 'publish_post', 'retailmaven_post_article_content' );

function retailmaven_post_article_content( $id ) {
  $tracking_code = get_option( 'retailmaven_code' );
  $saved_cats = get_option( 'retailmaven_categories' );
  $cats_satisfy = retailmaven_check_categories( $id, $tracking_code, $saved_cats );
  $post = get_post( $id );
  $min_content_length = 100;
  $min_title_length = 2;
  if ( !empty( $post ) ) {
    if ( strlen( $post->post_content ) > $min_content_length && strlen( $post->post_title ) > $min_title_length) {
      if ( $cats_satisfy ) {
        $response = wp_remote_post( RETAILMAVEN_API_URL . '/site', array(
          'headers' => array(
            'content-type' => 'application/json'
          ),
          'body' => json_encode(array(
              'x-maven-site-key' => $tracking_code,
              'article-url' => esc_url(get_permalink()),
              'content' => get_post($id)->post_content,
              'title' => get_post($id)->post_title
            ))
        ));
      } else {
        $response = wp_remote_post( RETAILMAVEN_API_URL . '/site', array(
          'headers' => array(
            'content-type' => 'application/json'
          ),
          'body' => json_encode(array(
              'x-maven-site-key' => $tracking_code,
              'article-url' => esc_url(get_permalink()),
              'x-maven-remove' => true,
            ))
        ));
      }
    }
  }
}
?>