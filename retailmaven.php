<?php
/**
 * Plugin Name: RetailMaven
 * Plugin URI: https://retailmaven.co
 * Description: RetailMaven is the simplest way to generate revenue from your content. We analyze your text content and convert them into appropriate product affiliate links. Primarily, aimed at lifestyle, fashion, entertainment and health and beauty - we effortlessly bridge content to e-commerce.
 * Version: 1.2.8
 * Author: RetailMaven <support@retailmaven.co>
 * Author URI: https://retailmaven.co
 * License: GPLv2 or later
 */
defined( 'ABSPATH' ) or die( 'Not WP' );
define( 'RETAILMAVEN_JS_URL', 'https://js.retailmaven.co/' );
define( 'RETAILMAVEN_API_URL', 'https://api.retailmaven.co' );
define( 'RETAILMAVEN_PATH', dirname( __FILE__ ) );


// Include files
include_once( RETAILMAVEN_PATH . '/retailmaven-helpers.php');
include_once( RETAILMAVEN_PATH . '/retailmaven-admin.php');
include_once( RETAILMAVEN_PATH . '/retailmaven-frontend.php');
include_once( RETAILMAVEN_PATH . '/retailmaven-article-publish.php');
?>
