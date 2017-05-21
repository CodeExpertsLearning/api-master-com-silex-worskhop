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
//            ->before(function(Request $request, Container $app){
//                $token =  $request->headers->get('Authorization');
//                $token = str_replace('Bearer ', '', $token);
//
//                try {
//                    $app['jwt']->validateToken($token);
//                } catch (\Exception $e) {
//                    return $app->json(['msg'=> 'Token Inválido!'], 401);
//                }
//            });

        /**
         * 
         */
//        $app->get($app['api_version'] . '/beers/{id}', 'beers:getBeer');

        /**
         * Auth
         */
        $app->post($app['api_version'] . '/auth/login', 'auth:login');

        /**
         * User
         */
        $app->get($app['api_version'] . '/users', 'user:index');

        $app->get($app['api_version'] . '/users/{id}', 'user:index');

        $app->post($app['api_version'] . '/users', 'user:create');

        $app->put($app['api_version'] . '/users', 'user:update');

        $app->delete($app['api_version'] . '/users/{id}', 'user:delete');

        $app->after(function(Request $request, Response $response) {
            $response->headers->set('Content-Type', 'application/json');
        });

        $app["cors-enabled"]($app);

    }

}