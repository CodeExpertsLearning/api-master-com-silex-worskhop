<?php
namespace ApiMaster\Controller;

use Illuminate\Hashing\BcryptHasher;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class AuthController
{
    private $app;

    /**
     * AuthController constructor.
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function login(Request $request)
    {
        $data = file_get_contents("php://input");
        $data = json_decode($data);
        $data = (array) $data;

        #validations

        $user = $this->app['orm.em']
                     ->getRepository('ApiMaster\Model\User')
                     ->findByEmail($data['email'])[0];
        if(!$user
           || $data['email'] != $user->getEmail()) {
            return $this->app->json(['msg' => 'Usuário ou senha incorretos!'],
                401);
        }

        $hash = new BcryptHasher();

        if(!$hash->check($data['password'], $user->getPassword())) {
            return $this->app->json(json_encode(['msg' => 'Usuário ou senha incorretos!']), 401);
        }

        $jwt = $this->app['jwt'];

        $jwt->setApplication($this->app);

        $jwt->setPayloadData([
            'username' => $user->getEmail()
        ]);

        return $this->app->json(['token' => $jwt->generateToken()->__toString()]);
    }
}