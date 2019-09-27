<?php

namespace TriadSemi\enqueues;

function enqueue_scripts(){
  wp_register_style( 'datatables', '//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css', null, '1.10.19' );
  wp_register_script( 'datatables', '//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js', ['jquery'], '1.10.19', true );
  wp_register_script( 'datatables-init', plugin_dir_url( __FILE__ ) . '../js/datatables-init.js', ['datatables'], filemtime( plugin_dir_path( __FILE__ ) . '../js/datatables-init.js' ), true );
}
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\enqueue_scripts' );
