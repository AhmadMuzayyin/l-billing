<script lang="ts">
    import { Link, Form } from '@inertiajs/svelte';
    import { Wifi, ChevronLeft, ChevronRight } from 'lucide-svelte';
    import { Button } from '@/components/ui/button';
    import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';

    let { packages, customer }: { packages: any; customer: any } = $props();

    function formatCurrency(amount: number): string {
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(amount);
    }
</script>

<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-bold tracking-tight">Beli Paket Internet</h1>
        <p class="text-muted-foreground mt-2">Pilih paket internet yang sesuai dengan kebutuhan Anda</p>
    </div>

    <!-- Packages Grid -->
    {#if packages.data && packages.data.length > 0}
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            {#each packages.data as package}
                <Card className="flex flex-col">
                    <CardHeader>
                        <CardTitle className="flex items-center gap-2">
                            <Wifi className="w-5 h-5" />
                            {package.name}
                        </CardTitle>
                        <CardDescription>{package.speed}Mbps</CardDescription>
                    </CardHeader>
                    <CardContent className="flex-1 space-y-4">
                        <div>
                            <p className="text-3xl font-bold">
                                {formatCurrency(package.price)}
                            </p>
                            <p className="text-sm text-muted-foreground">
                                untuk {package.validity_days} hari
                            </p>
                        </div>
                        <div className="space-y-2 text-sm">
                            <p className="text-muted-foreground">{package.description}</p>
                        </div>
                        <Link href={route('legacy.customer.buy-package.purchase', package.id)} className="mt-auto">
                            <Button className="w-full">Beli Paket</Button>
                        </Link>
                    </CardContent>
                </Card>
            {/each}
        </div>

        <!-- Pagination -->
        {#if packages.last_page > 1}
            <div className="flex items-center justify-between pt-6 border-t">
                <p class="text-sm text-muted-foreground">
                    Halaman {packages.current_page} dari {packages.last_page}
                </p>
                <div className="flex gap-2">
                    {#if packages.prev_page_url}
                        <Link href={packages.prev_page_url}>
                            <Button variant="outline" size="icon">
                                <ChevronLeft className="w-4 h-4" />
                            </Button>
                        </Link>
                    {/if}
                    {#if packages.next_page_url}
                        <Link href={packages.next_page_url}>
                            <Button variant="outline" size="icon">
                                <ChevronRight className="w-4 h-4" />
                            </Button>
                        </Link>
                    {/if}
                </div>
            </div>
        {/if}
    {:else}
        <Card>
            <CardHeader>
                <CardTitle>Tidak ada paket</CardTitle>
            </CardHeader>
            <CardContent>
                <p class="text-muted-foreground">Paket internet tidak tersedia saat ini</p>
            </CardContent>
        </Card>
    {/if}
</div>
