<?php

namespace TriadSemi\utilities;

function format_flexible_content( $content_rows = [] ){
  if( ! is_array( $content_rows ) || 0 === count( $content_rows ) )
    return false;

  $html = '';
  $x = 0;
  $content = '';
  foreach( $content_rows as $row ){
    if( 0 < $x )
      $html.= '<div class="elementor-element elementor-element-3b17d2a elementor-widget elementor-widget-divider" data-id="3b17d2a" data-element_type="widget" data-widget_type="divider.default"><div class="elementor-widget-container"><span class="elementor-divider-separator"></span></div></div>';
    $x++;

    switch( $row['acf_fc_layout'] ){
      case 'additional_products':
        $template = file_get_contents( plugin_dir_path( __FILE__ ) . '../templates/additional_product.html' );
        if( is_array( $row['_products'] ) && 0 < count( $row['_products'] ) ){
          $content = '<h3 class="title">' . $row['section_title'] . '</h3>';
          foreach( $row['_products'] as $product ){
            //error_log('$product[product] = ' . print_r( $product['product'], true ) );
            $product = $product['product'];
            $search = [
              '{{title}}',
              '{{link}}',
              '{{content}}',
              '{{image}}'
            ];
            $replace = [
              $product->post_title,
              get_permalink( $product->ID ),
              apply_filters( 'the_content', get_the_content( null, null, $product->ID ) ),
              get_the_post_thumbnail( $product->ID, 'full' )
            ];
            $content.= str_replace( $search, $replace, $template );
          }
        }
        break;

      case 'circuit_diagram':
        $content = '<h3 class="title">' . $row['title'] . '</h3><div class="flexible-content-image"><img src="' . $row['image']['url'] . '" style="width: ' . intval( $row['image']['width']/2 ) . 'px; height: auto; max-width: 800px;" alt="' . esc_attr( $row['title'] ) . '" /></div>';
        break;

      case 'product_highlights':
        error_log('$row = ' . print_r($row,true));
        $template_left = file_get_contents( plugin_dir_path( __FILE__ ) . '../templates/product-highlight_left.html' );
        $template_right = file_get_contents( plugin_dir_path( __FILE__ ) . '../templates/product-highlight_right.html' );
        $x = 0;
        if( is_array( $row['highlight'] ) && 0 < count( $row['highlight'] ) ){
          $content = '';
          foreach( $row['highlight'] as $highlight ){
            $search = ['{{title}}','{{image}}','{{content}}'];
            $replace = [ $highlight['title'], '<img src="' . $highlight['image']['url'] . '" />', $highlight['content'] ];
            $template = ( $x % 2 )? $template_left : $template_right ;
            $content.= str_replace( $search, $replace, $template );
            $x++;
          }
        }
        $content = '<div class="product-highlights">' . $content . '</div>';
        break;

      case 'column_content':
        // Get our column width
        $no_of_cols = count( $row['columns'] );
        $col_widths = [1 => 100, 2 => 50, 3 => 33, 4 => 25];
        $col_width = $col_widths[$no_of_cols];

        // Load the templates
        $section_template = file_get_contents( plugin_dir_path(__FILE__) . '../templates/columns-section.html' );
        $column_template = file_get_contents( plugin_dir_path(__FILE__) . '../templates/column.html' );

        // Build the columns
        $col_html = '';
        foreach( $row['columns'] as $column ){
          $search = ['{{col_width}}','{{image}}','{{title}}','{{text}}'];
          $replace = [
            $col_width,
            '<img src="' . $column['image']['url'] . '" />',
            $column['title'],
            apply_filters( 'the_content',  $column['text'] ),
          ];
          $col_html.= str_replace( $search, $replace, $column_template );
        }

        // Add the columns to the section
        $content = str_replace( '{{columns}}', $col_html, $section_template );
        break;

      case 'related_products':
        $table_rows = [];
        foreach( $row['products'] as $product ){
          $table_rows[] = '<tr><td><a href="' . get_permalink( $product->ID ) . '">' . $product->post_title . '</a></td><td>' . get_field( 'sub_title', $product->ID ) . '</td></tr>';
        }
        $content = '<h3 class="title">Related Products</h3><table class="striped"><thead><tr><th style="width: 30%">Triad Part Number</th><th style="width: 70%">Description</th></tr></thead><tbody>' . implode( '', $table_rows ) . '</tbody></table>';
        break;

      case 'technical_data_table':
        $table_rows = [];
        foreach( $row['table_row'] as $table_row ){
          $table_rows[] = '<tr><td>' . $table_row['parameter'] . '</td><td>' . $table_row['details'] . '</td></tr>';
        }
        $content = '<h3 class="title">Technical Data</h3><table class="striped"><thead><tr><th style="width: 30%">Parameter</th><th style="width: 70%">Details</th></tr></thead><tbody>' . implode( '', $table_rows ) . '</tbody></table>';
        break;

      default:
        $content = '<p><code>No layout defined for `' . $row['acf_fc_layout'] . '`.</code></p>';
        break;
    }
    $html.= '<div class="flexible-content-row">' . $content . '</div>';
  }

  $css = file_get_contents( plugin_dir_path( __FILE__ ) . '../css/flexible-content.css' );
  return '<div class="flexible-content">' . $html . '</div><style type="text/css">' . $css . '</style>';
}

function format_list( $list = [] ){
  if( ! is_array( $list ) )
    return false;

  return '<ul><li>' . implode( '</li><li>', $list ) . '</li></ul>';
}