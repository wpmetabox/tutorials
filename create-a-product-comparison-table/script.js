jQuery( function ( $ ) {
    const $slots          = $( '#compare-bar .slot' );
    const $btnCompare     = $( '#btn-show-compare' );
    const $btnClearAll    = $( '#btn-clear-all' );
    const $tableContainer = $( '#compare-table-container' );
    let selected          = [];

    // Add product.
    $( '.btn-compare' ).on( 'click', function () {
        const id = $( this ).data( 'id' );

        if ( selected.length >= 3 || selected.some( function ( p ) { return p.id === id; } ) ) {
            return;
        }

        const product = {
            id:      id,
            title:   $( this ).data( 'title' ),
            thumb:   $( this ).data( 'thumb' ),
            os:      $( this ).data( 'os' ),
            cpu:     $( this ).data( 'cpu' ),
            storage: $( this ).data( 'storage' ),
            camera:  $( this ).data( 'camera' ),
            battery: $( this ).data( 'battery' )
        };

        selected.push( product );

        // Assign to an empty slot.
        $slots.each( function () {
            if ( ! $( this ).attr( 'data-filled' ) ) {
                $( this ).html(
                    '<img src="' + product.thumb + '" alt="' + product.title + '"><br>' +
                    product.title +
                    '<span class="remove" data-id="' + id + '">x</span>'
                );
                $( this ).attr( 'data-filled', id );
                return false; // Exit the loop.
            }
        } );

        $btnCompare.prop( 'disabled', selected.length < 2 );
    } );

    // Remove product from slot.
    $( '#compare-bar' ).on( 'click', '.remove', function () {
        const id = $( this ).data( 'id' );

        selected = selected.filter( function ( p ) {
            return p.id !== id;
        } );

        $slots.each( function () {
            if ( $( this ).attr( 'data-filled' ) == id ) {
                $( this ).html( '+ Add Product' ).removeAttr( 'data-filled' );
            }
        } );

        $btnCompare.prop( 'disabled', selected.length < 2 );
    } );

    // Delete all products.
    $btnClearAll.on( 'click', function ( e ) {
        e.preventDefault();

        selected = [];
        $slots.html( '+ Add Product' ).removeAttr( 'data-filled' );
        $btnCompare.prop( 'disabled', true );
        $tableContainer.hide();
    } );

    // Show comparison table.
    $btnCompare.on( 'click', function () {
        if ( selected.length < 2 ) {
            return;
        }

        $tableContainer.show();

        // Reset table (delete old header / old rows / highlight).
        $( '#compare-titles' ).html( '<th>Technical specifications</th>' );
        $( '#row-os' ).html( '<td>Operating System</td>' );
        $( '#row-cpu' ).html( '<td>CPU</td>' );
        $( '#row-storage' ).html( '<td>Storage</td>' );
        $( '#row-camera' ).html( '<td>Camera</td>' );
        $( '#row-battery' ).html( '<td>Battery</td>' );
        $( '.compare-table .highlight' ).removeClass( 'highlight' );

        // Render the selected product.
        $.each( selected, function ( i, p ) {
            $( '#compare-titles' ).append( '<th>' + p.title + '</th>' );
            $( '#row-os' ).append( '<td class="field-value">' + ( p.os || '' ) + '</td>' );
            $( '#row-cpu' ).append( '<td class="field-value">' + ( p.cpu || '' ) + '</td>' );
            $( '#row-storage' ).append( '<td class="field-value">' + ( p.storage || '' ) + '</td>' );
            $( '#row-camera' ).append( '<td class="field-value">' + ( p.camera || '' ) + '</td>' );
            $( '#row-battery' ).append( '<td class="field-value">' + ( p.battery || '' ) + '</td>' );
        } );

        // Highlight if there is a duplicate value (at least 2 products have the same value).
        $( '.compare-table tbody tr' ).each( function () {
            const $cells = $( this ).find( '.field-value' );

            if ( $cells.length > 1 ) {
                // build frequency map (normalize: trim + toLowerCase)
                const values = $cells.map( function () {
                    return $.trim( $( this ).text() ).toLowerCase();
                } ).get();

                const freq = {};
                values.forEach( function ( v ) {
                    if ( v === '' ) {
                        return;
                    }
                    freq[ v ] = ( freq[ v ] || 0 ) + 1;
                } );

                // apply highlight to any cell whose value appears >= 2
                $cells.each( function () {
                    const val = $.trim( $( this ).text() ).toLowerCase();
                    if ( val !== '' && freq[ val ] >= 2 ) {
                        $( this ).addClass( 'highlight' );
                    }
                } );
            }
        } );
    } );
} );
