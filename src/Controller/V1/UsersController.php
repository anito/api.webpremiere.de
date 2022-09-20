<?php

namespace App\Controller\V1;

use App\Controller\V1\AppController;

class UsersController extends AppController
{
  public function initialize(): void
  {
    parent::initialize();

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
  }

  public function view($id)
  {
    $data = $this->Users->find('all')
      ->contain(['Todos'])
      ->where(['Users.id' => $id]);

    $this->set([
      'success' => true,
      'data' => $data,
    ]);

    $this->viewBuilder()->setOption('serialize', ['success', 'data']);
  }
}
