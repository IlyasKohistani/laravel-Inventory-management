<?php

namespace App\Http\Controllers;

use App\Imports\DataImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Facades\Excep;

class ImportController extends Controller
{
    public function ImportData(Request $request)
    {
        $request->validate([
            'file' => 'required|file',
        ]);

        try {
            Excel::import(new DataImport, request()->file('file'));
            return 'ok';
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            throw $e;
        }
    }

    public function Images(Request $request)
    {
        $path = 'images/6e87380a-8436-4f38-9bc7-2917a5ef5553.png';
        if (Storage::exists($path)) {
            return Storage::get($path);
        }
        return $path;
    }
}
