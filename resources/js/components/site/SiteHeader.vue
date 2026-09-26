<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { onMounted, onUnmounted, ref, watch } from 'vue';
import SiteButton from '@/components/site/SiteButton.vue';
import SiteMark from '@/components/site/SiteMark.vue';

const page = usePage();
const open = ref(false);

const links = [
    { label: 'Home', href: '/' },
    { label: 'About', href: '/about' },
    { label: 'Portfolio', href: '/portfolio' },
];

function isCurrent(path: string): boolean {
    const url = page.url.split('?')[0] ?? '/';

    return path === '/' ? url === '/' : url.startsWith(path);
}

function onKeydown(event: KeyboardEvent): void {
    if (event.key === 'Escape') {
        open.value = false;
    }
}

watch(open, (value) => {
    document.body.style.overflow = value ? 'hidden' : '';
});

watch(
    () => page.url,
    () => {
        open.value = false;
    },
);

onMounted(() => {
    window.addEventListener('keydown', onKeydown);
});

onUnmounted(() => {
    window.removeEventListener('keydown', onKeydown);
    document.body.style.overflow = '';
});
</script>

<template>
    <header
        class="sticky top-0 z-40 border-b border-line/80 bg-paper/85 backdrop-blur-md"
    >
        <div
            class="mx-auto flex h-16 max-w-6xl items-center justify-between gap-4 px-5"
        >
            <Link
                href="/"
                class="inline-flex items-center gap-2 text-ink"
                aria-label="SiteStar, home"
            >
                <SiteMark class="size-4 text-star" />
                <span class="font-display text-lg font-semibold tracking-tight">
                    SiteStar
                </span>
            </Link>

            <nav class="hidden items-center gap-7 md:flex" aria-label="Primary">
                <Link
                    v-for="link in links"
                    :key="link.href"
                    :href="link.href"
                    class="text-sm text-ink-soft transition hover:text-ink"
                    :class="{ 'text-ink': isCurrent(link.href) }"
                    :aria-current="isCurrent(link.href) ? 'page' : undefined"
                >
                    {{ link.label }}
                </Link>
            </nav>

            <div class="flex items-center gap-2">
                <div class="hidden md:block">
                    <SiteButton href="/contact">Start a project</SiteButton>
                </div>
                <button
                    type="button"
                    class="inline-flex size-10 items-center justify-center rounded-full border border-line md:hidden"
                    :aria-expanded="open"
                    aria-controls="mobile-nav"
                    @click="open = !open"
                >
                    <span class="sr-only">
                        {{ open ? 'Close menu' : 'Open menu' }}
                    </span>
                    <svg
                        viewBox="0 0 16 16"
                        class="size-4"
                        fill="none"
                        aria-hidden="true"
                    >
                        <path
                            v-if="open"
                            d="M3.5 3.5 L12.5 12.5 M12.5 3.5 L3.5 12.5"
                            stroke="currentColor"
                            stroke-width="1.5"
                            stroke-linecap="round"
                        />
                        <path
                            v-else
                            d="M2 4.5 H14 M2 11.5 H14"
                            stroke="currentColor"
                            stroke-width="1.5"
                            stroke-linecap="round"
                        />
                    </svg>
                </button>
            </div>
        </div>

        <div
            v-if="open"
            id="mobile-nav"
            class="border-t border-line bg-paper md:hidden"
        >
            <nav
                class="mx-auto flex max-w-6xl flex-col px-5 py-4"
                aria-label="Mobile"
            >
                <Link
                    v-for="link in [
                        ...links,
                        { label: 'Contact', href: '/contact' },
                    ]"
                    :key="link.href"
                    :href="link.href"
                    class="border-b border-line/80 py-3 font-display text-2xl text-ink"
                    :aria-current="isCurrent(link.href) ? 'page' : undefined"
                >
                    {{ link.label }}
                </Link>
            </nav>
        </div>
    </header>
</template>
