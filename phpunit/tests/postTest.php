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

        $title = get_post_meta( $post->ID, "_aioseop_title", true );
        if (empty($title)) {
            $title = $post->post_title;
        }

        /* @var $crawler Symfony\Component\DomCrawler\Crawler */
        $crawler = $client->request('GET', get_permalink($post));

        $this->assertEquals(200 , $client->getResponse()->getStatus());

        $this->assertContains(
            preg_replace('/[^\da-z]/i', '', $title),
            preg_replace('/[^\da-z]/i', '', $crawler->filterXPath('//title')->text())
        );

        $attachments = get_posts( array(
            'post_type' => 'attachment',
            'posts_per_page' => -1,
            'post_parent' => $post->ID,
        ) );

        if ( $attachments ) {
            foreach ( $attachments as $attachment ) {
                $client->request('HEAD', wp_get_attachment_image_src($attachment->ID, 'thumbnail')['url']);
                $this->assertEquals(200 , $client->getResponse()->getStatus());
            }
        }

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

    /**
     * @dataProvider locationsProvider
     */
    public function testLocation($url, $status)
    {
        $client = new Client();

        /* @var $crawler Symfony\Component\DomCrawler\Crawler */
        $crawler = $client->request('GET', $url);
        $this->assertEquals($status, $client->getResponse()->getStatus(), "Failed assert that status from url with method GET: " . $url . " = " . $status);

    }

    public function locationsProvider()
    {
        $uploadsBaseUrl = wp_upload_dir()['baseurl'];

        return array(
            array(home_url('/xmlrpc.php'), 403),
            array(home_url('/cron/get_youtube_video.php'), 403),
            array(home_url('/phpunit/composer.json'), 403),
            array(home_url('/sitemap.xml'), 200),
            array(home_url(self::getUniqueStr()), 404),
            array(home_url('/wp-content/uploads/index.php'), 403),
            array(sprintf('%s/profiles/%s.txt', $uploadsBaseUrl, self::getUniqueStr()), 403),
            array(sprintf('%s/wpcf7_captcha/%s.txt', $uploadsBaseUrl, self::getUniqueStr()), 403),
            array(sprintf('%s/wpcf7_captcha/%s.gif', $uploadsBaseUrl, self::getUniqueStr()), 200),
            array(sprintf('%s/wpcf7_captcha/%s.jpeg', $uploadsBaseUrl, self::getUniqueStr()), 200),
            array(sprintf('%s/wpcf7_captcha/%s.png', $uploadsBaseUrl, self::getUniqueStr()), 200),
            array(home_url('/wp-content/plugins/akismet/akismet.php'), 403),
            array(home_url('/wp-content/plugins/akismet/_inc/akismet.css'), 200),
            array(home_url('/wp-content/plugins/akismet/_inc/akismet.js'), 200),
            array(home_url('/wp-content/plugins/akismet/_inc/form.js'), 200),
            array(home_url('/wp-content/plugins/akismet/_inc/img/logo-full-2x.png'), 200),
            array(home_url('/wp-content/plugins/easy-social-share-buttons/public/cache/'), 403),
            array(home_url('/wp-content/plugins/wordfence/lib/GeoIP.dat'), 403),
            array(home_url('/wp-content/plugins/wordfence/tmp/configCache.php'), 403),
            array(home_url('/wp-content/plugins/p3-profiler/classes/index.php'), 403),
            array(home_url('/wp-content/plugins/p3-profiler/exceptions/index.php'), 403),
            array(home_url('/wp-content/plugins/p3-profiler/languages/index.php'), 403),
            array(home_url('/wp-content/plugins/p3-profiler/templates/index.php'), 403),
        );
    }

    /**
     * @beforeClass
     */
    public static function setUpLocationsData()
    {
        $uploadsBaseDir = wp_upload_dir()['basedir'];
        foreach (array('jpeg', 'gif', 'png', 'txt') as $ext) {
            file_put_contents(sprintf('%s/wpcf7_captcha/%s.%s', $uploadsBaseDir, self::getUniqueStr(), $ext), '');
        }

        file_put_contents(sprintf('%s/profiles/%s.txt', $uploadsBaseDir, self::getUniqueStr()), '');
    }

    /**
     * @afterClass
     */
    public static function tearDownLocationsData()
    {
        $uploadsBaseDir = wp_upload_dir()['basedir'];
        foreach (array('jpeg', 'gif', 'png', 'txt') as $ext) {
            unlink(sprintf('%s/wpcf7_captcha/%s.%s', $uploadsBaseDir, self::getUniqueStr(), $ext));
        }
        unlink(sprintf('%s/profiles/%s.txt', $uploadsBaseDir, self::getUniqueStr()));
    }


    /**
     * @dataProvider redirectsProvider
     */
    public function testRedirect($url, $redirectUrl)
    {
        $client = new Client();
        $client->followRedirects(false);


        /* @var $crawler Symfony\Component\DomCrawler\Crawler */
        $crawler = $client->request('GET', $url);
        $this->assertEquals($redirectUrl, $client->getResponse()->getHeader('location', true), "Redirection from url with method GET: " . $url . " to " . $redirectUrl . " failed");
    }

    public function redirectsProvider()
    {
        return array(
            // Custom redirect
            array(home_url('/spread-the-love'), 'http://www.mytinysecrets.com/sharethelove'),
            // Forced Tier Linking Code
            array(home_url('/signup-999999999.html'), 'http://mytinysecrets.com/sharethelove/signup.php?ref=999999999'),
            // Permanent URL redirect - generated by www.rapidtables.com
            array(
                home_url('/why-you-shouldnt-give-a-fuck-about-looks/'),
                'http://mytinysecrets.com/why-you-should-not-give-a-fuck-about-looks/'
            ),
            // TextAds
            array(
                home_url('/999999999-azazazazazazaz-999999999.html'),
                'http://mytinysecrets.com/sharethelove/idevads.php?id=999999999&ad=999999999'
            ),
            array(
                home_url('/999999999-azazazazazazaz-999999999-999999999.html'),
                'http://mytinysecrets.com/sharethelove/idevads.php?id=999999999&ad=999999999&page=999999999'
            ),
            // Standard Links
            array(
                home_url('/999999999.html'),
                'http://mytinysecrets.com/sharethelove/idevaffiliate.php?id=999999999'
            ),
            array(
                home_url('/999999999-999999999.html'),
                'http://mytinysecrets.com/sharethelove/idevaffiliate.php?id=999999999&page=999999999'
            ),
            array(
                home_url('/999999999-999999999-999999999.html'),
                'http://mytinysecrets.com/sharethelove/idevaffiliate.php?id=999999999&page=999999999&set=999999999'
            ),
            array(
                home_url('/999999999-999999999-999999999-999999999.html'),
                'http://mytinysecrets.com/sharethelove/idevaffiliate.php?id=999999999&page=999999999&set=999999999&link=999999999'
            ),
            array(
                home_url('/999999999-999999999-999999999-999999999-azazazazazazaz.html'),
                'http://mytinysecrets.com/sharethelove/idevaffiliate.php?id=999999999&page=999999999&set=999999999&link=999999999&keyword=azazazazazazaz'
            ),
            array(
                home_url('/999999999-999999999-999999999-999999999-azazazazazazaz-999999999.html'),
                'http://mytinysecrets.com/sharethelove/idevaffiliate.php?id=999999999&page=999999999&set=999999999&link=999999999&keyword=azazazazazazaz&custom=999999999'
            ),
            array(
                home_url('/999999999-999999999-999999999-999999999-azazazazazazaz-999999999-999999999.html'),
                'http://mytinysecrets.com/sharethelove/idevaffiliate.php?id=999999999&page=999999999&set=999999999&link=999999999&keyword=azazazazazazaz&custom=999999999&url=999999999'
            ),
            // End iDevAffiliate SEO Code
            array(
                home_url('/wiredtree'),
                'http://wiredtree.com'
            ),
        );
    }

    protected static function getUniqueStr()
    {
        return str_repeat(sha1(123456789), 5);
    }
}
