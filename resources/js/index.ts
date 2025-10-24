import '../css/pegboard.css';

import type { Alpine } from './types/alpine';
import mask from '@alpinejs/mask';
import polyfill from '@oddbird/css-anchor-positioning/fn';
import { input } from './components/input';
import { popover } from './components/popover';
import { textarea } from './components/textarea';
import { select } from './components/select';
import { autocomplete } from './components/autocomplete';
import { datepicker } from './components/datepicker';
import { timePicker } from './components/time-picker';
import { toast } from './components/toast';
import { radio } from './components/radio';
import { rating } from './components/rating';
import { checkbox } from './components/checkbox';
import { dropdown } from './components/dropdown';
import { menu } from './components/menu';
import { submenu } from './components/submenu';
import { modal } from './components/modal';
import { fileUpload } from './components/file-upload';
import { tabs } from './components/tabs';
import { editor } from './components/editor';
import { chart } from './components/chart';
import { range } from './components/range';
import { sidebar } from './components/sidebar';
import { sidebarSearch } from './components/sidebar-search';
import { timer } from './components/timer';
import { carousel } from './components/carousel';

export * from './types';
export * from './utils/helpers';

export function registerComponents(Alpine: Alpine): void {
    Alpine.plugin(mask);

    input(Alpine);
    popover(Alpine);
    textarea(Alpine);
    select(Alpine);
    autocomplete(Alpine);
    datepicker(Alpine);
    timePicker(Alpine);
    toast(Alpine);
    radio(Alpine);
    rating(Alpine);
    checkbox(Alpine);
    dropdown(Alpine);
    menu(Alpine);
    submenu(Alpine);
    modal(Alpine);
    fileUpload(Alpine);
    tabs(Alpine);
    editor(Alpine);
    chart(Alpine);
    range(Alpine);
    sidebar(Alpine);
    sidebarSearch(Alpine);
    timer(Alpine);
    carousel(Alpine);
}

if (typeof window !== 'undefined') {
    if (!('anchorName' in document.documentElement.style)) {
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => polyfill());
        } else {
            polyfill();
        }

        document.addEventListener('alpine:init', () => {
            setTimeout(() => polyfill(), 100);
        });
    }
}

if (typeof window !== 'undefined' && window.Alpine) {
    window.Alpine.plugin(registerComponents);
}

// Add Livewire morph tracking for debugging focus issues
if (typeof window !== 'undefined' && typeof (window as any).Livewire !== 'undefined') {
    document.addEventListener('livewire:init', () => {
        const Livewire = (window as any).Livewire;

        console.log('[Pegboard] Livewire initialized, adding morph hooks');

        // Track which element has focus before morphing
        let focusedBeforeMorph: Element | null = null;
        let cursorPositionBeforeMorph: number | null = null;

        Livewire.hook('morph', ({ el, component }: any) => {
            focusedBeforeMorph = document.activeElement;

            if (focusedBeforeMorph instanceof HTMLInputElement || focusedBeforeMorph instanceof HTMLTextAreaElement) {
                // Check all attributes since wire:model might have modifiers
                const hasLiveWireModel = Array.from(focusedBeforeMorph.attributes).some(
                    (attr: Attr) => attr.name.startsWith('wire:model') && attr.name.includes('.live')
                );

                // Only log for inputs with wire:model.live
                if (hasLiveWireModel) {
                    const wireModelAttr = Array.from(focusedBeforeMorph.attributes).find(
                        (attr: Attr) => attr.name.startsWith('wire:model')
                    );

                    cursorPositionBeforeMorph = focusedBeforeMorph.selectionStart;

                    console.log('[Pegboard] Before morph', {
                        focusedElement: focusedBeforeMorph.tagName,
                        inputId: focusedBeforeMorph.id,
                        wireModel: wireModelAttr?.name,
                        wireModelValue: wireModelAttr?.value,
                        wireKey: focusedBeforeMorph.getAttribute('wire:key'),
                        value: focusedBeforeMorph.value,
                        cursorPosition: cursorPositionBeforeMorph,
                        componentName: component?.name,
                    });
                }
            }
        });

        Livewire.hook('morph.updated', ({ el, component }: any) => {
            const focusedAfterMorph = document.activeElement;

            // Only log if we were tracking a live model input
            if (focusedBeforeMorph instanceof HTMLInputElement || focusedBeforeMorph instanceof HTMLTextAreaElement) {
                const hasLiveWireModel = Array.from(focusedBeforeMorph.attributes).some(
                    (attr: Attr) => attr.name.startsWith('wire:model') && attr.name.includes('.live')
                );

                if (hasLiveWireModel) {
                    console.log('[Pegboard] After morph', {
                        focusedBefore: focusedBeforeMorph?.tagName,
                        focusedAfter: focusedAfterMorph?.tagName,
                        focusPreserved: focusedBeforeMorph === focusedAfterMorph,
                        componentName: component?.name,
                    });

                    // Check if focus was lost from an input
                    if (focusedBeforeMorph !== focusedAfterMorph) {
                        console.warn('[Pegboard] ⚠️ Focus was lost during morph!', {
                            lostFrom: focusedBeforeMorph.id,
                            movedTo: focusedAfterMorph?.tagName || 'BODY',
                        });
                    }
                }
            }

            // Reset tracking
            focusedBeforeMorph = null;
            cursorPositionBeforeMorph = null;
        });
    });
}

export default registerComponents;
