<script setup lang="ts">
import { onMounted, onUnmounted, ref } from 'vue';

const canvas = ref<HTMLCanvasElement | null>(null);
let frame = 0;
let stopped = false;

type Star = {
    x: number;
    y: number;
    radius: number;
    alpha: number;
    speed: number;
};

onMounted(() => {
    const element = canvas.value;
    const context = element?.getContext('2d');

    if (!element || !context) {
        return;
    }

    const reduceMotion = window.matchMedia(
        '(prefers-reduced-motion: reduce)',
    ).matches;
    let stars: Star[] = [];

    function resize(): void {
        const parent = element?.parentElement;

        if (!parent || !element || !context) {
            return;
        }

        const ratio = Math.min(window.devicePixelRatio || 1, 2);
        const width = parent.clientWidth;
        const height = parent.clientHeight;

        element.width = Math.floor(width * ratio);
        element.height = Math.floor(height * ratio);
        element.style.width = `${width}px`;
        element.style.height = `${height}px`;
        context.setTransform(ratio, 0, 0, ratio, 0, 0);

        const count = Math.min(90, Math.round((width * height) / 18000));

        stars = Array.from({ length: count }, () => ({
            x: Math.random() * width,
            y: Math.random() * height,
            radius: Math.random() * 1.15 + 0.3,
            alpha: Math.random() * 0.45 + 0.15,
            speed: Math.random() * 0.12 + 0.02,
        }));
    }

    function draw(time: number): void {
        if (stopped || !element || !context) {
            return;
        }

        const width = element.clientWidth;
        const height = element.clientHeight;

        context.clearRect(0, 0, width, height);

        for (const star of stars) {
            const twinkle = reduceMotion
                ? star.alpha
                : star.alpha * (0.65 + Math.sin(time / 900 + star.x) * 0.35);

            context.fillStyle = `rgba(184, 137, 61, ${twinkle.toFixed(3)})`;
            context.beginPath();
            context.arc(star.x, star.y, star.radius, 0, Math.PI * 2);
            context.fill();

            if (!reduceMotion) {
                star.y -= star.speed;

                if (star.y < -2) {
                    star.y = height + 2;
                }
            }
        }

        frame = window.requestAnimationFrame(draw);
    }

    resize();
    window.addEventListener('resize', resize);
    frame = window.requestAnimationFrame(draw);

    onUnmounted(() => {
        stopped = true;
        window.cancelAnimationFrame(frame);
        window.removeEventListener('resize', resize);
    });
});
</script>

<template>
    <canvas
        ref="canvas"
        class="pointer-events-none absolute inset-0 h-full w-full"
        aria-hidden="true"
    />
</template>
