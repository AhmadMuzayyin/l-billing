<?php

namespace App\Http\Controllers\Legacy\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SendMessageRequest;
use App\Http\Requests\SendBulkMessageRequest;
use App\Models\Legacy\Customer;
use App\Services\MessageService;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

class AdminMessagesController extends Controller
{
    public function __construct(private MessageService $messageService) {}

    public function index(): Response
    {
        $messages = $this->messageService->getMessageHistory();

        return Inertia::render('legacy/admin/Messages', [
            'messages' => $messages,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('legacy/admin/MessageForm', [
            'message' => null,
        ]);
    }

    public function send(SendMessageRequest $request): RedirectResponse
    {
        $this->messageService->sendToCustomer([
            'customer_id' => $request->input('customer_id'),
            'title' => $request->input('title'),
            'message' => $request->input('message'),
            'send_by' => auth()->id(),
            'created_at' => now(),
        ]);

        return redirect()->route('legacy.admin.messages')->with('success', 'Pesan berhasil dikirim');
    }

    public function bulk(): Response
    {
        $customers = Customer::where('status', 'active')->get(['id', 'fullname', 'username']);

        return Inertia::render('legacy/admin/MessageBulkForm', [
            'customers' => $customers,
        ]);
    }

    public function sendBulk(SendBulkMessageRequest $request): RedirectResponse
    {
        $count = $this->messageService->sendBulk($request->validated());

        return redirect()->route('legacy.admin.messages')->with('success', "Pesan berhasil dikirim ke {$count} pelanggan");
    }
}
