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
class ContactPageTest extends PhpDorsetSilexTest {

    public function testContactPageResponseIs200()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/contact');

        $this->assertTrue($client->getResponse()->isOk());
    }

    public function testContactPageHasIrcChannel() {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/contact');

        $this->assertTrue($client->getResponse()->isOk());
        $this->assertCount(1, $crawler->filter('div.contact-list:contains("#phpdorset on freenode.net")'));
    }

}
