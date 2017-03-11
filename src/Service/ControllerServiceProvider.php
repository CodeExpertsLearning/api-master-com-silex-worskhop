<?php
namespace ApiMaster\Service;

use ApiMaster\Controller\AuthController;
use ApiMaster\Controller\BeerController;
use ApiMaster\Controller\UserController;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ControllerServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        /**
         * Beer Controller
         * @param Container $app
         * @return BeerController
         */
        $app['beers'] = function (Container $app){
            return new BeerController($app);
        };

        $app['user'] = function (Container $app){
            return new UserController($app);
        };

        $app['auth'] = function (Container $app){
            return new AuthController($app);
        };
    }
}