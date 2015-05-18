<?php
/**
 * Cron file is responsible for getting youtube videos from mytinysecrets.com channel.
 * 
 * run via console php -f get_youtube_video.php
 */
ini_set('display_errors', true);
error_reporting(E_ALL);

include(realpath(__DIR__) . './../wp-load.php');
require_once realpath(__DIR__) . '/Google/autoload.php';


//TODO: add code to retrieve more than 50 videos plus retrieve video with inappropriate content

$client = new Google_Client();
$client->setScopes('https://www.googleapis.com/auth/youtube.readonly');
$client->setDeveloperKey('AIzaSyDydBiWChdDPZWQcpwjMkT-Lh1_EKGuKws');

$youtube = new Google_Service_YouTube($client);

$channelId = 'UCZAUAzqAn88GTa8OoM9MJgA';//MyTinySecretsTV
$channel = $youtube->channels->listChannels('contentDetails', array('id'=>$channelId));

$playlistId = $channel->getItems()[0]->contentDetails->relatedPlaylists->uploads;
$pageToken = null;

$videos = array();

do {
    $playlistItemList = $youtube->playlistItems->listPlaylistItems('snippet', array(
        'playlistId' => $playlistId,
        'maxResults' => 10,
        'pageToken'  => $pageToken
    ));
    $videosStatistics = array();
    foreach ($playlistItemList->getItems() as $item) {
        $videosStatistics[] = $item->snippet->resourceId->videoId;

        $videos[strtolower($item->snippet->resourceId->videoId)] = array(
            'published' => date("Y-m-d H:i:s", strtotime($item->snippet->publishedAt)),
            'title' => $item->snippet->title,
            'content' => $item->snippet->description,
            'link' => sprintf('https://www.youtube.com/watch?v=%s', $item->snippet->resourceId->videoId),
            'uniqueUrl' => $item->snippet->resourceId->videoId
        );
    }

    foreach ($youtube->videos->listVideos('statistics', array('id'=>implode(',', $videosStatistics))) as $item) {
        $videos[strtolower($item->id)]['viewCount'] = $item->statistics->viewCount;
    }


} while ($pageToken = $playlistItemList->nextPageToken);

if(!$videos || empty($videos)){
    echo "ERROR: No videos retrieved\n";
    echo "Process end\n";
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
    $postName = $existsPost->post_name;

    if(!isset($videos[$postName]))
    {
        $removePosts[] = $existsPost;
    } else {
        $youtubePost = $videos[$postName];

        if(
              $youtubePost['published'] !=   $existsPost->post_date ||
              $youtubePost['title'] !=   $existsPost->post_title ||
              $youtubePost['content'] !=   $existsPost->post_content ||
              $youtubePost['viewCount'] !=   $existsPost->comment_count ||
              $youtubePost['uniqueUrl'] !=   $existsPost->post_excerpt ||
              $youtubePost['link'] !=   $existsPost->guid
        ){
            $updatePosts[$existsPost->ID] = $youtubePost;
        }
        unset($videos[$postName]);
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
                    `comment_count`     = %d
		 WHERE ID = %d",
                    $updatePost['content'],
                    strtolower($updatePost['uniqueUrl']),
                    $updatePost['uniqueUrl'],
                    $updatePost['title'],
                    $updatePost['link'],
                    $updatePost['published'],
                    $updatePost['published'],
                    $updatePost['viewCount'],
                    $key
        )
    );
}

//Insert post
foreach($videos as $key => $video)
{
    $post = array(
        'post_content'      => $video['content'],
        'post_name'         => $key,
        'post_excerpt'      => $video['uniqueUrl'],
        'post_title'        => $video['title'],
        'post_status'       => 'publish',
        'post_type'         => 'youtube-video',
        'guid'              => $video['link'],
        'post_date'         => $video['published'],
        'post_date_gmt'     => $video['published'],
        'comment_status'    => 'closed',
        'comment_count'     => $video['viewCount']
      );

     $idPost = wp_insert_post($post);

     if($idPost){
         $wpdb->query(
            $wpdb->prepare(
                    "UPDATE {$wpdb->posts}
                        SET
                        `comment_count`     = %d
                     WHERE ID = %d",
                        $video['viewCount'],
                        $idPost
            )
        );
     }
}

echo "Youtube videos updated!!!\n";

die();