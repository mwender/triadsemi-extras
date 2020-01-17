<?php

namespace TriadSemi\woocommerce;

function filter_waitlist_message( $text ){
  return '<span class="title">Join the Waitlist</span>' . $text;
}
add_filter( 'wcwl_join_waitlist_message_text', __NAMESPACE__ . '\\filter_waitlist_message' );

/**
 * Price break by user's geolocation
 *
 * @param      array  $atts   The atts
 *
 * @return     string  Price break table html
 */
function price_breaks( $atts ){
  if( ! is_singular( 'product' ) )
    return;

  global $post, $twig;
  $context = [];
  $product = wc_get_product( $post->ID );
  $context['baseprice'] = $product->get_price();

  // Get the user's location (i.e. country code).
  // $test_ips = [ 'china' => '27.106.191.255', 'taiwan' => '27.147.63.255', 'southkorea' => '14.63.255.255' ];
  $country = '';
  if( class_exists( 'WC_Geolocation' ) ){
    $geolocate = new \WC_Geolocation();
    $user_ip = $geolocate->get_ip_address();
    $location = $geolocate->geolocate_ip( $user_ip );
    $country = $location['country'];
  }

  // Don't show price breaks for China (CN), Taiwan (TW), and South Korea (KR)
  $countries = [ 'CN', 'TW', 'KR' ];
  $max_price_breaks = ( in_array( $country, $countries ) )? 1 : 10;

  // Get discounts
  if( 'yes' == get_post_meta( $post->ID, '_bulkdiscount_enabled', true ) && class_exists( 'Woo_Bulk_Discount_Plugin_t4m' ) ){
    uber_log("\n\n" . 'Calculating bulk discounts...');

    if( 'fixed' != get_option( 'woocommerce_t4m_discount_type' ) )
      return;

    $bulk_discounts = [];
    $default_price = $product->get_price();
    for( $x = 1; $x <= $max_price_breaks; $x++ ){
      $quantity = get_post_meta( $post->ID, '_bulkdiscount_quantity_' . $x, true );
      $discount = get_post_meta( $post->ID, '_bulkdiscount_discount_fixed_' . $x, true );
      // If not quantity or discount, break the loop
      if( empty( $quantity ) || empty( $discount ) )
        break;

      $bulk_discounts[$x] = ['quantity' => $quantity, 'discount' => $discount ];
    }
    $context['bulk_discounts'] = $bulk_discounts;
  }

  // Restore the context and loop back to the main query loop.
  wp_reset_postdata();
  return $twig->render('pricing-table.twig', $context );
}
add_shortcode( 'price_breaks', __NAMESPACE__ . '\\price_breaks' );

/**
 * Additional WC Order processing after the order has been submitted.
 *
 * We use this to process orders with the `SAMPLEREQ` coupon code.
 *
 * @param      int  $order_id  The order ID
 */
function process_order( $order_id ){
  $order = new \WC_Order( $order_id );
  $coupons = $order->get_coupon_codes();

  foreach( $coupons as $coupon_code ){
    switch ( strtolower( $coupon_code ) ) {
      case 'samplereq':
        // If we're using the `SAMPLEREQ` coupon,
        // update the order's status to `Sample Request`:
        $order->update_status('sample-request');
        break;

      default:
        uber_log('ℹ️ process_order() has no logic for `' . $coupon_code . '` coupon code.');
        break;
    }
  }
}
add_action( 'woocommerce_thankyou', __NAMESPACE__ . '\\process_order' );
