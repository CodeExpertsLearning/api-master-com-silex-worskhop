<?php
namespace ApiMaster\Controller;

use JMS\Serializer\SerializerBuilder;
use Silex\Application;
use Symfony\Component\HttpFoundation\Response;

class BeerController
{
    private $app;

    /**
     * BeerController constructor.
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function index()
    {
        $beers = $this->app['orm.em']
                      ->getRepository("ApiMaster\Model\Beer")
                      ->findAll();

        $beers = SerializerBuilder::create()->build()
                                    ->serialize($beers, 'json');
        
        return new Response($beers, 200);
    }
}