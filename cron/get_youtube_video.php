<?php
/**
 * Cron file is responsible for getting youtube videos from mytinysecrets.com channel.
 * 
 * run via console php -f get_youtube_video.php
 */
ini_set('display_errors', false);
error_reporting(0);

include('./wp-load.php');

//TODO: add code to retrieve more than 50 videos plus retrieve video with inappropriate content
$url = "http://gdata.youtube.com/feeds/api/videos?author=MyTinySecretsTV&alt=json&max-results=50";

$videoContent = file_get_contents($url);

$videos = json_decode($videoContent, true);

$videos = isset($videos['feed']['entry']) ? $videos['feed']['entry'] : array();

if(!$videos || empty($videos)){
    echo "ERROR: No videos retrieved\n";
    echo "Process end\n";
}

$aVideos = array();

foreach($videos as $v){

    $published = isset($v['published']['$t']) ? (string)$v['published']['$t'] : false;
    $updated = isset($v['updated']['$t']) ? (string)$v['updated']['$t'] : false;
    $title = isset($v['title']['$t']) ? (string)$v['title']['$t'] : '';
    $content = isset($v['content']['$t']) ? (string)$v['content']['$t'] : '';
    $link = isset($v['link'][0]['href']) ? (string)$v['link'][0]['href'] : '';
    $viewCount = isset($v['yt$statistics']['viewCount']) ? (int)$v['yt$statistics']['viewCount'] : 0;
    
    if(!$published || !$updated || !$title || !$content || !$link || !$viewCount){
        echo "ERROR: Video information missing. published: {$published}, updated: {$updated}, title : {$title}, content: {$content}, link: {$link}, viewCount: {$viewCount}\n";
        continue;
    }

    $published = date("Y-m-d H:i:s", strtotime($published));
    $updated = date("Y-m-d H:i:s", strtotime($updated));
    $uniqueUrl = '';
        
    if(preg_match('/v=(?<uniqueUrl>[^&]+)&/', $link, $m)){
        $uniqueUrl = (string)$m['uniqueUrl'];
    }

    $link = str_replace('&feature=youtube_gdata', '', $link);
    
    $aVideos[strtolower($uniqueUrl)] = array(
        'published' => $published,
        'updated' => $updated,
        'title' => $title,
        'content' => $content,
        'link' => $link,
        'viewCount' => $viewCount,
        'uniqueUrl' => $uniqueUrl
    );
}

$args = array(
            'post_type'      => 'youtube-video',
            'post_status'    => 'publish',
            'posts_per_page' => -1
        );

$removePosts = array();
$updatePosts = array();

$existsPosts = get_posts($args);

foreach($existsPosts as $existsPost)
{
    $postName = strtolower($existsPost->post_name);

    if(!isset($aVideos[$postName]))
    {
        $removePosts[] = $existsPost;
    }else{
        $youtubePost = $aVideos[$postName];
        
        if(
              $youtubePost['published'] !=   $existsPost->post_date ||
              $youtubePost['updated'] !=   $existsPost->post_modified ||
              $youtubePost['title'] !=   $existsPost->post_title ||
              $youtubePost['content'] !=   $existsPost->post_content ||
              $youtubePost['viewCount'] !=   $existsPost->comment_count ||
              $youtubePost['uniqueUrl'] !=   $existsPost->post_excerpt ||
              $youtubePost['link'] !=   $existsPost->guid
        ){
            $updatePosts[$existsPost->ID] = $youtubePost;
        }
        unset($aVideos[$postName]);
    }
}

global $wpdb;

//Delete posts
foreach($removePosts as $post){
    wp_delete_post( $post->ID, true);
}

//Update posts
foreach($updatePosts as $key => $updatePost){
    
    if(!$key){
        echo "Error: Can not update post. Unknown ID: {$key}\n";
        continue;
    }
    
    $wpdb->query( 
	$wpdb->prepare( 
                "UPDATE {$wpdb->posts}
                    SET
                    `post_content`      = %s,
                    `post_name`         = %s,
                    `post_excerpt`      = %s,
                    `post_title`        = %s,
                    `post_status`       = 'publish',
                    `post_type`         = 'youtube-video',
                    `guid`              = %s,
                    `post_date`         = %s,
                    `post_date_gmt`     = %s,
                    `comment_status`    = 'closed',
                    `post_modified`     = %s,
                    `post_modified_gmt` = %s,
                    `comment_count`     = %d
		 WHERE ID = %d",
                    $updatePost['content'],
                    strtolower($updatePost['uniqueUrl']),
                    $updatePost['uniqueUrl'],
                    $updatePost['title'],
                    $updatePost['link'],
                    $updatePost['published'],
                    $updatePost['published'],
                    $updatePost['updated'],
                    $updatePost['updated'],
                    $updatePost['viewCount'],
                    $key
        )
    );
}

//Insert post
foreach($aVideos as $key => $aVideo)
{
    $post = array(        
        'post_content'      => $aVideo['content'],
        'post_name'         => $key,
        'post_excerpt'      => $aVideo['uniqueUrl'],
        'post_title'        => $aVideo['title'],
        'post_status'       => 'publish',
        'post_type'         => 'youtube-video',
        'guid'              => $aVideo['link'],
        'post_date'         => $aVideo['published'],
        'post_date_gmt'     => $aVideo['published'],
        'comment_status'    => 'closed',
        'post_modified'     => $aVideo['updated'],
        'post_modified_gmt' => $aVideo['updated'],
        'comment_count'     => $aVideo['viewCount']
      );  
     
     $idPost = wp_insert_post($post);
     
     if($idPost){
         $wpdb->query( 
            $wpdb->prepare( 
                    "UPDATE {$wpdb->posts}
                        SET
                        `comment_count`     = %d
                     WHERE ID = %d",
                        $aVideo['viewCount'],
                        $idPost
            )
        );
     }
}

echo "Youtube videos updated!!!\n";

die();