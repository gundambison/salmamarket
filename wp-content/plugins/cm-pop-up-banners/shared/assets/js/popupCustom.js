
function safex( e, t ) {
    return typeof e === "undefined" ? t : e;
}

jQuery( document ).ready( function () {

    function cminds_popup_callback() {
        console.log( 'popup fired' );

        var first_image = jQuery( '#ouibounce-modal .modal .modal-body.auto-size img:eq(0)' );
        if ( first_image.length ) {

            resize_modal = function () {
                var width = jQuery( '#ouibounce-modal .modal .modal-body' ).width();
                var height = jQuery( '#ouibounce-modal .modal .modal-body' ).height();

                jQuery( '#ouibounce-modal .modal' ).css( 'width', width );
                jQuery( '#ouibounce-modal .modal' ).css( 'height', height );
            };

            first_image.on( 'load', resize_modal );
            resize_modal();
        }
        ;
    }

    if ( screen.width > parseInt( popup_custom_data.minDeviceWidth ) )
    {
        jQuery( "body" ).append( safex( popup_custom_data.content, '' ) );

        if ( popup_custom_data.showMethod == 'always' ) {
            setCookie( 'ouibounceBannerShown', 'true', -1 );
        }
        if ( getCookie( 'ouibounceBannerShown' ) === '' ) {
            ouibounce = ouibounce( document.getElementById( 'ouibounce-modal' ), { callback: cminds_popup_callback } );
            setTimeout( function () {
                ouibounce.fire();
                if ( popup_custom_data.showMethod === 'once' ) {
                    setCookie( 'ouibounceBannerShown', 'true', popup_custom_data.resetTime );
                }
            }, popup_custom_data.secondsToShow ),
                jQuery( 'body' ).on( 'click', function () {
                ouibounce.close();
            } );

            jQuery( '#ouibounce-modal #close_button' ).on( 'click', function () {
                ouibounce.close();
            } );

            jQuery( '#ouibounce-modal .modal' ).on( 'click', function ( e ) {
                e.stopPropagation();
            } );
        }
    }
} );