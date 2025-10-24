import type { Alpine as AlpineType } from 'alpinejs';

declare global {
    interface Window {
        Alpine: AlpineType;
    }

    const Alpine: AlpineType;
}

export type Alpine = AlpineType;

export interface AlpineComponent {
    $el: HTMLElement;
    $refs: Record<string, HTMLElement>;
    $store: AlpineType['store'];
    $watch: (property: string, callback: (value: any) => void) => void;
    $dispatch: (event: string, detail?: any) => void;
    $nextTick: (callback: () => void) => void;
    $root: HTMLElement;
    $data: Record<string, any>;
    $id: (name: string, key?: string | number) => string;
    $focus?: {
        focus: (el: HTMLElement) => void;
        within: (el: HTMLElement) => HTMLElement[];
        first: () => HTMLElement | null;
        last: () => HTMLElement | null;
        next: () => HTMLElement | null;
        previous: () => HTMLElement | null;
    };
}

export type ComponentFunction<T = Record<string, any>> = (this: AlpineComponent) => T;

export type AlpineData<T> = T & ThisType<T & AlpineComponent>;
