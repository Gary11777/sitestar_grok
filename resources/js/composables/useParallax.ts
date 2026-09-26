import { onMounted, onUnmounted, ref, type Ref } from 'vue';

/**
 * A small vertical shift tied to how far a section has travelled
 * through the viewport. Reduced-motion visitors get a still element.
 */
export function useParallax(amount = 36): {
    target: Ref<HTMLElement | null>;
    offset: Ref<number>;
} {
    const target = ref<HTMLElement | null>(null);
    const offset = ref(0);
    let reduceMotion = false;

    function update(): void {
        const element = target.value;

        if (!element || reduceMotion) {
            return;
        }

        const rect = element.getBoundingClientRect();
        const viewport = window.innerHeight || 1;
        const progress = (viewport - rect.top) / (viewport + rect.height);

        offset.value = (progress - 0.5) * amount;
    }

    onMounted(() => {
        reduceMotion = window.matchMedia(
            '(prefers-reduced-motion: reduce)',
        ).matches;
        update();
        window.addEventListener('scroll', update, { passive: true });
        window.addEventListener('resize', update);
    });

    onUnmounted(() => {
        window.removeEventListener('scroll', update);
        window.removeEventListener('resize', update);
    });

    return { target, offset };
}
