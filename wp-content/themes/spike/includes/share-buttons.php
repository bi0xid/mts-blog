<?php

$majorProviders = ['facebook','twitter','google'];
$secondaryProviders = ['pinterest','digg','stumbleupon','mail'];

$url = get_permalink($post->ID);
$title = get_the_title($post->ID);


if(is_single()) {
    $buttons = array_merge($majorProviders, $secondaryProviders);
//    echo do_shortcode('[easy-social-share buttons="'. implode(',',$buttons) .'" style="button" point_type="simple" url="'.$url.'" text="'. str_replace( [ "[" , "]" ] , [ "&#91;" , "&#93;" ] , $title).'"]');
} else {
    $buttons = $majorProviders;
//    echo do_shortcode('[easy-social-share buttons="'. implode(',',$buttons) .'" counters=1 style="button" point_type="simple" url="'.$url.'" text="'. str_replace( [ "[" , "]" ] , [ "&#91;" , "&#93;" ] , $title).'"]');
}

