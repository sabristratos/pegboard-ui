declare global {
    interface Window {
        Alpine: Alpine;
    }
}

export interface AlpineComponent {
    $el: HTMLElement;
    $refs: Record<string, HTMLElement | HTMLElement[]>;
    $watch: (property: string, callback: (value: any) => void) => void;
    $nextTick: (callback: () => void) => void;
    $dispatch: (event: string, detail?: any) => void;
    $data: any;
    [key: string]: any;
}

export type AlpineData<T = any> = T & Partial<AlpineComponent>;

export type ComponentFunction<T = any> = (...args: any[]) => T;

export interface Alpine {
    data(name: string, callback: (...args: any[]) => any): void;
    store<T = any>(name: string): T;
    store<T = any>(name: string, value: T): T;
    bind(name: string, callback: () => any): void;
    plugin(callback: (Alpine: Alpine) => void): void;
    magic(name: string, callback: () => any): void;
    $data(el: HTMLElement): any;
}
