import type { Alpine, AlpineData } from '../types/alpine';
import type { RangeOptions, RangeState, RangeThumb } from '../types/components';

export function range(Alpine: Alpine): void {
    Alpine.data('pegboardRange', (options: RangeOptions = {}): AlpineData<RangeState> => ({
        min: options.min ?? 0,
        max: options.max ?? 100,
        step: options.step ?? 1,
        orientation: options.orientation ?? 'horizontal',
        isRange: options.isRange ?? false,
        formatOptions: options.formatOptions ?? null,

        value: options.initialValue ?? (options.isRange ? [options.min ?? 0, options.max ?? 100] : options.min ?? 0) as number | number[],
        thumbsState: [] as RangeThumb[],
        draggingThumbIndex: null as number | null,
        isDragging: false,
        _pendingValue: undefined as number | undefined,
        isInitialized: false as boolean,
        rangeId: options.rangeId ?? '',
        thumbInputIds: [] as string[],
        tooltipValue: '' as string,
        tooltipVisible: false as boolean,

        init() {
            if (!this.rangeId) {
                this.rangeId = 'range-' + Math.random().toString(36).substr(2, 9);
            }

            this.thumbsState = (options.thumbs || []).map((thumb, _index) => ({
                value: thumb.value,
                percentage: thumb.percentage,
                dragging: false,
            }));

            this.thumbInputIds = this.thumbsState.map((_: RangeThumb, index: number) =>
                `${this.rangeId}-thumb-${index}`
            );

            this.$watch?.('value', (newValue: number | number[]) => {
                if (this.isDragging || this.draggingThumbIndex !== null) return;
                this.syncFromValue(newValue);
            });

            document.addEventListener('mousemove', this.handleDrag.bind(this));
            document.addEventListener('mouseup', this.stopDrag.bind(this));
            document.addEventListener('touchmove', this.handleDrag.bind(this));
            document.addEventListener('touchend', this.stopDrag.bind(this));

            this.$nextTick?.(() => {
                this.isInitialized = true;
            });
        },

        get formattedValue(): string {
            if (this.thumbsState.length === 0) return '';

            if (this.isRange) {
                const values = this.thumbsState.map((t: RangeThumb) => this.formatValue(t.value));
                return values.join(' – ');
            }

            return this.formatValue(this.thumbsState[0].value);
        },

        get fillerStyle(): string {
            if (this.thumbsState.length === 0) return '';

            const isVertical = this.orientation === 'vertical';

            if (this.isRange && this.thumbsState.length >= 2) {
                const start = Math.min(this.thumbsState[0].percentage, this.thumbsState[1].percentage);
                const end = Math.max(this.thumbsState[0].percentage, this.thumbsState[1].percentage);
                const size = end - start;

                if (isVertical) {
                    return `bottom: ${start}%; height: ${size}%;`;
                }
                return `left: ${start}%; width: ${size}%;`;
            }

            const percentage = this.thumbsState[0].percentage;

            if (isVertical) {
                return `bottom: 0%; height: ${percentage}%;`;
            }
            return `left: 0%; width: ${percentage}%;`;
        },

        formatValue(value: number): string {
            if (this.formatOptions) {
                try {
                    return new Intl.NumberFormat(undefined, this.formatOptions as Intl.NumberFormatOptions).format(value);
                } catch {
                    return this.roundToPrecision(value).toString();
                }
            }
            return this.roundToPrecision(value).toString();
        },

        thumbStyle(index: number): string {
            const thumb = this.thumbsState[index];
            if (!thumb) return '';

            const isVertical = this.orientation === 'vertical';
            const position = thumb.percentage;

            if (isVertical) {
                return `position: absolute; top: ${100 - position}%; transform: translate(-50%, -50%);`;
            }
            return `position: absolute; left: ${position}%; transform: translate(-50%, -50%);`;
        },

        stepStyle(stepIndex: number): string {
            const stepCount = (this.max - this.min) / this.step;
            let percentage = (stepIndex / stepCount) * 100;

            if (stepIndex === 0) {
                percentage = Math.max(percentage, 0.75);
            } else if (stepIndex === stepCount) {
                percentage = Math.min(percentage, 98.5);
            }

            const isVertical = this.orientation === 'vertical';

            if (isVertical) {
                return `top: ${100 - percentage}%;`;
            }
            return `left: ${percentage}%;`;
        },

        isStepInRange(stepIndex: number): boolean {
            const stepCount = (this.max - this.min) / this.step;
            const stepPercentage = (stepIndex / stepCount) * 100;

            if (this.isRange && this.thumbsState.length >= 2) {
                const start = Math.min(this.thumbsState[0].percentage, this.thumbsState[1].percentage);
                const end = Math.max(this.thumbsState[0].percentage, this.thumbsState[1].percentage);
                return stepPercentage >= start && stepPercentage <= end;
            }

            return stepPercentage <= this.thumbsState[0].percentage;
        },

        getThumbMin(index: number): number {
            if (!this.isRange || index === 0) return this.min;
            return this.thumbsState[0].value;
        },

        getThumbMax(index: number): number {
            if (!this.isRange || index === 1) return this.max;
            return this.thumbsState[1].value;
        },

        startDrag(event: MouseEvent | TouchEvent, index: number) {
            event.preventDefault();
            this.isDragging = true;
            this.draggingThumbIndex = index;
            this.thumbsState[index].dragging = true;

            this.tooltipValue = this.formatValue(this.thumbsState[index].value);
            this.tooltipVisible = true;
        },

        handleDrag(event: MouseEvent | TouchEvent) {
            if (this.draggingThumbIndex === null || !this.isDragging) return;

            const track = this.$refs?.track as HTMLElement;
            if (!track) return;

            const rect = track.getBoundingClientRect();
            const isVertical = this.orientation === 'vertical';

            let clientPos: number;
            if (event instanceof MouseEvent) {
                clientPos = isVertical ? event.clientY : event.clientX;
            } else {
                clientPos = isVertical
                    ? event.touches[0].clientY
                    : event.touches[0].clientX;
            }

            let percentage: number;
            if (isVertical) {
                percentage = ((rect.bottom - clientPos) / rect.height) * 100;
            } else {
                percentage = ((clientPos - rect.left) / rect.width) * 100;
            }

            percentage = Math.max(0, Math.min(100, percentage));

            let value = this.min + (percentage / 100) * (this.max - this.min);

            value = Math.round(value / this.step) * this.step;
            value = this.roundToPrecision(value);

            const thumbMin = this.getThumbMin(this.draggingThumbIndex);
            const thumbMax = this.getThumbMax(this.draggingThumbIndex);
            value = Math.max(thumbMin, Math.min(thumbMax, value));

            this._pendingValue = value;

            this.tooltipValue = this.formatValue(value);

            const thumbElements = this.$el?.querySelectorAll('[data-pegboard-thumb]');
            const thumbElement = thumbElements?.[this.draggingThumbIndex] as HTMLElement;

            if (thumbElement) {
                const finalPercentage = this.valueToPercentage(value);

                if (isVertical) {
                    thumbElement.style.position = 'absolute';
                    thumbElement.style.top = `${100 - finalPercentage}%`;
                    thumbElement.style.transform = 'translate(-50%, -50%)';
                } else {
                    thumbElement.style.position = 'absolute';
                    thumbElement.style.left = `${finalPercentage}%`;
                    thumbElement.style.transform = 'translate(-50%, -50%)';
                }
            }

            const filler = this.$el?.querySelector('[data-pegboard-filler]') as HTMLElement;
            if (filler) {
                const fillerPercentage = this.valueToPercentage(value);

                if (this.isRange && this.thumbsState.length >= 2) {
                    const otherIndex = this.draggingThumbIndex === 0 ? 1 : 0;
                    const otherPercentage = this.thumbsState[otherIndex].percentage;
                    const start = Math.min(fillerPercentage, otherPercentage);
                    const end = Math.max(fillerPercentage, otherPercentage);
                    const size = end - start;

                    if (isVertical) {
                        filler.style.bottom = `${start}%`;
                        filler.style.height = `${size}%`;
                        filler.style.borderRadius = '9999px';
                    } else {
                        filler.style.left = `${start}%`;
                        filler.style.width = `${size}%`;
                        filler.style.borderRadius = '9999px';
                    }
                } else {
                    if (isVertical) {
                        filler.style.bottom = '0%';
                        filler.style.height = `${fillerPercentage}%`;
                        filler.style.borderRadius = '9999px 9999px 9999px 9999px';
                    } else {
                        filler.style.left = '0%';
                        filler.style.width = `${fillerPercentage}%`;
                        filler.style.borderRadius = '9999px 0 0 9999px';
                    }
                }
            }
        },

        stopDrag() {
            if (this.draggingThumbIndex !== null) {
                const index = this.draggingThumbIndex;
                this.thumbsState[index].dragging = false;

                if (this._pendingValue !== undefined) {
                    this.updateThumbValue(index, this._pendingValue, false);
                    this._pendingValue = undefined;
                }

                this.draggingThumbIndex = null;
                this.isDragging = false;

                this.tooltipVisible = false;

                this.syncValueToLivewire();
            }
        },

        handleTrackClick(event: MouseEvent) {
            if ((event.target as HTMLElement).closest('[data-pegboard-thumb]')) {
                return;
            }

            const track = this.$refs?.track as HTMLElement;
            if (!track) return;

            const rect = track.getBoundingClientRect();
            const isVertical = this.orientation === 'vertical';

            let percentage: number;
            if (isVertical) {
                percentage = ((rect.bottom - event.clientY) / rect.height) * 100;
            } else {
                percentage = ((event.clientX - rect.left) / rect.width) * 100;
            }

            percentage = Math.max(0, Math.min(100, percentage));

            let nearestIndex = 0;
            let minDistance = Math.abs(this.thumbsState[0].percentage - percentage);

            for (let i = 1; i < this.thumbsState.length; i++) {
                const distance = Math.abs(this.thumbsState[i].percentage - percentage);
                if (distance < minDistance) {
                    minDistance = distance;
                    nearestIndex = i;
                }
            }

            let value = this.min + (percentage / 100) * (this.max - this.min);
            value = Math.round(value / this.step) * this.step;
            value = this.roundToPrecision(value);

            const thumbMin = this.getThumbMin(nearestIndex);
            const thumbMax = this.getThumbMax(nearestIndex);
            value = Math.max(thumbMin, Math.min(thumbMax, value));

            this.updateThumbValue(nearestIndex, value, false);
            this.syncValueToLivewire();
        },

        handleKeyDown(event: KeyboardEvent, index: number) {
            const isVertical = this.orientation === 'vertical';
            let delta = 0;

            if (event.key === 'ArrowUp' || event.key === 'ArrowRight') {
                delta = isVertical && event.key === 'ArrowUp' ? this.step :
                        !isVertical && event.key === 'ArrowRight' ? this.step : 0;
            } else if (event.key === 'ArrowDown' || event.key === 'ArrowLeft') {
                delta = isVertical && event.key === 'ArrowDown' ? -this.step :
                        !isVertical && event.key === 'ArrowLeft' ? -this.step : 0;
            } else if (event.key === 'PageUp') {
                delta = this.step * 10;
            } else if (event.key === 'PageDown') {
                delta = this.step * -10;
            } else if (event.key === 'Home') {
                delta = this.getThumbMin(index) - this.thumbsState[index].value;
            } else if (event.key === 'End') {
                delta = this.getThumbMax(index) - this.thumbsState[index].value;
            }

            if (delta !== 0) {
                event.preventDefault();
                let newValue = this.thumbsState[index].value + delta;
                newValue = this.roundToPrecision(newValue);

                const thumbMin = this.getThumbMin(index);
                const thumbMax = this.getThumbMax(index);
                newValue = Math.max(thumbMin, Math.min(thumbMax, newValue));

                this.updateThumbValue(index, newValue, false);
                this.syncValueToLivewire();
            }
        },

        updateThumbValue(index: number, value: number, syncToLivewire: boolean = true) {
            this.thumbsState[index].value = value;
            this.thumbsState[index].percentage = this.valueToPercentage(value);

            if (syncToLivewire) {
                if (this.isRange) {
                    this.value = [this.thumbsState[0].value, this.thumbsState[1].value];
                } else {
                    this.value = this.thumbsState[0].value;
                }
            }
        },

        valueToPercentage(value: number): number {
            if (this.max === this.min) return 0;
            return ((value - this.min) / (this.max - this.min)) * 100;
        },

        roundToPrecision(value: number): number {
            const stepStr = this.step.toString();
            const decimals = stepStr.includes('.')
                ? stepStr.split('.')[1].length
                : 0;

            return Number(value.toFixed(decimals));
        },

        syncValueToLivewire() {
            if (this.isRange) {
                this.value = [this.thumbsState[0].value, this.thumbsState[1].value];
            } else {
                this.value = this.thumbsState[0].value;
            }
        },

        syncFromValue(newValue: number | number[]) {
            if (this.isRange && Array.isArray(newValue) && newValue.length >= 2) {
                this.updateThumbValue(0, newValue[0], false);
                this.updateThumbValue(1, newValue[1], false);
            } else if (!this.isRange && typeof newValue === 'number') {
                this.updateThumbValue(0, newValue, false);
            }
        },
    }));
}
