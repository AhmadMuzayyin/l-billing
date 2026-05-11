<?php

namespace App\Http\Controllers\Legacy\Admin;

use App\Http\Controllers\Controller;
use App\Services\ReportService;
use Inertia\Inertia;
use Inertia\Response;

class AdminReportsController extends Controller
{
    public function __construct(private ReportService $reportService) {}

    public function index(): Response
    {
        $startDate = request('start_date');
        $endDate = request('end_date');

        $activationHistory = $this->reportService->getActivationHistory($startDate, $endDate)->paginate(15);
        $revenueReport = $this->reportService->getRevenueReport($startDate, $endDate);

        return Inertia::render('legacy/admin/Reports', [
            'activationHistory' => $activationHistory,
            'revenueReport' => $revenueReport,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);
    }

    public function daily(): Response
    {
        $date = request('date', now()->toDateString());
        $dailyReport = $this->reportService->getDailyReports($date);

        return Inertia::render('legacy/admin/DailyReports', [
            'dailyReport' => $dailyReport,
            'date' => $date,
        ]);
    }
}
