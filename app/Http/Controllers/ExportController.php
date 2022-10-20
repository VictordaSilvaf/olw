<?php

namespace App\Http\Controllers;

use App\Models\Export;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ExportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        $exports = Export::paginate(5);

        return Inertia::render('Reports', compact('exports'));
    }

    public function show($export)
    {
        $export = Export::findOrFail($export);
        return Storage::download($export->file_name);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $export
     * @return string
     */
    public function destroy($export)
    {
        $export = Export::findOrFail($export);

        if (isset($export)) {
            Storage::delete($export->file_name);
            $export->delete();
        }

        return redirect()->back()
            ->with('success', 'Arquivo excluído com sucesso!');
    }
}
