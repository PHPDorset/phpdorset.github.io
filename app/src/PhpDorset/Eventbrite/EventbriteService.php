<?php

namespace PhpDorset\Eventbrite;

class EventbriteService
{
    protected $oauth;

    public function __construct($oauth)
    {
        $this->oauth = $oauth;
        $this->client = new \GuzzleHttp\Client();
    }

    public function getEvents()
    {
        $client = new \GuzzleHttp\Client();
        $request = $client->createRequest('GET', 'https://www.eventbriteapi.com/v3/users/me/owned_events/');
        $request->setHeader('Authorization', 'Bearer ' . $this->oauth);
        $response = $client->send($request);

        $body = json_decode($response->getBody());

        if (isset($body->events) && is_array($body->events)) {
            $events = array_map(function($event) {
                return new \PhpDorset\Eventbrite\EventDecorator($event);
            }, $body->events);

            return $events;
        }

        return null;
    }
}

