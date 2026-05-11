<script lang="ts">
    import type { PageProps } from '@inertiajs/svelte';
    import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';

    interface Props extends PageProps {
        title: string;
        scope: string;
        slug: string;
    }

    let { title, scope, slug }: Props = $props();
</script>

<div class="space-y-8">
    <div>
        <h1 class="text-3xl font-bold tracking-tight">{title}</h1>
        <p class="text-muted-foreground mt-2">Halaman {title} dalam pengembangan</p>
    </div>

    <Card>
        <CardHeader>
            <CardTitle>{title}</CardTitle>
            <CardDescription>Fitur ini akan segera tersedia</CardDescription>
        </CardHeader>
        <CardContent>
            <p class="text-sm text-muted-foreground">Halaman ini sedang dalam tahap pengembangan. Silakan kembali lagi nanti.</p>
        </CardContent>
    </Card>
</div>
