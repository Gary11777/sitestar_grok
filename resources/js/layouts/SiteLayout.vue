<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import SiteFooter from '@/components/site/SiteFooter.vue';
import SiteHeader from '@/components/site/SiteHeader.vue';
</script>

<template>
    <div
        class="site min-h-screen overflow-x-hidden bg-paper text-ink antialiased"
    >
        <Head>
            <meta name="theme-color" content="#f3f0e8" />
        </Head>
        <a
            href="#content"
            class="sr-only focus:not-sr-only focus:absolute focus:top-3 focus:left-3 focus:z-50 focus:rounded-full focus:bg-ink focus:px-4 focus:py-2 focus:text-paper"
        >
            Skip to content
        </a>
        <SiteHeader />
        <main id="content">
            <slot />
        </main>
        <SiteFooter />
    </div>
</template>
