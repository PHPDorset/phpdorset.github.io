<?php

require_once __DIR__.'/../vendor/autoload.php'; 

$app = new Silex\Application();

// add the current url to the app object.
$app['current_url'] = $_SERVER['REQUEST_URI'];

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views',
));

$app->get('/', function() use($app) {
    return $app['twig']->render('master.twig', array(
        'main_content' => 'homepage.twig'
    ));
});

$app->get('/sponsors', function() use($app) { 
    return $app['twig']->render('master.twig', array(
        'main_content' => 'sponsors.twig'
    ));
});

$app->get('/contact', function() use($app) { 
    return $app['twig']->render('master.twig', array(
        'main_content' => 'contact.twig'
    ));
});

$app->run();
