<?php
/**
 * Plugin Name:     TriadSemi Extras
 * Plugin URI:      https://github.com/mwender/triadsemi-extras
 * Description:     Extra features for the TriadSemi website.
 * Author:          TheWebist
 * Author URI:      https://mwender.com
 * Text Domain:     triadsemi-extras
 * Domain Path:     /languages
 * Version:         1.0.0
 *
 * @package         Triadsemi_Extras
 */

/* Load Composer Dependencies */
require_once('vendor/autoload.php');
$loader = new \Twig\Loader\FilesystemLoader( plugin_dir_path( __FILE__ ) . 'lib/templates/twig');
$twig = new \Twig\Environment( $loader, [
  'cache' => plugin_dir_path( __FILE__ ) . 'lib/templates/twig/cache'
]);

/* Load Project Dependencies */
require_once('lib/fns/enqueues.php');
require_once('lib/fns/gravityforms.php');
require_once('lib/fns/shortcodes.php');
require_once('lib/fns/template_redirect.php');
require_once('lib/fns/utilities.php');
require_once('lib/fns/waitlist-to-kickfire.php');
require_once('lib/fns/woocommerce.php');

/**
 * Provides enhanced error logging.
 *
 * @param      string  $message  The message
 */
function uber_log( $message = null ){
  static $counter = 1;

  $bt = debug_backtrace();
  $caller = array_shift( $bt );

  if( 1 == $counter )
    error_log( "\n\n" . str_repeat('-', 25 ) . ' STARTING DEBUG [' . date('h:i:sa', current_time('timestamp') ) . '] ' . str_repeat('-', 25 ) . "\n\n" );
  error_log( $counter . '. ' . basename( $caller['file'] ) . '::' . $caller['line'] . ' ' . $message );
  $counter++;
}