<script lang="ts">
	import { Link, useForm } from '@inertiajs/svelte';
	import { Button } from '@/components/ui/button/index.js';
	import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card/index.js';
	import { Input } from '@/components/ui/input/index.js';
	import { Label } from '@/components/ui/label/index.js';
	import { ChevronLeft, Check } from 'lucide-svelte';

	type Customer = {
		id: number;
		fullname: string;
		username: string;
	};

	let { customers }: { customers: Customer[] } = $props();

	const form = useForm({
		title: '',
		message: '',
		customer_ids: [] as number[],
	});

	function toggleCustomer(id: number) {
		if ($form.customer_ids.includes(id)) {
			$form.customer_ids = $form.customer_ids.filter(cid => cid !== id);
		} else {
			$form.customer_ids = [...$form.customer_ids, id];
		}
	}

	function submit() {
		form.post('/testers/admin/messages/bulk', {
			onSuccess: () => {
				window.location.href = '/testers/admin/messages';
			},
		});
	}
</script>

<div class="space-y-6">
	<Link href="/testers/admin/messages" class="inline-flex items-center gap-2 text-sm text-muted-foreground hover:text-foreground">
		<ChevronLeft class="h-4 w-4" />
		Kembali ke Messaging
	</Link>

	<div>
		<h1 class="text-3xl font-bold tracking-tight">Kirim Pesan Massal</h1>
	</div>

	<Card>
		<CardHeader>
			<CardTitle>Form Kirim Pesan Massal</CardTitle>
		</CardHeader>
		<CardContent>
			<form onsubmit={submit} class="space-y-4">
				<div class="grid gap-2">
					<Label for="title">Judul Pesan</Label>
					<Input
						id="title"
						type="text"
						bind:value={$form.title}
						placeholder="Judul pesan..."
						disabled={$form.processing}
					/>
					{#if $form.errors.title}
						<p class="text-red-500 text-sm">{$form.errors.title}</p>
					{/if}
				</div>

				<div class="grid gap-2">
					<Label for="message">Isi Pesan</Label>
					<textarea
						id="message"
						bind:value={$form.message}
						placeholder="Isi pesan..."
						disabled={$form.processing}
						rows="6"
						class="border px-3 py-2 rounded-md"
					></textarea>
					{#if $form.errors.message}
						<p class="text-red-500 text-sm">{$form.errors.message}</p>
					{/if}
				</div>

				<div class="grid gap-2">
					<Label>Pilih Pelanggan ({$form.customer_ids.length} terpilih)</Label>
					<div class="border rounded-md p-4 max-h-96 overflow-y-auto space-y-2">
						{#each customers as customer (customer.id)}
							<label class="flex items-center gap-2 cursor-pointer hover:bg-gray-50 p-2 rounded">
								<input
									type="checkbox"
									checked={$form.customer_ids.includes(customer.id)}
									onchange={() => toggleCustomer(customer.id)}
									disabled={$form.processing}
									class="rounded"
								/>
								<div class="flex-1">
									<div class="font-medium">{customer.fullname}</div>
									<div class="text-sm text-muted-foreground">@{customer.username}</div>
								</div>
							</label>
						{/each}
					</div>
					{#if $form.errors['customer_ids']}
						<p class="text-red-500 text-sm">{$form.errors['customer_ids']}</p>
					{/if}
				</div>

				<div class="flex gap-2 justify-end">
					<Link href="/testers/admin/messages">
						<Button type="button" variant="outline">Batal</Button>
					</Link>
					<Button type="submit" disabled={$form.processing || $form.customer_ids.length === 0}>
						{$form.processing ? 'Mengirim...' : 'Kirim ke ' + $form.customer_ids.length + ' Pelanggan'}
					</Button>
				</div>
			</form>
		</CardContent>
	</Card>
</div>
