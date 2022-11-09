<?php

declare(strict_types=1);

namespace App\Model\Entity;

use Authentication\IdentityInterface;
use Authentication\PasswordHasher\DefaultPasswordHasher;
use Cake\ORM\Entity;

/**
 * User Entity
 *
 * @property string $id
 * @property string|null $username
 * @property string|null $password
 *
 * @property \App\Model\Entity\Todo[] $todos
 */
class User extends Entity implements IdentityInterface
{
  protected function _setPassword($password): ?string
  {
    if (strlen($password) > 0) {
      $hasher = new DefaultPasswordHasher();

      return $hasher->hash($password);
    }
  }

  /**
   * Fields that can be mass assigned using newEntity() or patchEntity().
   *
   * Note that when '*' is set to true, this allows all unspecified fields to
   * be mass assigned. For security purposes, it is advised to set '*' to false
   * (or remove it), and explicitly make individual fields accessible as needed.
   *
   * @var array<string, bool>
   */
  protected $_accessible = [
    'id' => true,
    'username' => true,
    'password' => true,
    'token' => true,
    'todos' => true,
    'group_id' => true,
  ];

  /**
   * Fields that are excluded from JSON versions of the entity.
   *
   * @var array
   */
  protected $_hidden = [
    'password', 'last_login'
  ];

  /**
   * Authentication\IdentityInterface method
   */
  public function getIdentifier()
  {
    return $this->id;
  }

  /**
   * Authentication\IdentityInterface method
   */
  public function getOriginalData()
  {
    return $this;
  }
}
