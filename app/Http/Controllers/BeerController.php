<?php

namespace App\Http\Controllers;

use App\Http\Requests\BeerRequest;
use App\Jobs\ExportJob;
use App\Jobs\SendExportEmailJob;
use App\Jobs\StoreExportDataJob;
use App\Services\PunkapiService;

class BeerController extends Controller
{
    public function index(BeerRequest $request, PunkapiService $service)
    {
        return $service->getBeers(...$request->validated());
    }

    public function export(BeerRequest $request)
    {
        $file_name = 'cervejas_encontradas_' . now()->format('Y-m-d_H-i') . '.xlsx';

        ExportJob::withChain([
            new SendExportEmailJob(auth()->user(), $file_name),
            new StoreExportDataJob(auth()->user(), $file_name),
        ])->dispatch($request->validated(), $file_name);

        return "Relatório criado!";
    }
}
