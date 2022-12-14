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
    $this->Authentication->addUnauthenticatedActions([]);

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
    $id = $this->Authentication->getIdentity()->getIdentifier();
    $this->Crud->on('beforePaginate', function (Event $event) use ($id) {
      $event->getSubject()->query
        ->where(['Todos.user_id' => $id]);
    });
    return $this->Crud->execute();
  }

  public function add()
  {
    return $this->Crud->execute();
  }
}
