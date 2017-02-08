<?php
namespace ApiMaster\Service;

use ApiMaster\Controller\HomeController;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ControllerServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        /**
         * Home Controller
         * @param Container $app
         * @return HomeController
         */
        $app['home'] = function (Container $app){
            return new HomeController($app);
        };
    }

}