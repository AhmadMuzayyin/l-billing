<?php

namespace App\Services;

use App\Models\Legacy\Customer;
use Illuminate\Pagination\LengthAwarePaginator;

class CustomerService
{
    public function list(int $perPage = 15, ?string $search = null): LengthAwarePaginator
    {
        $query = Customer::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('username', 'like', "%{$search}%")
                    ->orWhere('fullname', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        return $query->orderByDesc('created_at')->paginate($perPage);
    }

    public function create(array $data): Customer
    {
        $customer = new Customer();
        $customer->username = $data['username'];
        $customer->password = bcrypt($data['password']);
        $customer->fullname = $data['fullname'];
        $customer->email = $data['email'];
        $customer->phonenumber = $data['phonenumber'] ?? '0';
        $customer->status = $data['status'] ?? 'Active';
        $customer->auto_renewal = $data['auto_renewal'] ?? true;
        $customer->balance = $data['balance'] ?? 0;
        $customer->service_type = 'Others';
        $customer->account_type = 'Personal';
        $customer->created_by = auth()->id() ?? 0;
        $customer->created_at = now();
        $customer->save();

        return $customer;
    }

    public function update(Customer $customer, array $data): Customer
    {
        $customer->username = $data['username'];
        if (! empty($data['password'])) {
            $customer->password = bcrypt($data['password']);
        }
        $customer->fullname = $data['fullname'];
        $customer->email = $data['email'];
        $customer->phonenumber = $data['phonenumber'] ?? '0';
        $customer->status = $data['status'];
        $customer->auto_renewal = $data['auto_renewal'] ?? true;
        $customer->balance = $data['balance'] ?? 0;
        $customer->save();

        return $customer;
    }

    public function delete(Customer $customer): bool
    {
        return $customer->delete();
    }

    public function find(mixed $id): ?Customer
    {
        return Customer::find($id);
    }
}
