<?php

namespace App\Http\Controllers\Legacy\Admin;

use App\Http\Requests\StorePlanRequest;
use App\Http\Requests\UpdatePlanRequest;
use App\Http\Controllers\Controller;
use App\Models\Legacy\Plan;
use App\Services\PlanService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class AdminPlansController extends Controller
{
    public function __construct(private PlanService $planService)
    {
    }

    public function index(Request $request): Response
    {
        $search = $request->string('search')->toString();

        return Inertia::render('legacy/admin/Plans', [
            'title' => 'Internet Plan',
            'plans' => $this->planService->list(15, $search),
            'filters' => [
                'search' => $search,
            ],
        ]);
    }

    public function store(StorePlanRequest $request): RedirectResponse
    {
        $this->planService->create($request->validated());

        return back()->with('success', 'Plan berhasil dibuat.');
    }

    public function update(UpdatePlanRequest $request, Plan $plan): RedirectResponse
    {
        $this->planService->update($plan, $request->validated());

        return back()->with('success', 'Plan berhasil diperbarui.');
    }

    public function destroy(Plan $plan): RedirectResponse
    {
        $this->planService->delete($plan);

        return back()->with('success', 'Plan berhasil dihapus.');
    }
}
