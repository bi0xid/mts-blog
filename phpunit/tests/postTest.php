<?php
use Goutte\Client;
/**
 * Testing 
 */
class postTest extends \PHPUnit_Framework_TestCase
{
    public function testPosts()
    {
        $args = array(
            'posts_per_page' => -1,
            'post_status' => array('publish')
        );
        $client = new Client();



        foreach (get_posts($args) as $post) {
//            var_dump(get_permalink($post->ID)); exit;
            /* @var $crawler Symfony\Component\DomCrawler\Crawler */
//            $crawler = $client->request('GET', get_permalink($post->ID));
//            var_dump($crawler->html()); exit;
        }

        $this->assertTrue(true);
    }
}
