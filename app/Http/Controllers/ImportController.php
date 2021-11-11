<?php

namespace App\Http\Controllers;

use App\Imports\DataImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Facades\Excep;

class ImportController extends Controller
{
    /**
     * Display import page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('layouts.imports');
    }



    /**
     * Import data from user.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function ImportData(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xls,xlsx',
        ]);

        try {
            Excel::import(new DataImport, request()->file('file'));
            return 'ok';
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failure = $e->failures()[0];
            $message =   'There was an error onn row number ' . $failure->row() . '.' . $failure->errors()[0];
            return Response(['message' => $message], 422);
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
