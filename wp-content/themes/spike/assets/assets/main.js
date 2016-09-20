$(document).ready(function() {
	if($('#course-enroll-banner').length) {
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
	}
})