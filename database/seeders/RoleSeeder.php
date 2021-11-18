<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'id' => 1,
                'name' => 'owner'
            ],
            [
                'id' => 2,
                'name' => 'editor'
            ],
            [
                'id' => 3,
                'name' => 'approval'
            ],
            [
                'id' => 4,
                'name' => 'viewer'
            ],
        ];

        foreach ($data as $value) {
            Role::firstOrCreate($value);
        }

    }
}
