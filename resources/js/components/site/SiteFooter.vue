<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import ObfuscatedContact from '@/components/site/ObfuscatedContact.vue';
import SiteMark from '@/components/site/SiteMark.vue';

const year = new Date().getFullYear();

const links = [
    { label: 'Home', href: '/' },
    { label: 'About', href: '/about' },
    { label: 'Portfolio', href: '/portfolio' },
    { label: 'Contact', href: '/contact' },
];
</script>

<template>
    <footer class="border-t border-line bg-mist/40">
        <div
            class="mx-auto grid max-w-6xl gap-10 px-5 py-14 md:grid-cols-[1.4fr_1fr_1fr]"
        >
            <div>
                <Link href="/" class="inline-flex items-center gap-2 text-ink">
                    <SiteMark class="size-4 text-star" />
                    <span class="font-display text-lg font-semibold"
                        >SiteStar</span
                    >
                </Link>
                <p class="mt-4 max-w-sm text-sm leading-6 text-ink-soft">
                    A web studio in Belarus. We design and build sites that stay
                    clear after the launch week is over.
                </p>
            </div>

            <nav aria-label="Footer" class="flex flex-col gap-2 text-sm">
                <Link
                    v-for="link in links"
                    :key="link.href"
                    :href="link.href"
                    class="w-fit text-ink-soft transition hover:text-ink"
                >
                    {{ link.label }}
                </Link>
            </nav>

            <div class="text-sm">
                <p
                    class="text-xs font-medium tracking-[0.16em] text-tide uppercase"
                >
                    Studio
                </p>
                <p class="mt-3">
                    <ObfuscatedContact kind="email" />
                </p>
                <p class="mt-2">
                    <ObfuscatedContact kind="phone" />
                </p>
            </div>
        </div>
        <div
            class="mx-auto flex max-w-6xl items-center justify-between px-5 pb-8 text-xs text-ink-soft"
        >
            <p>© {{ year }} SiteStar</p>
        </div>
    </footer>
</template>
