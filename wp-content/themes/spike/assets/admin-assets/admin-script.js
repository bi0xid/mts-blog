var $ = jQuery;

$(document).ready(function() {
	var container = $('#facebook_posts_stats_update')

	if(container.length) {
		require('datatables.net')(window, $)
		var table = $('#table').dataTable()

		var loadingSpinner = container.find('.loading-background')

		container.find('#update_all').on('click', function(e) {
			e.preventDefault()
			ajaxCall('update_all_posts_media')
		})

		container.find('.individual_updated li a').on('click', function(e) {
			e.preventDefault()
			ajaxCall($(this).data('ajax'))
		})
	}

	function ajaxCall(url) {
		loadingSpinner.addClass('in')

		$.ajax({
			method: 'GET',
			url: ajaxurl,
			data: {
				action   : url,
				security : container.find('#nonce').val()
			}
		}).done(function(response) {
			loadingSpinner.removeClass('in')
			alert(JSON.parse(response).message)
		})
	}
})
