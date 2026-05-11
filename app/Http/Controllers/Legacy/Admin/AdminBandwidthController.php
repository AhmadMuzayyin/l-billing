<?php

namespace App\Http\Controllers\Legacy\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBandwidthRequest;
use App\Http\Requests\UpdateBandwidthRequest;
use App\Models\Legacy\BandwidthProfile;
use App\Services\BandwidthService;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

class AdminBandwidthController extends Controller
{
    public function __construct(private BandwidthService $bandwidthService) {}

    public function index(): Response
    {
        $search = request('search');
        $bandwidths = $this->bandwidthService->list(search: $search);

        return Inertia::render('legacy/admin/Bandwidth', [
            'bandwidths' => $bandwidths,
            'search' => $search,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('legacy/admin/BandwidthForm', [
            'bandwidth' => null,
        ]);
    }

    public function store(StoreBandwidthRequest $request): RedirectResponse
    {
        $this->bandwidthService->create($request->validated());

        return redirect()->route('legacy.admin.bandwidth')->with('success', 'Bandwidth profil berhasil ditambahkan');
    }

    public function edit(BandwidthProfile $bandwidth): Response
    {
        return Inertia::render('legacy/admin/BandwidthForm', [
            'bandwidth' => $bandwidth,
        ]);
    }

    public function update(UpdateBandwidthRequest $request, BandwidthProfile $bandwidth): RedirectResponse
    {
        $this->bandwidthService->update($bandwidth, $request->validated());

        return redirect()->route('legacy.admin.bandwidth')->with('success', 'Bandwidth profil berhasil diperbarui');
    }

    public function destroy(BandwidthProfile $bandwidth): RedirectResponse
    {
        $this->bandwidthService->delete($bandwidth);

        return redirect()->route('legacy.admin.bandwidth')->with('success', 'Bandwidth profil berhasil dihapus');
    }
}
