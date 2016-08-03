jQuery(document).ready(function(){
	jQuery('.clicble_voute').on('click', function(){

		var postId = parseInt(jQuery(this).attr('data-id'));
		var vote = jQuery(this).attr('data-vote');
		
		jQuery.post( SGReactShareAjaxPath.ajaxurl, {  action : "setVoute", vote : vote, postId : postId},	
				
				function(data) 
				{			
					if(data.status == 'ok')
					{
						jQuery('#span_positive_votes').html(data._post_votes_positive);
						jQuery('#span_negative_votes').html(data._post_votes_negative);
						return false;
					}
					
					if(data.status == 'error')
					{
						alert('Something has gone wrong. Please reload the page and try again.'); return false;
					}
					
					if(data.status == 'alreadyVoted')
					{
						alert(data.message + '.'); return false;
					}
				}, 'json');
		
		return false;
	});
})