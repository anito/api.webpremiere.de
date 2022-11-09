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
    $this->loadComponent('Authentication.Authentication');
  }

  public function viewClasses(): array
  {
    return [JsonView::class];
  }

  protected function _createToken($id, $exp = null)
  {
    if (!isset($exp)) {
      $expires = time() + Configure::read('Token.lifetime');
    } else {
      $expires = $exp;
    }
    return JWT::encode(
      [
        'sub' => $id,
        'exp' => $expires,
      ],
      Security::getSalt(),
      'HS256'
    );
  }

  protected function _checkValidationErrors(Entity $entity)
  {
    if ($entity->hasErrors()) {
      $errors = $entity->getErrors();

      return $this->_firstValue($errors);
    }
  }

  protected function _firstValue($val): String
  {
    if (is_array($val)) {
      $key = array_key_first($val);
      return $this->_firstValue($val[$key]);
    } else {
      return $val;
    }
  }
}
