<script lang="ts">
    import type { PageProps } from '@inertiajs/svelte';
    import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
    import { Button } from '@/components/ui/button';
    import Zap from 'lucide-svelte/icons/zap';
    import CreditCard from 'lucide-svelte/icons/credit-card';
    import Calendar from 'lucide-svelte/icons/calendar';

    interface Props extends PageProps {
        title: string;
        customerName: string;
        activePlans: number;
        accountBalance: number;
        nextExpiration: string | null;
    }

    let { title, customerName, activePlans, accountBalance, nextExpiration }: Props = $props();
</script>

<div class="space-y-8">
    <div>
        <h1 class="text-3xl font-bold tracking-tight">{title}</h1>
        <p class="text-muted-foreground mt-2">Selamat datang kembali, {customerName}!</p>
    </div>

    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
        <Card>
            <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                <CardTitle class="text-sm font-medium">Paket Aktif</CardTitle>
                <Zap class="h-4 w-4 text-muted-foreground" />
            </CardHeader>
            <CardContent>
                <div class="text-2xl font-bold">{activePlans}</div>
                <p class="text-xs text-muted-foreground">Layanan internet yang sedang berjalan</p>
            </CardContent>
        </Card>

        <Card>
            <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                <CardTitle class="text-sm font-medium">Saldo Akun</CardTitle>
                <CreditCard class="h-4 w-4 text-muted-foreground" />
            </CardHeader>
            <CardContent>
                <div class="text-2xl font-bold">Rp {accountBalance.toLocaleString('id-ID')}</div>
                <p class="text-xs text-muted-foreground">Saldo anda saat ini</p>
            </CardContent>
        </Card>

        <Card>
            <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                <CardTitle class="text-sm font-medium">Perpanjangan</CardTitle>
                <Calendar class="h-4 w-4 text-muted-foreground" />
            </CardHeader>
            <CardContent>
                <div class="text-2xl font-bold">{nextExpiration ? nextExpiration : 'Tidak ada'}</div>
                <p class="text-xs text-muted-foreground">Tanggal perpanjangan berikutnya</p>
            </CardContent>
        </Card>
    </div>

    <Card>
        <CardHeader>
            <CardTitle>Aksi Cepat</CardTitle>
            <CardDescription>Kelola akun anda dengan mudah</CardDescription>
        </CardHeader>
        <CardContent class="flex flex-wrap gap-2">
            <Button variant="outline">Beli Paket</Button>
            <Button variant="outline">Topup Saldo</Button>
            <Button variant="outline">Aktivasi Voucher</Button>
            <Button variant="outline">Lihat Riwayat</Button>
        </CardContent>
    </Card>
</div>
