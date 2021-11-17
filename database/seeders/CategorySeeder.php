<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
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
                'name' => mb_convert_case('WAM GOMLEK VE WAM LADY',MB_CASE_TITLE, 'UTF-8')
            ],
            [
                'id' => 2,
                'name' => mb_convert_case('WAM JEANS',MB_CASE_TITLE, 'UTF-8')
            ],
            [
                'id' => 3,
                'name' => mb_convert_case('YENİ WAM DENİM JEANS',MB_CASE_TITLE, 'UTF-8')
            ],
            [
                'id' => 4,
                'name' => mb_convert_case('GAZNWI JEANS',MB_CASE_TITLE, 'UTF-8')
            ],
            [
                'id' => 5,
                'name' => mb_convert_case('WAM DENİM CEKET, KABAN VE MONT',MB_CASE_TITLE, 'UTF-8')
            ],
            [
                'id' => 6,
                'name' => mb_convert_case('GAZNAWI PENYE',MB_CASE_TITLE, 'UTF-8')
            ],
            [
                'id' => 7,
                'name' => mb_convert_case('WAM PENYE',MB_CASE_TITLE, 'UTF-8')
            ],
            [
                'id' => 8,
                'name' => mb_convert_case('ARYA BRAND PENYE, GÖMLEK VE JEAN',MB_CASE_TITLE, 'UTF-8')
            ],
            [
                'id' => 9,
                'name' => mb_convert_case('ARYABOY TÜM AKSESUARLARI',MB_CASE_TITLE, 'UTF-8')
            ],
            [
                'id' => 10,
                'name' => mb_convert_case('TRİKO VE MARKASIZ METAL JEANS İ',MB_CASE_TITLE, 'UTF-8')
            ],
        ];

        foreach ($data as $value) {
            Category::firstOrCreate($value);
        }
    }
}
