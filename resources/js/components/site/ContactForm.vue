<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { computed, onMounted, onUnmounted, ref } from 'vue';

const props = defineProps<{
    siteKey: string | null;
    status: string | null;
}>();

const form = useForm({
    name: '',
    email: '',
    phone: '',
    subject: '',
    message: '',
    company_url: '',
    turnstile_token: '',
});

const turnstileEl = ref<HTMLElement | null>(null);
const widgetId = ref<string | null>(null);
const pendingSubmit = ref(false);
const checkError = ref('');

const generalError = computed((): string | undefined => {
    const errors = form.errors as unknown as Record<string, string | undefined>;

    return errors.form;
});

const fieldClass =
    'w-full rounded-2xl border border-line bg-white px-4 py-3 text-base text-ink shadow-[0_1px_0_rgba(22,26,34,0.04)] transition placeholder:text-ink-soft/60 focus:border-tide focus:outline-none';

function loadTurnstile(): Promise<void> {
    if (window.turnstile) {
        return Promise.resolve();
    }

    return new Promise((resolve, reject) => {
        const existing = document.querySelector<HTMLScriptElement>(
            'script[data-turnstile]',
        );

        if (existing) {
            existing.addEventListener('load', () => resolve(), { once: true });
            existing.addEventListener('error', () => reject(), { once: true });

            return;
        }

        const script = document.createElement('script');
        script.src =
            'https://challenges.cloudflare.com/turnstile/v0/api.js?render=explicit';
        script.async = true;
        script.defer = true;
        script.dataset.turnstile = 'true';
        script.onload = () => resolve();
        script.onerror = () => reject(new Error('Turnstile failed to load'));
        document.head.appendChild(script);
    });
}

function postForm(): void {
    form.post('/contact', {
        preserveScroll: true,
        onFinish: () => {
            pendingSubmit.value = false;
        },
        onSuccess: () => {
            form.reset();

            if (widgetId.value) {
                window.turnstile?.reset(widgetId.value);
            }
        },
        onError: () => {
            form.turnstile_token = '';

            if (widgetId.value) {
                window.turnstile?.reset(widgetId.value);
            }
        },
    });
}

function submit(): void {
    checkError.value = '';

    if (form.processing || pendingSubmit.value) {
        return;
    }

    if (!props.siteKey) {
        postForm();

        return;
    }

    if (!widgetId.value || !window.turnstile) {
        checkError.value =
            'The bot check is still loading. Please try again in a moment.';

        return;
    }

    // Invisible mode runs on submit. The token arrives in the callback below.
    pendingSubmit.value = true;
    window.turnstile.execute(widgetId.value);
}

onMounted(async () => {
    if (!props.siteKey) {
        return;
    }

    try {
        await loadTurnstile();
    } catch {
        checkError.value =
            'The bot check could not be loaded. Please try again in a moment.';

        return;
    }

    window.turnstile?.ready(() => {
        if (!turnstileEl.value || !window.turnstile || !props.siteKey) {
            return;
        }

        widgetId.value = window.turnstile.render(turnstileEl.value, {
            sitekey: props.siteKey,
            appearance: 'interaction-only',
            execution: 'execute',
            theme: 'light',
            action: 'contact',
            callback: (token: string) => {
                form.turnstile_token = token;

                if (pendingSubmit.value) {
                    postForm();
                }
            },
            'error-callback': () => {
                pendingSubmit.value = false;
                checkError.value =
                    'The bot check could not be completed. Please try again.';
            },
            'expired-callback': () => {
                form.turnstile_token = '';
            },
        });
    });
});

onUnmounted(() => {
    if (widgetId.value) {
        window.turnstile?.remove(widgetId.value);
    }
});
</script>

<template>
    <form class="space-y-5" novalidate @submit.prevent="submit">
        <div
            v-if="status === 'sent'"
            role="status"
            class="rounded-2xl border border-tide/20 bg-tide/5 px-4 py-3 text-sm text-tide"
        >
            Thank you. Your note is on its way, and we will reply from the
            studio.
        </div>

        <div
            v-if="generalError || checkError"
            role="alert"
            class="rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800"
        >
            {{ generalError || checkError }}
        </div>

        <!--
            Honeypot. Left in the document for simple bots, kept out of view
            and out of the tab order for people.
        -->
        <div
            class="absolute -left-[10000px] h-0 w-0 overflow-hidden"
            aria-hidden="true"
        >
            <label for="company_url">Website</label>
            <input
                id="company_url"
                v-model="form.company_url"
                type="text"
                name="company_url"
                tabindex="-1"
                autocomplete="off"
            />
        </div>

        <div class="grid gap-5 sm:grid-cols-2">
            <div>
                <label for="name" class="mb-2 block text-sm font-medium"
                    >Name</label
                >
                <input
                    id="name"
                    v-model="form.name"
                    name="name"
                    type="text"
                    autocomplete="name"
                    required
                    maxlength="120"
                    :class="fieldClass"
                />
                <p v-if="form.errors.name" class="mt-2 text-sm text-red-700">
                    {{ form.errors.name }}
                </p>
            </div>
            <div>
                <label for="email" class="mb-2 block text-sm font-medium"
                    >Email</label
                >
                <input
                    id="email"
                    v-model="form.email"
                    name="email"
                    type="email"
                    autocomplete="email"
                    required
                    maxlength="255"
                    :class="fieldClass"
                />
                <p v-if="form.errors.email" class="mt-2 text-sm text-red-700">
                    {{ form.errors.email }}
                </p>
            </div>
        </div>

        <div class="grid gap-5 sm:grid-cols-2">
            <div>
                <label for="phone" class="mb-2 block text-sm font-medium">
                    Phone
                    <span class="font-normal text-ink-soft">(optional)</span>
                </label>
                <input
                    id="phone"
                    v-model="form.phone"
                    name="phone"
                    type="tel"
                    autocomplete="tel"
                    maxlength="40"
                    :class="fieldClass"
                />
                <p v-if="form.errors.phone" class="mt-2 text-sm text-red-700">
                    {{ form.errors.phone }}
                </p>
            </div>
            <div>
                <label for="subject" class="mb-2 block text-sm font-medium"
                    >Subject</label
                >
                <input
                    id="subject"
                    v-model="form.subject"
                    name="subject"
                    type="text"
                    required
                    maxlength="160"
                    :class="fieldClass"
                />
                <p v-if="form.errors.subject" class="mt-2 text-sm text-red-700">
                    {{ form.errors.subject }}
                </p>
            </div>
        </div>

        <div>
            <label for="message" class="mb-2 block text-sm font-medium"
                >Message</label
            >
            <textarea
                id="message"
                v-model="form.message"
                name="message"
                required
                minlength="10"
                maxlength="5000"
                rows="6"
                :class="fieldClass"
            />
            <p v-if="form.errors.message" class="mt-2 text-sm text-red-700">
                {{ form.errors.message }}
            </p>
        </div>

        <div ref="turnstileEl" />
        <p v-if="form.errors.turnstile_token" class="text-sm text-red-700">
            {{ form.errors.turnstile_token }}
        </p>

        <button
            type="submit"
            class="group inline-flex items-center justify-center gap-2 rounded-full bg-ink px-5 py-2.5 text-sm font-medium text-paper transition duration-300 hover:bg-tide focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-tide disabled:cursor-not-allowed disabled:opacity-60"
            :disabled="form.processing || pendingSubmit"
        >
            {{
                pendingSubmit
                    ? 'Confirming…'
                    : form.processing
                      ? 'Sending…'
                      : 'Send the note'
            }}
        </button>
    </form>
</template>
