<?php

include_once __DIR__ . '/PhpDorsetSilexTest.php';

class MeetupsPageTest extends PhpDorsetSilexTest
{

    public function testMeetupsResponseIs200()
    {
        if (!isset($_ENV['EVENTBRITE_OAUTH'])) {
            $this->markTestSkipped('Test requires EVENTBRITE_OUAUTH key configured in phpunit.xml');
        }

        $this->app['current_url'] = '/meetups';
        $client = $this->createClient();
        $crawler = $client->request('GET', '/');

        $this->assertTrue($client->getResponse()->isOk());
    }

}
