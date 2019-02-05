/*!
 *
 * SCREETS, d.o.o. Sarajevo. All rights reserved.
 * This  is  commercial  software,  only  users  who have purchased a valid
 * license  and  accept  to the terms of the  License Agreement can install
 * and use this program.
 */

;(function () {	

	var W = window,
		D = document,
		_ruleRowi = 1; // Rules list index;

	D.addEventListener( 'DOMContentLoaded', function() {
		fn_listenRules();
	});

	var fn_triggerEvent = function( eventName, $el ) {
		if ( 'createEvent' in D ) {
			var e = D.createEvent( 'HTMLEvents' );
			e.initEvent( eventName, false, true);
			$el.dispatchEvent(e);
		} else {
			$el.fireEvent( 'on' + eventName );
		}
	};

	/**
	 * Listen rules.
	 */
	var fn_listenRules = function() {
		
		var $rows = D.getElementsByClassName( 'lcx-rule-row' );
		
		for( var i=0; i<$rows.length; i++ ) {
			fn_listenRow( $rows[i] );
		}

	};
	var fn_listenRow = function( $row ) {

		$row.classList.add( 'lcx-rule-row' );

		if( _ruleRowi > 1 ) {
			// Hide "if" prefix
			$row.querySelector('.lcx-condition-title').classList.remove('lcx-active');

			// Show condition select list
			$row.querySelector('.lcx-condition-list').classList.add('lcx-active');
		}

		_ruleRowi++;

		// Listen "add rule" button
		var $btnAddRule = $row.querySelector('.lcx-add-rule');
		$btnAddRule.removeEventListener( 'click', fn_addRule );
		$btnAddRule.addEventListener( 'click', fn_addRule );

		// Listen "remove rule" button
		var $btnRemoveRule = $row.querySelector('.lcx-remove-rule');
		if( $btnRemoveRule ) {
			$btnRemoveRule.removeEventListener( 'click', fn_removeRule );
			$btnRemoveRule.addEventListener( 'click', fn_removeRule );
		}

		/**
		 * Listen rule types in the current row
		 */
		var $rules, $lastRuleEls, $ruleComp, $ruleVal;
		$rules = $row.querySelectorAll('.lcx-rule-types');

		// Disable all rule fields by default
		var $els = $row.querySelectorAll( '.lcx-rule-el input, .lcx-rule-el select, .lcx-rule-el textarea' );
		for( var k=0; k<$els.length; k++ ) {
			$els[k].disabled = true;
		}

		for( var i=0; i<$rules.length; i++ ) {
			// Listen rule type changes
			$rules[i].addEventListener( 'change', function(e) {
				var val = this.value;
				var row = this.parentNode.parentNode;

				// Hide last active element
				$lastRuleEls = row.querySelectorAll('.lcx-rule-el.lcx-active');
				if($lastRuleEls) {
					for( var k=0; k<$lastRuleEls.length; k++ ) {
						$lastRuleEls[k].classList.remove('lcx-active');
						$lastRuleEls[k].querySelector('input,select,textarea').disabled = true;
					}
				}

				// Show related rule elements
				$ruleComp = row.querySelector('.lcx-rule-content-comp-'+val);
				$ruleVal = row.querySelector('.lcx-rule-content-val-'+val);
				
				$ruleComp.classList.add('lcx-active');
				$ruleComp.querySelector('input,select,textarea').disabled = false;
				
				$ruleVal.classList.add('lcx-active');
				$ruleVal.querySelector('input,select,textarea').disabled = false;

			});

			fn_triggerEvent( 'change', $rules[i] );
		}
	};
	var fn_addRule = function(e) {
		e.preventDefault();

		var $row, $rules, $newRow;

		// Get current row
		$row = this.parentNode.parentNode;

		$rules = D.getElementById('lcx-rules-list');

		// Create new row
		$row.insertAdjacentHTML( 'afterend', $row.innerHTML );

		var $newRow = $row.nextSibling;
		while( $newRow && $newRow.nodeType != 1) {
		    $newRow = $newRow.nextSibling
		}

		// Listen new row
		fn_listenRow( $newRow );
	};
	var fn_removeRule = function(e) {
		e.preventDefault();

		var $currentRow = this.parentNode.parentNode;
			$currentRow.parentNode.removeChild( $currentRow );
	};

})();