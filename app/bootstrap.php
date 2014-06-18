<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 21/03/2014
 * Time: 22:33
 */

require_once __DIR__ . '/../vendor/autoload.php';

$app = new Silex\Application();

// add the current url to the app object.
$app['current_url'] = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : null;
$app['debug'] = true;

$app->register(
    new Silex\Provider\TwigServiceProvider(),
    array(
        'twig.path' => __DIR__ . '/../views',
    )
);

$app->register(new Silex\Provider\ServiceControllerServiceProvider);


$app['presentation.controller'] = $app->share(
    function () use ($app) {
        return new PhpDorset\Presentation\PresentationController(
            new PhpDorset\Presentation\PresentationRepository(
                __DIR__ . '/database/cues.json'
            ), $app
        );
    }
);

$app->get(
    '/api/v1/presentations/{year}/{month}/cues.json',
    "presentation.controller:fetchCuesByYearAndMonth"
);

$app->get(
    '/',
    function () use ($app) {
        return $app['twig']->render(
            'homepage.twig',
            array()
        );
    }
);

$app->get(
    '/sponsors',
    function () use ($app) {
        return $app['twig']->render(
            'sponsors.twig',
            array()
        );
    }
);

$app->get(
    '/contact',
    function () use ($app) {
        return $app['twig']->render(
            'contact.twig',
            array()
        );
    }
);

$app->get(
    '/about',
    function () use ($app) {
        return $app['twig']->render('about.twig');
    }
);

$app->get(
    '/talks/{year}/{month}',
    [$app['presentation.controller'], 'fetchCuesByYearAndMonth']
);

return $app;
