<script setup lang="ts">
import { computed } from 'vue';
import {
    studioEmail,
    studioPhoneDisplay,
    studioPhoneTel,
} from '@/lib/studioContact';

const props = defineProps<{
    kind: 'email' | 'phone';
}>();

const label = computed(() =>
    props.kind === 'email' ? studioEmail() : studioPhoneDisplay(),
);

const href = computed(() =>
    props.kind === 'email'
        ? `mailto:${studioEmail()}`
        : `tel:${studioPhoneTel()}`,
);
</script>

<template>
    <a
        :href="href"
        class="text-ink underline decoration-star/80 underline-offset-4 transition hover:decoration-tide"
    >
        {{ label }}
    </a>
</template>
