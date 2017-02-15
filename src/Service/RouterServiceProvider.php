<?php
namespace ApiMaster\Service;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RouterServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        /**
         * Main Route
         */
        $app->get($app['api_version'] . '/beers', 'beers:index');

        /**
         * 
         */
        $app->get($app['api_version'] . '/beers/{id}', 'beers:getBeer');

        $app->after(function(Request $request, Response $response) {
            $response->headers->set('Content-Type', 'application/json');
        });
    }

}