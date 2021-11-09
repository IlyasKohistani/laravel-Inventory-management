<?php

namespace App\Http\Controllers;

use App\Imports\DataImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Facades\Excep;

class ImportController extends Controller
{
    public function ImportData(Request $request){
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
}
