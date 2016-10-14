var emailShareModal = require('./blocks/email-share/script')
var loveSchoolBanner = require('./blocks/loveschool-banner')

$(document).ready(function() {
	$('#course-enroll-banner').length && loveSchoolBanner($('#course-enroll-banner'))

	var emailShareModalContainer = $('#email-share-template')
	$('.ess-button--email').on('click', function(e) {
		e.preventDefault()
		emailShareModalContainer.addClass('in')
	})
	emailShareModalContainer.lenght && emailShareModal()
})
