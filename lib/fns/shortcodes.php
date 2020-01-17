<?php

namespace TriadSemi\shortcodes;

/**
 * Allows for output of special ACF fields via custom output code.
 *
 * @param      array          $atts {
 *   @type  string   $field  The field we're displaying.
 * }
 *
 * @return     boolean|string  HTML output for the field.
 */
function acf_shortcode( $atts ){
  $args = shortcode_atts( [
    'field' => null,
  ], $atts );

  if( is_null( $args['field'] ) )
    return '<p><code>Please specify an ACF field with the `field` attribute.</code></p>';

  $field = ( is_tax() )? get_field_object( $args['field'], get_queried_object() ) : get_field_object( $args['field'] ) ;
  //echo('<p><pre>$field = ' . print_r( $field, true ) . '</pre></p>' );
  if( ! $field )
    return false;

  wp_enqueue_style( 'triadsemi-extras' );

  $html = '';
  switch( $field['type'] ){
    case 'flexible_content':
      if( is_array( $field['value'] ) )
        $html = \TriadSemi\utilities\format_flexible_content( $field['value'] );
      break;

    case 'group':
      //$html.= '<pre>$field = '.print_r($field,true).'</pre>';
      $html.= $field['value']['heading'];
      if( $field['value']['background_image'] ){
        $html.= '<style type="text/css">body.archive .elementor-element.hero-unit{background-image: url(\'' . $field['value']['background_image']['url'] . '\') !important; background-size: cover;}</style>';
      }
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
        $html = \TriadSemi\utilities\format_list( $list );
      }
      break;

    default:
      $html = '<p><code>No display format provided for field of type `' . $field['type'] . '`.</code></p>';
  }

  return '<div class="elementor-widget-text-editor">' . $html . '</div>';
}
add_shortcode( 'acfadvanced', __NAMESPACE__  . '\\acf_shortcode' );

/**
 * Outputs the Product Selector table
 *
 * @param      array  $atts {
 *
 * }
 *
 * @return     html   The html for the product selector table.
 */
function product_selector( $atts ){
  static $selector_id = 1;

  $args = shortcode_atts( [
    'datatable' => true,
    'category'  => null,
    'tag'       => null,
  ], $atts );

  $product_query_args = [
    'limit'       => -1,
    'orderby'     => 'title',
    'order'       => 'ASC',
    'visibility'  => 'catalog',
    'status'      => 'publish',
  ];

  if( ! is_null( $args['category'] ) ){
    $category = ( stristr( $args['category'], ',') )? explode(',', $args['category'] ) : [ $args['category'] ] ;
    $product_query_args['category'] = $category;
  } else if( is_tax() ){
    $current_term = get_queried_object();
    $args['category'] = $current_term->slug;
    $product_query_args['category'] = [ $current_term->slug ];
  }

  if( ! is_null( $args['tag'] ) ){
    $tag = ( stristr( $args['tag'], ',') )? explode(',', $args['tag'] ) : [ $args['tag'] ] ;
    $product_query_args['tag'] = $tag;
  }

  $products = wc_get_products( $product_query_args );

  if( $products ){
    foreach( $products as $product ){
      $cat_column = ( ! $args['tag'] && ! is_product_category() )? '<td>' . wc_get_product_category_list( $product->get_id() ) . '</td>' : '' ;
      $rows[] = '	<tr><td><a href="' . get_permalink( $product->get_id() ) . '">' . $product->get_name() . '</a></td>' . $cat_column . '<td>' . get_field( 'sub_title', $product->get_id() ) . '</td></tr>';
    }
  }

  if( true === $args['datatable'] ){
    wp_enqueue_style( 'triadsemi-extras' );
    wp_enqueue_script( 'datatables-init' );

    // No Market filter if we have set the category or tag
    $marketFilter = ( $args['category'] || $args['tag'] || is_product_category() )? false : true ;
    wp_localize_script( 'datatables-init', 'wpvars', [ 'marketFilter' => $marketFilter ] );
  }

  $cat_header = ( ! $args['tag'] && ! is_product_category() )? '<th style="width: 25%;">Market</th>' : '' ;

  $table_head = "<table class=\"striped productselector\" id=\"productselector-{$selector_id}\"><thead><tr><th style=\"width: 15%;\">Triad Part Number</th>";
  $selector_id++;
  return  $table_head . $cat_header . '<th style="width: 60%;">Description</th></tr></thead><tbody>' . implode( '', $rows ) . '</tbody></table>';
}
add_shortcode( 'productselector', __NAMESPACE__ . '\\product_selector' );

function scroll_offset_js(){
  $scroll_offset_js = file_get_contents( plugin_dir_path( __FILE__ ) . '../js/scroll-offset.js' );
  return "<script type=\"text/javascript\">\n{$scroll_offset_js}\n</script>";
}
add_shortcode('scrolloffsetjs', __NAMESPACE__ . '\\scroll_offset_js' );
