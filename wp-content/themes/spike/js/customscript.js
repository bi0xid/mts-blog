	/*
 * Superfish v1.4.8 - jQuery menu widget
 * Copyright (c) 2008 Joel Birch
 *
 * Dual licensed under the MIT and GPL licenses:
 * 	http://www.opensource.org/licenses/mit-license.php
 * 	http://www.gnu.org/licenses/gpl.html
 *
 * CHANGELOG: http://users.tpg.com.au/j_birch/plugins/superfish/changelog.txt
 */
(function($){$.fn.superfish=function(op){var sf=$.fn.superfish,c=sf.c,$arrow=$(['<span class="',c.arrowClass,'"> &#xbb;</span>'].join("")),over=function(){var $$=$(this),menu=getMenu($$);clearTimeout(menu.sfTimer);$$.showSuperfishUl().siblings().hideSuperfishUl();},out=function(){var $$=$(this),menu=getMenu($$),o=sf.op;clearTimeout(menu.sfTimer);menu.sfTimer=setTimeout(function(){o.retainPath=($.inArray($$[0],o.$path)>-1);$$.hideSuperfishUl();if(o.$path.length&&$$.parents(["li.",o.hoverClass].join("")).length<1){over.call(o.$path);}},o.delay);},getMenu=function($menu){var menu=$menu.parents(["ul.",c.menuClass,":first"].join(""))[0];sf.op=sf.o[menu.serial];return menu;},addArrow=function($a){$a.addClass(c.anchorClass).append($arrow.clone());};return this.each(function(){var s=this.serial=sf.o.length;var o=$.extend({},sf.defaults,op);o.$path=$("li."+o.pathClass,this).slice(0,o.pathLevels).each(function(){$(this).addClass([o.hoverClass,c.bcClass].join(" ")).filter("li:has(ul)").removeClass(o.pathClass);});sf.o[s]=sf.op=o;$("li:has(ul)",this)[($.fn.hoverIntent&&!o.disableHI)?"hoverIntent":"hover"](over,out).each(function(){if(o.autoArrows){addArrow($(">a:first-child",this));}}).not("."+c.bcClass).hideSuperfishUl();var $a=$("a",this);$a.each(function(i){var $li=$a.eq(i).parents("li");$a.eq(i).focus(function(){over.call($li);}).blur(function(){out.call($li);});});o.onInit.call(this);}).each(function(){var menuClasses=[c.menuClass];if(sf.op.dropShadows&&!($.browser.msie&&$.browser.version<7)){menuClasses.push(c.shadowClass);}$(this).addClass(menuClasses.join(" "));});};var sf=$.fn.superfish;sf.o=[];sf.op={};sf.IE7fix=function(){var o=sf.op;if($.browser.msie&&$.browser.version>6&&o.dropShadows&&o.animation.opacity!=undefined){this.toggleClass(sf.c.shadowClass+"-off");}};sf.c={bcClass:"sf-breadcrumb",menuClass:"sf-js-enabled",anchorClass:"sf-with-ul",arrowClass:"sf-sub-indicator",shadowClass:"sf-shadow"};sf.defaults={hoverClass:"sfHover",pathClass:"overideThisToUse",pathLevels:1,delay:800,animation:{opacity:"show"},speed:"normal",autoArrows:true,dropShadows:true,disableHI:false,onInit:function(){},onBeforeShow:function(){},onShow:function(){},onHide:function(){}};$.fn.extend({hideSuperfishUl:function(){var o=sf.op,not=(o.retainPath===true)?o.$path:"";o.retainPath=false;var $ul=$(["li.",o.hoverClass].join(""),this).add(this).not(not).removeClass(o.hoverClass).find(">ul").hide().css("visibility","hidden");o.onHide.call($ul);return this;},showSuperfishUl:function(){var o=sf.op,sh=sf.c.shadowClass+"-off",$ul=this.addClass(o.hoverClass).find(">ul:hidden").css("visibility","visible");sf.IE7fix.call($ul);o.onBeforeShow.call($ul);$ul.animate(o.animation,o.speed,function(){sf.IE7fix.call($ul);o.onShow.call($ul);});return this;}});})(jQuery);
	$(document).ready(function($) { 
	$('#navigation ul.menu, #navigation ul#children, #navigation ul.sub-menu').superfish({ 
		delay:       100,								// 0.1 second delay on mouseout 
		animation:   {opacity:'show',height:'show'},	// fade-in and slide-down animation 
		dropShadows: false								// disable drop shadows 
	});
});

$(document).ready(function() {
	// Create the dropdown base
   $("<select />").appendTo("#navigation");
      // Create default option "Go to..."
      $("<option />", {
         "selected": "selected",
         "value"   : "",
         "text"    : "Go to..."
      }).appendTo("#navigation select");
      // Populate dropdown with menu items
      $("#navigation > ul > li:not([data-toggle])").each(function() {
      	var el = $(this);
      	var hasChildren = el.find("ul"),
      	    children    = el.find("li > a");
      	if (hasChildren.length) {
      		$("<optgroup />", {
      			"label": el.find("> a").text()
      		}).appendTo("#navigation select");
      		children.each(function() {		
      			$("<option />", {
					"value"   : $(this).attr("href"),
      				"text": " - " + $(this).text()
      			}).appendTo("optgroup:last");
      		});    	
      	} else {
      		$("<option />", {
	           "value"   : el.find("> a").attr("href"),
	           "text"    : el.find("> a").text()
	       }).appendTo("#navigation select");
      	}   
      });
      $("#navigation select").change(function() {
        window.location = $(this).find("option:selected").val();
      });
	//END -- Menus to <SELECT>	
	}); //END -- JQUERY document.ready

// Scroll to Top script
jQuery(document).ready(function($){
    $('a[href=#top]').click(function(){
        $('html, body').animate({scrollTop:0}, 'slow');
        return false;
    });
$(".togglec").hide();
    	
    	$(".togglet").click(function(){
    	
    	$(this).toggleClass("toggleta").next(".togglec").slideToggle("normal");
    	   return true;
    	});
});

// Tabs
jQuery(document).ready(function($){
	$('.stabs a').click(function(){
		switch_tabs($(this));
	});
	switch_tabs($('.defaulttab'));
	function switch_tabs(obj) {
		$('.stab-content').hide();
		$('.stabs a').removeClass("selected");
		var id = obj.attr("rel");
		$('#'+id).show();
		obj.addClass("selected");
	}
});

jQuery(document).ready(function(){
	// UL = .tabs
	// Tab contents = .inside
	var tag_cloud_class = '#tag-cloud'; 
	//Fix for tag clouds - unexpected height before .hide() 
	var tag_cloud_height = jQuery('#tag-cloud').height();
	jQuery('.inside ul li:last-child').css('border-bottom','0px') // remove last border-bottom from list in tab conten
	jQuery('.tabs').each(function(){
	jQuery(this).children('li').children('a:first').addClass('selected'); // Add .selected class to first tab on load
	});
	jQuery('.inside > *').hide();
	jQuery('.inside > *:first-child').show();
	jQuery('.tabs li a').click(function(evt){ // Init Click funtion on Tabs
	var clicked_tab_ref = jQuery(this).attr('href'); // Strore Href value
	jQuery(this).parent().parent().children('li').children('a').removeClass('selected'); //Remove selected from all tabs
	jQuery(this).addClass('selected');
	jQuery(this).parent().parent().parent().children('.inside').children('*').hide();
	jQuery('.inside ' + clicked_tab_ref).fadeIn(500);
	evt.preventDefault();

	})
	
	/*react-share functions */
	
	$('#reactshare-button .rs-share, #reactshare-button .rs-react').click(function(e) {
		 e.preventDefault();
		$('#reactshare-button').addClass('opened');
		$('.react-overlay').show();
	});
	
	$('.react-overlay').click(function(){
		$('#reactshare-button').removeClass('opened');
		$('.react-overlay').hide();
	});
	
	$('#reactshare-button a').click(function(){
		$('#reactshare-button').delay(800).removeClass('opened');
		$('.react-overlay').hide();
	});
	
	$(window).scroll(function() {
		$('#reactshare-button').removeClass('opened');
		$('.react-overlay').hide();
	});
	
	/*$('.clicble_voute').click(function(e) {
		 e.preventDefault();

		$('#reactshare-button').removeClass('opened');
	})*/
	
})

function swt_format_twitter(twitters) {
  var statusHTML = [];
  for (var i=0; i<twitters.length; i++){
    var username = twitters[i].user.screen_name;
    var status = twitters[i].text.replace(/((https?|s?ftp|ssh)\:\/\/[^"\s\<\>]*[^.,;'">\:\s\<\>\)\]\!])/g, function(url) {
      return '<a href="'+url+'">'+url+'</a>';
    }).replace(/\B@([_a-z0-9]+)/ig, function(reply) {
      return  reply.charAt(0)+'<a href="http://twitter.com/'+reply.substring(1)+'">'+reply.substring(1)+'</a>';
    });
    statusHTML.push('<li><span>'+status+'</span> <a style="font-size:90%; color:#bbb;" href="http://twitter.com/'+username+'/statuses/'+twitters[i].id_str+'">'+relative_time(twitters[i].created_at)+'</a></li>');
  }
  return statusHTML.join('');
}

function relative_time(time_value) {
  var values = time_value.split(" ");
  time_value = values[1] + " " + values[2] + ", " + values[5] + " " + values[3];
  var parsed_date = Date.parse(time_value);
  var relative_to = (arguments.length > 1) ? arguments[1] : new Date();
  var delta = parseInt((relative_to.getTime() - parsed_date) / 1000);
  delta = delta + (relative_to.getTimezoneOffset() * 60);

  if (delta < 60) {
    return 'less than a minute ago';
  } else if(delta < 120) {
    return 'about a minute ago';
  } else if(delta < (60*60)) {
    return (parseInt(delta / 60)).toString() + ' minutes ago';
  } else if(delta < (120*60)) {
    return 'about an hour ago';
  } else if(delta < (24*60*60)) {
    return 'about ' + (parseInt(delta / 3600)).toString() + ' hours ago';
  } else if(delta < (48*60*60)) {
    return '1 day ago';
  } else {
    return (parseInt(delta / 86400)).toString() + ' days ago';
  }
}
    /*

    if ( $('.google_custom_share').length ){
        $('.google_custom_share').each(function(){
            var url = $(this).attr('data-attr-url');
            var google_url = "/wp-content/plugins/easy-social-share-buttons/public/get-noapi-counts.php?nw=google&url=" + url;
            var selector = $(this);
            $.ajax({
                url: google_url,
                dataType: 'json',
                async: true,
                success: function(data) {
                    $(selector).find('.googleCounter').html(data.count);
                }
            });            
        });
    }
    
    if ( $('.twitter_custom_share').length ){
        $('.twitter_custom_share').each(function(){
            var url = $(this).attr('data-attr-url');
            var twitter_url		= "http://cdn.api.twitter.com/1/urls/count.json?url=" + url + "&callback=?";
            var selector = $(this);
            $.getJSON(twitter_url).done(function(data){ $(selector).find('.twitterCounter').html(data.count) });
        });
    }
    
    if ( $('.fb_custom_share').length ){
        $('.fb_custom_share').each(function(){
            var url = $(this).attr('data-attr-url');
            var fb_url = "https://graph.facebook.com/fql?q=SELECT%20like_count,%20total_count,%20share_count,%20click_count,%20comment_count%20FROM%20link_stat%20WHERE%20url%20=%20%22" + url + "%22";
            
            var selector = $(this);
            $.getJSON(fb_url).done(function(data){ $(selector).find('.fbCounter').html(data.data[0].share_count) });            
        });
    }
    
    if ( $('.fb_custom_likeit').length ){
        $('.fb_custom_likeit').each(function(){
            var url = $(this).attr('data-attr-url');
            var fb_url = "https://graph.facebook.com/fql?q=SELECT%20total_count%20FROM%20link_stat%20WHERE%20url=%27" + url + "%27";
            var selector = $(this);
            $.getJSON(fb_url).done(function(data){ $(selector).find('.fbLikeIt').html(data.data[0].total_count) });            
        });
    }
    */

$(document).ready(function(){
    var aPostIds = new Array();
    $('.get_social_counter_result').each(function(){
        aPostIds.push($(this).attr('data-id'));
    });
    if(aPostIds.length > 0){
        var url = "/wp-content/plugins/easy-social-share-buttons/public/getCounters.php";
        $.ajax({
            type: "GET",
            url: url,
            dataType: 'json',
            async: true,
            data: {'posts' : aPostIds, 'action' : 'getForHomePage'},
            success: function(data) {
                $.each(data, function(key, value)
                {
                    var sSelector = "#get_social_counter_result_" + key;
                    if($(sSelector).length){
                        $(sSelector).html(value);
                    }
                });
            }
        });
    }
});

function custom_social_window(sUrl){
    window.open(sUrl, "My Tiny Secrets share window", "height=300,width=550,resizable=1");
}
