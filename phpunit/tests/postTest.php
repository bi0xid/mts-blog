<?php
use Goutte\Client;

/**
 * Class postTest
 */
class postTest extends AbstractMyTinySecretsBlogTest
{
    /**
     * @dataProvider postsProvider
     *
     * @param $post
     */
    public function testPost($post)
    {
        $this->testSingleWPUnit($post);
    }

    /**
     * Data provider for testPost
     *
     * @return array
     */
    public function postsProvider()
    {
        return array_map(function($v) {
            return array($v);
        }, self::getVisiblePosts());
    }
}
