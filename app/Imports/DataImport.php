<?php

namespace App\Imports;

use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Mockery\Undefined;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing;

class DataImport implements OnEachRow, WithHeadingRow, WithValidation, WithCalculatedFormulas
{

    private $row_count = 2;

    public function onRow(Row $row)
    {
        $rowIndex = $row->getIndex();
        $row = $row->toArray();
        $spreadsheet = IOFactory::load(request()->file('file'));
        $item = new Product();
        $item->name = $row['name'] ?? 'NO NAME';
        $item->category_id = $row['category'];
        $item->sub_category_id = $row['sub_category'] ?? null;
        $item->quantity = $row['stock'];
        $item->image = 'no-pictures.png';
        $item->status = 1;
        if ($row['has_image'] == 0) {
            $this->row_count++;
            $item->save();
            return $row;
        };
        $drawing = $spreadsheet->getActiveSheet()->getDrawingCollection()[$rowIndex - $this->row_count];
        if ($drawing instanceof MemoryDrawing) {
            ob_start();
            call_user_func(
                $drawing->getRenderingFunction(),
                $drawing->getImageResource()
            );
            $imageContents = ob_get_contents();
            ob_end_clean();
            switch ($drawing->getMimeType()) {
                case MemoryDrawing::MIMETYPE_PNG:
                    $extension = 'png';
                    break;
                case MemoryDrawing::MIMETYPE_GIF:
                    $extension = 'gif';
                    break;
                case MemoryDrawing::MIMETYPE_JPEG:
                    $extension = 'jpg';
                    break;
            }
        } else {
            $zipReader = fopen($drawing->getPath(), 'r');
            $imageContents = '';
            while (!feof($zipReader)) {
                $imageContents .= fread($zipReader, 1024);
            }
            fclose($zipReader);
            $extension = $drawing->getExtension();
        }
        $myFileName = Str::uuid()->toString() . Carbon::now()->timestamp . '.' . $extension;
        Storage::put('products/' . $myFileName, $imageContents);

        //file name
        $item->image = 'products/' . $myFileName;
        $item->save();
        return $row;
    }

    public function rules(): array
    {
        return [
            'name' => 'nullable|max:255',
            'stock' => 'required|integer|min:0',
            'category' => 'required|integer|exists:categories,id',
            'sub_category' => 'nullable|integer|exists:sub_categories,id',
            'has_image' => 'required|integer|in:1,0',
        ];
    }

    /**
     * @return array
     */
    public function customValidationAttributes()
    {
        return [];
    }


    public function headingRow(): int
    {
        return 1;
    }
}
