<?php

include('./wp-load.php');

$args = array( 'posts_per_page' => -1, 'post_status'    => 'publish');

$myposts = get_posts( $args );

$i = 1;

foreach ( $myposts as $post )
{
    setup_postdata( $post );
    
    $content = get_the_content();
    
    preg_match_all('/<img [^>]*src=["|\']([^"|\']+)/i', $content, $matches);
    
    foreach ($matches[1] as $key => $value) {
        
        $url = str_replace('http://cdn.mytinysecrets.com/', 'http://mytinysecrets.com/', $value);
        
        if(!checkRemoteFile($url)){
             echo $post->ID . " " . $url . "\n";
        }
    }
    
    $i++;
}

var_dump($i);