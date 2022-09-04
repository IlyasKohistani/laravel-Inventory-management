<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
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
                'name' => 'owner',
                'surname' => 'Inventory',
                'username' => 'owner',
                'email' => 'owner@gmail.com',
                'password' => Hash::make('12345678'),
            ],
            [
                'id' => 2,
                'name' => 'Editor',
                'surname' => 'Inventory',
                'username' => 'editor',
                'email' => 'editor@gmail.com',
                'password' => Hash::make('12345678'),
            ],
            [
                'id' => 3,
                'name' => 'Approval',
                'surname' => 'Inventory',
                'username' => 'approval',
                'email' => 'approval@gmail.com',
                'password' => Hash::make('12345678'),
            ],
            [
                'id' => 4,
                'name' => 'viewer',
                'surname' => 'Inventory',
                'username' => 'viewer',
                'email' => 'viewer@gmail.com',
                'password' => Hash::make('12345678'),
            ],
        ];

        $user_role = [
            1 => [1],
            2 => [2],
            3 => [3],
            4 => [4],
        ];

        foreach ($data as $value) {
            User::firstOrCreate($value);
            User::find($value['id'])->roles()->sync($user_role[$value['id']]);
        }
    }
}
