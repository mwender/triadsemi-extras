<?php

namespace TriadSemi\enqueues;

function enqueue_scripts(){
  error_log('site_url = ' . get_site_url() );
  $site_url = get_site_url();
  $dev_servers = ['https://triadsemibeta.local','https://localhost:3000'];
  if( in_array( $site_url, $dev_servers ) ){
    wp_enqueue_style( 'triadsemi-extras', plugin_dir_url( __FILE__ ) . '../css/main.css', null, plugin_dir_path( __FILE__ ) . '../css/main.css' );
  } else {
    wp_enqueue_style( 'triadsemi-extras', plugin_dir_url( __FILE__ ) . '../dist/main.css', null, plugin_dir_path( __FILE__ ) . '../dist/main.css' );
  }

  wp_register_script( 'datatables', '//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js', ['jquery'], '1.10.19', true );
  wp_register_script( 'datatables-init', plugin_dir_url( __FILE__ ) . '../js/datatables-init.js', ['datatables'], filemtime( plugin_dir_path( __FILE__ ) . '../js/datatables-init.js' ), true );
}
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\enqueue_scripts' );

function footer_scripts(){
  $scripts = ['intercom.js','kickfire.js'];
  $js = [];
  foreach( $scripts as $script ){
    $js[] = file_get_contents( plugin_dir_path( __FILE__ ) . '../js/' . $script );
  }

  echo "\n" . '<script type="text/javascript">'. "\n" . implode( "\n", $js ) . "\n" . '</script>' . "\n";
}
add_action( 'wp_footer', __NAMESPACE__ . '\\footer_scripts' );