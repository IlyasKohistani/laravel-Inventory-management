<?php

namespace App\Imports;

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
        if (!empty(trim($row['picture']))) {
            $this->row_count++;
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
        // Storage::put('products/' . $myFileName, $imageContents);
        return $myFileName;
    }

    public function rules(): array
    {
        return [
            'total_stok' => 'required'
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
