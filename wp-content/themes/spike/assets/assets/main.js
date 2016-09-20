$(document).ready(function() {
	var container = $('#course-enroll-banner')
	var videoBackground = $('.loveschool-teaser-video-background')

	if(container.length) {
		require('countdown')
		var moment = require('moment-timezone')

		var counter = $('#ls_course_counter')
		var deadlineDate = moment.tz(counter.data('deadline'), 'America/Port_of_Spain')

		counter.find('.counter_labels').countdown(deadlineDate.toDate(), function(event) {
			var $this = $(this).html(event.strftime(''
				+ '<div class="d">'
					+ '<span class="label">Days</span>'
					+ '<span>%D</span>'
				+ '</div>'
				+ '<div class="gh">'
					+ '<span class="label">Hours</span>'
					+ '<span>%H</span>'
				+ '</div>'
				+ '<div class="m">'
					+ '<span class="label last">Minutes</span>'
					+ '<span class="last">%M</span>'
				+ '</div>'
			))
		})

		var player = new YT.Player('teaser-video', {
			height  : '390',
			width   : '640',
			videoId : 'Stdk8LTsMx4',
		})

		container.find('.play-btn').on('click', function() {
			videoBackground.fadeIn(400, function() {
				player.playVideo()
			})
		})

		videoBackground.on('click', function() {
			player.stopVideo()
			videoBackground.fadeOut(400)
		})

		videoBackground.find('.close-video').on('click', function() {
			player.stopVideo()
			videoBackground.fadeOut(400)
		})

		container.find('a.btn').on('click', function() {
			trackOutboundLink('http://adinariversloveschool.com/pussy-pleasure-course/')
			return false
		})
	}

	var trackOutboundLink = function(url) {
		ga('send', 'event', 'outbound', 'click', url, {
			'transport'  : 'beacon',
			'hitCallback': function() {
				document.location = url
			}
		})
	}
})