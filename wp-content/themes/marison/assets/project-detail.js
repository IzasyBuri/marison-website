( function () {
	'use strict';

	document.addEventListener( 'DOMContentLoaded', function () {
		var detail = document.querySelector( '[data-project-detail]' );
		var hero = document.querySelector( '[data-project-hero]' );
		var contact = document.querySelector( '[data-project-contact]' );
		var sticky = document.querySelector( '[data-project-sticky]' );
		if ( ! detail || ! hero || ! contact || ! sticky || ! window.IntersectionObserver ) {
			return;
		}

		var setVisible = function ( visible ) {
			sticky.hidden = ! visible;
			detail.classList.toggle( 'has-project-sticky', visible );
		};
		var heroObserver = new IntersectionObserver( function ( entries ) {
			var entry = entries[ 0 ];
			if ( entry.isIntersecting ) {
				setVisible( false );
			} else if ( entry.boundingClientRect.top < 0 ) {
				setVisible( true );
			}
		}, { threshold: 0 } );
		var contactObserver = new IntersectionObserver( function ( entries ) {
			if ( entries[ 0 ].isIntersecting ) {
				setVisible( false );
			}
		}, { threshold: 0.05 } );

		heroObserver.observe( hero );
		contactObserver.observe( contact );
	} );
}() );
