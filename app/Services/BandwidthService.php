<?php

namespace App\Services;

use App\Models\Legacy\BandwidthProfile;
use Illuminate\Pagination\LengthAwarePaginator;

class BandwidthService
{
    public function list(int $perPage = 15, ?string $search = null): LengthAwarePaginator
    {
        $query = BandwidthProfile::query();

        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        return $query->paginate($perPage);
    }

    public function create(array $data): BandwidthProfile
    {
        return BandwidthProfile::create($data);
    }

    public function update(BandwidthProfile $bandwidth, array $data): BandwidthProfile
    {
        $bandwidth->update($data);

        return $bandwidth->fresh();
    }

    public function delete(BandwidthProfile $bandwidth): bool
    {
        return $bandwidth->delete();
    }

    public function find(int $id): ?BandwidthProfile
    {
        return BandwidthProfile::findOrFail($id);
    }
}
