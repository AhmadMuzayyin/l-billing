<?php

namespace App\Services;

use Illuminate\Pagination\LengthAwarePaginator;

class InboxService
{
    public function getInbox($customer, int $perPage = 15): LengthAwarePaginator
    {
        return \DB::table('tbl_customers_inbox')
            ->where('customer_id', $customer->id)
            ->orderByDesc('created_at')
            ->paginate($perPage);
    }

    public function markAsRead(int $inboxId): bool
    {
        return \DB::table('tbl_customers_inbox')
            ->where('id', $inboxId)
            ->update(['date_read' => now()]);
    }

    public function getUnreadCount($customer): int
    {
        return \DB::table('tbl_customers_inbox')
            ->where('customer_id', $customer->id)
            ->whereNull('date_read')
            ->count();
    }
}