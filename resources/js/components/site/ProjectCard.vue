<script setup lang="ts">
import type { PortfolioProject } from '@/types/portfolio';

withDefaults(
    defineProps<{
        project: PortfolioProject;
        variant?: 'tile' | 'row';
        reverse?: boolean;
    }>(),
    {
        variant: 'tile',
        reverse: false,
    },
);
</script>

<template>
    <a
        :href="project.url"
        target="_blank"
        rel="noopener noreferrer"
        class="group block focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-tide"
        :class="
            variant === 'row'
                ? 'grid items-center gap-8 md:grid-cols-2'
                : 'h-full overflow-hidden rounded-3xl border border-line bg-white shadow-[0_16px_40px_-32px_rgba(22,26,34,0.6)] transition duration-300 hover:-translate-y-1'
        "
    >
        <div
            class="relative overflow-hidden bg-ink"
            :class="[
                variant === 'row' ? 'rounded-3xl' : 'aspect-[16/10]',
                reverse ? 'md:order-2' : '',
            ]"
        >
            <span
                class="card-rule absolute inset-x-0 top-0 z-10 h-0.5 bg-star"
                aria-hidden="true"
            />
            <img
                :src="project.image"
                alt=""
                class="h-full w-full object-cover transition duration-700 group-hover:scale-[1.04]"
                :class="
                    variant === 'row' ? 'aspect-[16/10]' : 'absolute inset-0'
                "
            />
        </div>

        <div
            :class="[
                variant === 'tile' ? 'p-6' : '',
                reverse ? 'md:order-1' : '',
            ]"
        >
            <p
                class="text-xs font-medium tracking-[0.16em] text-tide uppercase"
            >
                {{ project.discipline }}
            </p>
            <h3
                class="mt-3 font-display text-2xl font-semibold tracking-tight text-ink"
            >
                {{ project.title }}
            </h3>
            <p class="mt-3 text-sm leading-6 text-ink-soft">
                {{ project.summary }}
            </p>
            <p
                class="mt-5 inline-flex items-center gap-2 text-sm font-medium text-ink"
            >
                Visit the live site
                <span
                    aria-hidden="true"
                    class="transition duration-300 group-hover:translate-x-1"
                >
                    →
                </span>
                <span class="sr-only">(opens in a new tab)</span>
            </p>
        </div>
    </a>
</template>
