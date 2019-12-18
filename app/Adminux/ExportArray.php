<?php

namespace App\Adminux;
use Maatwebsite\Excel\Concerns\FromArray;

class ExportArray implements FromArray
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
