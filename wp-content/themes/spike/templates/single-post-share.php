<?php
$social_shares = array(
		'facebook_shares' => array(
			'name' => 'Share',
			'link' => 'https://www.facebook.com/sharer/sharer.php?u='.get_the_permalink(),
			'svg'  => '<path d="M853.35 0h-682.702c-94.25 0-170.648 76.42-170.648 170.686v682.63c0 94.266 76.398 170.684 170.648 170.684h341.352v-448h-128v-128h128v-96c0-88.366 71.634-160 160-160h160v128h-160c-17.674 0-32 14.328-32 32v96h176l-32 128h-144v448h213.35c94.25 0 170.65-76.418 170.65-170.684v-682.63c0-94.266-76.4-170.686-170.65-170.686z"></path>'
		),
		'twitter' => array(
			'name' => 'Tweet',
			'link' => 'http://twitter.com/intent/tweet?text='.get_the_title().'%20'.get_the_permalink(),
			'svg'  => '<path d="M1024 194.418c-37.676 16.708-78.164 28.002-120.66 33.080 43.372-26 76.686-67.17 92.372-116.23-40.596 24.078-85.556 41.56-133.41 50.98-38.32-40.83-92.922-66.34-153.346-66.34-116.022 0-210.088 94.058-210.088 210.078 0 16.466 1.858 32.5 5.44 47.878-174.6-8.764-329.402-92.4-433.018-219.506-18.084 31.028-28.446 67.116-28.446 105.618 0 72.888 37.088 137.192 93.46 174.866-34.438-1.092-66.832-10.542-95.154-26.278-0.020 0.876-0.020 1.756-0.020 2.642 0 101.788 72.418 186.696 168.522 206-17.626 4.8-36.188 7.372-55.348 7.372-13.538 0-26.698-1.32-39.528-3.772 26.736 83.46 104.32 144.206 196.252 145.896-71.9 56.35-162.486 89.934-260.916 89.934-16.958 0-33.68-0.994-50.116-2.94 92.972 59.61 203.402 94.394 322.042 94.394 386.422 0 597.736-320.124 597.736-597.744 0-9.108-0.206-18.168-0.61-27.18 41.056-29.62 76.672-66.62 104.836-108.748z"></path>'
		),
		'google' => array(
			'name' => 'Share',
			'link' => 'https://plus.google.com/share?url='.get_the_permalink(),
			'svg'  => '<path d="M559.066 64c0 0-200.956 0-267.94 0-120.12 0-233.17 91.006-233.17 196.422 0 107.726 81.882 194.666 204.088 194.666 8.498 0 16.756-0.17 24.842-0.752-7.93 15.186-13.602 32.288-13.602 50.042 0 29.938 16.104 54.21 36.468 74.024-15.386 0-30.242 0.448-46.452 0.448-148.782-0.002-263.3 94.758-263.3 193.020 0 96.778 125.542 157.314 274.334 157.314 169.624 0 263.306-96.244 263.306-193.028 0-77.6-22.896-124.072-93.686-174.134-24.216-17.144-70.53-58.836-70.53-83.344 0-28.72 8.196-42.868 51.428-76.646 44.312-34.624 75.672-83.302 75.672-139.916 0-67.406-30.020-133.098-86.372-154.772h84.954l59.96-43.344zM465.48 719.458c2.126 8.972 3.284 18.206 3.284 27.628 0 78.2-50.392 139.31-194.974 139.31-102.842 0-177.116-65.104-177.116-143.3 0-76.642 92.126-140.444 194.964-139.332 24 0.254 46.368 4.116 66.67 10.69 55.826 38.826 95.876 60.762 107.172 105.004zM300.818 427.776c-69.038-2.064-134.636-77.226-146.552-167.86-11.916-90.666 34.37-160.042 103.388-157.99 69.010 2.074 134.638 74.814 146.558 165.458 11.906 90.66-34.39 162.458-103.394 160.392zM832 256v-192h-64v192h-192v64h192v192h64v-192h192v-64z"></path>'
		),
		'pinterest' => array(
			'name' => 'Pin',
			'href' => "javascript:void((function(){var%20e=document.createElement('script');e.setAttribute('type','text/javascript');e.setAttribute('charset','UTF-8');e.setAttribute('src','http://assets.pinterest.com/js/pinmarklet.js?r='+Math.random()*99999999);document.body.appendChild(e)})());",
			'svg'  => '<path d="M512.006 0.002c-282.774 0-512.006 229.23-512.006 511.996 0 216.906 134.952 402.166 325.414 476.772-4.478-40.508-8.518-102.644 1.774-146.876 9.298-39.954 60.040-254.5 60.040-254.5s-15.32-30.664-15.32-76.008c0-71.19 41.268-124.336 92.644-124.336 43.68 0 64.784 32.794 64.784 72.12 0 43.928-27.964 109.604-42.404 170.464-12.060 50.972 25.556 92.536 75.814 92.536 91.008 0 160.958-95.96 160.958-234.466 0-122.584-88.088-208.298-213.868-208.298-145.678 0-231.186 109.274-231.186 222.19 0 44.008 16.95 91.196 38.102 116.844 4.182 5.070 4.792 9.516 3.548 14.68-3.884 16.18-12.522 50.96-14.216 58.076-2.234 9.368-7.422 11.356-17.124 6.842-63.95-29.77-103.926-123.264-103.926-198.348 0-161.51 117.348-309.834 338.294-309.834 177.61 0 315.634 126.56 315.634 295.704 0 176.458-111.256 318.466-265.676 318.466-51.886 0-100.652-26.958-117.35-58.796 0 0-25.672 97.766-31.894 121.71-11.564 44.468-42.768 100.218-63.642 134.226 47.91 14.832 98.818 22.832 151.604 22.832 282.768-0.002 511.996-229.23 511.996-512 0-282.766-229.228-511.996-511.994-511.996z"></path>'
		),
		'email' => array(
			'name'  => 'E-mail',
			'svg'  => '<path d="M928 128h-832c-52.8 0-96 43.2-96 96v640c0 52.8 43.2 96 96 96h832c52.8 0 96-43.2 96-96v-640c0-52.8-43.2-96-96-96zM398.74 550.372l-270.74 210.892v-501.642l270.74 290.75zM176.38 256h671.24l-335.62 252-335.62-252zM409.288 561.698l102.712 110.302 102.71-110.302 210.554 270.302h-626.528l210.552-270.302zM625.26 550.372l270.74-290.75v501.642l-270.74-210.892z"></path>'
		)
);
?>

<ul class="social_shares single_post">
	<?php
		foreach ( $social_shares as $key => $value ) {
			echo '<li class="share_item '.$key.'">';
				if( $value['link'] ) {
					echo '<a href="#" data-url="'.$value['link'].'" data-media="'.$key.'" class="share-item-button modal">';
				} elseif( $value['href'] ) {
					echo '<a href="'.$value['href'].'" class="share-item-button">';
				} else {
					echo '<a href="#" data-media="'.$key.'" class="share-item-button">';
				}
					echo '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"viewBox="0 0 1024 1024">'.$value['svg'].'</svg>';
					echo '<span>'.$value['name'].'</span>';
				echo '</a>';
			echo '</li>';
		}
	?>
</ul>
