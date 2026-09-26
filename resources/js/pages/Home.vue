<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { onMounted, onUnmounted, ref } from 'vue';
import ProjectCard from '@/components/site/ProjectCard.vue';
import Reveal from '@/components/site/Reveal.vue';
import SiteButton from '@/components/site/SiteButton.vue';
import SiteMark from '@/components/site/SiteMark.vue';
import StarField from '@/components/site/StarField.vue';
import { useParallax } from '@/composables/useParallax';
import type { PortfolioProject } from '@/types/portfolio';

defineProps<{
    projects: PortfolioProject[];
}>();

const hero = ref<HTMLElement | null>(null);
const { target: processBand, offset } = useParallax(42);

const services = [
    {
        index: '01',
        title: 'Interface',
        copy: 'Type, spacing, and a small set of colours. The page should be easy to enter and just as easy to remember.',
    },
    {
        index: '02',
        title: 'Engineering',
        copy: 'Laravel applications with a careful front end. Forms, content, and the unglamorous parts are built to last.',
    },
    {
        index: '03',
        title: 'Stewardship',
        copy: 'A launch is the start. We stay close for the revisions that keep a site honest after the first visitors arrive.',
    },
];

const steps = [
    {
        index: '01',
        title: 'Listen',
        copy: 'We start with the work itself: who it is for, what must be understood, and what can stay quiet.',
    },
    {
        index: '02',
        title: 'Frame',
        copy: 'A short map of pages and words, and the one idea the site should leave behind.',
    },
    {
        index: '03',
        title: 'Make',
        copy: 'Design and build stay in the same conversation, so the interface and the code agree.',
    },
    {
        index: '04',
        title: 'Hand over',
        copy: 'A site you can run, with notes you can use and a clear way to reach us afterwards.',
    },
];

function onPointerMove(event: PointerEvent): void {
    if (event.pointerType !== 'mouse' || !hero.value) {
        return;
    }

    const rect = hero.value.getBoundingClientRect();

    hero.value.style.setProperty('--glow-x', `${event.clientX - rect.left}px`);
    hero.value.style.setProperty('--glow-y', `${event.clientY - rect.top}px`);
}

onMounted(() => {
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        return;
    }

    hero.value?.addEventListener('pointermove', onPointerMove);
});

onUnmounted(() => {
    hero.value?.removeEventListener('pointermove', onPointerMove);
});
</script>

<template>
    <Head title="Web studio">
        <meta
            name="description"
            content="SiteStar is a web studio in Belarus. We design and build clear, lasting websites for companies that make real things."
        />
    </Head>

    <section ref="hero" class="relative overflow-hidden border-b border-line">
        <StarField />
        <div
            class="hero-glow pointer-events-none absolute inset-0"
            aria-hidden="true"
        />
        <div
            class="pointer-events-none absolute inset-x-0 bottom-0 h-24 bg-gradient-to-b from-transparent to-paper"
            aria-hidden="true"
        />

        <div
            class="relative mx-auto max-w-6xl px-5 pt-20 pb-16 md:pt-28 md:pb-24"
        >
            <p
                class="text-xs font-medium tracking-[0.18em] text-tide uppercase"
            >
                Web design and development
            </p>
            <h1
                class="mt-5 max-w-3xl font-display text-[2.7rem] leading-[1.02] font-semibold tracking-tight text-ink sm:text-6xl lg:text-7xl"
            >
                Sites that hold
                <span class="inline-flex items-end gap-3">
                    a steady light
                    <SiteMark
                        class="float-star mb-2 size-6 text-star sm:size-8"
                    />
                </span>
            </h1>
            <p class="mt-6 max-w-xl text-lg leading-8 text-ink-soft">
                SiteStar is a small studio. We design and build websites for
                companies whose work deserves a clear, lasting presentation.
            </p>
            <div class="mt-8 flex flex-wrap gap-3">
                <SiteButton href="/contact">Start a project</SiteButton>
                <SiteButton href="/portfolio" variant="line">
                    See the work
                </SiteButton>
            </div>

            <dl
                class="mt-16 grid gap-6 border-t border-line pt-6 sm:grid-cols-3"
            >
                <div>
                    <dt class="text-xs tracking-[0.16em] text-tide uppercase">
                        Studio
                    </dt>
                    <dd class="mt-2 font-display text-xl">Belarus</dd>
                </div>
                <div>
                    <dt class="text-xs tracking-[0.16em] text-tide uppercase">
                        Practice
                    </dt>
                    <dd class="mt-2 font-display text-xl">
                        Design and Laravel
                    </dd>
                </div>
                <div>
                    <dt class="text-xs tracking-[0.16em] text-tide uppercase">
                        Focus
                    </dt>
                    <dd class="mt-2 font-display text-xl">
                        Few pages, strong type
                    </dd>
                </div>
            </dl>
        </div>
    </section>

    <section class="mx-auto max-w-6xl px-5 py-20 md:py-28">
        <Reveal>
            <p
                class="text-xs font-medium tracking-[0.18em] text-tide uppercase"
            >
                What we do
            </p>
            <h2
                class="mt-3 max-w-xl font-display text-4xl font-semibold tracking-tight"
            >
                A quiet system, built with care.
            </h2>
        </Reveal>
        <div class="mt-10 grid gap-4 md:grid-cols-3">
            <Reveal
                v-for="(service, index) in services"
                :key="service.title"
                :delay="index * 80"
            >
                <article
                    class="h-full rounded-3xl border border-line bg-white p-6 transition duration-300 hover:-translate-y-1 hover:shadow-[0_18px_40px_-30px_rgba(22,26,34,0.55)]"
                >
                    <p class="font-display text-sm text-star">
                        {{ service.index }}
                    </p>
                    <h3 class="mt-6 font-display text-2xl font-semibold">
                        {{ service.title }}
                    </h3>
                    <p class="mt-3 text-sm leading-6 text-ink-soft">
                        {{ service.copy }}
                    </p>
                </article>
            </Reveal>
        </div>
    </section>

    <section class="border-y border-line bg-mist/50">
        <div class="mx-auto max-w-6xl px-5 py-20 md:py-28">
            <Reveal>
                <div class="flex flex-wrap items-end justify-between gap-4">
                    <div>
                        <p
                            class="text-xs font-medium tracking-[0.18em] text-tide uppercase"
                        >
                            Selected work
                        </p>
                        <h2
                            class="mt-3 font-display text-4xl font-semibold tracking-tight"
                        >
                            Recent sites
                        </h2>
                    </div>
                    <SiteButton href="/portfolio" variant="line">
                        All projects
                    </SiteButton>
                </div>
            </Reveal>
            <div class="mt-10 grid gap-5 lg:grid-cols-3">
                <Reveal
                    v-for="(project, index) in projects"
                    :key="project.slug"
                    :delay="index * 90"
                >
                    <ProjectCard :project="project" />
                </Reveal>
            </div>
        </div>
    </section>

    <section
        ref="processBand"
        class="relative mx-auto max-w-6xl px-5 py-20 md:py-28"
    >
        <div
            class="pointer-events-none absolute top-16 -right-4 hidden h-56 w-56 md:block"
            :style="{ transform: `translate3d(0, ${offset}px, 0)` }"
            aria-hidden="true"
        >
            <div
                class="orbit-spin relative h-full w-full rounded-full border border-star/50"
            >
                <span
                    class="absolute top-0 left-1/2 size-2 -translate-x-1/2 -translate-y-1/2 rounded-full bg-star"
                />
            </div>
        </div>

        <Reveal>
            <p
                class="text-xs font-medium tracking-[0.18em] text-tide uppercase"
            >
                How a project moves
            </p>
            <h2
                class="mt-3 max-w-xl font-display text-4xl font-semibold tracking-tight"
            >
                Four steps, one thread.
            </h2>
        </Reveal>
        <ol class="mt-10 grid gap-8 md:grid-cols-2">
            <Reveal
                v-for="(step, index) in steps"
                :key="step.index"
                :delay="index * 70"
            >
                <li class="border-t border-line pt-5">
                    <p class="font-display text-sm text-star">
                        {{ step.index }}
                    </p>
                    <h3 class="mt-3 font-display text-2xl font-semibold">
                        {{ step.title }}
                    </h3>
                    <p class="mt-2 max-w-md text-sm leading-6 text-ink-soft">
                        {{ step.copy }}
                    </p>
                </li>
            </Reveal>
        </ol>
    </section>

    <section class="bg-ink text-paper">
        <div
            class="mx-auto flex max-w-6xl flex-col items-start gap-6 px-5 py-20 md:flex-row md:items-end md:justify-between"
        >
            <div>
                <SiteMark class="size-6 text-star" />
                <h2
                    class="mt-5 max-w-lg font-display text-4xl font-semibold tracking-tight"
                >
                    Tell us about the site you want to make.
                </h2>
            </div>
            <SiteButton href="/contact" variant="inverse"
                >Write to the studio</SiteButton
            >
        </div>
    </section>
</template>
