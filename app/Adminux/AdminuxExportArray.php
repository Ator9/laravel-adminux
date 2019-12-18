<?php

namespace App\Adminux;
use Maatwebsite\Excel\Concerns\FromArray;

class AdminuxExportArray implements FromArray
{
    public function __construct($array = [])
    {
        $this->array = $array;
    }

    public function array(): array
    {
        return $this->array;
    }
}
