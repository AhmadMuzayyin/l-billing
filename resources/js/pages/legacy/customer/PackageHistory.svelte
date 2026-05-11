<script lang="ts">
	import { Link } from '@inertiajs/svelte';
	import { ShoppingCart, ChevronLeft, ChevronRight } from 'lucide-svelte';
	import { Button } from '@/components/ui/button';
	import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';

	let { history, customer }: { history: any; customer: any } = $props();

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
</script>

<div class="space-y-6">
	<div className="flex items-center gap-2">
		<Link href={route('legacy.customer.buy-package')}>
			<Button variant="outline" size="icon">
				<ChevronLeft className="w-4 h-4" />
			</Button>
		</Link>
		<h1 class="text-3xl font-bold tracking-tight">Riwayat Pembelian Paket</h1>
	</div>

	<Card>
		<CardHeader>
			<CardTitle className="flex items-center gap-2">
				<ShoppingCart className="w-5 h-5" />
				Paket yang Dibeli
			</CardTitle>
			<CardDescription>Daftar paket internet yang pernah Anda beli</CardDescription>
		</CardHeader>
		<CardContent>
			{#if history.data && history.data.length > 0}
				<div className="space-y-3">
					{#each history.data as transaction}
						<div className="flex items-center justify-between p-3 border rounded-lg hover:bg-muted/50 transition">
							<div className="space-y-1">
								<p className="font-medium">{transaction.plan?.name || 'Paket Tidak Diketahui'}</p>
								<p className="text-sm text-muted-foreground">{transaction.plan?.speed}Mbps</p>
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
					<ShoppingCart className="w-12 h-12 mx-auto text-muted-foreground mb-3" />
					<p class="text-muted-foreground">Anda belum membeli paket apapun</p>
					<Link href={route('legacy.customer.buy-package')} className="mt-4 inline-block">
						<Button>Belanja Paket</Button>
					</Link>
				</div>
			{/if}
		</CardContent>
	</Card>
</div>
