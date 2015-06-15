<?php
/**
 * Testing posts
 */
class postTest extends Symfony\Bundle\FrameworkBundle\Test\WebTestCase
{
    public function getPosts()
    {
        include realpath(__DIR__).'/../wp-load.php';        
    }

    public function testPosts()
    {
        $this->getPosts();
        $this->assertTrue(true);
    }
}