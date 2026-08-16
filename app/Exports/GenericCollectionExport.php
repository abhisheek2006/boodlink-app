<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

/**
 * Wraps any associative-array collection (as produced by
 * ReportController::dataFor) into a downloadable spreadsheet.
 */
class GenericCollectionExport implements FromCollection, WithHeadings
{
    public function __construct(private Collection $rows) {}

    public function collection(): Collection
    {
        return $this->rows->map(fn ($row) => array_values((array) $row));
    }

    public function headings(): array
    {
        $first = $this->rows->first();

        return $first ? array_keys((array) $first) : [];
    }
}
