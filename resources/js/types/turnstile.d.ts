export {};

declare global {
    interface TurnstileRenderOptions {
        sitekey: string;
        appearance?: 'always' | 'execute' | 'interaction-only';
        execution?: 'render' | 'execute';
        theme?: 'light' | 'dark' | 'auto';
        action?: string;
        callback?: (token: string) => void;
        'error-callback'?: () => void;
        'expired-callback'?: () => void;
    }

    interface TurnstileApi {
        ready: (callback: () => void) => void;
        render: (
            container: HTMLElement | string,
            options: TurnstileRenderOptions,
        ) => string;
        execute: (widget: HTMLElement | string) => void;
        reset: (widget?: HTMLElement | string) => void;
        remove: (widget: HTMLElement | string) => void;
    }

    interface Window {
        turnstile?: TurnstileApi;
    }
}
