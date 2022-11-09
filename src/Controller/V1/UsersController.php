<?php

namespace App\Controller\V1;

use App\Controller\V1\AppController;
use Cake\Event\Event;
use Cake\Http\Exception\ForbiddenException;

class UsersController extends AppController
{
  public function initialize(): void
  {
    parent::initialize();
    $this->Authentication->addUnauthenticatedActions(['logout', 'login', 'add']);

    $this->loadComponent('Crud.Crud', [
      'actions' => [
        'Crud.Index',
        'Crud.View',
        'Crud.Add',
        'Crud.Edit',
        'Crud.Delete',
      ],
      'listeners' => [
        'Crud.Api',
      ],
    ]);
    $this->Crud->addListener('relatedModels', 'Crud.RelatedModels');
  }

  public function login()
  {
    $result = $this->Authentication->getResult();
    if ($result->isValid()) {
      $user = $this->Authentication->getIdentity();
    }

    if (isset($user)) {
      $user = $this->Users->patchEntity($user, [
        'token' => $this->_createToken($user->id),
        'last_login' => date("Y-m-d H:i:s")
      ]);
      $this->Users->save($user);
      $this->set([
        'success' => true,
        'data' => [
          'user' => $user->toArray(),
          'message' => __('Login successful')
        ],
      ]);
    } else {
      $this->set([
        'success' => false,
        'data' => [
          'message' => __('Login failed')
        ],
      ]);
    }

    $this->viewBuilder()->setOption('serialize', ['success', 'data']);
  }

  public function view($id)
  {
    $data = $this->Users->get($id, ['contain' => ['Todos']]);
    // $todos = $data->todos;

    $this->set([
      'success' => true,
      'data' => $data
    ]);

    $this->viewBuilder()->setOption('serialize', ['success', 'data']);
  }

  public function add()
  {
    $this->Crud->on('beforeSave', function (Event $event) {
      $entity = $event->getSubject()->entity;
      $this->Users->patchEntity($entity, [
        'token' => $this->_createToken($entity->id),
        'last_login' => date("Y-m-d H:i:s")
      ]);
    });

    $this->Crud->on('afterSave', function (Event $event) {

      $entity = $event->getSubject()->entity;
      $errors = $entity->getErrors();
      if (!empty($errors)) {
        $message = $this->_firstValue($errors);
        throw new ForbiddenException(__($message));
      }
      $this->set([
        'message' => 'User registered',
      ]);
      $this->Crud->action()->serialize(['message']);
    });
    return $this->Crud->execute();
  }
}
