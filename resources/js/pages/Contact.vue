<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import ContactForm from '@/components/site/ContactForm.vue';
import ObfuscatedContact from '@/components/site/ObfuscatedContact.vue';

defineProps<{
    siteKey: string | null;
    status: string | null;
}>();
</script>

<template>
    <Head title="Contact">
        <meta
            name="description"
            content="Write to SiteStar about a new website or a revision. The form is checked for abuse before it reaches the studio."
        />
        <link
            v-if="siteKey"
            rel="preconnect"
            href="https://challenges.cloudflare.com"
        />
    </Head>

    <section
        class="mx-auto grid max-w-6xl gap-14 px-5 py-20 md:grid-cols-[0.8fr_1.2fr] md:py-28"
    >
        <div>
            <p
                class="text-xs font-medium tracking-[0.18em] text-tide uppercase"
            >
                Contact
            </p>
            <h1
                class="mt-5 font-display text-5xl leading-[1.05] font-semibold tracking-tight"
            >
                Write a few lines.
            </h1>
            <p class="mt-6 text-base leading-7 text-ink-soft">
                A name, a link to what exists today, and the outcome you want
                are enough to begin. We read every note.
            </p>
            <dl class="mt-10 space-y-5 text-sm">
                <div>
                    <dt class="text-xs tracking-[0.16em] text-tide uppercase">
                        Email
                    </dt>
                    <dd class="mt-2">
                        <ObfuscatedContact kind="email" />
                    </dd>
                </div>
                <div>
                    <dt class="text-xs tracking-[0.16em] text-tide uppercase">
                        Phone
                    </dt>
                    <dd class="mt-2">
                        <ObfuscatedContact kind="phone" />
                    </dd>
                </div>
                <div>
                    <dt class="text-xs tracking-[0.16em] text-tide uppercase">
                        Studio
                    </dt>
                    <dd class="mt-2 text-ink">Belarus</dd>
                </div>
            </dl>
        </div>

        <div
            class="relative rounded-3xl border border-line bg-white p-6 shadow-[0_18px_50px_-36px_rgba(22,26,34,0.5)] md:p-8"
        >
            <ContactForm :site-key="siteKey" :status="status" />
        </div>
    </section>
</template>
