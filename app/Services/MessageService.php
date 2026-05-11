<?php

namespace App\Services;

use App\Models\Legacy\AdminUser;
use App\Models\Legacy\Message;

class MessageService
{
    public function sendToCustomer(array $data): Message
    {
        return Message::create($data);
    }

    public function sendBulk(array $data): int
    {
        $count = 0;

        foreach ($data['customer_ids'] ?? [] as $customerId) {
            Message::create([
                'customer_id' => $customerId,
                'title' => $data['title'],
                'message' => $data['message'],
                'send_by' => auth()->id(),
                'created_at' => now(),
            ]);
            $count++;
        }

        return $count;
    }

    public function getMessageHistory(int $perPage = 15)
    {
        return Message::orderByDesc('created_at')->paginate($perPage);
    }

    public function deleteMessage(Message $message): bool
    {
        return $message->delete();
    }
}
