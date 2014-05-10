<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 21/03/2014
 * Time: 22:25
 */

use Symfony\Component\DomCrawler\Crawler;

include_once __DIR__ . '/PhpDorsetSilexTest.php';

/**
 * Class GoogleAnalyticsScriptTest
 */
class GoogleAnalyticsScriptTest extends PhpDorsetSilexTest
{

    public function testGoogleAnalyticsScriptTagExists()
    {
        $crawler = $this->fetchHomePageCrawler();
        $googleAnalyticsScriptNode = $this->findGoogleAnalyticsScriptTagNode($crawler);
        $googleAnalyticsScriptText = $googleAnalyticsScriptNode->text();

        $this->assertFalse(is_null($googleAnalyticsScriptText));
    }

    /**
     * @return Crawler
     */
    protected function fetchHomePageCrawler()
    {
        $this->app['current_url'] = '/';
        $client = $this->createClient();
        $crawler = $client->request('GET', '/');
        return $crawler;
    }

    /**
     * @param Crawler $crawler
     * @return mixed
     * @throws Exception
     */
    protected function findGoogleAnalyticsScriptTagNode(Crawler $crawler)
    {
        $scriptTagValues = $crawler
            ->filter('script')
            ->each(
                function (Crawler $node, $i) {

                    if (strstr($node->text(), 'www.google-analytics.com/analytics.js')) {
                        return $node;
                    }

                    return null;
                }
            );

        if(isset($scriptTagValues[0])) {
            return $scriptTagValues[0];
        }

        throw new Exception('Google analytics script tag not found');
    }

    public function testGoogleAnalyticsUACodeIsCorrect()
    {
        $crawler = $this->fetchHomePageCrawler();
        $googleAnalyticsScriptNode = $this->findGoogleAnalyticsScriptTagNode($crawler);
        $googleAnalyticsScriptText = $googleAnalyticsScriptNode->text();
        $expectedUACodeRegex = '/UA-50716707-1/';

        $this->assertRegExp($expectedUACodeRegex, $googleAnalyticsScriptText);
    }

}
