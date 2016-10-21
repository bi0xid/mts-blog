<?php
	$social_networks = array(
		'facebook_like' => array(
			'name'  => 'Likes',
			'value' => (int) get_post_meta( get_the_ID(), 'facebook_likes', true )
		),
		'facebook_shares' => array(
			'name'  => 'Share',
			'value' => (int) get_post_meta( get_the_ID(), 'facebook_shares', true ),
			'link'  => 'https://www.facebook.com/sharer/sharer.php?u='.get_the_permalink()
		),
		'google' => array(
			'name'  => 'Google+',
			'value' => (int) get_post_meta( get_the_ID(), 'google_shares', true ),
			'link'  => 'https://plus.google.com/share?url='.get_the_permalink()
		),
		'pinterest' => array(
			'name'  => 'Pinterest',
			'value' => (int) get_post_meta( get_the_ID(), 'pinterest_shares', true ),
			'href'  => "javascript:void((function(){var%20e=document.createElement('script');e.setAttribute('type','text/javascript');e.setAttribute('charset','UTF-8');e.setAttribute('src','http://assets.pinterest.com/js/pinmarklet.js?r='+Math.random()*99999999);document.body.appendChild(e)})());"
		),
		'stumbleupon' => array(
			'name' => 'StumbleUpon',
			'value' => (int) get_post_meta( get_the_ID(), 'stumble_shares', true ),
			'link' => 'http://www.stumbleupon.com/badge/?url='.get_the_permalink()
		),
		'digg' => array(
			'name'  => 'Digg',
			'value' => (int) get_post_meta( get_the_ID(), 'digg_post_type', true ),
			'link'  => 'http://digg.com/submit?phase=2%20&amp;url='.get_the_permalink().'&amp;title='.get_the_title()
		),
		'email' => array(
			'name'  => 'E-mail',
			'value' => (int) get_post_meta( get_the_ID(), 'total_email_shares', true )
		)
	);
?>

<ul class="social_shares">
	<?php
		foreach ( $social_networks as $key => $value ) {
			echo '<li class="share_item '.$key.'">';
				if( $value['link'] ) {
					echo '<a href="#" data-url="'.$value['link'].'" data-media="'.$key.'" class="share-item-button modal">';
				} elseif( $value['href'] ) {
					echo '<a href="'.$value['href'].'" class="share-item-button">';
				} else {
					echo '<a href="#" data-media="'.$key.'" class="share-item-button">';
				}
					echo '<span class="icon"></span>';
					echo '<span>'.$value['name'].'</span>';
				echo '</a>';
				echo '<span class="counter">'.$value['value'].'</span>';

				if( $key === 'facebook_like' ) {
					$test_url = str_replace(array('.dev'), array('.com'), get_the_permalink());
				?>
					<div class="fb-like"
						data-href="<?php echo $test_url; ?>"
						data-layout="standard"
						data-action="like"
						data-show-faces="true">
					</div>
				<?php
				}
			echo '</li>';
		}
	?>
</ul>
