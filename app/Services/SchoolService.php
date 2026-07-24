<?php

namespace App\Services;

use App\Models\ActivityLog;
use App\Models\School;
use App\Repositories\Contracts\SchoolRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class SchoolService
{
    public function __construct(
        protected SchoolRepositoryInterface $schoolRepository
    ) {}

    public function getSchools(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        return $this->schoolRepository->getPaginated($filters, $perPage);
    }

    public function registerSchool(array $data, ?string $ipAddress = null): School
    {
        // Auto-compute legacy totals from the disaggregated fields
        $data['total_students'] = ($data['male_students'] ?? 0) + ($data['female_students'] ?? 0);
        $data['total_teachers'] = ($data['teaching_male_staff'] ?? 0)
                                + ($data['teaching_female_staff'] ?? 0)
                                + ($data['non_teaching_male_staff'] ?? 0)
                                + ($data['non_teaching_female_staff'] ?? 0);

        $school = $this->schoolRepository->create($data);

        // Activity log
        ActivityLog::create([
            'user_id'     => auth()->id(),
            'school_id'   => $school->id,
            'action'      => 'REGISTER',
            'description' => "New school '{$school->name}' registered with code {$school->code}.",
            'ip_address'  => $ipAddress,
        ]);

        Log::info("School Registered: {$school->name} ({$school->code})");

        return $school;
    }

    public function changeStatus(int $schoolId, string $status, ?string $reason = null, ?int $userId = null, ?string $ipAddress = null): School
    {
        $school = $this->schoolRepository->updateStatus($schoolId, $status, $reason, $userId);

        ActivityLog::create([
            'user_id' => $userId ?? auth()->id(),
            'school_id' => $school->id,
            'action' => 'STATUS_CHANGE',
            'description' => "School status updated to {$status}." . ($reason ? " Reason: {$reason}" : ""),
            'ip_address' => $ipAddress,
        ]);

        return $school;
    }

    public function findSchool(int $id): ?School
    {
        return $this->schoolRepository->findById($id);
    }

    public function deleteSchool(int $id, ?string $ipAddress = null): bool
    {
        $school = $this->schoolRepository->findById($id);
        if ($school) {
            ActivityLog::create([
                'user_id' => auth()->id(),
                'school_id' => $school->id,
                'action' => 'DELETE',
                'description' => "School '{$school->name}' deleted.",
                'ip_address' => $ipAddress,
            ]);
        }

        return $this->schoolRepository->delete($id);
    }
}
