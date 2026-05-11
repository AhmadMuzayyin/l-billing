<?php

namespace App\Http\Controllers\Legacy\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRouterRequest;
use App\Http\Requests\UpdateRouterRequest;
use App\Models\Legacy\NetworkRouter;
use App\Services\RouterService;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

class AdminRoutersController extends Controller
{
    public function __construct(private RouterService $routerService) {}

    public function index(): Response
    {
        $search = request('search');
        $routers = $this->routerService->list(search: $search);

        return Inertia::render('legacy/admin/Routers', [
            'routers' => $routers,
            'search' => $search,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('legacy/admin/RouterForm', [
            'router' => null,
        ]);
    }

    public function store(StoreRouterRequest $request): RedirectResponse
    {
        $this->routerService->create($request->validated());

        return redirect()->route('legacy.admin.routers')->with('success', 'Router berhasil ditambahkan');
    }

    public function edit(NetworkRouter $router): Response
    {
        return Inertia::render('legacy/admin/RouterForm', [
            'router' => $router,
        ]);
    }

    public function update(UpdateRouterRequest $request, NetworkRouter $router): RedirectResponse
    {
        $this->routerService->update($router, $request->validated());

        return redirect()->route('legacy.admin.routers')->with('success', 'Router berhasil diperbarui');
    }

    public function destroy(NetworkRouter $router): RedirectResponse
    {
        $this->routerService->delete($router);

        return redirect()->route('legacy.admin.routers')->with('success', 'Router berhasil dihapus');
    }
}
