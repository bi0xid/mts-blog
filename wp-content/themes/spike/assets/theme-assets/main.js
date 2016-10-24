var emailShareModal  = require('./blocks/email-share/script'),
	loveSchoolBanner = require('./blocks/loveschool-banner')

var _ = require('underscore')

$(document).ready(function() {
	// LoveSchool Banner
	$('#course-enroll-banner').length && loveSchoolBanner($('#course-enroll-banner'))

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

	// Floating share block
	if($('#blog').hasClass('single')) {
		require('../plugins/jquery.bullseye-1.0.js')
		require('../plugins/jquery.visible.js')

		var floatingBlock = $('#floating_share')

		var initialTop = $('.article img.alignnone.size-full').offset()
		floatingBlock.css('top', initialTop)

		var bullseyeTopElement = $('.social_shares.single_post')
			? $('.social_shares.single_post').first()
			: $('.article img.alignnone.size-full')

		bullseyeTopElement
			.bind('enterviewport', function() {
				floatingBlock.removeClass('fixed')
			})
			.bind('leaveviewport', function() {
				floatingBlock.addClass('fixed')
			})
		.bullseye()

		_.defer(function() {
			!bullseyeTopElement.visible(true) && floatingBlock.addClass('fixed')
		})
	}
})
