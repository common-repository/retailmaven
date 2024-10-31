<?php
add_action( 'wp_loaded', array ( RetailMaven_Admin::get_instance(), 'register' ) );

class RetailMaven_Admin {
  /**
   * Plugin instance.
   *
   * @see get_instance()
   * @type object
   */
  protected static $instance = NULL;

  protected $page_id   = NULL;
  protected $msg_text  = NULL;
  protected $msg_class = NULL;
  protected $option_code     = 'retailmaven_code';
  protected $option_cats     = 'retailmaven_categories';
  protected $option_debug    = 'retailmaven_debug_mode';
  protected $settings_name   = 'retailmaven-settings-group';
  protected $page_name       = 'toplevel_page_retailmaven-settings';
  protected $action          = 'retailmaven_check';

  /**
   * Access this plugin’s working instance
   *
   * @wp-hook wp_loaded
   * @return  object of this class
   */
  public static function get_instance() {
    NULL === self::$instance and self::$instance = new self;
    return self::$instance;
  }

  public function register() {
    if ( is_Admin() ) {
      add_action( 'admin_menu', array ( $this, 'retailmaven_add_menu' ) );
      add_action( "admin_post_$this->action", array ( $this, 'retailmaven_check_code' ) );
      add_action( 'admin_enqueue_scripts', array ( $this, 'retailmaven_add_admin_assets' ) );
    }
  }

  public function retailmaven_add_admin_assets( $hook ) {
    if ( $this->page_name !== $hook ) {
        return;
    }

    wp_enqueue_script( 'retailmaven-admin-script', plugins_url( 'retailmaven-admin.js', __FILE__ ), array( 'jquery','thickbox' ), null );
  }

  public function retailmaven_add_menu() {
    // Create RetailMaven top-level menu
    $page_id = add_menu_page(
      'RetailMaven Settings',
      'RetailMaven',
      'administrator',
      'retailmaven-settings',
      array ( $this, 'retailmaven_settings_page' ),
      'dashicons-admin-generic'
    );

    // Register RetailMaven settings
    add_action( 'admin_init', array ( $this, 'retailmaven_settings' ) );

    // Register message handling
    add_action( "load-$page_id", array( $this, 'parse_message') );
  }

  public function parse_message() {
    if ( !isset( $_GET['msg'] ) ) {
      return;
    }

    // $text = FALSE;
    $this->msg_class = 'error';
    if ( 'nocat' === $_GET['msg'] ) {
      $this->msg_text = 'No categories were chosen before you clicked the "Register & Save Settings" button. We have loaded your last successfully saved categories. Please "Register & Save Settings" again.';
    }

    if ( 'error' === $_GET['msg'] ) {
      $this->msg_text = 'An error occurred communicating with RetailMaven services. Please check the status page of RetailMaven: http://status.retailmaven.co for any reported issues. If you are still experiencing issues please contact us at support@retailmaven.co';
    }

    if ( 'invalid' === $_GET['msg'] ) {
      $this->msg_text = '"Site Code" is either invalid or empty. Please try again. If you are experiencing issues please contact us at support@retailmaven.co';
    }

    if ( 'unknown' === $_GET['msg'] ) {
      $this->msg_text = 'Please check you are using the latest RetailMaven WordPress widget. If you are still experiencing issues please contact us at support@retailmaven.co';
    }

    if ( 'success' === $_GET['msg'] ) {
      $this->msg_text = 'You have successfully registered with RetailMaven. Thank you for choosing RetailMaven where we help to monetise your content. If you have any enquiries please do not hessitate to contact us at support@retailmaven.co';
      $this->msg_class = 'updated';
    }

    if ( !empty( $this->msg_text ) )
      add_action( 'admin_notices', array ( $this, 'render_msg' ) );
  }

  public function render_msg() {
    echo '<div class="' . $this->msg_class . '"><p>' . $this->msg_text . '</p></div>';
  }

  public function retailmaven_settings() {
    register_setting( $this->settings_name, $this->option_code );
    register_setting( $this->settings_name, $this->option_cats );
  }

  public function retailmaven_settings_page() {
    $code = esc_attr(  get_option( $this->option_code ) );
    $cats = esc_attr(  get_option( $this->option_cats ) );
    $redirect = urlencode( remove_query_arg( 'msg', $_SERVER['REQUEST_URI'] ) );
    $redirect = urlencode( $_SERVER['REQUEST_URI'] );

    ?><div class="wrap">
    <h2>RetailMaven</h2>
    <form method="post" action="<?php echo admin_url( 'admin-post.php' ); ?>">
        <input type="hidden" name="action" value="<?php echo $this->action; ?>">
        <?php wp_nonce_field( $this->action, $this->option_code . '_nonce', FALSE ); ?>
        <input type="hidden" name="_wp_http_referer" value="<?php echo $redirect; ?>">
        <input type="hidden" name="cats" value="<?php echo $cats; ?>">
        <?php do_settings_sections( $this->settings_name ); ?>
        <table class="form-table">
            <tr valign="top">
            <th scope="row">Site Code</th>
            <td>
              <?php
                echo '<input type="text" name="' . $this->option_code . '" value="' . $code . '"/>';
              ?>
              <a style="margin-left: 15px;" target="_blank" href="https://publishers.retailmaven.co/login">Get my Site Code</a>
            </td>
            </tr>
            <th scope="row">Categories to Cover</th>
            <td style="list-style-type: none;">
              <li id="category-0" class="popular-category">
                <label class="selectit" style="font-weight: bold;">
                  <input value="all-cat" type="checkbox" name="post_category[]" id="category-all-cat"> All Categories Below
                </label>
              </li>
              <?php wp_category_checklist(); ?>
            </td>
            <p>This plugin adds Javascript to your posts and converts appropriate text to affiliate links. <a target="blank" href="https://retailmaven.co">To find out more ...</a></p>
        </table>
        <p>By entering a 'Site Code' and clicking 'Register & Save Settings' you opt-in to the RetailMaven service.</p>
        <?php submit_button( 'Register & Save Settings' ); ?>
    </form>
    </div>
    <?php
  }

  /**
   * Check the Tracking Code is correct
   *
   * @return String error or NULL for success
   */
  public function retailmaven_check_code() {
    if ( !wp_verify_nonce( $_POST[$this->option_code . '_nonce'], $this->action ) ) {
      die( 'Invalid nonce.' . var_export( $_POST, true ) );
    }

    if ( isset( $_POST[$this->option_code] ) ) {
      if ( empty( $_POST['post_category'] ) ) {
        $msg = 'nocat';
      } else {
        // Get the category slugs
        $to_post_cats = array();
        foreach( $_POST['post_category'] as $val ) {
          if ( 'all-cat' === $val ) {
            array_push( $to_post_cats, 'rmaven-all-cat' );
          } elseif ( is_numeric( $val ) ) {
            $category = get_term( intval( $val ), 'category' );
            array_push( $to_post_cats, $category->name . ' -> ' . $category->slug );
          }
        }

        $plugin_val = get_plugin_data( dirname( __FILE__ ) . '/retailmaven.php' );
        $ver = '';
        if (!empty( $val )) {
          if ( array_key_exists ('Version', $plugin_val  ) ) {
            $ver = $plugin_val['Version'];
          }
        }

        // Delete if there is any debug option set and delete accordingly
        if ( is_null( get_option( $this->option_debug ) ) ) {
          delete_option( $this->option_debug );
        }

        $response = wp_remote_post( RETAILMAVEN_API_URL . '/check', array(
          'headers' => array(
            'content-type' => 'application/json'
          ),
          'body' => json_encode( array(
              'x-maven-domain' => get_site_url(),
              'x-maven-site-key' => $_POST[$this->option_code],
              'x-maven-widget-type' => 'WP',
              'x-maven-widget-version' => $ver,
              'x-maven-categories' => $to_post_cats,
            ))
        ));

        if ( is_wp_error( $response ) ) {
          delete_option( $this->option_code );
          $error_message = $response->get_error_message();
          $msg = 'error';
        } else {
          if ( is_array( $response ) ) {
            $body = json_decode( $response['body'] ); // use json response

            // Check for error code, if nothing is up contine
            if ( isset( $body->error ) ) {
              delete_option( $this->option_code );
              $msg = 'invalid';
            } else {
              // Update options as the code was a success
              update_option( $this->option_code, $_POST[$this->option_code] );
              update_option( $this->option_cats, implode(',', $_POST['post_category']) );
              $msg = 'success';
            }
          } else {
            delete_option( $this->option_code );
            $msg = 'unknown';
          }
        }
      }
    } else {
      delete_option( $this->option_code );
      $msg = 'incorrect';
    }


    if ( ! isset ( $_POST['_wp_http_referer'] ) )
      die( 'Missing target.' );

    $url = add_query_arg( 'msg', $msg, urldecode( $_POST['_wp_http_referer'] ) );
    wp_safe_redirect( $url );
    exit;
  }
}
?>
