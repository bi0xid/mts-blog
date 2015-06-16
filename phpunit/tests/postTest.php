<?php
use Goutte\Client;
/**
 * Testing 
 */
class postTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider postsProvider
     */
    public function testPost($post)
    {
        $client = new Client();


//var_dump($post); exit;
//            var_dump(get_permalink($post->ID)); exit;
            /* @var $crawler Symfony\Component\DomCrawler\Crawler */
        $crawler = $client->request('GET', get_permalink($post->ID));
        $this->assertEquals(200 , $client->getResponse()->getStatus());
        //var_dump($crawler->filterXPath('//title')->text());
        //$this->assertContains()
            //$this->assertTrue($crawler->html());
//            var_dump($crawler->html()); exit;

        $this->assertTrue(true);
    }

    public function postsProvider()
    {
        $args = array(
            'posts_per_page' => -1,
            'post_status' => array('publish')
        );

        return array_map(function($v) {
            return array($v);
        }, get_posts($args));
    }
}
