jQuery(document).ready(function($){
	jQuery.fn.essb_get_counters = function(){
		return this.each(function(){
			
			var plugin_url 		= $(this).find('.essb_info_plugin_url').val();
			var url 			= $(this).find('.essb_info_permalink').val();

			// tetsing
			//url = "http://google.com";
			
			var $twitter 	= $(this).find('.essb_link_twitter');
			var $linkedin 	= $(this).find('.essb_link_linkedin');
			var $delicious 	= $(this).find('.essb_link_delicious');
			var $facebook 	= $(this).find('.essb_link_facebook');
			var $pinterest 	= $(this).find('.essb_link_pinterest');
			var $google 	= $(this).find('.essb_link_google');
			var $stumble 	= $(this).find('.essb_link_stumbleupon');
			var $vk         = $(this).find('.essb_link_vk');
                        
                        var $digg       = $(this).find('.essb_link_digg');
                        var $mail      = $(this).find('.essb_link_mail');


			var twitter_url		= "http://cdn.api.twitter.com/1/urls/count.json?url=" + url + "&callback=?"; 
			//
			var delicious_url	= "http://feeds.delicious.com/v2/json/urlinfo/data?url=" + url + "&callback=?" ;
			// 
			var linkedin_url	= "http://www.linkedin.com/countserv/count/share?format=jsonp&url=" + url + "&callback=?";
			// 
			var pinterest_url       = "http://api.pinterest.com/v1/urls/count.json?callback=?&url=" + url;
			// 
			var facebook_url	= "https://graph.facebook.com/fql?q=SELECT%20like_count,%20total_count,%20share_count,%20click_count,%20comment_count%20FROM%20link_stat%20WHERE%20url%20=%20%22"+url+"%22";
			// 
			var google_url		= plugin_url+"/public/get-noapi-counts.php?nw=google&url=" + url;
			var stumble_url		= plugin_url+"/public/get-noapi-counts.php?nw=stumble&url=" + url;
			var vk_url              = plugin_url+"/public/get-noapi-counts.php?nw=vk&url=" + url;
			
                        var dig_url              = plugin_url + "/public/setCounter.php?action=getCount&iPostId=" + parseInt(window._wp_rp_post_id) + "&type=digg";
                        var mail_url             = plugin_url + "/public/setCounter.php?action=getCount&iPostId=" + parseInt(window._wp_rp_post_id) + "&type=mail";
                        
                        if ( $digg.length ) {
				$.getJSON(dig_url)
					.done(function(data){
						$digg.prepend('<span class="essb_counter">' + data.count + '</span>');
					});
			}
                        
                        if ( $mail.length ) {
				$.getJSON(mail_url)
					.done(function(data){
						$mail.prepend('<span class="essb_counter">' + data.count + '</span>');
					});
			}
                        

			if ( $twitter.length ) {
				$.getJSON(twitter_url)
					.done(function(data){
						$twitter.prepend('<span class="essb_counter">' + data.count + '</span>');
					});
			}
			if ( $linkedin.length ) {
				$.getJSON(linkedin_url)
					.done(function(data){
						$linkedin.prepend('<span class="essb_counter">' + data.count + '</span>');
					});
			}
			if ( $pinterest.length ) {
				$.getJSON(pinterest_url)
					.done(function(data){
						$pinterest.prepend('<span class="essb_counter">' + data.count + '</span>');
					});
			}
			if ( $google.length ) {
				$.getJSON(google_url)
					.done(function(data){
						$google.prepend('<span class="essb_counter">' + data.count + '</span>');
					})
			}
			if ( $stumble.length ) {
				$.getJSON(stumble_url)
					.done(function(data){
						$stumble.prepend('<span class="essb_counter">' + data.count + '</span>');
					})
			}
			if ( $facebook.length ) {
				$.getJSON(facebook_url)
					.done(function(data){
						$facebook.prepend('<span class="essb_counter">' + data.data[0].share_count + '</span>');
					});
			}
			if ( $delicious.length ) {
				$.getJSON(delicious_url)
					.done(function(data){
						$delicious.prepend('<span class="essb_counter">' + data[0].total_posts + '</span>');
					});
			}
			if ( $vk.length ) {
				$.getJSON(vk_url)
					.done(function(data){
						$vk.prepend('<span class="essb_counter">' + data.count + '</span>');
					});
			}
		});
	}; 
                
	jQuery.fn.essb_update_counters = function(){
		return this.each(function(){

			var $group			= $(this);
			var $total_count 	= $group.find('.essb_totalcount');
			var $total_count_nb = $total_count.find('.essb_t_nb');
			var total_text = $total_count.attr('title');
			$total_count.prepend('<span class="essb_total_text">'+total_text+'</span>');

			function count_total() {
				var total = 0;
				$group.find('.essb_counter').each(function(){
					total += parseInt($(this).text());		
					
					var value = parseInt($(this).text());
					
					if (!$total_count_nb) {
					value = shortenNumber(value);
					$(this).text(value);
				}
					
				});
				$total_count_nb.text(shortenNumber(total));
			}
			
			  function shortenNumber(n) {
				    if ('number' !== typeof n) n = Number(n);
				    var sgn      = n < 0 ? '-' : ''
				      , suffixes = ['k', 'M', 'G', 'T', 'P', 'E', 'Z', 'Y']
				      , overflow = Math.pow(10, suffixes.length * 3 + 3)
				      , suffix, digits;
				    n = Math.abs(Math.round(n));
				    if (n < 1000) return sgn + n;
				    if (n >= 1e100) return sgn + 'many';
				    if (n >= overflow) return (sgn + n).replace(/(\.\d*)?e\+?/i, 'e'); // 1e24
				 
				    do {
				      n      = Math.floor(n);
				      suffix = suffixes.shift();
				      digits = n % 1e6;
				      n      = n / 1000;
				      if (n >= 1000) continue; // 1M onwards: get them in the next iteration
				      if (n >= 10 && n < 1000 // 10k ... 999k
				       || (n < 10 && (digits % 1000) < 100) // Xk (X000 ... X099)
				         )
				        return sgn + Math.floor(n) + suffix;
				      return (sgn + n).replace(/(\.\d).*/, '$1') + suffix; // #.#k
				    } while (suffixes.length)
				    return sgn + 'many';
				  }
			setInterval(count_total, 1200);

		});
	}; 
	
        
        $('.essb_link_digg').click(function(){
            var plugin_url  = $('.essb_links.essb_counters').find('.essb_info_plugin_url').val();
            if (typeof(plugin_url) == 'undefined')
                plugin_url = $('#additonal_easy_share_button_url').val();
            var postId = parseInt($(this).find('#home_page_post_id').val());
            if (!postId)
                postId = parseInt(window._wp_rp_post_id);
            var ajaxUrlEasyButton = plugin_url + "/public/setCounter.php?action=setCount&iPostId=" + postId + "&type=digg";            
            $.ajax({ 
                url: ajaxUrlEasyButton,
                type: "POST",
                data: {
                    action: 'setCount',
                    iPostId: postId,
                    type: 'digg'
                }
            });
        });        
        $('.essb_link_mail').click(function(){
            var plugin_url  = $('.essb_links.essb_counters').find('.essb_info_plugin_url').val();
            if (typeof(plugin_url) == 'undefined')
                plugin_url = $('#additonal_easy_share_button_url').val();
            var postId = parseInt($(this).find('#home_page_post_id').val());
            if (!postId)
                postId = parseInt(window._wp_rp_post_id);
            var ajaxUrlEasyButton = plugin_url + "/public/setCounter.php?action=setCount&iPostId=" + postId + "&type=mail";            
            $.ajax({
                type: "POST",
                url: ajaxUrlEasyButton,                
                data: {
                    action: 'setCount',
                    iPostId: postId,
                    type: 'mail'
                }
            });
        });
        
	//$('.essb_links.essb_counters').essb_get_counters();
	//$('.essb_counters .essb_links_list').essb_update_counters();
        
        
        if($('.essb_links_list').length){
            var postId = parseInt(window._wp_rp_post_id);
            var plugin_url 		= $(this).find('.essb_info_plugin_url').val();            
            var url = plugin_url + "/public/getCounters.php?action=getForSinglePost&postId=" + postId;
            
            $.ajax({
                type: "GET",
                url: url,
                dataType: 'json',
                async: true,
                success: function(data) {
                    var twitter_shares_count = 0;
                    var fbsharecount_shares_count = 0;
                    var google_shares_count = 0;
                    var pinterest_shares_count = 0;
                    var digg_post_type = 0;
                    var stumble_shares_count = 0;
                    var mail_post_type = 0;
                    
                    if (typeof data.twitter_shares_count !== 'undefined' && data.twitter_shares_count){
                        twitter_shares_count = data.twitter_shares_count;
                    }
                    if (typeof data.fbsharecount_shares_count !== 'undefined' && data.fbsharecount_shares_count){
                        fbsharecount_shares_count = data.fbsharecount_shares_count;
                    }
                    if (typeof data.google_shares_count !== 'undefined' && data.google_shares_count){
                        google_shares_count = data.google_shares_count;
                    }
                    if (typeof data.pinterest_shares_count !== 'undefined' && data.pinterest_shares_count){
                        pinterest_shares_count = data.pinterest_shares_count;
                    }
                    if (typeof data.digg_post_type !== 'undefined' && data.digg_post_type){
                        digg_post_type = data.digg_post_type;
                    }
                    if (typeof data.stumble_shares_count !== 'undefined' && data.stumble_shares_count){
                        stumble_shares_count = data.stumble_shares_count;
                    }
                    if (typeof data.mail_post_type !== 'undefined' && data.mail_post_type){
                        mail_post_type = data.mail_post_type;
                    }
                    
                    $('.essb_links_list').find('.essb_link_facebook').find('.essb_counter').html(fbsharecount_shares_count);
                    $('.essb_links_list').find('.essb_link_twitter').find('.essb_counter').html(twitter_shares_count);
                    $('.essb_links_list').find('.essb_link_pinterest').find('.essb_counter').html(pinterest_shares_count);
                    $('.essb_links_list').find('.essb_link_google').find('.essb_counter').html(google_shares_count);
                    $('.essb_links_list').find('.essb_link_stumbleupon').find('.essb_counter').html(stumble_shares_count);
                    $('.essb_links_list').find('.essb_link_digg').find('.essb_counter').html(digg_post_type);
                    $('.essb_links_list').find('.essb_link_mail').find('.essb_counter').html(mail_post_type);
                }
            });
            
            
            
        }
});
