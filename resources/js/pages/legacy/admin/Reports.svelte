<script lang="ts">
	import { Link } from '@inertiajs/svelte';
	import { Button } from '@/components/ui/button/index.js';
	import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card/index.js';
	import { BarChart3 } from 'lucide-svelte';

	type ActivationHistory = {
		id: number;
		customer_id: number;
		plan_id: number;
		recharged_on: string;
		expiration: string;
		status: string;
	};

	type RevenueReport = {
		total: number;
		count: number;
		average: number;
	};

	let { activationHistory, revenueReport, startDate, endDate }: { 
		activationHistory: any; 
		revenueReport: RevenueReport;
		startDate: string | null;
		endDate: string | null;
	} = $props();
</script>

<div class="space-y-6">
	<div>
		<h1 class="text-3xl font-bold tracking-tight">Reports</h1>
		<p class="text-muted-foreground">Laporan aktivitas dan revenue</p>
	</div>

	<div class="grid grid-cols-3 gap-4">
		<Card>
			<CardHeader class="pb-2">
				<CardTitle class="text-sm font-medium">Total Revenue</CardTitle>
			</CardHeader>
			<CardContent>
				<div class="text-2xl font-bold">Rp {(revenueReport.total || 0).toLocaleString('id-ID')}</div>
			</CardContent>
		</Card>

		<Card>
			<CardHeader class="pb-2">
				<CardTitle class="text-sm font-medium">Jumlah Transaksi</CardTitle>
			</CardHeader>
			<CardContent>
				<div class="text-2xl font-bold">{revenueReport.count || 0}</div>
			</CardContent>
		</Card>

		<Card>
			<CardHeader class="pb-2">
				<CardTitle class="text-sm font-medium">Rata-rata Transaksi</CardTitle>
			</CardHeader>
			<CardContent>
				<div class="text-2xl font-bold">Rp {Math.round(revenueReport.average || 0).toLocaleString('id-ID')}</div>
			</CardContent>
		</Card>
	</div>

	<Card>
		<CardHeader>
			<CardTitle>Activation History</CardTitle>
		</CardHeader>
		<CardContent>
			<div class="overflow-x-auto">
				<table class="w-full">
					<thead>
						<tr class="border-b">
							<th class="px-4 py-2 text-left">ID Recharge</th>
							<th class="px-4 py-2 text-left">Tanggal</th>
							<th class="px-4 py-2 text-left">Expiration</th>
							<th class="px-4 py-2 text-left">Status</th>
						</tr>
					</thead>
					<tbody>
						{#each activationHistory.data as item (item.id)}
							<tr class="border-b hover:bg-gray-50">
								<td class="px-4 py-2">#{item.id}</td>
								<td class="px-4 py-2">{new Date(item.recharged_on).toLocaleDateString('id-ID')}</td>
								<td class="px-4 py-2">{new Date(item.expiration).toLocaleDateString('id-ID')}</td>
								<td class="px-4 py-2">
									<span class="px-2 py-1 rounded-full text-sm" class:bg-green-100 class:text-green-800={item.status === 'active'} class:bg-red-100 class:text-red-800={item.status !== 'active'}>
										{item.status}
									</span>
								</td>
							</tr>
						{/each}
					</tbody>
				</table>
			</div>

			<div class="mt-6 flex justify-between items-center">
				<p class="text-sm text-muted-foreground">
					Menampilkan {activationHistory.from}-{activationHistory.to} dari {activationHistory.total} record
				</p>
				<div class="flex gap-2">
					{#if activationHistory.prev_page_url}
						<Link href={activationHistory.prev_page_url}>
							<Button variant="outline">Sebelumnya</Button>
						</Link>
					{/if}
					{#if activationHistory.next_page_url}
						<Link href={activationHistory.next_page_url}>
							<Button variant="outline">Berikutnya</Button>
						</Link>
					{/if}
				</div>
			</div>
		</CardContent>
	</Card>
</div>
