<?php

require_once __DIR__ . '/vendor/autoload.php';

$data = json_decode(file_get_contents(__DIR__ . '/app/database/talks.json'), true);

foreach ($data as $year => $meetup) {
    @mkdir(__DIR__ . '/app/database/' . $year);
    foreach ($meetup as $month => $talks) {
        foreach ($talks as $talk) {
            @mkdir(__DIR__ . '/app/database/' . $year . '/' . $month);

            $yamlFile = \Symfony\Component\Yaml\Yaml::dump($talk);

            file_put_contents(
                __DIR__ . '/app/database/' . $year . '/' . $month . '/' . $talk['twitter'] . '.yml',
                $yamlFile
            );
        }
    }
}
