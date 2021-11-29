<?php

namespace App\Http\Controllers;

use App\Http\Requests\Imports\ImportIndexRequest;
use App\Http\Requests\Imports\ImportRequest;
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
    public function index(ImportIndexRequest $request)
    {
        return view('layouts.imports');
    }



    /**
     * Import data from user.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function ImportData(ImportRequest $request)
    {
        ini_set('max_execution_time', 180); 
        try {
            Excel::import(new DataImport, request()->file('file'));
            return 'ok';
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failure = $e->failures()[0];
            $message =   'There was an error on row number ' . $failure->row() . '.' . $failure->errors()[0];
            return Response(['message' => $message], 422);
        }
    }
}
