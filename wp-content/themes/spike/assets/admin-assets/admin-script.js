var $ = jQuery;

$(document).ready(function() {
	var container = $('#facebook_posts_stats_update')

	if(container.length) {
		require('datatables.net')(window, $)
		var table = $('#table').dataTable()

		var loadingSpinner = container.find('.loading-background')

		container.find('#update_all').on('click', function(e) {
			e.preventDefault()
			loadingSpinner.addClass('in')

			$.ajax({
				method: 'GET',
				url: ajaxurl,
				data: {
					action   : 'update_all_facebook_posts',
					security : container.find('#nonce').val()
				}
			}).done(function(response) {
				var parsedData = JSON.parse(response)
				loadingSpinner.removeClass('in')
				container.find('#update_date').html(parsedData.new_fetch_date)
			})
		})
	}
})
