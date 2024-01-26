$(document).ready(function() {
    $('#dataTables-example').DataTable( {
        "lengthMenu": [ 4, 15, 30, 40, 50 ],
        initComplete: function () {
            this.api().columns([4,5]).every( function () {
                var column = this;
                var select = $('<select><option value="">Todos</option></select>')
                    .appendTo( $(column.footer()).empty() )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
 
                        column
                            .search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                    } );
 
                column.data().unique().sort().each( function ( d, j ) {
                    select.append( '<option value="'+d+'">'+d+'</option>' )
                } );
            } );
        },            
    } );

    // Setup - add a text input to each footer cell
    $('.inputnumerico').each( function () {
        var title = $(this).text();
        $(this).html( '<input class="numerico" type="text" placeholder="Buscar..." style="width: 90%;"/>' );
    } );

    $('.inputcaracter').each( function () {
        var title = $(this).text();
        $(this).html( '<input class="caracter" type="text" placeholder="Buscar..." style="width: 90%;"/>' );
    } );

    $('.inputcompleto').each( function () {
        var title = $(this).text();
        $(this).html( '<input class="completo" type="text" placeholder="Buscar..." style="width: 90%;"/>' );
    } );      
 
    // DataTable
    var table = $('#dataTables-example').DataTable();

    // Apply the search
    table.columns().every( function () {
        var that = this;

        
        $( '.numerico', this.footer() ).on( 'keyup change', function () {
          
            this.value = (this.value + '').replace(/[^0-9]/g, '');
            /* Act on the event */


            if ( that.search() !== this.value ) {
                that
                    .search( this.value )
                    .draw();
            }
        } );
        $( '.caracter', this.footer() ).on( 'keyup change', function () {
          
            this.value = (this.value + '').replace(/[^a-z]+$/i, '');
            /* Act on the event */


            if ( that.search() !== this.value ) {
                that
                    .search( this.value )
                    .draw();
            }
        } );

        $( '.completo', this.footer() ).on( 'keyup change', function () {
          
            if ( that.search() !== this.value ) {
                that
                    .search( this.value )
                    .draw();
            }
        } );
    } );
} );