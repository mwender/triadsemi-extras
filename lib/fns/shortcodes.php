<?php

namespace ACFAdvanced\shortcodes;

function acf_shortcode( $atts ){
  $args = shortcode_atts( [
    'field' => null,
  ], $atts );

  if( is_null( $args['field'] ) )
    return '<p><code>Please specify an ACF field with the `field` attribute.</code></p>';

  $field = get_field_object( $args['field']);
  //error_log('$field = ' . print_r( $field, true ) );
  if( ! $field )
    return false;

  $html = '';
  switch( $field['type'] ){
    case 'flexible_content':
      if( is_array( $field['value'] ) )
        $html = \ACFAdvanced\utilities\format_flexible_content( $field['value'] );
      break;

    case 'range':
      if( 'product_image_width' == $field['name'] ){
        $value = ( empty( $field['value'] ) || 0 === $field['value'] )? 50 : $field['value'] ;
        $html = '<style type="text/css">#chip-image img{width: ' . $value . '%;}</style>';
      }
      break;

    case 'repeater':
      if( is_array( $field['value'] ) ){
        foreach( $field['value'] as $item ){
          $list[] = $item['detail'];
        }
        $html = \ACFAdvanced\utilities\format_list( $list );
      }
      break;

    default:
      $html = '<p><code>No display format provided for field of type `' . $field['type'] . '`.</code></p>';
  }

  return '<div class="elementor-widget-text-editor">' . $html . '</div>';
}
add_shortcode( 'acfadvanced', __NAMESPACE__  . '\\acf_shortcode' );

function product_selector( $atts ){
  $products = wc_get_products([
    'limit'       => -1,
    'orderby'     => 'title',
    'order'       => 'ASC',
    'visibility'  => 'catalog',
  ]);

  if( $products ){
    foreach( $products as $product ){
      $rows[] = '	<tr><td><a href="' . get_permalink( $product->get_id() ) . '">' . $product->get_name() . '</a></td><td>' . $product->get_categories() . '</td><td>' . get_field( 'sub_title', $product->get_id() ) . '</td></tr>';
    }
  }

  return '<table class="striped"><thead><tr><th style="width: 15%;">Triad Part Number</th><th style="width: 25%;">Market</th><th style="width: 60%;">Description</th></tr></thead><tbody>' . implode( '', $rows ) . '</tbody></table>';
}
add_shortcode( 'productselector', __NAMESPACE__ . '\\product_selector' );
