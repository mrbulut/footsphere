/**
 * Live Chat X, by Screets.
 *
 * SCREETS, d.o.o. Sarajevo. All rights reserved.
 * This  is  commercial  software,  only  users  who have purchased a valid
 * license  and  accept  to the terms of the  License Agreement can install
 * and use this program.
 */

'use strict';

var lcx_events,
    lcx_frontend;

(function() {

    var xhr = new XMLHttpRequest();
    var fd = new FormData();
    var data = {
        mode: 'getWidget',
        action: 'lcx_action',
        _ajax_nonce: lcxAJAX.nonce
    };

    xhr.open( 'POST', lcxAJAX.uri, true );

    // Handle response
    xhr.onreadystatechange = function() {

        if ( xhr.readyState == 4 ) {

            // Perfect!
            if( xhr.status == 200 ) {
                if( cb ) { cb( JSON.parse( xhr.responseText ) ); }

            // Something wrong!
            } else {
                if( cb ) { cb( null ); }
            }
        }

    };

    // Get data
    for( var k in data ) fd.append( k, data[k] );

    var cb = function( r ) {

        // Load assets
        if( r.assets ) {
            var obj;
            var total = r.assets.length;
            var head = document.getElementsByTagName( 'head' )[0];
            for( var i=0; i<total; i++ ) {

                // JS
                if( r.assets[i].type === 'js' ) {
                    obj = document.createElement( 'script' );
                    obj.async = false;
                    obj.src = r.assets[i].src;
                    document.head.appendChild( obj );

                // CSS
                } else {
                    obj = document.createElement( 'link' );
                    obj.rel = 'stylesheet';
                    obj.type = 'text/css';
                    obj.href = r.assets[i].href;
                    head.appendChild( obj );
                }

                if( i+1 === total ) { // last asset
                    obj.addEventListener( 'load', function() {
                        init( r );
                    });
                }
            }
        }
    };

    var init = function( r ) {
        // Create widget object
        var widget = document.createElement( 'div' );
        widget.id = 'lcx-widget';
        widget.className = 'lcx lcx-widget';
        document.body.appendChild( widget );

        // Create an iframe
        var iframe = document.createElement( 'iframe' );
        iframe.setAttribute( 'allowfullscreen', '' );
        widget.appendChild( iframe );

        // Write iframe content
        var ibody = iframe.contentWindow.document;
        ibody.open();
        ibody.write( r.iframe );
        ibody.close();

        var opts = {
            _iframe: iframe, //include iframe object
            db: {},
            ajax: {},
            user: {},
            autoinit: true,
            authMethod: 'anonymous',
            initPopup: 'online',
            ntfDuration: 5000, // ms.
            platform: 'frontend',
            dateFormat: 'd/m/Y H:i',
            hourFormat: 'H:i',
            askContactInfo: true,

            // Company data
            companyName: '',
            companyURL: '',
            companyLogo: '',
            anonymousImage: '',
            systemImage: '',
        };

        for( var k in r.opts ) opts[k] = r.opts[k];

        lcx_events = new nBirdEvents();
        lcx_frontend = new nightBird( opts, r.strings );
    };

    // Initiate a multipart/form-data upload
    xhr.send( fd );

})();