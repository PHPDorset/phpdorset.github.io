<?php

require_once __DIR__ . '/../vendor/autoload.php';

$app = new Silex\Application();

$app['current_url'] = function ($app) {
    return $app['request_stack']->getCurrentRequest()->server->get('REQUEST_URI');
};

$app->register(
    new Silex\Provider\TwigServiceProvider(),
    array(
        'twig.path' => __DIR__ . '/../views',
    )
);

$app->register(new Silex\Provider\ServiceControllerServiceProvider());

$app['talk.controller'] = function () use ($app) {
    return new PhpDorset\Talk\TalkController($app['talk.repo'], $app['twig']);
};

$app['talk.repo'] = function () {
    return new PhpDorset\Talk\TalkRepository(
        json_decode(file_get_contents(__DIR__ . '/database/talks.json'), true)
    );
};

$app->get(
    '/api/v1/talks/{year}/{month}/talks.json',
    "talk.controller:fetchCuesByYearAndMonth"
);

$app->get(
    '/',
    [$app['talk.controller'], 'fetchHomepageTalks']
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
    [$app['talk.controller'], 'fetchTalksByYearAndMonth']
);

$app->get(
    '/talks/{year}/{month}/{key}',
    [$app['talk.controller'], 'fetchTalk']
);

$app->get(
    '/talks',
    [$app['talk.controller'], 'fetchTalkList']
);

$app->get(
    '/talk/create',
    [$app['talk.controller'], 'createTalk']
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
    '/sponsors',
    function () use ($app) {
        return $app->redirect('/', 301);
    }
);

$app->get(
    '/about',
    function () use ($app) {
        return $app['twig']->render(
            'about.twig',
            array()
        );
    }
);


return $app;
