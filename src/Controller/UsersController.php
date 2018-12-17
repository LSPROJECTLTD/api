<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');

        $this->loadModel('Token');

    }

    public function validatoken($token)
    {
        $this->loadModel('Token');
        // Autenticação 1 pra 1
        // $part = explode(".", $token);
        // $header = $part[0];
        // $payload = $part[1];
        // $signature = $part[2];
        // $valid = hash_hmac('sha256', "$header.$payload", 'minha-senha', true);
        // $valid = base64_encode($valid);

        // Autenticação 1 pra N
        $tokens = $this->Token->find('all');
        $valid = $token;
        foreach ($tokens as $key => $token) {
            if ($token['token'] == $valid) {
                $validacao = true;
                break;
            } else {
                $validacao = false;
            }
        }
        return $validacao;
    }
    public function index()
    {
        if ($token = $this->request->header('Authorization')) {
            $token = $this->validatoken($token);
        } else {
            echo ' Não autorizado';exit;
        }
        if ($token) {
            $users = $this->Users->find('all');
            $this->set([
                'users' => $users,
                '_serialize' => ['users'],
            ]);
        } else {
            echo 'Token Invalido';exit;
        }
    }

    public function view($id)
    {
        if ($token = $this->request->header('Authorization')) {
            $token = $this->validatoken($token);
        } else {
            echo ' Não autorizado';exit;
        }
        if ($token) {
            $user = $this->Users->get($id);
            $this->set([
                'user' => $user,
                '_serialize' => ['user'],
            ]);
        } else {
            echo 'Token Invalido';exit;
        }
    }

    public function add()
    {
        if ($token = $this->request->header('Authorization')) {
            $token = $this->validatoken($token);
        } else {
            echo ' Não autorizado';exit;
        }
        if ($token) {
            $user = $this->Users->newEntity($this->request->getData());
            if ($this->Users->save($user)) {
                $message = 'Saved';
            } else {
                $message = 'Error';
            }
            $this->set([
                'message' => $message,
                'user' => $user,
                '_serialize' => ['message', 'user'],
            ]);
        } else {
            echo 'Token Invalido';exit;
        }
    }

    public function edit($id)
    {

        $user = $this->Users->get($id);
        if ($this->request->is(['put', 'patch'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $message = 'Saved';
            } else {
                $message = 'Error';
            }
        }
        $this->set([
            'message' => $message,
            '_serialize' => ['message', 'user'],
        ]);

    }

    public function delete($id)
    {
        $user = $this->Users->get($id);
        $message = 'Deleted';
        if (!$this->Users->delete($user)) {
            $message = 'Error';
        }
        $this->set([
            'message' => $message,
            '_serialize' => ['message', 'user'],
        ]);
    }
}
