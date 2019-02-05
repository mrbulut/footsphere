/*!
 *
 * SCREETS, d.o.o. Sarajevo. All rights reserved.
 * This  is  commercial  software,  only  users  who have purchased a valid
 * license  and  accept  to the terms of the  License Agreement can install
 * and use this program.
 */

'use strict';




class lcx_AdminOpts {

	constructor() {

		this._ui();
	}

	_ui() {

		const selectBtns = document.getElementsByClassName( 'lcx-browse' );
		const hash = window.location.hash.substr(1) || sessionStorage.getItem( 'lcx-adminOpts-lastTab' ) || '';

		const fn_resetTab = () => {
			this.resetTab();
		};

		// 
		// Manage tabs.
		// 
		const tabs = document.getElementsByClassName( 'lcx-tab-link' );
		for( let i=0; i<tabs.length; i++ ) {
			tabs[i].addEventListener( 'click', function(e) {
				e.preventDefault();

				// Deactivate last active tab
				fn_resetTab();

				const tabHash = this.getAttribute('href').substring(1);

				// Activate current tab
				this.classList.add( 'nav-tab-active' );
				document.getElementById( tabHash ).classList.add( 'lcx-tab--active' );

				// Save the last tab
				sessionStorage.setItem( 'lcx-adminOpts-lastTab', tabHash );
			});
		}

		if( hash ) {
			fn_resetTab();

			const tabLink = document.querySelector( '[href="#' + hash +'"]' );
			if( tabLink ) {
				tabLink.classList.add( 'nav-tab-active' );
				document.getElementById( hash ).classList.add( 'lcx-tab--active' );
			}
		}

		// 
		// Select media buttons.
		//
		jQuery(function($){
			let mediaFrame;
			var fn_openMedia = function(e) {
				e.preventDefault();

				if( mediaFrame ) {
					mediaFrame.open();
					return;
				}

				mediaFrame = wp.media({
					title: 'Select or upload new one',
					button: {
						text: 'Select'
					},
					multiple: false
				});


				mediaFrame.on( 'select', () => {

					const attachment = mediaFrame.state().get('selection').first().toJSON();

					this.previousElementSibling.value = attachment.url;

				});

				mediaFrame.open();
			};


			if( selectBtns ) {

				for( let i=0; i<selectBtns.length; i++ ) {
					selectBtns[i].addEventListener( 'click', fn_openMedia );
				}
			}

		});

		// 
		// Colors.
		// 
		var colorOpts = {
			// a callback to fire whenever the color changes to a valid color
			change: function( event, ui ) {},

			// a callback to fire when the input is emptied or an invalid color
			clear: function() {},

			// hide the color picker controls on load
			hide: true,
			// show a group of common colors beneath the square
			// or, supply an array of colors to customize further
			palettes: [  '#ea3c3b', '#7e8bfe', '#fffc79', '#ff80a7', '#212121' ]
		};

		(function ($, document) {
			jQuery( '.lcx-color' ).wpColorPicker( colorOpts );
		}(jQuery, document));
	}

	// Deactivate last tab
	resetTab() {
		document.querySelector( '.nav-tab-active' ).classList.remove( 'nav-tab-active' );
		document.querySelector( '.lcx-tab--active' ).classList.remove( 'lcx-tab--active' );
	}
}

document.addEventListener( 'DOMContentLoaded', function() {
	const lcx_adminOpts = new lcx_AdminOpts();
});