<script lang="ts">
    import { Link, page } from '@inertiajs/svelte';
    import BarChart3 from 'lucide-svelte/icons/bar-chart-3';
    import BookOpen from 'lucide-svelte/icons/book-open';
    import Clock from 'lucide-svelte/icons/clock';
    import CreditCard from 'lucide-svelte/icons/credit-card';
    import FileText from 'lucide-svelte/icons/file-text';
    import FolderGit2 from 'lucide-svelte/icons/folder-git-2';
    import History from 'lucide-svelte/icons/history';
    import LayoutDashboard from 'lucide-svelte/icons/layout-dashboard';
    import LayoutGrid from 'lucide-svelte/icons/layout-grid';
    import ListOrdered from 'lucide-svelte/icons/list-ordered';
    import Mail from 'lucide-svelte/icons/mail';
    import Map from 'lucide-svelte/icons/map';
    import Network from 'lucide-svelte/icons/network';
    import Radio from 'lucide-svelte/icons/radio';
    import Settings from 'lucide-svelte/icons/settings';
    import ShoppingCart from 'lucide-svelte/icons/shopping-cart';
    import Ticket from 'lucide-svelte/icons/ticket';
    import Users from 'lucide-svelte/icons/users';
    import Users2 from 'lucide-svelte/icons/users-2';
    import Wifi from 'lucide-svelte/icons/wifi';
    import Zap from 'lucide-svelte/icons/zap';
    import type { Snippet } from 'svelte';
    import AppLogo from '@/components/AppLogo.svelte';
    import NavFooter from '@/components/NavFooter.svelte';
    import NavMain from '@/components/NavMain.svelte';
    import NavUser from '@/components/NavUser.svelte';
    import {
        Sidebar,
        SidebarContent,
        SidebarFooter,
        SidebarHeader,
        SidebarMenu,
        SidebarMenuButton,
        SidebarMenuItem,
    } from '@/components/ui/sidebar';
    import { dashboard } from '@/routes';
    import type { NavItem } from '@/types';

    let {
        children,
    }: {
        children?: Snippet;
    } = $props();

    const iconMap: Record<string, any> = {
        LayoutDashboard,
        Users,
        Zap,
        Wifi,
        Map,
        BarChart3,
        Mail,
        Network,
        Radio,
        FileText,
        Settings,
        ListOrdered,
        'list-numbers': ListOrdered,
        Users2,
        Ticket,
        CreditCard,
        ShoppingCart,
        History,
        Clock,
    };

    function resolveIcon(iconName?: string) {
        if (!iconName) return LayoutGrid;
        return iconMap[iconName] || LayoutGrid;
    }

    const dashboardUrl = $derived(dashboard());

    const mainNavItems = $derived<NavItem[]>([
        {
            title: 'Dashboard',
            href: dashboardUrl,
            icon: LayoutGrid,
        },
    ]);

    const legacyMenuItems = $derived<NavItem[]>(
        ((page.props.menuItems as Array<{ title: string; href: string; icon?: string }> | undefined) ?? []).map((item) => ({
            title: item.title,
            href: item.href,
            icon: resolveIcon(item.icon),
        })),
    );

    const navItems = $derived<NavItem[]>(legacyMenuItems.length > 0 ? legacyMenuItems : mainNavItems);

    const footerNavItems: NavItem[] = [
        {
            title: 'Repository',
            href: 'https://github.com/laravel/svelte-starter-kit',
            icon: FolderGit2,
        },
        {
            title: 'Documentation',
            href: 'https://laravel.com/docs/starter-kits#svelte',
            icon: BookOpen,
        },
    ];
</script>

<Sidebar collapsible="icon" variant="inset">
    <SidebarHeader>
        <SidebarMenu>
            <SidebarMenuItem>
                <SidebarMenuButton size="lg" asChild>
                    {#snippet children(props)}
                        <Link
                            {...props}
                            href={dashboardUrl}
                            class={props.class}
                        >
                            <AppLogo />
                        </Link>
                    {/snippet}
                </SidebarMenuButton>
            </SidebarMenuItem>
        </SidebarMenu>
    </SidebarHeader>

    <SidebarContent>
        <NavMain items={navItems} />
    </SidebarContent>

    <SidebarFooter>
        <NavFooter items={footerNavItems} />
        <NavUser />
    </SidebarFooter>
</Sidebar>
{@render children?.()}
