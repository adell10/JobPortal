<?php

namespace App\Exports;

use App\Models\Application;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;


class ApplicationsExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $jobId;

    public function __construct($jobId)
    {
        $this->jobId = $jobId;
    }

    public function collection()
    {
         return Application::with(['user', 'job'])
            ->where('job_id', $this->jobId)     // Filter berdasarkan lowongan tertentu
            ->get()
            ->map(function ($app) {
                return [
                    'Nama Pelamar' => $app->user->name ?? '-',
                    'Lowongan' => $app->job->title ?? '-',
                    'CV' => asset('storage/' . $app->cv),
                    'Status' => $app->status,
                ];
            });
    }

    public function headings(): array
    {
        return ['Nama Pelamar', 'Lowongan', 'CV', 'Status'];
    }
}
