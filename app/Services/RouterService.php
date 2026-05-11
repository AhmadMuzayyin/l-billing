<?php

namespace App\Services;

use App\Models\Legacy\NetworkRouter;
use Illuminate\Pagination\LengthAwarePaginator;

class RouterService
{
    public function list(int $perPage = 15, ?string $search = null): LengthAwarePaginator
    {
        $query = NetworkRouter::query();

        if ($search) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('ip_address', 'like', "%{$search}%");
        }

        return $query->paginate($perPage);
    }

    public function create(array $data): NetworkRouter
    {
        return NetworkRouter::create($data);
    }

    public function update(NetworkRouter $router, array $data): NetworkRouter
    {
        $router->update($data);

        return $router->fresh();
    }

    public function delete(NetworkRouter $router): bool
    {
        return $router->delete();
    }

    public function find(int $id): ?NetworkRouter
    {
        return NetworkRouter::findOrFail($id);
    }
}
