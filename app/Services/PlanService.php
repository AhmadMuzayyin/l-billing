<?php

namespace App\Services;

use App\Models\Legacy\Plan;
use Illuminate\Pagination\LengthAwarePaginator;

class PlanService
{
    public function list(int $perPage = 15, ?string $search = null): LengthAwarePaginator
    {
        $query = Plan::query();

        if ($search) {
            $query->where('name_plan', 'like', "%{$search}%");
        }

        return $query->orderByDesc('id')->paginate($perPage);
    }

    public function create(array $data): Plan
    {
        $plan = new Plan();
        $plan->name_plan = $data['name_plan'];
        $plan->id_bw = $data['id_bw'];
        $plan->price = (string) $data['price'];
        $plan->price_old = '';
        $plan->type = $data['type'];
        $plan->validity = $data['validity'];
        $plan->validity_unit = $data['validity_unit'];
        $plan->routers = $data['routers'] ?? '';
        $plan->enabled = $data['enabled'] ?? true;
        $plan->is_radius = $data['is_radius'] ?? false;
        $plan->prepaid = $data['prepaid'];
        $plan->plan_type = $data['plan_type'];
        $plan->plan_expired = 0;
        $plan->expired_date = 20;
        $plan->save();

        return $plan;
    }

    public function update(Plan $plan, array $data): Plan
    {
        $plan->name_plan = $data['name_plan'];
        $plan->id_bw = $data['id_bw'];
        $plan->price = (string) $data['price'];
        $plan->type = $data['type'];
        $plan->validity = $data['validity'];
        $plan->validity_unit = $data['validity_unit'];
        $plan->routers = $data['routers'] ?? '';
        $plan->enabled = $data['enabled'] ?? true;
        $plan->is_radius = $data['is_radius'] ?? false;
        $plan->prepaid = $data['prepaid'];
        $plan->plan_type = $data['plan_type'];
        $plan->save();

        return $plan;
    }

    public function delete(Plan $plan): bool
    {
        return $plan->delete();
    }
}
