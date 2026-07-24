<?php

namespace App\Repositories\Eloquent;

use App\Models\School;
use App\Models\SchoolStatusHistory;
use App\Repositories\Contracts\SchoolRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class SchoolRepository implements SchoolRepositoryInterface
{
    public function getPaginated(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = School::with(['state', 'zone', 'category']);

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['state_id'])) {
            $query->where('state_id', $filters['state_id']);
        }

        if (!empty($filters['zone_id'])) {
            $query->where('zone_id', $filters['zone_id']);
        }

        if (!empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        if (!empty($filters['search'])) {
            $query->search($filters['search']);
        }

        $sortField = $filters['sort_by'] ?? 'created_at';
        $sortOrder = $filters['sort_order'] ?? 'desc';
        $allowedSorts = ['id', 'name', 'code', 'status', 'created_at', 'total_students'];

        if (in_array($sortField, $allowedSorts)) {
            $query->orderBy($sortField, strtolower($sortOrder) === 'asc' ? 'asc' : 'desc');
        } else {
            $query->latest();
        }

        return $query->paginate($perPage);
    }

    public function findById(int $id): ?School
    {
        return School::with(['state', 'zone', 'category', 'statusHistories.user', 'activityLogs.user'])->find($id);
    }

    public function findByCode(string $code): ?School
    {
        return School::with(['state', 'zone', 'category', 'statusHistories.user'])->where('code', $code)->first();
    }

    public function create(array $data): School
    {
        if (empty($data['code'])) {
            $data['code'] = !empty($data['suic_code']) ? $data['suic_code'] : School::generateUniqueCode();
        }

        $school = School::create($data);

        // Record initial status history
        SchoolStatusHistory::create([
            'school_id' => $school->id,
            'user_id' => auth()->id(),
            'status' => $school->status,
            'notes' => 'Initial school registration submitted.',
        ]);

        return $school;
    }

    public function update(int $id, array $data): bool
    {
        $school = School::findOrFail($id);
        return $school->update($data);
    }

    public function updateStatus(int $id, string $status, ?string $reason = null, ?int $userId = null): School
    {
        return DB::transaction(function () use ($id, $status, $reason, $userId) {
            $school = School::findOrFail($id);
            $oldStatus = $school->status;

            $school->status = $status;
            if ($status === 'rejected') {
                $school->rejection_reason = $reason;
            } else {
                $school->rejection_reason = null;
            }
            $school->save();

            SchoolStatusHistory::create([
                'school_id' => $school->id,
                'user_id' => $userId ?? auth()->id(),
                'status' => $status,
                'notes' => $reason ? "Status changed from {$oldStatus} to {$status}. Reason: {$reason}" : "Status changed from {$oldStatus} to {$status}.",
            ]);

            return $school;
        });
    }

    public function delete(int $id): bool
    {
        $school = School::findOrFail($id);
        return $school->delete();
    }

    public function getStatusCounts(): array
    {
        $counts = DB::table('schools')
            ->whereNull('deleted_at')
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        return [
            'total'              => array_sum($counts),
            // Actual DB status keys
            'registered'         => $counts['registered'] ?? 0,
            'under_construction' => $counts['under_construction'] ?? 0,
            'trial_running'      => $counts['trial_running'] ?? 0,
            'on_going'           => $counts['on_going'] ?? 0,
            // Dashboard display aliases
            'approved'           => $counts['on_going'] ?? 0,
            'pending'            => $counts['registered'] ?? 0,
            'under_review'       => $counts['trial_running'] ?? 0,
            'rejected'           => $counts['under_construction'] ?? 0,
        ];
    }

    public function getGroupedByState(): Collection
    {
        return School::with(['state', 'zone', 'category'])
            ->where('status', 'on_going')
            ->get()
            ->groupBy('state.name');
    }
}
