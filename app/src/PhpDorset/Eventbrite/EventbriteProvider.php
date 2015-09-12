<?php

namespace PhpDorset\EventBrite;

class EventbriteProvider implements \Silex\ServiceProviderInterface
{
    public function register(\Silex\Application $app)
    {
        $app['eventbrite'] = $app->share(function ($app) {
            return new EventbriteService($app['eventbrite.oauth']);
        });

        $app['eventbrite.oauth'] = function() {
            return $_ENV['EVENTBRITE_OAUTH'];
        };
    }

    public function boot(\Silex\Application $app)
    {
    }
}

