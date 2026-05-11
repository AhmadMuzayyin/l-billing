<script lang="ts">
    import { Link, Form } from '@inertiajs/svelte';
    import { Zap, Plus, ChevronLeft, ChevronRight } from 'lucide-svelte';
    import { Button } from '@/components/ui/button';
    import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';

    let { balance, transactions, customer }: { balance: number; transactions: any; customer: any } = $props();

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
            deduction: 'Pengurangan',
            purchase: 'Pembelian'
        };
        return labels[type] || type;
    }
</script>

<div class="space-y-6">
    <div className="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold tracking-tight">Saldo Saya</h1>
            <p class="text-muted-foreground mt-2">Kelola saldo dan top-up</p>
        </div>
        <Link href={route('legacy.customer.buy-balance.create')}>
            <Button className="gap-2">
                <Plus className="w-4 h-4" />
                Top-up Saldo
            </Button>
        </Link>
    </div>

    <!-- Balance Card -->
    <Card className="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900 dark:to-blue-800">
        <CardHeader>
            <CardTitle className="flex items-center gap-2">
                <Zap className="w-5 h-5" />
                Saldo Anda
            </CardTitle>
        </CardHeader>
        <CardContent>
            <p class="text-4xl font-bold">
                {formatCurrency(balance)}
            </p>
            <p class="text-sm text-muted-foreground mt-2">
                Saldo tersedia untuk pembelian paket
            </p>
        </CardContent>
    </Card>

    <!-- Transactions -->
    <Card>
        <CardHeader>
            <CardTitle>Riwayat Transaksi</CardTitle>
            <CardDescription>Daftar top-up dan pengurangan saldo</CardDescription>
        </CardHeader>
        <CardContent>
            {#if transactions.data && transactions.data.length > 0}
                <div className="space-y-3">
                    {#each transactions.data as transaction}
                        <div className="flex items-center justify-between p-3 border rounded-lg hover:bg-muted/50 transition">
                            <div className="space-y-1">
                                <p className="font-medium">{getTypeLabel(transaction.type)}</p>
                                <p className="text-sm text-muted-foreground">{transaction.description}</p>
                                <p className="text-xs text-muted-foreground">
                                    {formatDate(transaction.created_at)}
                                </p>
                            </div>
                            <p className={`font-bold ${transaction.type === 'topup' ? 'text-green-600' : 'text-red-600'}`}>
                                {transaction.type === 'topup' ? '+' : '-'}{formatCurrency(transaction.amount)}
                            </p>
                        </div>
                    {/each}
                </div>

                <!-- Pagination -->
                <div className="flex items-center justify-between mt-6 pt-6 border-t">
                    <p class="text-sm text-muted-foreground">
                        Halaman {transactions.current_page} dari {transactions.last_page}
                    </p>
                    <div className="flex gap-2">
                        {#if transactions.prev_page_url}
                            <Link href={transactions.prev_page_url}>
                                <Button variant="outline" size="icon">
                                    <ChevronLeft className="w-4 h-4" />
                                </Button>
                            </Link>
                        {/if}
                        {#if transactions.next_page_url}
                            <Link href={transactions.next_page_url}>
                                <Button variant="outline" size="icon">
                                    <ChevronRight className="w-4 h-4" />
                                </Button>
                            </Link>
                        {/if}
                    </div>
                </div>
            {:else}
                <div className="text-center py-8">
                    <Zap className="w-12 h-12 mx-auto text-muted-foreground mb-3" />
                    <p class="text-muted-foreground">Tidak ada transaksi</p>
                </div>
            {/if}
        </CardContent>
    </Card>
</div>
