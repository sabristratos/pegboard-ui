import type { Alpine } from '../types/alpine';
import type { AlpineData, RatingOptions, RatingState } from '../types/components';

export function rating(Alpine: Alpine): void {
    Alpine.data('pegboardRating', (options: RatingOptions = {}): AlpineData<RatingState> => ({
        maxStars: options.maxStars ?? 5,
        disabled: options.disabled ?? false,
        stars: 0,
        value: 0,

        init() {
            const input = this.$refs?.input as HTMLInputElement;
            if (input && input.value) {
                const initialValue = parseInt(input.value, 10);
                if (!isNaN(initialValue) && initialValue >= 0 && initialValue <= this.maxStars) {
                    this.value = initialValue;
                    this.stars = initialValue;
                }
            }
        },

        hoverStar(star: number) {
            if (this.disabled) {
                return;
            }

            this.stars = star;
        },

        resetHover() {
            if (this.disabled) {
                return;
            }

            this.stars = this.value;
        },

        rate(star: number) {
            if (this.disabled) {
                return;
            }

            this.stars = star;
            this.value = star;

            const input = this.$refs?.input as HTMLInputElement;
            if (input) {
                input.value = star.toString();
                input.dispatchEvent(new Event('input', { bubbles: true }));
                input.dispatchEvent(new Event('change', { bubbles: true }));
            }
        },

        reset() {
            if (this.disabled) {
                return;
            }

            this.value = 0;
            this.stars = 0;

            const input = this.$refs?.input as HTMLInputElement;
            if (input) {
                input.value = '';
                input.dispatchEvent(new Event('input', { bubbles: true }));
                input.dispatchEvent(new Event('change', { bubbles: true }));
            }
        },
    }));
}
