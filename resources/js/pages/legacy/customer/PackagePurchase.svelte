<script lang="ts">
	import { Link, Form } from '@inertiajs/svelte';
	import { ChevronLeft, AlertCircle } from 'lucide-svelte';
	import { Button } from '@/components/ui/button';
	import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';

	let { package: pkg, customer, balance }: { package: any; customer: any; balance: number } = $props();

	const canPurchase = balance >= pkg.price;

	function formatCurrency(amount: number): string {
		return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(amount);
	}
</script>

<div class="space-y-6">
	<div className="flex items-center gap-2">
		<Link href={route('legacy.customer.buy-package')}>
			<Button variant="outline" size="icon">
				<ChevronLeft className="w-4 h-4" />
			</Button>
		</Link>
		<h1 class="text-3xl font-bold tracking-tight">Konfirmasi Pembelian</h1>
	</div>

	<div className="grid grid-cols-1 md:grid-cols-3 gap-6">
		<!-- Package Details -->
		<Card className="md:col-span-2">
			<CardHeader>
				<CardTitle>{pkg.name}</CardTitle>
				<CardDescription>{pkg.speed}Mbps - {pkg.validity_days} hari</CardDescription>
			</CardHeader>
			<CardContent className="space-y-4">
				<p className="text-muted-foreground">{pkg.description}</p>

				<div className="space-y-3 pt-4 border-t">
					<div className="flex justify-between">
						<span className="text-muted-foreground">Harga Paket</span>
						<span className="font-medium">{formatCurrency(pkg.price)}</span>
					</div>
					<div className="flex justify-between">
						<span className="text-muted-foreground">Durasi</span>
						<span className="font-medium">{pkg.validity_days} hari</span>
					</div>
					<div className="flex justify-between text-lg font-bold border-t pt-3">
						<span>Total</span>
						<span>{formatCurrency(pkg.price)}</span>
					</div>
				</div>

				{#if !canPurchase}
					<div className="bg-red-50 dark:bg-red-900/20 p-4 rounded-lg flex gap-3">
						<AlertCircle className="w-5 h-5 text-red-600 flex-shrink-0" />
						<div>
							<p className="text-sm font-medium text-red-600">Saldo Tidak Cukup</p>
							<p className="text-sm text-red-600/80 mt-1">
								Anda memerlukan {formatCurrency(pkg.price - balance)} lagi untuk membeli paket ini
							</p>
						</div>
					</div>
					<Link href={route('legacy.customer.buy-balance.create')}>
						<Button className="w-full">Top-up Saldo Terlebih Dahulu</Button>
					</Link>
				{:else}
					<Form method="POST" action={route('legacy.customer.buy-package.store', pkg.id)}>
						<Button type="submit" className="w-full">Konfirmasi Pembelian</Button>
					</Form>
				{/if}
			</CardContent>
		</Card>

		<!-- Summary -->
		<Card>
			<CardHeader>
				<CardTitle className="text-sm">Ringkasan Akun</CardTitle>
			</CardHeader>
			<CardContent className="space-y-3 text-sm">
				<div>
					<p className="text-muted-foreground">Saldo Anda</p>
					<p className="font-bold text-lg">{formatCurrency(balance)}</p>
				</div>
				<div className="border-t pt-3">
					<p className="text-muted-foreground">Saldo Setelah Pembelian</p>
					<p className={`font-bold text-lg ${canPurchase ? 'text-green-600' : 'text-red-600'}`}>
						{formatCurrency(Math.max(0, balance - pkg.price))}
					</p>
				</div>
			</CardContent>
		</Card>
	</div>
</div>
