<?php

use App\Http\Controllers\Legacy\Admin\AdminDashboardController;
use App\Http\Controllers\Legacy\Admin\AdminCustomersController;
use App\Http\Controllers\Legacy\Admin\AdminPlansController;
use App\Http\Controllers\Legacy\Admin\AdminRoutersController;
use App\Http\Controllers\Legacy\Admin\AdminBandwidthController;
use App\Http\Controllers\Legacy\Admin\AdminReportsController;
use App\Http\Controllers\Legacy\Admin\AdminMessagesController;
use App\Http\Controllers\Legacy\Customer\CustomerVoucherActivationController;
use App\Http\Controllers\Legacy\Customer\CustomerHomeController;
use App\Http\Controllers\Legacy\Customer\CustomerInboxController;
use App\Http\Controllers\Legacy\Customer\CustomerBalanceController;
use App\Http\Controllers\Legacy\Customer\CustomerPackageController;
use App\Http\Controllers\Legacy\Customer\CustomerPaymentHistoryController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

Route::inertia('/', 'Welcome', [
    'canRegister' => Features::enabled(Features::registration()),
])->name('home');

Route::middleware(['auth', 'verified'])
    ->group(function () {
        Route::inertia('dashboard', 'Dashboard')->name('dashboard');

        $adminPages = [
            'dashboard' => 'Admin Dashboard',
            'customers' => 'Customer',
            'services' => 'Services',
            'internet-plan' => 'Internet Plan',
            'maps' => 'Maps',
            'reports' => 'Reports',
            'messages' => 'Send Message',
            'network' => 'Network',
            'radius' => 'Radius',
            'pages' => 'Static Pages',
            'settings' => 'Settings',
            'logs' => 'Logs',
            'community' => 'Community',
        ];

        Route::get('admin/dashboard', AdminDashboardController::class)
            ->name('legacy.admin.dashboard');

        Route::get('admin/customers', [AdminCustomersController::class, 'index'])
            ->name('legacy.admin.customers');
        Route::post('admin/customers', [AdminCustomersController::class, 'store'])
            ->name('legacy.admin.customers.store');
        Route::put('admin/customers/{customer}', [AdminCustomersController::class, 'update'])
            ->name('legacy.admin.customers.update');
        Route::delete('admin/customers/{customer}', [AdminCustomersController::class, 'destroy'])
            ->name('legacy.admin.customers.destroy');

        Route::get('admin/internet-plan', [AdminPlansController::class, 'index'])
            ->name('legacy.admin.internet-plan');
        Route::post('admin/internet-plan', [AdminPlansController::class, 'store'])
            ->name('legacy.admin.internet-plan.store');
        Route::put('admin/internet-plan/{plan}', [AdminPlansController::class, 'update'])
            ->name('legacy.admin.internet-plan.update');
        Route::delete('admin/internet-plan/{plan}', [AdminPlansController::class, 'destroy'])
            ->name('legacy.admin.internet-plan.destroy');

        Route::get('admin/routers', [AdminRoutersController::class, 'index'])
            ->name('legacy.admin.routers');
        Route::get('admin/routers/create', [AdminRoutersController::class, 'create'])
            ->name('legacy.admin.routers.create');
        Route::post('admin/routers', [AdminRoutersController::class, 'store'])
            ->name('legacy.admin.routers.store');
        Route::get('admin/routers/{router}/edit', [AdminRoutersController::class, 'edit'])
            ->name('legacy.admin.routers.edit');
        Route::put('admin/routers/{router}', [AdminRoutersController::class, 'update'])
            ->name('legacy.admin.routers.update');
        Route::delete('admin/routers/{router}', [AdminRoutersController::class, 'destroy'])
            ->name('legacy.admin.routers.destroy');

        Route::get('admin/bandwidth', [AdminBandwidthController::class, 'index'])
            ->name('legacy.admin.bandwidth');
        Route::get('admin/bandwidth/create', [AdminBandwidthController::class, 'create'])
            ->name('legacy.admin.bandwidth.create');
        Route::post('admin/bandwidth', [AdminBandwidthController::class, 'store'])
            ->name('legacy.admin.bandwidth.store');
        Route::get('admin/bandwidth/{bandwidth}/edit', [AdminBandwidthController::class, 'edit'])
            ->name('legacy.admin.bandwidth.edit');
        Route::put('admin/bandwidth/{bandwidth}', [AdminBandwidthController::class, 'update'])
            ->name('legacy.admin.bandwidth.update');
        Route::delete('admin/bandwidth/{bandwidth}', [AdminBandwidthController::class, 'destroy'])
            ->name('legacy.admin.bandwidth.destroy');

        Route::get('admin/reports', [AdminReportsController::class, 'index'])
            ->name('legacy.admin.reports');
        Route::get('admin/daily-reports', [AdminReportsController::class, 'daily'])
            ->name('legacy.admin.daily-reports');

        Route::get('admin/messages', [AdminMessagesController::class, 'index'])
            ->name('legacy.admin.messages');
        Route::get('admin/messages/create', [AdminMessagesController::class, 'create'])
            ->name('legacy.admin.messages.create');
        Route::post('admin/messages/send', [AdminMessagesController::class, 'send'])
            ->name('legacy.admin.messages.send');
        Route::get('admin/messages/bulk', [AdminMessagesController::class, 'bulk'])
            ->name('legacy.admin.messages.bulk');
        Route::post('admin/messages/bulk', [AdminMessagesController::class, 'sendBulk'])
            ->name('legacy.admin.messages.bulk-send');

        foreach ($adminPages as $slug => $title) {
            if (in_array($slug, ['dashboard', 'customers', 'internet-plan', 'routers', 'bandwidth', 'reports', 'messages'], true)) {
                continue;
            }
            Route::inertia("admin/{$slug}", 'legacy/Placeholder', [
                'title' => $title,
                'scope' => 'admin',
                'slug' => $slug,
            ])->name("legacy.admin.{$slug}");
        }

        $customerPages = [
            'dashboard' => 'Customer Dashboard',
            'inbox' => 'Inbox',
            'voucher' => 'Voucher',
            'buy-balance' => 'Buy Balance',
            'buy-package' => 'Buy Package',
            'payment-history' => 'Payment History',
            'activation-history' => 'Activation History',
        ];

        Route::get('customer/dashboard', CustomerHomeController::class)
            ->name('legacy.customer.dashboard');

        Route::get('customer/voucher', [CustomerVoucherActivationController::class, 'index'])
            ->name('legacy.customer.voucher');
        Route::post('customer/voucher/activate', [CustomerVoucherActivationController::class, 'activate'])
            ->name('legacy.customer.voucher.activate');

        Route::get('customer/inbox', [CustomerInboxController::class, 'index'])
            ->name('legacy.customer.inbox');
        Route::get('customer/inbox/{id}', [CustomerInboxController::class, 'show'])
            ->name('legacy.customer.inbox.show');

        Route::get('customer/buy-balance', [CustomerBalanceController::class, 'index'])
            ->name('legacy.customer.buy-balance');
        Route::get('customer/buy-balance/create', [CustomerBalanceController::class, 'create'])
            ->name('legacy.customer.buy-balance.create');
        Route::post('customer/buy-balance', [CustomerBalanceController::class, 'store'])
            ->name('legacy.customer.buy-balance.store');

        Route::get('customer/buy-package', [CustomerPackageController::class, 'index'])
            ->name('legacy.customer.buy-package');
        Route::get('customer/buy-package/{plan}', [CustomerPackageController::class, 'purchase'])
            ->name('legacy.customer.buy-package.purchase');
        Route::post('customer/buy-package/{plan}', [CustomerPackageController::class, 'store'])
            ->name('legacy.customer.buy-package.store');
        Route::get('customer/buy-package-history', [CustomerPackageController::class, 'history'])
            ->name('legacy.customer.buy-package-history');

        Route::get('customer/payment-history', [CustomerPaymentHistoryController::class, 'index'])
            ->name('legacy.customer.payment-history');
        Route::get('customer/payment-history/monthly', [CustomerPaymentHistoryController::class, 'monthly'])
            ->name('legacy.customer.payment-history.monthly');

        foreach ($customerPages as $slug => $title) {
            if (in_array($slug, ['dashboard', 'voucher', 'inbox', 'buy-balance', 'buy-package', 'payment-history'], true)) {
                continue;
            }
            Route::inertia("customer/{$slug}", 'legacy/Placeholder', [
                'title' => $title,
                'scope' => 'customer',
                'slug' => $slug,
            ])->name("legacy.customer.{$slug}");
        }
});

require __DIR__.'/settings.php';
