$(document).ready(function(){
	$('.clicble_voute').on('click', function(){

		var postId = parseInt($(this).attr('data-id'));
		var vote = $(this).attr('data-vote');
		
		$.post( SGReactShareAjaxPath.ajaxurl, {  action : "setVoute", vote : vote, postId : postId},	
				
				function(data) 
				{			
					if(data.status == 'ok')
					{
						$('#span_positive_votes').html(data._post_votes_positive);
						$('#span_negative_votes').html(data._post_votes_negative);
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