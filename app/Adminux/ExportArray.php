<?php

namespace App\Adminux;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;

class ExportArray implements FromArray, WithCustomCsvSettings
{
    public function __construct($array = [], $settings = [])
    {
        $this->array = $array;
        $this->settings = $settings;
    }

    public function array(): array
    {
        return $this->array;
    }

    public function getCsvSettings(): array
    {
        return !empty($this->settings) ? $this->settings : [];
    }
}
