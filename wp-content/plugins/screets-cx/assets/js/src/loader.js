/**
 * Live Chat X, by Screets.
 *
 * SCREETS, d.o.o. Sarajevo. All rights reserved.
 * This  is  commercial  software,  only  users  who have purchased a valid
 * license  and  accept  to the terms of the  License Agreement can install
 * and use this program.
 */

'use strict';

(function() {
    console.log( 'd>' + d );
    var d = document;
    window.addEventListener( "load", function() {
        var b = d.createElement("script");
        b.src = lcxAPI.uri + '/assets/js/widget.js';
        b.async = !0;
        d.head.appendChild(b);
    }, !1);
})();