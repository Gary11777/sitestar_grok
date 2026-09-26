<script setup lang="ts">
import { onMounted, onUnmounted, ref } from 'vue';

const props = withDefaults(
    defineProps<{
        delay?: number;
    }>(),
    {
        delay: 0,
    },
);

const root = ref<HTMLElement | null>(null);
const visible = ref(false);
let observer: IntersectionObserver | null = null;

onMounted(() => {
    const element = root.value;

    if (!element) {
        return;
    }

    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        visible.value = true;

        return;
    }

    observer = new IntersectionObserver(
        (entries) => {
            if (entries.some((entry) => entry.isIntersecting)) {
                visible.value = true;
                observer?.disconnect();
            }
        },
        { threshold: 0.16 },
    );

    observer.observe(element);
});

onUnmounted(() => {
    observer?.disconnect();
});
</script>

<template>
    <div
        ref="root"
        class="reveal"
        :class="{ 'is-visible': visible }"
        :style="{ transitionDelay: `${props.delay}ms` }"
    >
        <slot />
    </div>
</template>
