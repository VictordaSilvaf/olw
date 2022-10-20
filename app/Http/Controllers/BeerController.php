<?php

namespace App\Http\Controllers;

use App\Http\Requests\BeerRequest;
use App\Jobs\ExportJob;
use App\Jobs\SendExportEmailJob;
use App\Jobs\StoreExportDataJob;
use App\Models\Export;
use App\Models\Meal;
use App\Services\PunkapiService;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class BeerController extends Controller
{
    public function index(BeerRequest $request, PunkapiService $service)
    {
        $filters = $request->validated();
        $beers = $service->getBeers(...$filters);
        $meals = Meal::all();

        return Inertia::render('Beers', [
            'beers' => $beers,
            'meals' => $meals,
            'filters' => $filters
        ]);
    }

    public function export(BeerRequest $request)
    {
        $file_name = 'cervejas_encontradas_' . now()->format('Y-m-d_H-i') . '.xlsx';

        ExportJob::withChain([
            new SendExportEmailJob(auth()->user(), $file_name),
            new StoreExportDataJob(auth()->user(), $file_name),
        ])->dispatch($request->validated(), $file_name);

        return redirect()->back()
            ->with('success', 'Seu arquivo foi enviado para o seu email, aguarde alguns instantes.!');
    }
}
