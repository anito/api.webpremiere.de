<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * TodosFixture
 */
class TodosFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => '016ef7c1-9256-46ae-b08d-a10bc1a2e980',
                'done' => 1,
                'name' => 'Lorem ipsum dolor sit amet',
                'user_id' => '62f845e7-f5e2-4655-b797-d11a2de75a72',
                'created' => '2022-09-13 16:22:45',
                'modified' => '2022-09-13 16:22:45',
            ],
        ];
        parent::init();
    }
}
