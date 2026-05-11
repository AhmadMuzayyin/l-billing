<script lang="ts">
    let { title, scope, slug } = $props<{
        title: string;
        scope: string;
        slug: string;
    }>();
</script>

<div class="space-y-3">
    <h1 class="text-2xl font-semibold">{title}</h1>
    <p class="text-muted-foreground">Phase 2A placeholder: {scope}/{slug}</p>
</div>
