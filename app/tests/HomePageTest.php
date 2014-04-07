<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 21/03/2014
 * Time: 22:25
 */

include_once __DIR__ . '/PhpDorsetSilexTest.php';

/**
 * Class HomePageTest
 */
class HomePageTest extends PhpDorsetSilexTest {

    public function testHomePageResponseIs200()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/');

        $this->assertTrue($client->getResponse()->isOk());
    }

//    public function testHomePageHasLogo()
//    {
//        $client = $this->createClient();
//        $crawler = $client->request('GET', '/');
//
//        $this->assertCount(1, $crawler->filter('img#phpdorset-logo[src="/images/logo-transparent.png"]'));
//    }

}
