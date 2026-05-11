<script lang="ts">
    import type { PageProps } from '@inertiajs/svelte';
    import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
    import Users from 'lucide-svelte/icons/users';
    import Zap from 'lucide-svelte/icons/zap';
    import DollarSign from 'lucide-svelte/icons/dollar-sign';
    import ShoppingCart from 'lucide-svelte/icons/shopping-cart';

    interface Props extends PageProps {
        title: string;
        totalCustomers: number;
        activeServices: number;
        todayRevenue: number;
        pendingOrders: number;
    }

    let { title, totalCustomers, activeServices, todayRevenue, pendingOrders }: Props = $props();
</script>

<div class="space-y-8">
    <div>
        <h1 class="text-3xl font-bold tracking-tight">{title}</h1>
        <p class="text-muted-foreground mt-2">Selamat datang di dashboard admin</p>
    </div>

    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
        <Card>
            <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                <CardTitle class="text-sm font-medium">Total Pelanggan</CardTitle>
                <Users class="h-4 w-4 text-muted-foreground" />
            </CardHeader>
            <CardContent>
                <div class="text-2xl font-bold">{totalCustomers}</div>
                <p class="text-xs text-muted-foreground">+0 dari minggu lalu</p>
            </CardContent>
        </Card>

        <Card>
            <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                <CardTitle class="text-sm font-medium">Layanan Aktif</CardTitle>
                <Zap class="h-4 w-4 text-muted-foreground" />
            </CardHeader>
            <CardContent>
                <div class="text-2xl font-bold">{activeServices}</div>
                <p class="text-xs text-muted-foreground">+0 dari minggu lalu</p>
            </CardContent>
        </Card>

        <Card>
            <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                <CardTitle class="text-sm font-medium">Pendapatan Hari Ini</CardTitle>
                <DollarSign class="h-4 w-4 text-muted-foreground" />
            </CardHeader>
            <CardContent>
                <div class="text-2xl font-bold">Rp {todayRevenue.toLocaleString('id-ID')}</div>
                <p class="text-xs text-muted-foreground">+0 dari kemarin</p>
            </CardContent>
        </Card>

        <Card>
            <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                <CardTitle class="text-sm font-medium">Pesanan Tertunda</CardTitle>
                <ShoppingCart class="h-4 w-4 text-muted-foreground" />
            </CardHeader>
            <CardContent>
                <div class="text-2xl font-bold">{pendingOrders}</div>
                <p class="text-xs text-muted-foreground">Memerlukan tindakan segera</p>
            </CardContent>
        </Card>
    </div>

    <Card>
        <CardHeader>
            <CardTitle>Aktivitas Terbaru</CardTitle>
            <CardDescription>Tidak ada aktivitas saat ini</CardDescription>
        </CardHeader>
        <CardContent>
            <p class="text-sm text-muted-foreground">Dashboard dalam tahap pengembangan</p>
        </CardContent>
    </Card>
</div>
