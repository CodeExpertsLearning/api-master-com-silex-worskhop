<?php
namespace ApiMaster\Service;

use ApiMaster\Controller\BeerController;
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
    }
}