<script lang="ts">
    import { Link } from '@inertiajs/svelte';
    import { CreditCard, ChevronLeft, ChevronRight } from 'lucide-svelte';
    import { Button } from '@/components/ui/button';
    import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';

    let { history, stats, customer, filter_type }: { history: any; stats: any; customer: any; filter_type: string | null } = $props();

    function formatCurrency(amount: number): string {
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(amount);
    }

    function formatDate(date: string): string {
        return new Date(date).toLocaleDateString('id-ID', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
    }

    function getTypeLabel(type: string): string {
        const labels: Record<string, string> = {
            topup: 'Top-up',
            purchase: 'Pembelian',
            deduction: 'Pengurangan'
        };
        return labels[type] || type;
    }
</script>

<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-bold tracking-tight">Riwayat Pembayaran</h1>
        <p class="text-muted-foreground mt-2">Lihat semua transaksi pembayaran Anda</p>
    </div>

    <!-- Statistics Cards -->
    <div className="grid grid-cols-1 md:grid-cols-4 gap-4">
        <Card>
            <CardHeader className="pb-2">
                <CardTitle className="text-sm font-medium text-muted-foreground">Total Pembayaran</CardTitle>
            </CardHeader>
            <CardContent>
                <p class="text-2xl font-bold">{formatCurrency(stats.total_paid)}</p>
            </CardContent>
        </Card>
        <Card>
            <CardHeader className="pb-2">
                <CardTitle className="text-sm font-medium text-muted-foreground">Jumlah Transaksi</CardTitle>
            </CardHeader>
            <CardContent>
                <p class="text-2xl font-bold">{stats.total_transactions}</p>
            </CardContent>
        </Card>
        <Card>
            <CardHeader className="pb-2">
                <CardTitle className="text-sm font-medium text-muted-foreground">Top-up</CardTitle>
            </CardHeader>
            <CardContent>
                <p class="text-2xl font-bold">{stats.topup_count}</p>
            </CardContent>
        </Card>
        <Card>
            <CardHeader className="pb-2">
                <CardTitle className="text-sm font-medium text-muted-foreground">Pembelian Paket</CardTitle>
            </CardHeader>
            <CardContent>
                <p class="text-2xl font-bold">{stats.purchase_count}</p>
            </CardContent>
        </Card>
    </div>

    <!-- Transactions Table -->
    <Card>
        <CardHeader>
            <CardTitle className="flex items-center gap-2">
                <CreditCard className="w-5 h-5" />
                Daftar Transaksi
            </CardTitle>
            <CardDescription>Kelola riwayat pembayaran Anda</CardDescription>
        </CardHeader>
        <CardContent>
            {#if history.data && history.data.length > 0}
                <div className="space-y-3">
                    {#each history.data as transaction}
                        <div className="flex items-center justify-between p-3 border rounded-lg hover:bg-muted/50 transition">
                            <div className="space-y-1">
                                <p className="font-medium">{getTypeLabel(transaction.type)}</p>
                                <p className="text-sm text-muted-foreground">{transaction.description}</p>
                                <p className="text-xs text-muted-foreground">
                                    {formatDate(transaction.created_at)}
                                </p>
                            </div>
                            <p className="font-bold">
                                {formatCurrency(transaction.amount)}
                            </p>
                        </div>
                    {/each}
                </div>

                <!-- Pagination -->
                <div className="flex items-center justify-between mt-6 pt-6 border-t">
                    <p class="text-sm text-muted-foreground">
                        Halaman {history.current_page} dari {history.last_page}
                    </p>
                    <div className="flex gap-2">
                        {#if history.prev_page_url}
                            <Link href={history.prev_page_url}>
                                <Button variant="outline" size="icon">
                                    <ChevronLeft className="w-4 h-4" />
                                </Button>
                            </Link>
                        {/if}
                        {#if history.next_page_url}
                            <Link href={history.next_page_url}>
                                <Button variant="outline" size="icon">
                                    <ChevronRight className="w-4 h-4" />
                                </Button>
                            </Link>
                        {/if}
                    </div>
                </div>
            {:else}
                <div className="text-center py-8">
                    <CreditCard className="w-12 h-12 mx-auto text-muted-foreground mb-3" />
                    <p class="text-muted-foreground">Tidak ada transaksi</p>
                </div>
            {/if}
        </CardContent>
    </Card>
</div>
