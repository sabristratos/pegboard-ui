import type { Alpine } from '../types/alpine';
import type { AlpineData, TimePickerOptions, TimePickerState } from '../types/components';

export function timePicker(Alpine: Alpine): void {
    Alpine.data('pegboardTimePicker', (options: TimePickerOptions = {}): AlpineData<TimePickerState> => ({
        format: options.format || '12',
        step: options.step || 5,
        disabled: options.disabled || false,

        isOpen: false,
        selectedHour: 0,
        selectedMinute: 0,
        period: 'AM',
        hours: [],
        minutes: [],

        init() {
            this.generateHours();
            this.generateMinutes();
            this.parseInputValue();

            this.$watch?.('isOpen', (open: boolean) => {
                const popover = this.$refs?.popover as HTMLElement;
                if (!popover) return;

                try {
                    if (open) {
                        popover.showPopover();
                    } else {
                        popover.hidePopover();
                    }
                } catch (error) {
                    console.error('[Pegboard TimePicker] Popover error:', error);
                }
            });
        },

        get displayTime(): string {
            if (this.selectedHour === null || this.selectedMinute === null) {
                return this.format === '24' ? '--:--' : '--:-- --';
            }

            let hour: string;
            if (this.format === '24') {
                hour = this.formatHour(this.selectedHour);
            } else {
                hour = this.selectedHour.toString().padStart(2, '0');
            }

            const minute = this.formatMinute(this.selectedMinute);

            if (this.format === '24') {
                return `${hour}:${minute}`;
            }

            return `${hour}:${minute} ${this.period}`;
        },

        generateHours() {
            if (this.format === '24') {
                this.hours = Array.from({ length: 24 }, (_, i) => i);
            } else {
                this.hours = Array.from({ length: 12 }, (_, i) => i === 0 ? 12 : i);
            }
        },

        generateMinutes() {
            this.minutes = Array.from({ length: 60 / this.step }, (_, i) => i * this.step);
        },

        formatHour(hour: number): string {
            if (this.format === '24') {
                return hour.toString().padStart(2, '0');
            }
            return hour.toString();
        },

        formatMinute(minute: number): string {
            return minute.toString().padStart(2, '0');
        },

        parseInputValue() {
            const input = this.$refs?.input as HTMLInputElement;
            if (!input || !input.value) {
                this.selectedHour = null;
                this.selectedMinute = null;
                this.period = 'AM';
                return;
            }

            const value = input.value.trim();

            const time24Pattern = /^(\d{1,2}):(\d{2})(?::\d{2})?$/;
            const time12Pattern = /^(\d{1,2}):(\d{2})(?::\d{2})?\s*(a|p|am|pm)?$/i;

            let match = value.match(this.format === '24' ? time24Pattern : time12Pattern);

            if (!match) {
                match = value.match(this.format === '24' ? time12Pattern : time24Pattern);
            }

            if (match) {
                let hour = parseInt(match[1], 10);
                const minute = parseInt(match[2], 10);
                const periodMatch = match[3]?.toLowerCase();

                if (minute < 0 || minute > 59) return;

                if (this.format === '24') {
                    if (hour < 0 || hour > 23) return;
                    this.selectedHour = hour;
                    this.selectedMinute = this.roundToStep(minute);
                } else {
                    if (hour < 1 || hour > 12) return;

                    if (periodMatch) {
                        this.period = periodMatch.startsWith('p') ? 'PM' : 'AM';
                    }

                    this.selectedHour = hour;
                    this.selectedMinute = this.roundToStep(minute);
                }
            }
        },

        roundToStep(minute: number): number {
            return Math.round(minute / this.step) * this.step;
        },

        selectHour(hour: number) {
            this.selectedHour = hour;
            this.updateInput();
        },

        selectMinute(minute: number) {
            this.selectedMinute = minute;
            this.updateInput();
        },

        selectPeriod(period: 'AM' | 'PM') {
            this.period = period;
            this.updateInput();
        },

        updateInput() {
            const input = this.$refs?.input as HTMLInputElement;
            if (!input) return;

            if (this.selectedHour === null || this.selectedMinute === null) {
                input.value = '';
            } else {
                if (this.format === '24') {
                    const hour = this.selectedHour.toString().padStart(2, '0');
                    const minute = this.selectedMinute.toString().padStart(2, '0');
                    input.value = `${hour}:${minute}`;
                } else {
                    const hour = this.selectedHour.toString().padStart(2, '0');
                    const minute = this.selectedMinute.toString().padStart(2, '0');
                    input.value = `${hour}:${minute} ${this.period}`;
                }
            }

            input.dispatchEvent(new Event('input', { bubbles: true }));
            input.dispatchEvent(new Event('change', { bubbles: true }));
        },

        onInput() {
        },

        onBlur() {
            this.parseInputValue();
            this.updateInput();
        },

        selectCurrentTime() {
            this.parseInputValue();
            this.closePopover();
        },

        togglePopover() {
            if (this.disabled) return;

            this.isOpen = !this.isOpen;
            if (this.isOpen) {
                this.parseInputValue();
            }
        },

        openPopover() {
            if (this.disabled) return;

            this.parseInputValue();
            this.isOpen = true;
        },

        closePopover() {
            this.isOpen = false;
        },

        setNow() {
            const now = new Date();
            let hour = now.getHours();
            const minute = this.roundToStep(now.getMinutes());

            if (this.format === '24') {
                this.selectedHour = hour;
                this.selectedMinute = minute;
            } else {
                this.period = hour >= 12 ? 'PM' : 'AM';
                if (hour === 0) {
                    this.selectedHour = 12;
                } else if (hour > 12) {
                    this.selectedHour = hour - 12;
                } else {
                    this.selectedHour = hour;
                }
                this.selectedMinute = minute;
            }

            this.updateInput();
            this.closePopover();
        },

        clearTime() {
            this.selectedHour = null;
            this.selectedMinute = null;
            this.period = 'AM';
            this.updateInput();
            this.closePopover();
        },
    }));
}
