<?php

namespace TriadSemi\kickfire;

function waitlist_to_kickfire( $WC_Product, $WP_User ){
  $user_email = $WP_User->data->user_email;
  \uber_log('👉 $WP_User->data->user_email = ' . $user_email );
  $expire = time() + ( 10 * 365 * 24 * 60 * 60 );
  setcookie( 'identity', $user_email, $expire, '/' );
}
add_action( 'wcwl_after_add_user_to_waitlist', __NAMESPACE__ . '\\waitlist_to_kickfire', 10, 2 );