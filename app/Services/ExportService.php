<?php

namespace App\Services;

use App\Models\School;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportService
{
    public function exportSchoolsCsv(array $filters = []): StreamedResponse
    {
        $filename = 'schools_export_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($filters) {
            $file = fopen('php://output', 'w');

            // Add UTF-8 BOM for Excel compatibility
            fputs($file, "\xEF\xBB\xBF");

            // CSV Header
            fputcsv($file, [
                'ID',
                'Code',
                'School Name',
                'State',
                'Zone',
                'Category',
                'Principal Name',
                'Email',
                'Phone',
                'Students',
                'Teachers',
                'Status',
                'Registration Date',
            ]);

            $query = School::with(['state', 'zone', 'category']);

            if (!empty($filters['status'])) {
                $query->where('status', $filters['status']);
            }
            if (!empty($filters['state_id'])) {
                $query->where('state_id', $filters['state_id']);
            }

            $query->chunk(500, function ($schools) use ($file) {
                foreach ($schools as $school) {
                    fputcsv($file, [
                        $school->id,
                        $school->code,
                        $school->name,
                        $school->state->name ?? 'N/A',
                        $school->zone->name ?? 'N/A',
                        $school->category->name ?? 'N/A',
                        $school->principal_name,
                        $school->email,
                        $school->phone,
                        $school->total_students,
                        $school->total_teachers,
                        strtoupper($school->status),
                        $school->created_at->format('Y-m-d H:i'),
                    ]);
                }
            });

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
