<?php

namespace App\Http\Controllers;

use App\Models\Export;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class ExportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index()
    {
        $export = Export::paginate(15);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Export $export
     * @return string
     */
    public function destroy(Export $export)
    {
        Storage::delete($export->file_name);
        $export->delete();

        return "deletado com sucesso!";
    }
}
