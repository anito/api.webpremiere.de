<?php

namespace App\Controller\Api;

use App\Controller\Api\AppController;

class TodosController extends AppController
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
}
