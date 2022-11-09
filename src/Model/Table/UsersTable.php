<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property \App\Model\Table\TodosTable&\Cake\ORM\Association\HasMany $Todos
 *
 * @method \App\Model\Entity\User newEmptyEntity()
 * @method \App\Model\Entity\User newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\User|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class UsersTable extends Table
{
  /**
   * Initialize method
   *
   * @param array $config The configuration for the Table.
   * @return void
   */
  public function initialize(array $config): void
  {
    parent::initialize($config);

    $this->setTable('users');
    $this->setDisplayField('username');
    $this->setPrimaryKey('id');

    $this->belongsTo('Groups', [
      'foreignKey' => 'group_id',
    ]);

    $this->hasMany('Todos', [
      'foreignKey' => 'user_id',
    ]);
  }

  /**
   * Default validation rules.
   *
   * @param \Cake\Validation\Validator $validator Validator instance.
   * @return \Cake\Validation\Validator
   */
  public function validationDefault(Validator $validator): \Cake\Validation\Validator
  {
    $validator
      // dont use uuid validation as long as there are still any scalar user ids
      // ->uuid('id', 'No valid UUID')
      ->scalar('id')
      ->allowEmptyString('id', null, 'create')
      ->add('id', 'unique', ['rule' => 'validateUnique', 'provider' => 'table', 'message' => 'Id already exists']);

    $validator
      ->scalar('username')
      ->maxLength('username', 255)
      ->notEmptyString('username', __('Username can not be empty'))
      ->add('username', 'unique', ['rule' => 'validateUnique', 'provider' => 'table', 'message' => 'Username already exists']);

    $validator
      ->scalar('password')
      ->maxLength('password', 255)
      ->allowEmptyString('password');

    return $validator;
  }

  /**
   * Returns a rules checker object that will be used for validating
   * application integrity.
   *
   * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
   * @return \Cake\ORM\RulesChecker
   */
  public function buildRules(RulesChecker $rules): RulesChecker
  {
    $rules->add($rules->isUnique(['id']));
    $rules->add($rules->existsIn(['group_id'], 'Groups'));

    return $rules;
  }
}
