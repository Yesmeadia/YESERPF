<?php

namespace App\Repositories\Contracts;

use App\Models\School;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface SchoolRepositoryInterface
{
    public function getPaginated(array $filters = [], int $perPage = 15): LengthAwarePaginator;

    public function findById(int $id): ?School;

    public function findByCode(string $code): ?School;

    public function create(array $data): School;

    public function update(int $id, array $data): bool;

    public function updateStatus(int $id, string $status, ?string $reason = null, ?int $userId = null): School;

    public function delete(int $id): bool;

    public function getStatusCounts(): array;

    public function getGroupedByState(): Collection;
}
