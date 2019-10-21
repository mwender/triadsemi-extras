/* Datatables Init */
(function($){
  const table = $('.productselector').DataTable({
    'lengthMenu': [20,50,75,100],
    'pageLength': 20
  });

  if( wpvars.marketFilter ){
    table.columns().flatten().each( function( colIdx ){
      if( 1 === colIdx ){
        var select = $('<select><option value="">...</option></select>')
          .appendTo(
            table.column(colIdx).header()
          )
          .on('change', function(){
            table
              .column( colIdx )
              .search( $(this).val() )
              .draw();
          });

        table
          .column(colIdx)
          .cache('search')
          .sort()
          .unique()
          .each(function(d){
            select.append( $('<option value="' + d + '">' + d + '</option>' ) );
          });
      }
    });
  }
})(jQuery);