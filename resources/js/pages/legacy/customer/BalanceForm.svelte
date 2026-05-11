<script lang="ts">
	import { Link, Form, useForm } from '@inertiajs/svelte';
	import { ChevronLeft } from 'lucide-svelte';
	import { Button } from '@/components/ui/button';
	import { Input } from '@/components/ui/input';
	import { Label } from '@/components/ui/label';
	import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';

	let { customer, balance }: { customer: any; balance: number } = $props();

	const form = useForm({
		amount: ''
	});

	function submit() {
		form.post(route('legacy.customer.buy-balance.store', customer.id));
	}

	function formatCurrency(amount: number): string {
		return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(amount);
	}
</script>

<div class="space-y-6">
	<div className="flex items-center gap-2">
		<Link href={route('legacy.customer.buy-balance')}>
			<Button variant="outline" size="icon">
				<ChevronLeft className="w-4 h-4" />
			</Button>
		</Link>
		<h1 class="text-3xl font-bold tracking-tight">Top-up Saldo</h1>
	</div>

	<div className="grid grid-cols-1 md:grid-cols-3 gap-6">
		<!-- Form -->
		<Card className="md:col-span-2">
			<CardHeader>
				<CardTitle>Masukkan Jumlah Top-up</CardTitle>
				<CardDescription>Saldo Anda saat ini: {formatCurrency(balance)}</CardDescription>
			</CardHeader>
			<CardContent>
				<form onsubmit={submit} className="space-y-6">
					<div className="space-y-2">
						<Label for="amount">Jumlah (Rp)</Label>
						<Input
							id="amount"
							type="number"
							min="1000"
							step="1000"
							placeholder="Masukkan jumlah top-up"
							bind:value={$form.amount}
							disabled={$form.processing}
						/>
						{#if $form.errors.amount}
							<p className="text-sm text-red-600">{$form.errors.amount}</p>
						{/if}
					</div>

					<div className="bg-blue-50 dark:bg-blue-900/20 p-3 rounded-lg space-y-2">
						<p className="text-sm font-medium">Informasi Top-up</p>
						<p className="text-sm text-muted-foreground">
							{#if $form.data.amount}
								Saldo baru: {formatCurrency(balance + parseFloat($form.data.amount))}
							{:else}
								Masukkan jumlah untuk melihat saldo baru
							{/if}
						</p>
					</div>

					<Button type="submit" className="w-full" disabled={$form.processing}>
						{$form.processing ? 'Memproses...' : 'Lanjutkan Top-up'}
					</Button>
				</form>
			</CardContent>
		</Card>

		<!-- Info Card -->
		<Card>
			<CardHeader>
				<CardTitle className="text-sm">Bantuan</CardTitle>
			</CardHeader>
			<CardContent className="space-y-3 text-sm text-muted-foreground">
				<div>
					<p className="font-medium text-foreground mb-1">Cara Top-up</p>
					<ol className="list-decimal list-inside space-y-1">
						<li>Masukkan jumlah top-up</li>
						<li>Klik tombol Lanjutkan Top-up</li>
						<li>Selesaikan proses pembayaran</li>
						<li>Saldo akan langsung bertambah</li>
					</ol>
				</div>
			</CardContent>
		</Card>
	</div>
</div>
