( function( $ ) {
	// Add Upgrade Message to Customizer Header
	if ('undefined' !== typeof cleanretinaproupgrade) {
		upsell = $('<a class="cleanretina-upgrade-link"></a>')
			.attr('href', cleanretinaproupgrade.cleanretinaprourl)
			.attr('target', '_blank')
			.text(cleanretinaproupgrade.cleanretinaprolabel)
			.css({
				'padding': '3px 12px 2px',
				'display': 'inline-block',
				'color': '#fff',
				'background-color': 'rgba(150, 81, 204, 1)',
				'margin-top': '6px',
				'-webkit-border-radius': '2px',
				'-moz-border-radius': '2px',
				'border-radius': '2px',
				'font-size': '12px',
				'text-transform': 'uppercase'
			})
		;
		setTimeout(function () {
			$('.preview-notice').append(upsell);
		}, 200);
		// Remove accordion click event
		$('.preview-notice').on('click', function(e) {
			e.stopPropagation();
		});
	}
} )( jQuery );