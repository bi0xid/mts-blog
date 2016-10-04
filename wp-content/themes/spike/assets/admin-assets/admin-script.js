var $ = jQuery;

$(document).ready(function() {
	var container = $('#facebook_posts_stats_update')

	if(container.length) {
		require('datatables.net')(window, $)
		var table = $('#table').dataTable()

		container.find('#update_all').on('click', function(e) {
			e.preventDefault()

			$.ajax({
				method: 'GET',
				url: ajaxurl,
				data: {
					action   : 'update_all_facebook_posts',
					security : container.find('#nonce').val()
				}
			}).done(function(response) {
				console.log(response)
			})
		})
	}
})
