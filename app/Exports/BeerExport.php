<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BeerExport implements FromCollection, WithHeadings
{
    public function __construct(
        private array $reportData,
    ) {
    }

    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        return collect($this->reportData);
    }

    public function headings(): array
    {
        return array_keys($this->reportData[0]);
    }
}
