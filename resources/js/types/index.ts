export type { Alpine, AlpineComponent, ComponentFunction, AlpineData } from './alpine';
export type {
    PopoverOptions,
    PopoverPlacement,
    PopoverTrigger,
    PopoverState,
} from './components';

export interface PegboardConfig {
    prefix?: string;
    theme?: {
        colors?: Record<string, string>;
    };
}

export interface ComponentProps {
    [key: string]: any;
}
