import type { Alpine, AlpineData } from '../types/alpine';

export interface SidebarOptions {
    open?: boolean;
}

export interface SidebarState {
    toggleMobile(): void;
    closeMobile(): void;
    init(): void;
}

export function sidebar(Alpine: Alpine): void {
    Alpine.data('pegboardSidebar', (_options: SidebarOptions = {}): AlpineData<SidebarState> => ({
    toggleMobile() {
        const sidebar = this.$refs?.sidebar as HTMLElement;
        const isOpen = sidebar.dataset.open === 'true';
        sidebar.dataset.open = (!isOpen).toString();

        if (!isOpen) {
            sidebar.setAttribute('aria-hidden', 'false');
            sidebar.removeAttribute('inert');
        } else {
            sidebar.setAttribute('aria-hidden', 'true');
            sidebar.setAttribute('inert', '');
        }
    },

    closeMobile() {
        const sidebar = this.$refs?.sidebar as HTMLElement;
        sidebar.dataset.open = 'false';
        sidebar.setAttribute('aria-hidden', 'true');
        sidebar.setAttribute('inert', '');
    },

    init() {
        const sidebar = this.$refs?.sidebar as HTMLElement;

        const isMobile = window.innerWidth < 768;
        const isOpen = sidebar.dataset.open === 'true';

        if (isMobile && !isOpen) {
            sidebar.setAttribute('inert', '');
            sidebar.setAttribute('aria-hidden', 'true');
        } else {
            sidebar.removeAttribute('inert');
            sidebar.setAttribute('aria-hidden', 'false');
        }

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && sidebar.dataset.open === 'true') {
                this.closeMobile();
            }
        });

        const mediaQuery = window.matchMedia('(min-width: 768px)');
        mediaQuery.addEventListener('change', (e) => {
            if (e.matches && sidebar.dataset.open === 'true') {
                this.closeMobile();
            }

            if (e.matches) {
                sidebar.removeAttribute('inert');
                sidebar.setAttribute('aria-hidden', 'false');
            } else if (sidebar.dataset.open !== 'true') {
                sidebar.setAttribute('inert', '');
                sidebar.setAttribute('aria-hidden', 'true');
            }
        });
    },

    }));
}
