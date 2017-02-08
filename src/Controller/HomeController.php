<?php
namespace ApiMaster\Controller;

use Silex\Application;

class HomeController
{
    private $app;

    /**
     * HomeController constructor.
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function index()
    {
        return "Home Controller Index";
    }

    public function show($name)
    {
        return $name;
    }
}