<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class Org_With_Rep_Export implements FromArray, WithHeadings
{
    protected $rows;

    public function __construct(array $rows)
    {
        $this->rows = $rows;
    }

    public function array(): array
    {
        return $this->rows;
    }

    public function headings(): array
    {
        return [
            'Наименование организации',
            'Регион',
            'Email организации',
            'Имя представителя',
            'Должность',
            'Телефон представителя',
        ];
    }
}
