import type { Alpine, AlpineData } from '../types/alpine';

export interface SidebarSearchOptions {
    debounceMs?: number;
    shortcut?: string[] | null;
}

export interface SidebarSearchState {
    searchQuery: string;
    showNoResults: boolean;
    shortcut: string[];
    keyboardShortcut: string;
    filterItems(): void;
    focusSearch(): void;
    clearSearch(): void;
    formatShortcutForDisplay(): string;
    matchesShortcut(event: KeyboardEvent): boolean;
    init(): void;
}

export function sidebarSearch(Alpine: Alpine): void {
    Alpine.data('pegboardSidebarSearch', (options: SidebarSearchOptions = {}): AlpineData<SidebarSearchState> => ({
        searchQuery: '',
        showNoResults: false,
        shortcut: [],
        keyboardShortcut: '',

        filterItems() {
            const query = this.searchQuery.toLowerCase().trim();

            const items = document.querySelectorAll('[data-sidebar-item]');
            const sections = document.querySelectorAll('[data-sidebar-section]');
            const detailsElements = document.querySelectorAll('details[data-sidebar-item]');

            if (!query) {
                this.showAllItems(items, sections, detailsElements);
                this.showNoResults = false;
                return;
            }

            let totalVisibleItems = 0;

            items.forEach((item) => {
                const itemElement = item as HTMLElement;
                const text = this.getItemText(itemElement);
                const matches = text.toLowerCase().includes(query);

                const parentDetails = itemElement.closest('details');
                const isNestedItem = parentDetails !== null;

                if (matches) {
                    itemElement.classList.remove('hidden');
                    totalVisibleItems++;

                    if (isNestedItem && parentDetails) {
                        parentDetails.classList.remove('hidden');
                        parentDetails.open = true;
                    }
                } else {
                    if (!this.hasMatchingChildren(itemElement, query)) {
                        itemElement.classList.add('hidden');

                        if (itemElement.tagName === 'DETAILS') {
                            (itemElement as HTMLDetailsElement).open = false;
                        }
                    } else {
                        itemElement.classList.remove('hidden');
                        if (itemElement.tagName === 'DETAILS') {
                            (itemElement as HTMLDetailsElement).open = true;
                        }
                        totalVisibleItems++;
                    }
                }
            });

            sections.forEach((section) => {
                const sectionElement = section as HTMLElement;
                const visibleItems = sectionElement.querySelectorAll(
                    '[data-sidebar-item]:not(.hidden)'
                );

                if (visibleItems.length === 0) {
                    sectionElement.classList.add('hidden');
                } else {
                    sectionElement.classList.remove('hidden');
                }
            });

            this.showNoResults = totalVisibleItems === 0;
        },

        getItemText(element: HTMLElement): string {
            if (element.tagName === 'DETAILS') {
                const summary = element.querySelector('summary [data-part="text"]');
                if (summary) {
                    return summary.textContent?.trim() || '';
                }
            }

            const textElement = element.querySelector('[data-part="text"]');
            if (textElement) {
                return textElement.textContent?.trim() || '';
            }

            return element.textContent?.trim() || '';
        },

        hasMatchingChildren(parentElement: HTMLElement, query: string): boolean {
            if (parentElement.tagName !== 'DETAILS') {
                return false;
            }

            const nestedItems = parentElement.querySelectorAll('[data-sidebar-item]');

            for (const nestedItem of Array.from(nestedItems)) {
                if (nestedItem === parentElement) continue;

                const text = this.getItemText(nestedItem as HTMLElement);
                if (text.toLowerCase().includes(query)) {
                    return true;
                }
            }

            return false;
        },

        showAllItems(
            items: NodeListOf<Element>,
            sections: NodeListOf<Element>,
            detailsElements: NodeListOf<Element>
        ) {
            items.forEach((item) => {
                (item as HTMLElement).classList.remove('hidden');
            });

            sections.forEach((section) => {
                (section as HTMLElement).classList.remove('hidden');
            });

            detailsElements.forEach((details) => {
                (details as HTMLDetailsElement).open = false;
            });
        },

        focusSearch() {
            const input = document.querySelector('[data-sidebar-search-input]') as HTMLInputElement;
            if (input) {
                input.focus();
                input.select();
            }
        },

        clearSearch() {
            this.searchQuery = '';
            this.filterItems();

            const input = document.querySelector('[data-sidebar-search-input]') as HTMLInputElement;
            if (input) {
                input.blur();
            }
        },

        formatShortcutForDisplay(): string {
            const isMac = navigator.platform.toUpperCase().indexOf('MAC') >= 0 ||
                          navigator.userAgent.toUpperCase().indexOf('MAC') >= 0;

            return this.shortcut.map((key: string, index: number) => {
                const isModifier = index < this.shortcut.length - 1;

                switch (key.toLowerCase()) {
                    case 'cmd':
                    case 'command':
                        return isMac ? '⌘' : 'Ctrl';
                    case 'ctrl':
                    case 'control':
                        return 'Ctrl';
                    case 'shift':
                        return isModifier ? 'Shift' : key.toUpperCase();
                    case 'alt':
                    case 'option':
                        return isMac && isModifier ? '⌥' : 'Alt';
                    default:
                        return key.toUpperCase();
                }
            }).join(isMac ? '' : '+');
        },

        matchesShortcut(event: KeyboardEvent): boolean {
            if (this.shortcut.length === 0) return false;

            const isMac = navigator.platform.toUpperCase().indexOf('MAC') >= 0 ||
                          navigator.userAgent.toUpperCase().indexOf('MAC') >= 0;

            const regularKey = this.shortcut[this.shortcut.length - 1].toLowerCase();

            if (event.key.toLowerCase() !== regularKey) {
                return false;
            }

            const modifiers = this.shortcut.slice(0, -1).map((k: string) => k.toLowerCase());

            for (const modifier of modifiers) {
                switch (modifier) {
                    case 'cmd':
                    case 'command':
                        if (isMac && !event.metaKey) return false;
                        if (!isMac && !event.ctrlKey) return false;
                        break;
                    case 'ctrl':
                    case 'control':
                        if (!event.ctrlKey) return false;
                        break;
                    case 'shift':
                        if (!event.shiftKey) return false;
                        break;
                    case 'alt':
                    case 'option':
                        if (!event.altKey) return false;
                        break;
                }
            }

            const expectedCtrl = modifiers.includes('ctrl') || modifiers.includes('control') ||
                                (!isMac && (modifiers.includes('cmd') || modifiers.includes('command')));
            const expectedMeta = isMac && (modifiers.includes('cmd') || modifiers.includes('command'));
            const expectedShift = modifiers.includes('shift');
            const expectedAlt = modifiers.includes('alt') || modifiers.includes('option');

            if (event.ctrlKey !== expectedCtrl) return false;
            if (event.metaKey !== expectedMeta) return false;
            if (event.shiftKey !== expectedShift) return false;
            if (event.altKey !== expectedAlt) return false;

            return true;
        },

        init() {
            this.$watch?.('searchQuery', () => {
                this.filterItems();
            });

            const isMac = navigator.platform.toUpperCase().indexOf('MAC') >= 0 ||
                          navigator.userAgent.toUpperCase().indexOf('MAC') >= 0;

            if (options.shortcut && options.shortcut.length > 0) {
                this.shortcut = options.shortcut;
            } else {
                this.shortcut = isMac ? ['cmd', 'k'] : ['ctrl', 'k'];
            }

            this.keyboardShortcut = this.formatShortcutForDisplay();

            document.addEventListener('keydown', (e) => {
                if (this.matchesShortcut(e)) {
                    e.preventDefault();
                    this.focusSearch();
                }

                if (e.key === 'Escape' && this.searchQuery) {
                    e.preventDefault();
                    this.clearSearch();
                }
            });
        },
    }));
}
