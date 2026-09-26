<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import ProjectCard from '@/components/site/ProjectCard.vue';
import Reveal from '@/components/site/Reveal.vue';
import type { PortfolioProject } from '@/types/portfolio';

defineProps<{
    projects: PortfolioProject[];
}>();
</script>

<template>
    <Head title="Portfolio">
        <meta
            name="description"
            content="Selected SiteStar projects, including Dimgent Technologies and the Garand 101 magnetometer site."
        />
    </Head>

    <section class="border-b border-line">
        <div class="mx-auto max-w-6xl px-5 py-20 md:py-24">
            <p
                class="text-xs font-medium tracking-[0.18em] text-tide uppercase"
            >
                Portfolio
            </p>
            <h1
                class="mt-5 max-w-3xl font-display text-5xl leading-[1.05] font-semibold tracking-tight md:text-6xl"
            >
                Sites for companies that build real things.
            </h1>
            <p class="mt-6 max-w-2xl text-lg leading-8 text-ink-soft">
                A short set of projects. Each one is live. The pictures here are
                original covers; the links open the work itself.
            </p>
        </div>
    </section>

    <section class="mx-auto max-w-6xl space-y-20 px-5 py-16 md:py-24">
        <Reveal
            v-for="(project, index) in projects"
            :key="project.slug"
            :delay="index * 40"
        >
            <ProjectCard
                :project="project"
                variant="row"
                :reverse="index % 2 === 1"
            />
        </Reveal>
    </section>
</template>
