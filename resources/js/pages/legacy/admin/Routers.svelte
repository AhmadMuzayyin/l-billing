<script lang="ts">
	import { page } from '@inertiajs/svelte';
	import { Link, Form, useForm } from '@inertiajs/svelte';
	import { Button } from '@/components/ui/button/index.js';
	import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card/index.js';
	import { Input } from '@/components/ui/input/index.js';
	import { Label } from '@/components/ui/label/index.js';
	import { ChevronRight, Plus, Pencil, Trash2 } from 'lucide-svelte';

	type Router = {
		id: number;
		name: string;
		ip_address: string;
		username: string;
		port: number;
	};

	let { routers, search }: { routers: any; search: string | null } = $props();

	const deleteForm = useForm({});

	function deleteRouter(id: number) {
		if (confirm('Apakah Anda yakin?')) {
			deleteForm.delete(`/testers/admin/routers/${id}`, {
				onSuccess: () => {
					$page.props.flash.success = 'Router berhasil dihapus';
				}
			});
		}
	}
</script>

<div class="space-y-6">
	<div class="flex items-center justify-between">
		<div>
			<h1 class="text-3xl font-bold tracking-tight">Router Management</h1>
			<p class="text-muted-foreground">Kelola router jaringan</p>
		</div>
		<Link href="/testers/admin/routers/create">
			<Button class="gap-2">
				<Plus class="h-4 w-4" />
				Tambah Router
			</Button>
		</Link>
	</div>

	<Card>
		<CardHeader>
			<CardTitle>Daftar Router</CardTitle>
		</CardHeader>
		<CardContent>
			<Form method="get" action="/testers/admin/routers" class="mb-6">
				<div class="flex gap-2">
					<Input type="text" name="search" placeholder="Cari router..." value={search || ''} />
					<Button type="submit">Cari</Button>
				</div>
			</Form>

			<div class="overflow-x-auto">
				<table class="w-full">
					<thead>
						<tr class="border-b">
							<th class="px-4 py-2 text-left">Nama Router</th>
							<th class="px-4 py-2 text-left">IP Address</th>
							<th class="px-4 py-2 text-left">Username</th>
							<th class="px-4 py-2 text-left">Port</th>
							<th class="px-4 py-2 text-center">Aksi</th>
						</tr>
					</thead>
					<tbody>
						{#each routers.data as router (router.id)}
							<tr class="border-b hover:bg-gray-50">
								<td class="px-4 py-2">{router.name}</td>
								<td class="px-4 py-2">{router.ip_address}</td>
								<td class="px-4 py-2">{router.username}</td>
								<td class="px-4 py-2">{router.port}</td>
								<td class="px-4 py-2 text-center">
									<div class="flex justify-center gap-2">
										<Link href={`/testers/admin/routers/${router.id}/edit`}>
											<Button variant="outline" size="sm" class="gap-2">
												<Pencil class="h-4 w-4" />
											</Button>
										</Link>
										<Button
											variant="destructive"
											size="sm"
											onclick={() => deleteRouter(router.id)}
											class="gap-2"
										>
											<Trash2 class="h-4 w-4" />
										</Button>
									</div>
								</td>
							</tr>
						{/each}
					</tbody>
				</table>
			</div>

			<div class="mt-6 flex justify-between items-center">
				<p class="text-sm text-muted-foreground">
					Menampilkan {routers.from}-{routers.to} dari {routers.total} router
				</p>
				<div class="flex gap-2">
					{#if routers.prev_page_url}
						<Link href={routers.prev_page_url}>
							<Button variant="outline">Sebelumnya</Button>
						</Link>
					{/if}
					{#if routers.next_page_url}
						<Link href={routers.next_page_url}>
							<Button variant="outline">Berikutnya</Button>
						</Link>
					{/if}
				</div>
			</div>
		</CardContent>
	</Card>
</div>
