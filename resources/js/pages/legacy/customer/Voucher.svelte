<script lang="ts">
    import { Form } from '@inertiajs/svelte';
    import InputError from '@/components/InputError.svelte';
    import { activate } from '@/actions/App/Http/Controllers/Legacy/Customer/CustomerVoucherActivationController';
    import { Button } from '@/components/ui/button';
    import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
    import { Input } from '@/components/ui/input';
    import { Label } from '@/components/ui/label';

    interface Props {
        title: string;
        recentVouchers: Array<{
            id: number;
            code: string;
            status: string;
            user: string;
            used_date: string | null;
        }>;
    }

    let { title, recentVouchers }: Props = $props();
</script>

<div class="space-y-8">
    <div>
        <h1 class="text-3xl font-bold tracking-tight">{title}</h1>
        <p class="text-muted-foreground mt-2">Aktivasi voucher pelanggan</p>
    </div>

    <Card>
        <CardHeader>
            <CardTitle>Form Aktivasi Voucher</CardTitle>
            <CardDescription>Masukkan kode voucher dan username customer</CardDescription>
        </CardHeader>
        <CardContent>
            <Form {...activate.form()} class="grid gap-4 md:grid-cols-2">
                {#snippet children({ errors, processing })}
                    <div class="grid gap-2">
                        <Label for="code">Kode Voucher</Label>
                        <Input id="code" name="code" required />
                        <InputError message={errors.code} />
                    </div>
                    <div class="grid gap-2">
                        <Label for="customer_username">Username Customer</Label>
                        <Input id="customer_username" name="customer_username" required />
                        <InputError message={errors.customer_username} />
                    </div>
                    <div class="md:col-span-2 flex justify-end">
                        <Button type="submit" disabled={processing}>Aktivasi Voucher</Button>
                    </div>
                {/snippet}
            </Form>
        </CardContent>
    </div>

    <Card>
        <CardHeader>
            <CardTitle>Riwayat Voucher Terbaru</CardTitle>
            <CardDescription>10 voucher terakhir</CardDescription>
        </CardHeader>
        <CardContent>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b text-left">
                            <th class="px-2 py-3">Kode</th>
                            <th class="px-2 py-3">Status</th>
                            <th class="px-2 py-3">User</th>
                            <th class="px-2 py-3">Used Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        {#if recentVouchers.length === 0}
                            <tr>
                                <td class="px-2 py-3 text-muted-foreground" colspan="4">Belum ada data voucher</td>
                            </tr>
                        {/if}
                        {#each recentVouchers as voucher (voucher.id)}
                            <tr class="border-b">
                                <td class="px-2 py-3">{voucher.code}</td>
                                <td class="px-2 py-3">{voucher.status}</td>
                                <td class="px-2 py-3">{voucher.user}</td>
                                <td class="px-2 py-3">{voucher.used_date ?? '-'}</td>
                            </tr>
                        {/each}
                    </tbody>
                </table>
            </div>
        </CardContent>
    </Card>
</div>
