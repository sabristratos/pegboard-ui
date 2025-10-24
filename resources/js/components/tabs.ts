import type { Alpine, AlpineData } from '../types/alpine';
import type { TabsOptions, TabsState } from '../types/components';

export function tabs(Alpine: Alpine): void {
    Alpine.data('pegboardTabs', (options: TabsOptions = {}): AlpineData<TabsState> => ({
        activeTab: options.initialTab || '',
        variant: options.variant || 'default',
        size: options.size || 'base',
        orientation: options.orientation || 'horizontal',
        tabButtons: [],
        markerEl: null,
        markerPositioned: false,
        showLeftFade: false,
        showRightFade: false,

        init() {
            this.$nextTick?.(() => {
                const buttons = this.$el?.querySelectorAll('[data-tab-name]');
                buttons?.forEach((button) => {
                    if (button instanceof HTMLElement) {
                        this.registerTab(button);
                    }
                });

                if (!this.activeTab && this.tabButtons.length > 0) {
                    const firstEnabledTab = this.tabButtons.find(
                        (btn: HTMLElement) => !btn.hasAttribute('disabled')
                    );
                    if (firstEnabledTab) {
                        this.activeTab = firstEnabledTab.getAttribute('data-tab-name') || '';
                    }
                }

                if (this.variant === 'segmented' || this.variant === 'pills') {
                    this.markerEl = this.$el?.querySelector('[data-tab-marker]') || null;
                    requestAnimationFrame(() => {
                        requestAnimationFrame(() => {
                            this.updateMarker();
                        });
                    });
                }

                this.updateScrollFades();
                this.$el?.addEventListener('scroll', () => {
                    this.updateScrollFades();
                });
            });
        },

        updateScrollFades() {
            const container = this.$el;
            if (!container) return;

            if (this.orientation === 'vertical') {
                const scrollTop = container.scrollTop;
                const scrollHeight = container.scrollHeight;
                const clientHeight = container.clientHeight;

                this.showLeftFade = scrollTop > 10;

                this.showRightFade = scrollTop < scrollHeight - clientHeight - 10;
            } else {
                const scrollLeft = container.scrollLeft;
                const scrollWidth = container.scrollWidth;
                const clientWidth = container.clientWidth;

                this.showLeftFade = scrollLeft > 10;

                this.showRightFade = scrollLeft < scrollWidth - clientWidth - 10;
            }
        },

        selectTab(name: string) {
            const tabButton = this.tabButtons.find(
                (btn: HTMLElement) => btn.getAttribute('data-tab-name') === name
            );

            if (tabButton && tabButton.hasAttribute('disabled')) {
                return;
            }

            this.activeTab = name;
            this.updateMarker();

            if (tabButton) {
                tabButton.focus();
            }
        },

        isActive(name: string): boolean {
            return this.activeTab === name;
        },

        registerTab(element: HTMLElement) {
            if (!this.tabButtons.includes(element)) {
                this.tabButtons.push(element);
            }
        },

        updateMarker() {
            if (!this.markerEl) return;

            const activeButton = this.tabButtons.find(
                (btn: HTMLElement) => btn.getAttribute('data-tab-name') === this.activeTab
            );

            if (activeButton) {
                this.repositionMarker(activeButton);
                this.markerPositioned = true;
            }
        },

        repositionMarker(tabButton: HTMLElement) {
            if (!this.markerEl) return;

            this.markerEl.style.width = `${tabButton.offsetWidth}px`;
            this.markerEl.style.height = `${tabButton.offsetHeight}px`;

            if (this.orientation === 'vertical') {
                this.markerEl.style.transform = `translateY(${tabButton.offsetTop}px)`;
            } else {
                this.markerEl.style.transform = `translateX(${tabButton.offsetLeft}px)`;
            }
        },

        handleKeydown(event: KeyboardEvent) {
            const key = event.key;

            const nextKeys = this.orientation === 'vertical'
                ? ['ArrowDown']
                : ['ArrowRight'];
            const prevKeys = this.orientation === 'vertical'
                ? ['ArrowUp']
                : ['ArrowLeft'];

            if (nextKeys.includes(key)) {
                event.preventDefault();
                this.navigateNext();
            } else if (prevKeys.includes(key)) {
                event.preventDefault();
                this.navigatePrevious();
            } else if (key === 'Home') {
                event.preventDefault();
                this.focusTab(0);
            } else if (key === 'End') {
                event.preventDefault();
                this.focusTab(this.tabButtons.length - 1);
            }
        },

        navigateNext() {
            const currentIndex = this.tabButtons.findIndex(
                (btn: HTMLElement) => btn.getAttribute('data-tab-name') === this.activeTab
            );

            let nextIndex = currentIndex + 1;
            while (nextIndex < this.tabButtons.length) {
                if (!this.tabButtons[nextIndex].hasAttribute('disabled')) {
                    this.focusTab(nextIndex);
                    return;
                }
                nextIndex++;
            }

            nextIndex = 0;
            while (nextIndex < currentIndex) {
                if (!this.tabButtons[nextIndex].hasAttribute('disabled')) {
                    this.focusTab(nextIndex);
                    return;
                }
                nextIndex++;
            }
        },

        navigatePrevious() {
            const currentIndex = this.tabButtons.findIndex(
                (btn: HTMLElement) => btn.getAttribute('data-tab-name') === this.activeTab
            );

            let prevIndex = currentIndex - 1;
            while (prevIndex >= 0) {
                if (!this.tabButtons[prevIndex].hasAttribute('disabled')) {
                    this.focusTab(prevIndex);
                    return;
                }
                prevIndex--;
            }

            prevIndex = this.tabButtons.length - 1;
            while (prevIndex > currentIndex) {
                if (!this.tabButtons[prevIndex].hasAttribute('disabled')) {
                    this.focusTab(prevIndex);
                    return;
                }
                prevIndex--;
            }
        },

        focusTab(index: number) {
            const tabButton = this.tabButtons[index];
            if (tabButton && !tabButton.hasAttribute('disabled')) {
                const tabName = tabButton.getAttribute('data-tab-name');
                if (tabName) {
                    this.selectTab(tabName);
                }
            }
        }
    }));
}
