<script lang="ts">
	import { Link, Form } from '@inertiajs/svelte';
	import { Mail, ChevronLeft, ChevronRight, Trash2 } from 'lucide-svelte';
	import { Button } from '@/components/ui/button';
	import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';

	let { inbox, unread_count }: { inbox: any; unread_count: number } = $props();

	function formatDate(date: string): string {
		return new Date(date).toLocaleDateString('id-ID', {
			year: 'numeric',
			month: 'long',
			day: 'numeric',
			hour: '2-digit',
			minute: '2-digit'
		});
	}

	function truncateText(text: string, length: number = 100): string {
		return text.length > length ? text.substring(0, length) + '...' : text;
	}
</script>

<div class="space-y-6">
	<div class="flex items-center justify-between">
		<div>
			<h1 class="text-3xl font-bold tracking-tight">Pesan Masuk</h1>
			<p class="text-muted-foreground mt-2">
				{unread_count} pesan belum dibaca
			</p>
		</div>
	</div>

	<Card>
		<CardHeader>
			<CardTitle className="flex items-center gap-2">
				<Mail className="w-5 h-5" />
				Daftar Pesan
			</CardTitle>
			<CardDescription>Kelola pesan-pesan Anda</CardDescription>
		</CardHeader>
		<CardContent>
			{#if inbox.data && inbox.data.length > 0}
				<div className="space-y-3">
					{#each inbox.data as message}
						<div className="flex items-center justify-between p-3 border rounded-lg hover:bg-muted/50 transition">
							<Link href={route('legacy.customer.inbox.show', message.id)} className="flex-1">
								<div className="space-y-1">
									<p className={`font-medium ${!message.date_read ? 'font-bold' : ''}`}>
										{message.title}
									</p>
									<p className="text-sm text-muted-foreground">
										{truncateText(message.message, 80)}
									</p>
									<p className="text-xs text-muted-foreground">
										{formatDate(message.created_at)}
									</p>
								</div>
							</Link>
							<Form method="POST" action={route('legacy.customer.inbox.delete', message.id)}>
								<Button variant="ghost" size="icon">
									<Trash2 className="w-4 h-4" />
								</Button>
							</Form>
						</div>
					{/each}
				</div>

				<!-- Pagination -->
				<div className="flex items-center justify-between mt-6 pt-6 border-t">
					<p className="text-sm text-muted-foreground">
						Halaman {inbox.current_page} dari {inbox.last_page}
					</p>
					<div className="flex gap-2">
						{#if inbox.prev_page_url}
							<Link href={inbox.prev_page_url}>
								<Button variant="outline" size="icon">
									<ChevronLeft className="w-4 h-4" />
								</Button>
							</Link>
						{/if}
						{#if inbox.next_page_url}
							<Link href={inbox.next_page_url}>
								<Button variant="outline" size="icon">
									<ChevronRight className="w-4 h-4" />
								</Button>
							</Link>
						{/if}
					</div>
				</div>
			{:else}
				<div className="text-center py-8">
					<Mail className="w-12 h-12 mx-auto text-muted-foreground mb-3" />
					<p className="text-muted-foreground">Tidak ada pesan</p>
				</div>
			{/if}
		</CardContent>
	</Card>
</div>
