<script lang="ts">
	import { Link, useForm } from '@inertiajs/svelte';
	import { Button } from '@/components/ui/button/index.js';
	import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card/index.js';
	import { Input } from '@/components/ui/input/index.js';
	import { Label } from '@/components/ui/label/index.js';
	import { ChevronLeft } from 'lucide-svelte';

	const form = useForm({
		customer_id: '',
		title: '',
		message: '',
	});

	function submit() {
		form.post('/testers/admin/messages/send', {
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
		<h1 class="text-3xl font-bold tracking-tight">Kirim Pesan Individual</h1>
	</div>

	<Card>
		<CardHeader>
			<CardTitle>Form Kirim Pesan</CardTitle>
		</CardHeader>
		<CardContent>
			<form onsubmit={submit} class="space-y-4">
				<div class="grid gap-2">
					<Label for="customer_id">Pilih Pelanggan</Label>
					<select
						id="customer_id"
						bind:value={$form.customer_id}
						disabled={$form.processing}
						class="border px-3 py-2 rounded-md"
					>
						<option value="">-- Pilih Pelanggan --</option>
					</select>
					{#if $form.errors.customer_id}
						<p class="text-red-500 text-sm">{$form.errors.customer_id}</p>
					{/if}
				</div>

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

				<div class="flex gap-2 justify-end">
					<Link href="/testers/admin/messages">
						<Button type="button" variant="outline">Batal</Button>
					</Link>
					<Button type="submit" disabled={$form.processing}>
						{$form.processing ? 'Mengirim...' : 'Kirim Pesan'}
					</Button>
				</div>
			</form>
		</CardContent>
	</Card>
</div>
