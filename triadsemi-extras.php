<?php
/**
 * Plugin Name:     TriadSemi Extras
 * Plugin URI:      PLUGIN SITE HERE
 * Description:     Extra features for the TriadSemi website.
 * Author:          TheWebist
 * Author URI:      https://mwender.com
 * Text Domain:     triadsemi-extras
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Triadsemi_Extras
 */

require_once('lib/fns/enqueues.php');
require_once('lib/fns/gravityforms.php');
require_once('lib/fns/shortcodes.php');
require_once('lib/fns/template_redirect.php');
require_once('lib/fns/utilities.php');
require_once('lib/fns/woocommerce.php');

function uber_log( $message = null ){
  static $counter = 1;

  $bt = debug_backtrace();
  $caller = array_shift( $bt );

  if( 1 == $counter )
    error_log( "\n\n" . str_repeat('-', 25 ) . ' STARTING DEBUG [' . date('h:i:sa', current_time('timestamp') ) . '] ' . str_repeat('-', 25 ) . "\n\n" );
  error_log( $counter . '. ' . basename( $caller['file'] ) . '::' . $caller['line'] . ' ' . $message );
  $counter++;
}