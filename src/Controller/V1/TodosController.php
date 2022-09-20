<?php

namespace App\Controller\V1;

use App\Controller\V1\AppController;
use Cake\Event\Event;
use Cake\View\JsonView;

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

  public function index()
  {
    if ($this->request->is('json')) {
      return $this->Crud->execute();
    } else {
      $data = $this->paginate();
      $success = true;
      $this->set('serialize', compact('success', 'data'));
    }
  }
}
