$(document).ready(function() {
	if($('#course-enroll-banner').length) {
		require('countdown')
		var moment = require('moment-timezone')

		var counter = $('#ls_course_counter')
		var deadlineDate = moment.tz(counter.data('deadline'), 'America/Port_of_Spain')

		counter.find('.counter').countdown(deadlineDate.toDate(), function(event) {
			var $this = $(this).html(event.strftime(''
				+ '<span>%D</span>'
				+ '<span>%H</span>'
				+ '<span class="last">%M</span>'
			))
		})
	}
})