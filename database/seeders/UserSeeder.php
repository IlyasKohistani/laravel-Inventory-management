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
                'name' => 'Ilyas',
                'surname' => 'Kohistani',
                'username' => 'IlyasKohistani',
                'email' => 'alyas.kohistani@gmail.com',
                'password' => Hash::make('12345678'),
            ],
            [
                'id' => 2,
                'name' => 'Abdul Khaliq',
                'surname' => 'Karimi',
                'username' => 'AbdulKhaliq',
                'email' => 'itshalik@gmail.com',
                'password' => Hash::make('12345678'),
            ],
            [
                'id' => 3,
                'name' => 'Sami',
                'surname' => 'Hadad',
                'username' => 'SamiHadad',
                'email' => 's.hadad@wamdenim.com',
                'password' => Hash::make('12345678'),
            ],
            [
                'id' => 4,
                'name' => 'Ebru',
                'surname' => 'Amiri',
                'username' => 'EbruAmiri',
                'email' => 'acmodelhane@gmail.com',
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
