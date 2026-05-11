<script lang="ts">
	import { page } from '@inertiajs/svelte';
	import { Link, Form, useForm } from '@inertiajs/svelte';
	import { Button } from '@/components/ui/button/index.js';
	import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card/index.js';
	import { Input } from '@/components/ui/input/index.js';
	import { Label } from '@/components/ui/label/index.js';
	import { ChevronLeft } from 'lucide-svelte';

	type Router = {
		id?: number;
		name: string;
		ip_address: string;
		username: string;
		password: string;
		port: number;
	};

	let { router }: { router: Router | null } = $props();

	const form = useForm({
		name: router?.name || '',
		ip_address: router?.ip_address || '',
		username: router?.username || '',
		password: router?.password || '',
		port: router?.port || 8728,
	});

	function submit() {
		if (router?.id) {
			form.put(`/testers/admin/routers/${router.id}`, {
				onSuccess: () => {
					window.location.href = '/testers/admin/routers';
				},
			});
		} else {
			form.post('/testers/admin/routers', {
				onSuccess: () => {
					window.location.href = '/testers/admin/routers';
				},
			});
		}
	}
</script>

<div class="space-y-6">
	<Link href="/testers/admin/routers" class="inline-flex items-center gap-2 text-sm text-muted-foreground hover:text-foreground">
		<ChevronLeft class="h-4 w-4" />
		Kembali ke Router
	</Link>

	<div>
		<h1 class="text-3xl font-bold tracking-tight">{router?.id ? 'Edit Router' : 'Tambah Router'}</h1>
	</div>

	<Card>
		<CardHeader>
			<CardTitle>{router?.id ? 'Edit Router' : 'Form Tambah Router'}</CardTitle>
		</CardHeader>
		<CardContent>
			<form onsubmit={submit} class="space-y-4">
				<div class="grid gap-2">
					<Label for="name">Nama Router</Label>
					<Input
						id="name"
						type="text"
						bind:value={$form.name}
						placeholder="Router Utama"
						disabled={$form.processing}
					/>
					{#if $form.errors.name}
						<p class="text-red-500 text-sm">{$form.errors.name}</p>
					{/if}
				</div>

				<div class="grid gap-2">
					<Label for="ip_address">IP Address</Label>
					<Input
						id="ip_address"
						type="text"
						bind:value={$form.ip_address}
						placeholder="192.168.1.1"
						disabled={$form.processing}
					/>
					{#if $form.errors.ip_address}
						<p class="text-red-500 text-sm">{$form.errors.ip_address}</p>
					{/if}
				</div>

				<div class="grid gap-2">
					<Label for="username">Username</Label>
					<Input
						id="username"
						type="text"
						bind:value={$form.username}
						placeholder="admin"
						disabled={$form.processing}
					/>
					{#if $form.errors.username}
						<p class="text-red-500 text-sm">{$form.errors.username}</p>
					{/if}
				</div>

				<div class="grid gap-2">
					<Label for="password">Password</Label>
					<Input
						id="password"
						type="password"
						bind:value={$form.password}
						placeholder="••••••"
						disabled={$form.processing}
					/>
					{#if $form.errors.password}
						<p class="text-red-500 text-sm">{$form.errors.password}</p>
					{/if}
				</div>

				<div class="grid gap-2">
					<Label for="port">Port</Label>
					<Input
						id="port"
						type="number"
						bind:value={$form.port}
						placeholder="8728"
						disabled={$form.processing}
					/>
					{#if $form.errors.port}
						<p class="text-red-500 text-sm">{$form.errors.port}</p>
					{/if}
				</div>

				<div class="flex gap-2 justify-end">
					<Link href="/testers/admin/routers">
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
