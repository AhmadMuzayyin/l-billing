<script lang="ts">
	import { page } from '@inertiajs/svelte';
	import { Link, Form, useForm } from '@inertiajs/svelte';
	import { Button } from '@/components/ui/button/index.js';
	import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card/index.js';
	import { Input } from '@/components/ui/input/index.js';
	import { Label } from '@/components/ui/label/index.js';
	import { Plus, Pencil, Trash2 } from 'lucide-svelte';

	type Bandwidth = {
		id: number;
		name: string;
		upload_limit: number;
		download_limit: number;
		burst_upload: number | null;
		burst_download: number | null;
	};

	let { bandwidths, search }: { bandwidths: any; search: string | null } = $props();

	const deleteForm = useForm({});

	function deleteBandwidth(id: number) {
		if (confirm('Apakah Anda yakin?')) {
			deleteForm.delete(`/testers/admin/bandwidth/${id}`, {
				onSuccess: () => {
					$page.props.flash.success = 'Bandwidth profil berhasil dihapus';
				}
			});
		}
	}
</script>

<div class="space-y-6">
	<div class="flex items-center justify-between">
		<div>
			<h1 class="text-3xl font-bold tracking-tight">Bandwidth Management</h1>
			<p class="text-muted-foreground">Kelola profil bandwidth jaringan</p>
		</div>
		<Link href="/testers/admin/bandwidth/create">
			<Button class="gap-2">
				<Plus class="h-4 w-4" />
				Tambah Bandwidth
			</Button>
		</Link>
	</div>

	<Card>
		<CardHeader>
			<CardTitle>Daftar Bandwidth</CardTitle>
		</CardHeader>
		<CardContent>
			<Form method="get" action="/testers/admin/bandwidth" class="mb-6">
				<div class="flex gap-2">
					<Input type="text" name="search" placeholder="Cari bandwidth..." value={search || ''} />
					<Button type="submit">Cari</Button>
				</div>
			</Form>

			<div class="overflow-x-auto">
				<table class="w-full">
					<thead>
						<tr class="border-b">
							<th class="px-4 py-2 text-left">Nama Bandwidth</th>
							<th class="px-4 py-2 text-left">Upload Limit</th>
							<th class="px-4 py-2 text-left">Download Limit</th>
							<th class="px-4 py-2 text-center">Aksi</th>
						</tr>
					</thead>
					<tbody>
						{#each bandwidths.data as bandwidth (bandwidth.id)}
							<tr class="border-b hover:bg-gray-50">
								<td class="px-4 py-2">{bandwidth.name}</td>
								<td class="px-4 py-2">{bandwidth.upload_limit} Mbps</td>
								<td class="px-4 py-2">{bandwidth.download_limit} Mbps</td>
								<td class="px-4 py-2 text-center">
									<div class="flex justify-center gap-2">
										<Link href={`/testers/admin/bandwidth/${bandwidth.id}/edit`}>
											<Button variant="outline" size="sm" class="gap-2">
												<Pencil class="h-4 w-4" />
											</Button>
										</Link>
										<Button
											variant="destructive"
											size="sm"
											onclick={() => deleteBandwidth(bandwidth.id)}
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
					Menampilkan {bandwidths.from}-{bandwidths.to} dari {bandwidths.total} bandwidth
				</p>
				<div class="flex gap-2">
					{#if bandwidths.prev_page_url}
						<Link href={bandwidths.prev_page_url}>
							<Button variant="outline">Sebelumnya</Button>
						</Link>
					{/if}
					{#if bandwidths.next_page_url}
						<Link href={bandwidths.next_page_url}>
							<Button variant="outline">Berikutnya</Button>
						</Link>
					{/if}
				</div>
			</div>
		</CardContent>
	</Card>
</div>
