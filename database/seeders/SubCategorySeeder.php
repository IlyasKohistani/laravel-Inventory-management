<?php

namespace Database\Seeders;

use App\Models\SubCategory;
use Illuminate\Database\Seeder;

class SubCategorySeeder extends Seeder
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
                'name' => mb_convert_case('YENİ GELEN AKSESUARLAR',MB_CASE_TITLE, 'UTF-8')
            ],
            [
                'id' => 2,
                'name' => mb_convert_case('TURUNCE VE LACİVER TAKIMI',MB_CASE_TITLE, 'UTF-8')
            ],
            [
                'id' => 3,
                'name' => mb_convert_case('KIRMIZI VE SİYAH TAKIMI',MB_CASE_TITLE, 'UTF-8')
            ],
            [
                'id' => 4,
                'name' => mb_convert_case('ARYA BRAND PENYE VE GÖMLEK',MB_CASE_TITLE, 'UTF-8')
            ],
            [
                'id' => 5,
                'name' => mb_convert_case('CEKET',MB_CASE_TITLE, 'UTF-8')
            ],
            [
                'id' => 6,
                'name' => mb_convert_case('KABAN',MB_CASE_TITLE, 'UTF-8')
            ],
            [
                'id' => 7,
                'name' => mb_convert_case('MONT',MB_CASE_TITLE, 'UTF-8')
            ],
            [
                'id' => 8,
                'name' => mb_convert_case('ESKİ ETİKETLER',MB_CASE_TITLE, 'UTF-8')
            ],
            [
                'id' => 9,
                'name' => mb_convert_case('YENİ ETİKETLER',MB_CASE_TITLE, 'UTF-8')
            ],
            [
                'id' => 10,
                'name' => mb_convert_case('PENYE İÇİN YENİ AKSESUARLAR',MB_CASE_TITLE, 'UTF-8')
            ],
        ];

        foreach ($data as $value) {
            SubCategory::firstOrCreate($value);
        }
    }
}
