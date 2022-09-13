<?php

namespace App\Controller\Api;

use Cake\Cache\Cache;
use Cake\Controller\Controller;
use Cake\Core\Configure;
use Cake\Http\Client;
use Cake\I18n\I18n;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;
use Cake\Utility\Security;
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
}
