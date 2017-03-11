<?php
namespace ApiMaster\Controller;

use ApiMaster\Model\User;
use Illuminate\Hashing\BcryptHasher;
use JMS\Serializer\SerializerBuilder;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController
{
    /**
     * @var Application
     */
    private $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function index($id = null)
    {
        $users = $this->app['orm.em']
            ->getRepository('ApiMaster\Model\User');

        if(is_null($id)) {
            $users = $users->findAll();
        }

        if(!is_null($id)) {
            $id = (int) $id;
            $users = $users->find($id);
        }

        $build = SerializerBuilder::create()->build();

        return new Response($build->serialize($users, 'json'), 200);
    }

    public function create(Request $request)
    {
        $orm = $this->app['orm.em'];

        $data = $request->request->all();

        $user = new User();

        $password = new BcryptHasher();
        $password = $password->make($data['password']);

        $user->setName($data['name'])
            ->setEmail($data['email'])
            ->setPassword($password)
            ->setCreatedAt(new \DateTime("now", new \DateTimeZone("America/Sao_Paulo")))
            ->setUpdatedAt(new \DateTime("now", new \DateTimeZone("America/Sao_Paulo")));

        $orm->persist($user);
        $orm->flush();

        return $this->app->json(['msg' => 'Usuário salvo com sucesso!'], 200);
    }

    public function update(Request $request)
    {
        $data = $request->request->all();

        if(!isset($data['id'])) {
            return $this->app->json(
                json_encode(['msg' => 'ID Não Informado!']),
                401
            );
        }

        $orm = $this->app['orm.em'];


        $user = $orm->getRepository('ApiMaster\App\Entity\User')->find($data['id']);


        if(isset($data['name'])
            && $data['name']) {
            $user->setName($data['name']);
        }

        if(isset($data['email'])
            && $data['email']) {
            $user->setEmail($data['email']);
        }

        if(isset($data['password'])
            && $data['password']) {

            $password = new BcryptHasher();
            $password = $password->make($data['password']);


            $user->setPassword($password);
        }

        $user->setUpdatedAt(new \DateTime("now", new \DateTimeZone("America/Sao_Paulo")));

        $orm->merge($user);
        $orm->flush();

        return $this->app->json(
            json_encode(['msg' => 'Usuário atualizado com sucesso!']),
            200
        );
    }

    public function delete($id)
    {

        if(!isset($id)) {
            return $this->app->json(
                json_encode(['msg' => 'ID Não Informado!']),
                401
            );
        }

        $orm = $this->app['orm.em'];
        $user = $orm->getRepository('ApiMaster\App\Entity\User')
            ->find($id);

        $orm->remove($user);
        $orm->flush();

        return $this->app->json(
            json_encode(['msg' => 'Usuário Deletado com sucesso!']),
            200
        );
    }
}