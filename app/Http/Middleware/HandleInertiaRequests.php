<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $user = $request->user();

        $menuContext = null;
        if ($request->routeIs('legacy.admin.*')) {
            $menuContext = 'admin';
        }

        if ($request->routeIs('legacy.customer.*')) {
            $menuContext = 'customer';
        }

        return [
            ...parent::share($request),
            'name' => config('app.name'),
            'auth' => [
                'user' => $user,
            ],
            'sidebarOpen' => ! $request->hasCookie('sidebar_state') || $request->cookie('sidebar_state') === 'true',
            'menuContext' => $menuContext,
            'menuItems' => fn () => $this->legacyMenu($request),
        ];
    }

    protected function legacyMenu(Request $request): array
    {
        $context = null;
        if ($request->routeIs('legacy.admin.*')) {
            $context = 'admin';
        }

        if ($request->routeIs('legacy.customer.*')) {
            $context = 'customer';
        }

        if ($context === null) {
            return [];
        }

        $menu = config("legacy_menu.{$context}", []);

        return array_map(function (array $item): array {
            return [
                'title' => $item['title'],
                'href' => route($item['name']),
                'icon' => $item['icon'] ?? null,
            ];
        }, $menu);
    }
}
