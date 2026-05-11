<script lang="ts">
	import { Link, Form, useForm } from '@inertiajs/svelte';
	import { Button } from '@/components/ui/button/index.js';
	import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card/index.js';
	import { Input } from '@/components/ui/input/index.js';
	import { Label } from '@/components/ui/label/index.js';
	import { ChevronLeft } from 'lucide-svelte';

	type Bandwidth = {
		id?: number;
		name: string;
		upload_limit: number;
		download_limit: number;
		burst_upload?: number;
		burst_download?: number;
	};

	let { bandwidth }: { bandwidth: Bandwidth | null } = $props();

	const form = useForm({
		name: bandwidth?.name || '',
		upload_limit: bandwidth?.upload_limit || 0,
		download_limit: bandwidth?.download_limit || 0,
		burst_upload: bandwidth?.burst_upload || null,
		burst_download: bandwidth?.burst_download || null,
	});

	function submit() {
		if (bandwidth?.id) {
			form.put(`/testers/admin/bandwidth/${bandwidth.id}`, {
				onSuccess: () => {
					window.location.href = '/testers/admin/bandwidth';
				},
			});
		} else {
			form.post('/testers/admin/bandwidth', {
				onSuccess: () => {
					window.location.href = '/testers/admin/bandwidth';
				},
			});
		}
	}
</script>

<div class="space-y-6">
	<Link href="/testers/admin/bandwidth" class="inline-flex items-center gap-2 text-sm text-muted-foreground hover:text-foreground">
		<ChevronLeft class="h-4 w-4" />
		Kembali ke Bandwidth
	</Link>

	<div>
		<h1 class="text-3xl font-bold tracking-tight">{bandwidth?.id ? 'Edit Bandwidth' : 'Tambah Bandwidth'}</h1>
	</div>

	<Card>
		<CardHeader>
			<CardTitle>{bandwidth?.id ? 'Edit Bandwidth' : 'Form Tambah Bandwidth'}</CardTitle>
		</CardHeader>
		<CardContent>
			<form onsubmit={submit} class="space-y-4">
				<div class="grid gap-2">
					<Label for="name">Nama Bandwidth</Label>
					<Input
						id="name"
						type="text"
						bind:value={$form.name}
						placeholder="5 Mbps Premium"
						disabled={$form.processing}
					/>
					{#if $form.errors.name}
						<p class="text-red-500 text-sm">{$form.errors.name}</p>
					{/if}
				</div>

				<div class="grid grid-cols-2 gap-4">
					<div class="grid gap-2">
						<Label for="upload_limit">Upload Limit (Mbps)</Label>
						<Input
							id="upload_limit"
							type="number"
							bind:value={$form.upload_limit}
							placeholder="5"
							disabled={$form.processing}
						/>
						{#if $form.errors.upload_limit}
							<p class="text-red-500 text-sm">{$form.errors.upload_limit}</p>
						{/if}
					</div>

					<div class="grid gap-2">
						<Label for="download_limit">Download Limit (Mbps)</Label>
						<Input
							id="download_limit"
							type="number"
							bind:value={$form.download_limit}
							placeholder="10"
							disabled={$form.processing}
						/>
						{#if $form.errors.download_limit}
							<p class="text-red-500 text-sm">{$form.errors.download_limit}</p>
						{/if}
					</div>
				</div>

				<div class="grid grid-cols-2 gap-4">
					<div class="grid gap-2">
						<Label for="burst_upload">Burst Upload (Mbps)</Label>
						<Input
							id="burst_upload"
							type="number"
							bind:value={$form.burst_upload}
							placeholder="10 (opsional)"
							disabled={$form.processing}
						/>
					</div>

					<div class="grid gap-2">
						<Label for="burst_download">Burst Download (Mbps)</Label>
						<Input
							id="burst_download"
							type="number"
							bind:value={$form.burst_download}
							placeholder="20 (opsional)"
							disabled={$form.processing}
						/>
					</div>
				</div>

				<div class="flex gap-2 justify-end">
					<Link href="/testers/admin/bandwidth">
						<Button type="button" variant="outline">Batal</Button>
					</Link>
					<Button type="submit" disabled={$form.processing}>
						{$form.processing ? 'Menyimpan...' : 'Simpan'}
					</Button>
				</div>
			</form>
		</CardContent>
	</Card>
</div>
