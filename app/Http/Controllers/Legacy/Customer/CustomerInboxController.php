<?php

namespace App\Http\Controllers\Legacy\Customer;

use App\Http\Controllers\Controller;
use App\Services\InboxService;
use Inertia\Inertia;
use Inertia\Response;

class CustomerInboxController extends Controller
{
    public function __construct(private InboxService $service) {}

    public function index(): Response
    {
        $customer = auth()->user();
        $unreadCount = $this->service->getUnreadCount($customer);
        $inbox = $this->service->getInbox($customer);

        return Inertia::render('legacy/customer/Inbox', [
            'inbox' => $inbox,
            'unread_count' => $unreadCount,
        ]);
    }

    public function show(int $id): Response
    {
        $customer = auth()->user();
        $message = \DB::table('tbl_customers_inbox')
            ->where('id', $id)
            ->where('customer_id', $customer->id)
            ->firstOrFail();

        if (! $message->date_read) {
            $this->service->markAsRead($id);
            $message->date_read = now();
        }

        return Inertia::render('legacy/customer/InboxDetail', [
            'message' => $message,
        ]);
    }
}
