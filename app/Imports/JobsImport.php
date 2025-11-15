<?php

namespace App\Imports;

use App\Models\JobVacancy;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class JobsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new JobVacancy([
            'title' => $row['title'] ?? null,
            'description' => $row['description'] ?? null,
            'location' => $row['location'] ?? null,
            'company' => $row['company'] ?? null,
            'salary' => $row['salary'] ?? null,
        ]);
    }
}
