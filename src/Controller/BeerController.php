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
    
    public function getBeer($id)
    {
        $id = (int) $id;

        $beers = $this->app['orm.em']
                      ->getRepository("ApiMaster\Model\Beer")
                      ->find($id);

        $beers = SerializerBuilder::create()->build()
                                    ->serialize($beers, 'json');
        
        return new Response($beers, 200);
    }

     public function create()
    {
        $data = file_get_contents("php://input");
        $data = json_decode($data);
        $data = (array) $data;

        $beer = new \ApiMaster\Model\Beer();

        $beer->setName($data['name'])
             ->setPrice($data['price'])
             ->setType($data['type'])
             ->setMark($data['mark'])
             ->setCreatedAt(new \DateTime('now', new \DateTimeZone("America/Sao_Paulo")))
             ->setUpdatedAt(new \DateTime('now', new \DateTimeZone("America/Sao_Paulo")));
        
        $orm = $this->app['orm.em'];
        $orm->persist($beer);
        $orm->flush();
        return json_encode(['msg'=>'Beer Saved With Sucess']);
    }

}