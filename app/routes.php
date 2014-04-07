<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 21/03/2014
 * Time: 22:34
 */

$app->get(
    '/',
    function () use ($app) {
        return $app['twig']->render(
            'master.twig',
            array(
                'main_content' => 'homepage.twig'
            )
        );
    }
);

$app->get(
    '/sponsors',
    function () use ($app) {
        return $app['twig']->render(
            'master.twig',
            array(
                'main_content' => 'sponsors.twig'
            )
        );
    }
);

$app->get(
    '/contact',
    function () use ($app) {
        return $app['twig']->render(
            'master.twig',
            array(
                'main_content' => 'contact.twig'
            )
        );
    }
);