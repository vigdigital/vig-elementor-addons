/**
 * Icon Search Widget — Toggle dropdown on click
 */
( function () {
	'use strict';

	/**
	 * Initialise one icon search instance.
	 * @param {HTMLElement} wrapper — the .header-search-widget-wrapper element
	 */
	function initIconSearch( wrapper ) {
		var trigger    = wrapper.querySelector( '.header-search-trigger' );
		var dropdown   = wrapper.querySelector( '.header-search-dropdown' );
		var inputField = dropdown ? dropdown.querySelector( '.search-field' ) : null;

		if ( ! trigger || ! dropdown ) {
			return;
		}

		// Guard: prevent double-initialisation (both onReady and elementor hook can fire)
		if ( trigger.dataset.searchBound ) {
			return;
		}
		trigger.dataset.searchBound = '1';

		// Click to toggle dropdown
		trigger.addEventListener( 'click', function ( e ) {
			e.stopPropagation();
			dropdown.classList.toggle( 'active' );

			if ( dropdown.classList.contains( 'active' ) && inputField ) {
				setTimeout( function () {
					inputField.focus();
				}, 100 );
			}
		} );

		// Prevent closing when clicking inside dropdown
		dropdown.addEventListener( 'click', function ( e ) {
			e.stopPropagation();
		} );

		// Close when clicking outside
		document.addEventListener( 'click', function () {
			dropdown.classList.remove( 'active' );
		} );
	}

	/**
	 * Run on DOM ready — target .header-search-widget-wrapper directly.
	 */
	function onReady() {
		document.querySelectorAll( '.header-search-widget-wrapper' ).forEach( initIconSearch );
	}

	if ( document.readyState === 'loading' ) {
		document.addEventListener( 'DOMContentLoaded', onReady );
	} else {
		onReady();
	}

	// Re-init after Elementor frontend renders widgets in the editor preview
	window.addEventListener( 'elementor/frontend/init', function () {
		window.elementorFrontend.hooks.addAction( 'frontend/element_ready/icon_search.default', function ( $scope ) {
			$scope[ 0 ].querySelectorAll( '.header-search-widget-wrapper' ).forEach( initIconSearch );
		} );
	} );
} )();