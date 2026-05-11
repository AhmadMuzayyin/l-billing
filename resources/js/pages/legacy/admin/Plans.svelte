<script lang="ts">
    import { Form } from '@inertiajs/svelte';
    import InputError from '@/components/InputError.svelte';
    import { Button } from '@/components/ui/button';
    import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
    import { Input } from '@/components/ui/input';
    import { Label } from '@/components/ui/label';
    import { destroy, store, update } from '@/actions/App/Http/Controllers/Legacy/Admin/AdminPlansController';

    type PlanItem = {
        id: number;
        name_plan: string;
        price: string;
        type: string;
        validity: number;
        validity_unit: string;
        routers: string;
        enabled: boolean;
    };

    type Props = {
        title: string;
        plans: {
            data: PlanItem[];
        };
    };

    let { title, plans }: Props = $props();
</script>

<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-bold tracking-tight">{title}</h1>
        <p class="text-muted-foreground mt-2">Kelola paket internet legacy</p>
    </div>

    <Card>
        <CardHeader>
            <CardTitle>Tambah Plan</CardTitle>
        </CardHeader>
        <CardContent>
            <Form {...store.form()} class="grid gap-4 md:grid-cols-2">
                {#snippet children({ errors, processing })}
                    <div class="grid gap-2">
                        <Label for="name_plan">Nama Plan</Label>
                        <Input id="name_plan" name="name_plan" required />
                        <InputError message={errors.name_plan} />
                    </div>
                    <div class="grid gap-2">
                        <Label for="price">Harga</Label>
                        <Input id="price" name="price" type="number" min="0" step="0.01" required />
                        <InputError message={errors.price} />
                    </div>
                    <div class="grid gap-2">
                        <Label for="type">Tipe</Label>
                        <select id="type" name="type" class="border-input h-10 rounded-md border bg-transparent px-3 text-sm" required>
                            <option value="Hotspot">Hotspot</option>
                            <option value="PPPOE">PPPOE</option>
                            <option value="Balance">Balance</option>
                            <option value="VPN">VPN</option>
                        </select>
                    </div>
                    <div class="grid gap-2">
                        <Label for="id_bw">Bandwidth ID</Label>
                        <Input id="id_bw" name="id_bw" type="number" min="1" value="1" required />
                        <InputError message={errors.id_bw} />
                    </div>
                    <div class="grid gap-2">
                        <Label for="validity">Durasi</Label>
                        <Input id="validity" name="validity" type="number" min="1" value="30" required />
                        <InputError message={errors.validity} />
                    </div>
                    <div class="grid gap-2">
                        <Label for="validity_unit">Satuan Durasi</Label>
                        <select id="validity_unit" name="validity_unit" class="border-input h-10 rounded-md border bg-transparent px-3 text-sm" required>
                            <option value="Days">Days</option>
                            <option value="Months">Months</option>
                            <option value="Hrs">Hrs</option>
                            <option value="Mins">Mins</option>
                            <option value="Period">Period</option>
                        </select>
                    </div>
                    <div class="grid gap-2">
                        <Label for="routers">Router</Label>
                        <Input id="routers" name="routers" />
                    </div>
                    <div class="grid gap-2">
                        <Label for="prepaid">Prepaid</Label>
                        <select id="prepaid" name="prepaid" class="border-input h-10 rounded-md border bg-transparent px-3 text-sm" required>
                            <option value="yes">yes</option>
                            <option value="no">no</option>
                        </select>
                    </div>
                    <div class="grid gap-2">
                        <Label for="plan_type">Plan Type</Label>
                        <select id="plan_type" name="plan_type" class="border-input h-10 rounded-md border bg-transparent px-3 text-sm" required>
                            <option value="Personal">Personal</option>
                            <option value="Business">Business</option>
                        </select>
                    </div>
                    <div class="grid gap-2">
                        <Label for="enabled">Enabled</Label>
                        <select id="enabled" name="enabled" class="border-input h-10 rounded-md border bg-transparent px-3 text-sm">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    <div class="grid gap-2">
                        <Label for="is_radius">Radius</Label>
                        <select id="is_radius" name="is_radius" class="border-input h-10 rounded-md border bg-transparent px-3 text-sm">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </div>
                    <div class="md:col-span-2 flex justify-end">
                        <Button type="submit" disabled={processing}>Simpan Plan</Button>
                    </div>
                {/snippet}
            </Form>
        </CardContent>
    </Card>

    <Card>
        <CardHeader>
            <CardTitle>Daftar Plan</CardTitle>
        </CardHeader>
        <CardContent>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b text-left">
                            <th class="px-2 py-3">Nama</th>
                            <th class="px-2 py-3">Tipe</th>
                            <th class="px-2 py-3">Harga</th>
                            <th class="px-2 py-3">Validitas</th>
                            <th class="px-2 py-3">Router</th>
                            <th class="px-2 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        {#if plans.data.length === 0}
                            <tr>
                                <td class="px-2 py-3 text-muted-foreground" colspan="6">Belum ada plan</td>
                            </tr>
                        {/if}
                        {#each plans.data as plan (plan.id)}
                            <tr class="border-b align-top">
                                <td class="px-2 py-3">{plan.name_plan}</td>
                                <td class="px-2 py-3">{plan.type}</td>
                                <td class="px-2 py-3">{plan.price}</td>
                                <td class="px-2 py-3">{plan.validity} {plan.validity_unit}</td>
                                <td class="px-2 py-3">{plan.routers}</td>
                                <td class="px-2 py-3 space-y-2">
                                    <Form {...update.form({ plan: plan.id })} class="grid gap-2">
                                        {#snippet children({ processing })}
                                            <Input name="name_plan" value={plan.name_plan} required />
                                            <Input name="price" value={plan.price} required />
                                            <input type="hidden" name="type" value={plan.type} />
                                            <input type="hidden" name="id_bw" value="1" />
                                            <input type="hidden" name="validity" value={String(plan.validity)} />
                                            <input type="hidden" name="validity_unit" value={plan.validity_unit} />
                                            <input type="hidden" name="prepaid" value="yes" />
                                            <input type="hidden" name="plan_type" value="Personal" />
                                            <input type="hidden" name="enabled" value={plan.enabled ? '1' : '0'} />
                                            <input type="hidden" name="is_radius" value="0" />
                                            <Button type="submit" size="sm" variant="outline" disabled={processing}>Update</Button>
                                        {/snippet}
                                    </Form>
                                    <Form {...destroy.form({ plan: plan.id })}>
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
