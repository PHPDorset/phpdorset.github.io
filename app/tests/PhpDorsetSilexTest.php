<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 21/03/2014
 * Time: 22:25
 */

use Silex\WebTestCase;

/**
 * Class PhpDorsetSilexTest
 */
abstract class PhpDorsetSilexTest extends WebTestCase
{

    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap.php';
        $app['debug'] = true;
        $app['exception_handler']->disable();

        return $app;
    }
}
