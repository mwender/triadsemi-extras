<?php
/**
 * Functions that work with Gravity Forms
 *
 *
 *
 * @link URL
 * @since 1.1.0
 *
 * @package The7 Child Theme
 * @subpackage Component
 */

namespace TriadSemi\gravityforms;

/**
 * Adds Kickfire Identity™ tracking to Gravity Forms
 *
 * Works with any email fields with a CSS Class of .identity. When
 * the form is submitted, $_COOKIE['identity'] gets set and is
 * then output in /lib/js/kickfire.js.
 *
 * @since 1.1.0
 *
 * @param array $validation_result Gravity Forms array containing the form's validation status and the form object.
 * @return array Gravity Forms validation result.
 */
function track_user_email( $validation_result ) {

  $form = $validation_result['form'];

  $identity = array();

  foreach( $form['fields'] as &$field ){

    if( in_array( $field['cssClass'], array( 'identity', 'identity-name', 'identity-email') ) ) {

      $is_hidden = RGFormsModel::is_field_hidden( $form, $field, array() );

      if( $is_hidden )
        continue;

      $value = '';

      if( is_array( $field['inputs'] ) && 0 < count( $field['inputs'] ) ) {
        foreach( $field['inputs'] as &$input ){
          $id = str_replace( '.', '_', $input['id'] );
          $value_array[] = rgpost( "input_{$id}" );
        }
        $value = implode( ' ', $value_array );
      } else {
        $value = rgpost( "input_{$field['id']}" );
      }

      if( 'email' == $field['type'] ){
        if( filter_var( $value, FILTER_VALIDATE_EMAIL ) )
          $identity['email'] = filter_var( $value, FILTER_SANITIZE_EMAIL );
      } else {
        $identity['name'] = $value;
      }
    }
  }

  if( 0 < count( $identity ) ){
    if( isset( $identity['name'] ) && isset( $identity['email'] ) ){
      $identity_str = $identity['name'] . ' (' . $identity['email'] . ')';
    } else {
      $identity_str = implode( '', $identity );
    }

    $expire = time() + ( 10 * 365 * 24 * 60 * 60 );
    setcookie( 'identity', $identity_str, $expire, '/' );
  }

  return $validation_result;
}
add_filter( 'gform_validation', __NAMESPACE__ . '\\track_user_email' );
?>