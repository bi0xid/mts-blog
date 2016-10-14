var $ = jQuery
var _ = require('underscore')

module.exports = function() {
	var modal = $('#email-share-template')

	var debounceFunc = _.throttle(sendEmailHandler, 600)

	modal.find('form').on('submit', function(e) {
		e.preventDefault()
		debounceFunc()
	})

	modal.find('.close-modal').on('click', closeModal)

	function sendEmailHandler(e) {
		$.post($('#ajax_url').val(), {
			'action'     : 'share_via_email',
			'security'   : $('#email_nonce').val(),
			'email_to'   : modal.find('.to_email').val(),
			'email_from' : modal.find('.from_email').val(),
			'message'    : modal.find('.message').val(),
			'post_id'    : $('#page').data('postid')
		},
		function(response) {
			var parsedData = JSON.parse(response)

			if( parsedData.code == 200 ) {
				closeModal()
				showMessage(parsedData.message)
			} else {
				showMessage(parsedData.message)
			}
		})
	}

	function showMessage(message) {
		$('#message_alert').html(message).fadeIn(400);
		_.delay(function() {
			$('#message_alert').fadeOut(400, function() {
				$(this).html('')
			})
		}, 5000)
	}

	function closeModal() {
		modal.removeClass('in')
		modal.find('input').val('')
	}
}
