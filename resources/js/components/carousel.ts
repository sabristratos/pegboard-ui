import type { Alpine, AlpineData } from '../types/alpine';
import type { CarouselOptions, CarouselState } from '../types/components';

export function carousel(Alpine: Alpine): void {
    Alpine.data('carousel', (options: CarouselOptions = {}): AlpineData<CarouselState> => ({
        currentIndex: 0,
        totalSlides: 0,
        isAutoPlaying: options.autoPlay ?? true,
        isPaused: false,
        isDragging: false,
        startX: 0,
        scrollLeft: 0,
        intervalId: null as number | null,
        canGoPrev: true,
        canGoNext: true,
        autoPlay: options.autoPlay ?? true,
        interval: options.interval ?? 5000,
        pauseOnHover: options.pauseOnHover ?? true,
        loop: options.loop ?? true,

        init() {
            this.$nextTick?.(() => {
                const container = this.$refs?.scrollContainer as HTMLElement;

                if (!container) {
                    return;
                }

                this.updateSlideCount();

                const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

                if (this.autoPlay && !prefersReducedMotion) {
                    this.startAutoPlay();
                } else if (prefersReducedMotion) {
                    this.isAutoPlaying = false;
                }

                this.setupGestures();

                this.updateNavigation();
            });
        },

        destroy() {
            this.stopAutoPlay();
        },

        updateSlideCount() {
            const container = this.$refs?.scrollContainer as HTMLElement;
            const slides = container.querySelectorAll('[data-carousel-item]');
            this.totalSlides = slides.length;
        },

        updateNavigation() {
            if (this.loop) {
                this.canGoPrev = true;
                this.canGoNext = true;
            } else {
                this.canGoPrev = this.currentIndex > 0;
                this.canGoNext = this.currentIndex < this.totalSlides - 1;
            }
        },

        next() {
            let nextIndex = this.currentIndex + 1;

            if (nextIndex >= this.totalSlides) {
                if (this.loop) {
                    nextIndex = 0;
                } else {
                    return;
                }
            }

            this.goTo(nextIndex);
        },

        prev() {
            let prevIndex = this.currentIndex - 1;

            if (prevIndex < 0) {
                if (this.loop) {
                    prevIndex = this.totalSlides - 1;
                } else {
                    return;
                }
            }

            this.goTo(prevIndex);
        },

        goTo(index: number) {
            if (index < 0 || index >= this.totalSlides) {
                return;
            }

            const container = this.$refs?.scrollContainer as HTMLElement;
            const slides = container.querySelectorAll('[data-carousel-item]');
            const targetSlide = slides[index] as HTMLElement;

            if (!targetSlide) {
                return;
            }

            const scrollLeft = targetSlide.offsetLeft - (container.clientWidth / 2) + (targetSlide.clientWidth / 2);

            container.scrollTo({
                left: scrollLeft,
                behavior: window.matchMedia('(prefers-reduced-motion: reduce)').matches ? 'auto' : 'smooth',
            });

            this.currentIndex = index;
            this.updateNavigation();

            if (this.isAutoPlaying && !this.isPaused) {
                this.restartAutoPlay();
            }
        },

        onScroll() {
            const container = this.$refs?.scrollContainer as HTMLElement;
            const slides = container.querySelectorAll('[data-carousel-item]');

            let closestIndex = 0;
            let closestDistance = Infinity;

            const containerRect = container.getBoundingClientRect();
            const containerCenter = containerRect.left + containerRect.width / 2;

            slides.forEach((slide, index) => {
                const slideRect = slide.getBoundingClientRect();
                const slideCenter = slideRect.left + slideRect.width / 2;
                const distance = Math.abs(containerCenter - slideCenter);

                if (distance < closestDistance) {
                    closestDistance = distance;
                    closestIndex = index;
                }
            });

            if (this.currentIndex !== closestIndex) {
                this.currentIndex = closestIndex;
                this.updateNavigation();
            }
        },

        startAutoPlay() {
            if (this.intervalId !== null) {
                return;
            }

            this.intervalId = window.setInterval(() => {
                if (!this.isPaused) {
                    this.next();
                }
            }, this.interval);
        },

        stopAutoPlay() {
            if (this.intervalId !== null) {
                window.clearInterval(this.intervalId);
                this.intervalId = null;
            }
        },

        restartAutoPlay() {
            this.stopAutoPlay();
            this.startAutoPlay();
        },

        pause() {
            if (this.isAutoPlaying) {
                this.isPaused = true;
            }
        },

        resume() {
            if (this.isAutoPlaying) {
                this.isPaused = false;
            }
        },

        setupGestures() {
            const container = this.$refs?.scrollContainer as HTMLElement;

            let startX = 0;
            let scrollLeft = 0;
            let isDragging = false;

            container.addEventListener('pointerdown', (e: PointerEvent) => {
                if (e.button !== 0) return;

                isDragging = true;
                startX = e.pageX - container.offsetLeft;
                scrollLeft = container.scrollLeft;

                container.style.cursor = 'grabbing';
                container.style.userSelect = 'none';
            });

            container.addEventListener('pointermove', (e: PointerEvent) => {
                if (!isDragging) return;

                e.preventDefault();

                const x = e.pageX - container.offsetLeft;
                const walk = (x - startX) * 2;
                container.scrollLeft = scrollLeft - walk;
            });

            const endDrag = () => {
                if (!isDragging) return;

                isDragging = false;
                container.style.cursor = 'grab';
                container.style.userSelect = '';
            };

            container.addEventListener('pointerup', endDrag);
            container.addEventListener('pointerleave', endDrag);
        },
    }));
}
