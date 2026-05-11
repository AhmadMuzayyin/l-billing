<script lang="ts">
	import { Link } from '@inertiajs/svelte';
	import { Calendar, ChevronLeft } from 'lucide-svelte';
	import { Button } from '@/components/ui/button';
	import { Input } from '@/components/ui/input';
	import { Label } from '@/components/ui/label';
	import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';

	let { monthly_stats, stats, history, customer, selected_month }: { monthly_stats: any; stats: any; history: any; customer: any; selected_month: string | null } = $props();
	let month = $state(selected_month || new Date().toISOString().slice(0, 7));

	function formatCurrency(amount: number): string {
		return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(amount);
	}

	function handleMonthChange() {
		window.location.href = route('legacy.customer.payment-history.monthly') + '?month=' + month;
	}
</script>

<div class="space-y-6">
	<div className="flex items-center gap-2">
		<Link href={route('legacy.customer.payment-history')}>
			<Button variant="outline" size="icon">
				<ChevronLeft className="w-4 h-4" />
			</Button>
		</Link>
		<h1 class="text-3xl font-bold tracking-tight">Laporan Pembayaran Bulanan</h1>
	</div>

	<!-- Month Picker -->
	<Card>
		<CardHeader>
			<CardTitle className="flex items-center gap-2">
				<Calendar className="w-5 h-5" />
				Pilih Bulan
			</CardTitle>
		</CardHeader>
		<CardContent className="flex gap-3">
			<div className="flex-1">
				<Label for="month">Bulan</Label>
				<Input
					id="month"
					type="month"
					bind:value={month}
					onchange={handleMonthChange}
				/>
			</div>
		</CardContent>
	</Card>

	<!-- Monthly Statistics -->
	{#if monthly_stats}
		<div className="grid grid-cols-1 md:grid-cols-4 gap-4">
			<Card>
				<CardHeader className="pb-2">
					<CardTitle className="text-sm font-medium text-muted-foreground">Total Bulan Ini</CardTitle>
				</CardHeader>
				<CardContent>
					<p class="text-2xl font-bold">{formatCurrency(monthly_stats.total)}</p>
				</CardContent>
			</Card>
			<Card>
				<CardHeader className="pb-2">
					<CardTitle className="text-sm font-medium text-muted-foreground">Jumlah Transaksi</CardTitle>
				</CardHeader>
				<CardContent>
					<p class="text-2xl font-bold">{monthly_stats.count}</p>
				</CardContent>
			</Card>
			<Card>
				<CardHeader className="pb-2">
					<CardTitle className="text-sm font-medium text-muted-foreground">Top-up</CardTitle>
				</CardHeader>
				<CardContent>
					<p class="text-2xl font-bold">{formatCurrency(monthly_stats.topup)}</p>
				</CardContent>
			</Card>
			<Card>
				<CardHeader className="pb-2">
					<CardTitle className="text-sm font-medium text-muted-foreground">Pembelian</CardTitle>
				</CardHeader>
				<CardContent>
					<p class="text-2xl font-bold">{formatCurrency(monthly_stats.purchase)}</p>
				</CardContent>
			</Card>
		</div>

		<!-- Comparison -->
		<Card>
			<CardHeader>
				<CardTitle>Perbandingan dengan Total Keseluruhan</CardTitle>
			</CardHeader>
			<CardContent className="space-y-3">
				<div className="space-y-2">
					<div className="flex justify-between">
						<span className="text-muted-foreground">Persentase Bulan Ini</span>
						<span className="font-bold">
							{stats.total_paid > 0 ? ((monthly_stats.total / stats.total_paid) * 100).toFixed(2) : 0}%
						</span>
					</div>
					<div className="w-full bg-gray-200 rounded-full h-2">
						<div
							className="bg-blue-600 h-2 rounded-full"
							style={`width: ${stats.total_paid > 0 ? ((monthly_stats.total / stats.total_paid) * 100) : 0}%`}
						/>
					</div>
				</div>
			</CardContent>
		</Card>
	{/if}
</div>
