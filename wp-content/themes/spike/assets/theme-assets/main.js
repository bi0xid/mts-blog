var emailShareButton = require('./blocks/email-share')
var loveSchoolBanner = require('./blocks/loveschool-banner')

$(document).ready(function() {
	$('#course-enroll-banner').length && loveSchoolBanner($('#course-enroll-banner'))

	$('.ess-button--email').each(function() {
		emailShareButton($(this))
	})
})
