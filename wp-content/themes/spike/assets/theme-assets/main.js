var emailShareModal  = require('./blocks/email-share/script'),
	loveSchoolBanner = require('./blocks/loveschool-banner')

$(document).ready(function() {
	// Init Facebook SDK
	window.fbAsyncInit = function() {
		FB.init({
			appId   : '109970876058039',
			xfbml   : true,
			version : 'v2.8'
		})

		FB.AppEvents.logPageView()
	}

	// LoveSchool Banner
	$('#course-enroll-banner').length && loveSchoolBanner($('#course-enroll-banner'))

	/*$('.ess-button--email').on('click', function(e) {
		e.preventDefault()
		emailShareModalContainer.addClass('in')
	})*/

	// Share via Email Action
	var emailShareModalContainer = $('#email-share-template')
	$('.share_item.email').on('click', function(e) {
		e.preventDefault()
		var id = $(this).parents('.post.excerpt').data('id')

		emailShareModalContainer.addClass('in')
		emailShareModalContainer.data('postid', id)
	})

	emailShareModalContainer.length && emailShareModal()

	// Open Share Modal
	$('.share-item-button.modal').on('click', function(e) {
		e.preventDefault()
		window.open($(this).data('url'), 'My Tiny Secrets share window', 'height=300,width=550,resizable=1')
	})
})
