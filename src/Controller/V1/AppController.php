<?php

namespace App\Controller\V1;

use Cake\Cache\Cache;
use Cake\Controller\Controller;
use Cake\Core\Configure;
use Cake\Event\EventInterface;
use Cake\Http\Client;
use Cake\Http\ContentTypeNegotiation;
use Cake\I18n\I18n;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;
use Cake\Utility\Security;
use Cake\View\JsonView;
use Crud\Controller\ControllerTrait;
use Firebase\JWT\JWT;
use phpDocumentor\Reflection\Types\Scalar;

class AppController extends Controller
{
  use ControllerTrait;

  public function initialize(): void
  {

    parent::initialize();
    $this->loadComponent('RequestHandler');
  }

  public function viewClasses(): array
  {
    return [JsonView::class];
  }
}
