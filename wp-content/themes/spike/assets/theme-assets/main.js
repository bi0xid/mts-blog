var emailShareModal = require('./blocks/email-share/script')
var loveSchoolBanner = require('./blocks/loveschool-banner')

$(document).ready(function() {
	$('#course-enroll-banner').length && loveSchoolBanner($('#course-enroll-banner'))

	var emailShareModalContainer = $('#email-share-template')
	$('.ess-button--email').on('click', function(e) {
		e.preventDefault()
		emailShareModalContainer.addClass('in')
	})

	$('.essb_link_mail').on('click', function(e) {
		e.preventDefault()
		var id = $(this).parents('.post.excerpt').data('id')
		emailShareModalContainer.data('postid', id)
		emailShareModalContainer.addClass('in')
	})
	emailShareModalContainer.length && emailShareModal()
})
