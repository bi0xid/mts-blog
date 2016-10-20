var emailShareModal = require('./blocks/email-share/script')
var loveSchoolBanner = require('./blocks/loveschool-banner')

$(document).ready(function() {
	$('#course-enroll-banner').length && loveSchoolBanner($('#course-enroll-banner'))

	var emailShareModalContainer = $('#email-share-template')

	$('.ess-button--email').on('click', function(e) {
		e.preventDefault()
		emailShareModalContainer.addClass('in')
	})

	$('.share_item.email').on('click', function(e) {
		e.preventDefault()
		var id = $(this).parents('.post.excerpt').data('id')
		emailShareModalContainer.data('postid', id)
		emailShareModalContainer.addClass('in')
	})

	emailShareModalContainer.length && emailShareModal()

	$('.share-item-button.modal').on('click', function(e) {
		e.preventDefault()
		window.open($(this).data('url'), 'My Tiny Secrets share window', 'height=300,width=550,resizable=1');
	})
})
