<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import Reveal from '@/components/site/Reveal.vue';
import SiteButton from '@/components/site/SiteButton.vue';
import SiteMark from '@/components/site/SiteMark.vue';

const principles = [
    {
        title: 'Clarity before decoration',
        copy: 'A visitor should know where they are and what the company does before they notice the styling.',
    },
    {
        title: 'One idea on a page',
        copy: 'We would rather cut a section than make someone hold three claims in their head at once.',
    },
    {
        title: 'Speed as a courtesy',
        copy: 'A light page is a form of respect. We keep the interface quick on a phone and on a slow connection.',
    },
    {
        title: 'Words for people',
        copy: 'The sentences are written to be read. Search engines can follow along, they are not the audience.',
    },
];
</script>

<template>
    <Head title="About">
        <meta
            name="description"
            content="SiteStar is a small web studio. We design and build websites with clear structure, careful type, and durable Laravel engineering."
        />
    </Head>

    <section class="border-b border-line">
        <div class="mx-auto max-w-6xl px-5 py-20 md:py-28">
            <p
                class="text-xs font-medium tracking-[0.18em] text-tide uppercase"
            >
                About the studio
            </p>
            <h1
                class="mt-5 max-w-3xl font-display text-5xl leading-[1.05] font-semibold tracking-tight md:text-6xl"
            >
                We build sites for work that already matters.
            </h1>
            <div
                class="mt-8 grid gap-8 md:grid-cols-[1.3fr_0.7fr] md:items-end"
            >
                <p class="max-w-2xl text-lg leading-8 text-ink-soft">
                    SiteStar designs and builds websites for product companies,
                    studios, and technical teams. We prefer few pages, strong
                    type, and an interface that is still understandable a year
                    later.
                </p>
                <SiteMark
                    class="float-star size-10 text-star md:justify-self-end"
                />
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-6xl px-5 py-20 md:py-28">
        <div class="grid gap-12 md:grid-cols-2">
            <Reveal>
                <h2 class="font-display text-3xl font-semibold tracking-tight">
                    A short practice
                </h2>
                <div class="mt-5 space-y-4 text-base leading-7 text-ink-soft">
                    <p>
                        The studio stays small on purpose. A project has one
                        thread from the first conversation to the last revision,
                        so the work is not translated three times before it
                        reaches the page.
                    </p>
                    <p>
                        Much of our published work is for electronics and
                        instrument teams. Those sites taught us to treat a
                        technical subject as something a visitor can enter,
                        rather than a wall of claims.
                    </p>
                    <p>
                        We design in the browser and build with Laravel, Vue,
                        and Inertia. The result is a site you can edit, extend,
                        and trust.
                    </p>
                </div>
            </Reveal>
            <Reveal :delay="80">
                <div class="rounded-3xl border border-line bg-white p-8">
                    <p
                        class="text-xs font-medium tracking-[0.16em] text-tide uppercase"
                    >
                        What we leave out
                    </p>
                    <ul class="mt-5 space-y-4 text-sm leading-6 text-ink-soft">
                        <li class="border-t border-line pt-4">
                            Stock photographs of people who do not work here.
                        </li>
                        <li class="border-t border-line pt-4">
                            Pages that shout a promise the project cannot keep.
                        </li>
                        <li class="border-t border-line pt-4">
                            Forms that ask the visitor to prove they are human
                            with a puzzle, when a quieter check will do.
                        </li>
                    </ul>
                </div>
            </Reveal>
        </div>
    </section>

    <section class="border-y border-line bg-mist/50">
        <div class="mx-auto max-w-6xl px-5 py-20 md:py-28">
            <Reveal>
                <h2 class="font-display text-3xl font-semibold tracking-tight">
                    Principles
                </h2>
            </Reveal>
            <div class="mt-10 grid gap-6 md:grid-cols-2">
                <Reveal
                    v-for="(principle, index) in principles"
                    :key="principle.title"
                    :delay="index * 70"
                >
                    <article class="h-full border-t border-line pt-5">
                        <h3 class="font-display text-2xl font-semibold">
                            {{ principle.title }}
                        </h3>
                        <p class="mt-3 text-sm leading-6 text-ink-soft">
                            {{ principle.copy }}
                        </p>
                    </article>
                </Reveal>
            </div>
        </div>
    </section>

    <section
        class="mx-auto flex max-w-6xl flex-col items-start gap-6 px-5 py-20 md:flex-row md:items-center md:justify-between"
    >
        <h2 class="max-w-lg font-display text-4xl font-semibold tracking-tight">
            The work is the clearest introduction.
        </h2>
        <div class="flex flex-wrap gap-3">
            <SiteButton href="/portfolio">View the portfolio</SiteButton>
            <SiteButton href="/contact" variant="line">Contact</SiteButton>
        </div>
    </section>
</template>
