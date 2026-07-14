/**
 * Product Carousel Widget — Vanilla JS carousel navigation + mouse drag + touch.
 * Initialises Prev/Next buttons and drag scrolling for every .vdp-pc element.
 */
( function () {
	'use strict';

	/** Pixels of movement required before a mousedown is treated as a drag. */
	var DRAG_THRESHOLD = 6;

	/**
	 * Initialise one carousel instance.
	 * @param {HTMLElement} wrapper — the .vdp-pc root element
	 */
	function initCarousel( wrapper ) {
		var track   = wrapper.querySelector( '.vdp-pc__track' );
		var prevBtn = wrapper.querySelector( '.vdp-pc__prev' );
		var nextBtn = wrapper.querySelector( '.vdp-pc__next' );

		if ( ! track ) {
			return;
		}

		// ── Helpers ──────────────────────────────────────────────────────────

		function slideWidth() {
			var slide = track.querySelector( '.vdp-pc__slide' );
			var gap   = parseInt( getComputedStyle( track ).gap || '0', 10 );
			return slide ? slide.offsetWidth + gap : track.offsetWidth * 0.75;
		}

		// ── Prev / Next buttons ───────────────────────────────────────────────

		if ( prevBtn ) {
			prevBtn.addEventListener( 'click', function () {
				track.scrollBy( { left: -slideWidth(), behavior: 'smooth' } );
			} );
		}

		if ( nextBtn ) {
			nextBtn.addEventListener( 'click', function () {
				track.scrollBy( { left: slideWidth(), behavior: 'smooth' } );
			} );
		}

		function updateNavState() {
			if ( ! prevBtn || ! nextBtn ) { return; }
			var atStart = track.scrollLeft <= 0;
			var atEnd   = Math.ceil( track.scrollLeft + track.clientWidth ) >= track.scrollWidth;
			prevBtn.style.opacity      = atStart ? '0.35' : '1';
			prevBtn.style.pointerEvents = atStart ? 'none' : 'auto';
			nextBtn.style.opacity      = atEnd   ? '0.35' : '1';
			nextBtn.style.pointerEvents = atEnd   ? 'none' : 'auto';
		}

		track.addEventListener( 'scroll', updateNavState, { passive: true } );
		updateNavState();

		// ── Mouse drag (desktop) ──────────────────────────────────────────────

		var isDragging  = false;
		var startX      = 0;
		var startScroll = 0;
		var hasMoved    = false;

		track.addEventListener( 'mousedown', function ( e ) {
			// Ignore right-click
			if ( e.button !== 0 ) { return; }
			isDragging  = true;
			hasMoved    = false;
			startX      = e.pageX - track.getBoundingClientRect().left;
			startScroll = track.scrollLeft;
			track.classList.add( 'is-dragging' );
		} );

		// Listen on document so drag continues outside the track bounds
		document.addEventListener( 'mousemove', function ( e ) {
			if ( ! isDragging ) { return; }
			e.preventDefault();
			var x    = e.pageX - track.getBoundingClientRect().left;
			var walk = x - startX;
			if ( Math.abs( walk ) > DRAG_THRESHOLD ) {
				hasMoved = true;
			}
			track.scrollLeft = startScroll - walk;
		} );

		document.addEventListener( 'mouseup', function () {
			if ( ! isDragging ) { return; }
			isDragging = false;
			track.classList.remove( 'is-dragging' );
		} );

		// Prevent a link click from firing after a drag gesture
		track.addEventListener( 'click', function ( e ) {
			if ( hasMoved ) {
				e.preventDefault();
				e.stopPropagation();
				hasMoved = false;
			}
		}, true /* capture */ );

		// Prevent the browser's native image/link drag from interfering
		track.addEventListener( 'dragstart', function ( e ) {
			e.preventDefault();
		} );
	}

	/**
	 * Run on DOM ready.
	 */
	function onReady() {
		document.querySelectorAll( '.vdp-pc' ).forEach( initCarousel );
	}

	if ( document.readyState === 'loading' ) {
		document.addEventListener( 'DOMContentLoaded', onReady );
	} else {
		onReady();
	}

	// Re-init after Elementor frontend renders widgets in the editor preview
	window.addEventListener( 'elementor/frontend/init', function () {
		window.elementorFrontend.hooks.addAction( 'frontend/element_ready/vdp_product_carousel/default', function ( $scope ) {
			initCarousel( $scope[ 0 ] );
		} );
	} );
} )();
