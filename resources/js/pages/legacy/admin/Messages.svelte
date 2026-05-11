<script lang="ts">
	import { Link, useForm } from '@inertiajs/svelte';
	import { Button } from '@/components/ui/button/index.js';
	import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card/index.js';
	import { Plus, Trash2, Mail } from 'lucide-svelte';

	type Message = {
		id: number;
		title: string;
		message: string;
		send_by: number;
		created_at: string;
		customer_id?: number;
	};

	let { messages }: { messages: any } = $props();

	const deleteForm = useForm({});

	function deleteMessage(id: number) {
		if (confirm('Apakah Anda yakin?')) {
			deleteForm.delete(`/testers/admin/messages/${id}`, {
				onSuccess: () => {
					window.location.reload();
				}
			});
		}
	}
</script>

<div class="space-y-6">
	<div class="flex items-center justify-between">
		<div>
			<h1 class="text-3xl font-bold tracking-tight">Messaging</h1>
			<p class="text-muted-foreground">Kirim pesan ke pelanggan</p>
		</div>
		<div class="flex gap-2">
			<Link href="/testers/admin/messages/create">
				<Button class="gap-2">
					<Mail class="h-4 w-4" />
					Pesan Individual
				</Button>
			</Link>
			<Link href="/testers/admin/messages/bulk">
				<Button variant="outline" class="gap-2">
					<Mail class="h-4 w-4" />
					Pesan Massal
				</Button>
			</Link>
		</div>
	</div>

	<Card>
		<CardHeader>
			<CardTitle>Riwayat Pesan</CardTitle>
		</CardHeader>
		<CardContent>
			<div class="overflow-x-auto">
				<table class="w-full">
					<thead>
						<tr class="border-b">
							<th class="px-4 py-2 text-left">Judul</th>
							<th class="px-4 py-2 text-left">Pesan</th>
							<th class="px-4 py-2 text-left">Tanggal Kirim</th>
							<th class="px-4 py-2 text-center">Aksi</th>
						</tr>
					</thead>
					<tbody>
						{#each messages.data as msg (msg.id)}
							<tr class="border-b hover:bg-gray-50">
								<td class="px-4 py-2 font-medium">{msg.title}</td>
								<td class="px-4 py-2 truncate max-w-xs">{msg.message}</td>
								<td class="px-4 py-2">{new Date(msg.created_at).toLocaleDateString('id-ID')}</td>
								<td class="px-4 py-2 text-center">
									<Button
										variant="destructive"
										size="sm"
										onclick={() => deleteMessage(msg.id)}
										class="gap-2"
									>
										<Trash2 class="h-4 w-4" />
									</Button>
								</td>
							</tr>
						{/each}
					</tbody>
				</table>
			</div>

			<div class="mt-6 flex justify-between items-center">
				<p class="text-sm text-muted-foreground">
					Menampilkan {messages.from}-{messages.to} dari {messages.total} pesan
				</p>
				<div class="flex gap-2">
					{#if messages.prev_page_url}
						<Link href={messages.prev_page_url}>
							<Button variant="outline">Sebelumnya</Button>
						</Link>
					{/if}
					{#if messages.next_page_url}
						<Link href={messages.next_page_url}>
							<Button variant="outline">Berikutnya</Button>
						</Link>
					{/if}
				</div>
			</div>
		</CardContent>
	</Card>
</div>
