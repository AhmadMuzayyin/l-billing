<script lang="ts">
    import { Form } from '@inertiajs/svelte';
    import InputError from '@/components/InputError.svelte';
    import { Button } from '@/components/ui/button';
    import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
    import { Input } from '@/components/ui/input';
    import { Label } from '@/components/ui/label';
    import { destroy, store, update } from '@/actions/App/Http/Controllers/Legacy/Admin/AdminCustomersController';

    type CustomerItem = {
        id: number;
        username: string;
        fullname: string;
        email: string;
        phonenumber: string;
        status: string;
        balance: number | string;
        auto_renewal: boolean;
    };

    type Props = {
        title: string;
        customers: {
            data: CustomerItem[];
        };
        filters: {
            search?: string;
        };
    };

    let { title, customers }: Props = $props();
</script>

<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-bold tracking-tight">{title}</h1>
        <p class="text-muted-foreground mt-2">Kelola data pelanggan legacy</p>
    </div>

    <Card>
        <CardHeader>
            <CardTitle>Tambah Customer</CardTitle>
        </CardHeader>
        <CardContent>
            <Form {...store.form()} class="grid gap-4 md:grid-cols-2">
                {#snippet children({ errors, processing })}
                    <div class="grid gap-2">
                        <Label for="username">Username</Label>
                        <Input id="username" name="username" required />
                        <InputError message={errors.username} />
                    </div>
                    <div class="grid gap-2">
                        <Label for="fullname">Nama Lengkap</Label>
                        <Input id="fullname" name="fullname" required />
                        <InputError message={errors.fullname} />
                    </div>
                    <div class="grid gap-2">
                        <Label for="email">Email</Label>
                        <Input id="email" name="email" type="email" required />
                        <InputError message={errors.email} />
                    </div>
                    <div class="grid gap-2">
                        <Label for="phonenumber">No HP</Label>
                        <Input id="phonenumber" name="phonenumber" />
                        <InputError message={errors.phonenumber} />
                    </div>
                    <div class="grid gap-2">
                        <Label for="password">Password</Label>
                        <Input id="password" name="password" type="password" required />
                        <InputError message={errors.password} />
                    </div>
                    <div class="grid gap-2">
                        <Label for="password_confirmation">Konfirmasi Password</Label>
                        <Input id="password_confirmation" name="password_confirmation" type="password" required />
                    </div>
                    <div class="grid gap-2">
                        <Label for="status">Status</Label>
                        <select id="status" name="status" class="border-input h-10 rounded-md border bg-transparent px-3 text-sm" required>
                            <option value="Active">Active</option>
                            <option value="Banned">Banned</option>
                            <option value="Disabled">Disabled</option>
                            <option value="Inactive">Inactive</option>
                            <option value="Limited">Limited</option>
                            <option value="Suspended">Suspended</option>
                        </select>
                    </div>
                    <div class="grid gap-2">
                        <Label for="balance">Balance</Label>
                        <Input id="balance" name="balance" type="number" min="0" step="0.01" value="0" />
                    </div>
                    <div class="md:col-span-2 flex justify-end">
                        <Button type="submit" disabled={processing}>Simpan Customer</Button>
                    </div>
                {/snippet}
            </Form>
        </CardContent>
    </Card>

    <Card>
        <CardHeader>
            <CardTitle>Daftar Customer</CardTitle>
        </CardHeader>
        <CardContent>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b text-left">
                            <th class="px-2 py-3">Username</th>
                            <th class="px-2 py-3">Nama</th>
                            <th class="px-2 py-3">Email</th>
                            <th class="px-2 py-3">Status</th>
                            <th class="px-2 py-3">Balance</th>
                            <th class="px-2 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        {#if customers.data.length === 0}
                            <tr>
                                <td class="px-2 py-3 text-muted-foreground" colspan="6">Belum ada customer</td>
                            </tr>
                        {/if}
                        {#each customers.data as customer (customer.id)}
                            <tr class="border-b align-top">
                                <td class="px-2 py-3">{customer.username}</td>
                                <td class="px-2 py-3">{customer.fullname}</td>
                                <td class="px-2 py-3">{customer.email}</td>
                                <td class="px-2 py-3">{customer.status}</td>
                                <td class="px-2 py-3">{customer.balance}</td>
                                <td class="px-2 py-3 space-y-2">
                                    <Form {...update.form({ customer: customer.id })} class="grid gap-2">
                                        {#snippet children({ processing })}
                                            <Input name="username" value={customer.username} required />
                                            <Input name="fullname" value={customer.fullname} required />
                                            <Input name="email" value={customer.email} required />
                                            <Input name="phonenumber" value={customer.phonenumber ?? ''} />
                                            <input type="hidden" name="status" value={customer.status} />
                                            <input type="hidden" name="balance" value={String(customer.balance ?? 0)} />
                                            <Button type="submit" size="sm" variant="outline" disabled={processing}>Update</Button>
                                        {/snippet}
                                    </Form>
                                    <Form {...destroy.form({ customer: customer.id })}>
                                        {#snippet children({ processing })}
                                            <Button type="submit" size="sm" variant="destructive" disabled={processing}>Hapus</Button>
                                        {/snippet}
                                    </Form>
                                </td>
                            </tr>
                        {/each}
                    </tbody>
                </table>
            </div>
        </CardContent>
    </Card>
</div>
