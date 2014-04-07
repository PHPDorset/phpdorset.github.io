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
$app['current_url'] = $_SERVER['REQUEST_URI'];

$app->register(
    new Silex\Provider\TwigServiceProvider(),
    array(
        'twig.path' => __DIR__ . '/../views',
    )
);

require_once __DIR__ . '/routes.php';

return $app;