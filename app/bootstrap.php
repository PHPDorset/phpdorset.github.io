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

$app->register(
    new Silex\Provider\TwigServiceProvider(),
    array(
        'twig.path' => __DIR__ . '/../views',
    )
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

$app->get('/about', function () use ($app) {
    return $app['twig']->render('about.twig');
});

$app->get(
    '/talks/{year}/{month}',
    function ($year,$month) use ($app) {

        // $json = file_get_contents("/presentations/{$year}/{$month}/cues.json");
        // $cues = json_decode($json,true);

        $cues = array(
            2 => 3,
            3 => 7,
            4 => 10,
            5 => 27,
            6 => 39,
            7 => 47,
            8 => 81   
        );

        $pdf_url = "/presentations/{$year}/{$month}/talk.pdf";

        return $app['twig']->render(
            'talk.twig',
            array(
                'pdf_url' => $pdf_url,
                'cues' => $cues
            )
        );
    }
);

return $app;
