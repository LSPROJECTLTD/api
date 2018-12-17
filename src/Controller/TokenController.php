<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Token Controller
 *
 * @property \App\Model\Table\TokenTable $Token
 *
 * @method \App\Model\Entity\Token[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TokenController extends AppController
{

    public function salvaToken($token)
    {

        $header = [
            'alg' => 'HS256',
            'typ' => 'JWT',
        ];
        $header = json_encode($header);
        $header = base64_encode($header);

        $payload = [
            'iss' => $token['iss'],
            'name' => $token['name'],
            'email' => $token['email'],
        ];
        $payload = json_encode($payload);
        $payload = base64_encode($payload);

        $signature = hash_hmac('sha256', "$header.$payload", $token['senha'], true);
        $signature = base64_encode($signature);

        return $token = "$header.$payload.$signature";

    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $token = $this->paginate($this->Token);

        $this->set(compact('token'));
    }

    /**
     * View method
     *
     * @param string|null $id Token id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $token = $this->Token->get($id, [
            'contain' => [],
        ]);

        $this->set('token', $token);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {

        $salvaToken = $this->request->getData();

        $token = $this->Token->newEntity();
        if ($this->request->is('post')) {
            $salvaToken['token'] = $this->salvaToken($salvaToken);
            $token = $this->Token->patchEntity($token, $salvaToken);
            if ($this->Token->save($token)) {
                $this->Flash->success(__('The token has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The token could not be saved. Please, try again.'));
        }
        $this->set(compact('token'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Token id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $token = $this->Token->get($id);
        if ($this->Token->delete($token)) {
            $this->Flash->success(__('The token has been deleted.'));
        } else {
            $this->Flash->error(__('The token could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
