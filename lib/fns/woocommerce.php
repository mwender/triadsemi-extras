<?php

namespace TriadSemi\woocommerce;

function filter_waitlist_message( $text ){
  return '<span class="title">Join the Waitlist</span>' . $text;
}
add_filter( 'wcwl_join_waitlist_message_text', __NAMESPACE__ . '\\filter_waitlist_message' );