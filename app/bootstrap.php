<?php

require_once __DIR__ . '/../vendor/autoload.php';

$app = new Silex\Application();

// add the current url to the app object.
$app['current_url'] = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : null;

$app->register(
    new Silex\Provider\TwigServiceProvider(),
    array(
        'twig.path' => __DIR__ . '/../views',
    )
);

$app->register(new Silex\Provider\ServiceControllerServiceProvider);

$app['presentation.controller'] = $app->share(
    function () use ($app) {
        return new PhpDorset\Presentation\PresentationController($app['presentation.repo'], $app['twig']);
    }
);

$app['presentation.repo'] = $app->share(function () {
    return new PhpDorset\Presentation\PresentationRepository(
        json_decode(file_get_contents(__DIR__ . '/database/cues.json'), true)
    );
});

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
    '/get-involved',
    function () use ($app) {
        return $app['twig']->render(
            'get-involved.twig',
            array()
        );
    }
);

$app->get(
    '/talks/{year}/{month}',
    [$app['presentation.controller'], 'fetchCuesByYearAndMonth']
);

$app->get(
    '/talks',
    "presentation.controller:fetchTalkList"
);

$app->get(
    '/contact',
    function () use ($app) {
        return $app->redirect('get-involved', 301);
    }
);

$app->get(
    '/sponsors',
    function () use ($app) {
        return $app->redirect('/', 301);
    }
);

$app->get(
    '/about',
    function () use ($app) {
        return $app->redirect('/', 301);
    }
);


return $app;
