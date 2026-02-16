<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ClientsImport;
use Illuminate\Support\Facades\Redirect;

class ImportController extends Controller
{
    /**
     * Show the upload form.
     */
    public function showUploadForm()
    {
        return view('import'); // make sure resources/views/import.blade.php exists
    }

    /**
     * Handle the file upload and import.
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048', // added csv + size limit
        ]);

        Excel::import(new ClientsImport, $request->file('file'));

        return Redirect::back()->with('success', 'Excel file imported successfully.');
    }
}
