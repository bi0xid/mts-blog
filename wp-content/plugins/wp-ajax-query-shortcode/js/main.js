var $ = jQuery;

// Global variable
window.short_code_ajax_is_loading = false;

function wp_ajax_query_shortcodeclassic(ajaxParam) {
	var item_showed = $('#waq'+ajaxParam['waq_id']+' .wp-ajax-query-content .ajax-item').length;

	if(!item_showed) {
		item_showed = $('.post.excerpt').length;
	}

	if(item_showed < 9999) {
		$('#waq'+ajaxParam['waq_id']+' .wp-ajax-loading-images').addClass('show');

		var param1 = { action: 'wp_ajax_query' };
		var param = $.extend({}, param1, ajaxParam);

		short_code_ajax_is_loading = true;

		param['ajax_runnig'] = true;
		param['offset'] = item_showed * 1;

		$.ajax({
			type: "GET",
			url: ajaxParam['home_url']+"ajax.php",
			dataType: 'html',
			data: (param),
			success: function(data) {
				short_code_ajax_is_loading = false;
				if(data == '-11'|| data.replace(/(\r\n|\n|\r)/gm, "") == '-11') {
					$('#waq'+ajaxParam['waq_id']+' .wp-ajax-query-button a').html('<i class="icon-remove"></i> No more');
					$('#waq'+ajaxParam['waq_id']+' .wp-ajax-query-button a').fadeOut(1000, function() {
						$(this).remove();
					});

					$('#waq'+ajaxParam['waq_id']+' .wp-ajax-loading-images').remove();
				} else {
					$('#waq'+ajaxParam['waq_id']+' .wp-ajax-loading-images').removeClass('show');
					$(data).hide().appendTo('#waq'+ajaxParam['waq_id']+' .wp-ajax-query-content').slideDown('slow').imagesLoaded( function(){
						wp_ajax_query_resize();
					});
				}
			}
		});
	}
}

function wp_ajax_query_shortcodemodern(ajaxParam) {
	var item_showed = $('#waq'+ajaxParam['waq_id']+' .wp-ajax-query-content .ajax-item').length;

	if(item_showed < 9999) {
		$('#waq'+ajaxParam['waq_id']+' .wp-ajax-loading-images').addClass('show');

		var param1 = { action: 'wp_ajax_query' };
		var param = $.extend({}, param1, ajaxParam);

		short_code_ajax_is_loading = true;

		param['ajax_runnig'] = true;
		param['offset'] = param['offset'] * 1 + item_showed * 1;

		$.ajax({
			type: "GET",
			url: ajaxParam['home_url'] + 'ajax.php',
			dataType: 'html',
			data: (param),
			success: function(data) {
				short_code_ajax_is_loading = false;
				if(data == '-11'|| data.replace(/(\r\n|\n|\r)/gm, "") == '-11') {
					$('#waq'+ajaxParam['waq_id']+' .wp-ajax-query-button a').html('<i class="icon-remove"></i> No more');
					$('#waq'+ajaxParam['waq_id']+' .wp-ajax-query-button a').fadeOut(1500, function(){
						$(this).remove();
					});
					$('#waq'+ajaxParam['waq_id']+' .wp-ajax-loading-images').remove();
				} else {
					$('#waq'+ajaxParam['waq_id']+' .wp-ajax-loading-images').removeClass('show');
					$('#waq'+ajaxParam['waq_id']+'.modern .wp-ajax-query-content').append(data).imagesLoaded(function() {
						wp_ajax_query_resize();
						$('#waq'+ajaxParam['waq_id']+'.modern .wp-ajax-query-content').masonry().masonry('reload');
					});
				}
			}
		});
	}
}

function waq_isScrolledIntoView(elem) {
	var docViewTop = $(window).scrollTop();
	var docViewBottom = docViewTop + $(window).height();

	var elemTop = $(elem).offset().top;
	var elemBottom = elemTop + $(elem).height();

	return ((elemBottom <= docViewBottom + 50) && (elemTop >= docViewTop));
}

function wp_ajax_query_resize() {
	$('.ajax-item-thumb').height( function(){
		return $(this).children('img').height();
	});
}

$(window).resize(function() {
	wp_ajax_query_resize();        
	$('.modern .wp-ajax-query-content').masonry().masonry('reload');
});

$(window).load(wp_ajax_query_resize);

$(document).ready(function(e) {
	$('.ajax-layout-toggle').click(function(e){
		$(this).closest('.wp-ajax-query-shortcode').toggleClass('comboed');

		wp_ajax_query_resize();

		$(this).closest('.wp-ajax-query-shortcode').find('.wp-ajax-query-content').masonry().masonry('reload');
	});
});
