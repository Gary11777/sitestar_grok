<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';
import SiteMark from '@/components/site/SiteMark.vue';

const props = withDefaults(
    defineProps<{
        href?: string;
        type?: 'button' | 'submit';
        variant?: 'solid' | 'line' | 'inverse';
        disabled?: boolean;
    }>(),
    {
        type: 'button',
        variant: 'solid',
        disabled: false,
    },
);

const classes = computed(() => {
    const shared = [
        'group inline-flex items-center justify-center gap-2 rounded-full px-5 py-2.5 text-sm font-medium',
        'transition duration-300',
        'focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-tide',
        'disabled:cursor-not-allowed disabled:opacity-60',
    ];

    if (props.variant === 'line') {
        shared.push(
            'border border-line bg-white/70 text-ink hover:border-star',
        );
    } else if (props.variant === 'inverse') {
        shared.push('bg-paper text-ink hover:bg-white');
    } else {
        shared.push('bg-ink text-paper hover:bg-tide');
    }

    return shared.join(' ');
});
</script>

<template>
    <Link v-if="href" :href="href" :class="classes">
        <slot />
        <SiteMark
            class="size-3.5 text-star transition duration-300 group-hover:translate-x-0.5 group-hover:rotate-12"
        />
    </Link>
    <button v-else :type="type" :disabled="disabled" :class="classes">
        <slot />
        <SiteMark
            class="size-3.5 text-star transition duration-300 group-hover:translate-x-0.5 group-hover:rotate-45"
        />
    </button>
</template>
