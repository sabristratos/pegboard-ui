import type { Alpine, AlpineData } from '../types/alpine';

export interface DatePickerOptions {
    format?: string;
    value?: string | { start: string | null; end: string | null } | null;
    name?: string | null;
    range?: boolean;
}

export interface DatePickerState {
    format: string;
    name: string | null;
    range: boolean;

    isOpen: boolean;
    view: 'days' | 'months' | 'years';
    value: string;
    startDate: string;
    endDate: string;
    selectingStart: boolean;
    hoveredDate: Date | null;
    month: number;
    year: number;
    day: number;
    daysInMonth: number[];
    blankDaysInMonth: number[];
    yearRange: number[];
    yearRangeStart: number;
    monthNames: string[];
    dayNames: string[];

    dateRangeValue: { start: string; end: string };

    init(): void;
    getMask(): string;
    onInput(): void;
    onBlur(): void;
    parseInputValue(): void;
    parseDate(dateStr: string): Date | null;
    normalizeInput(): void;
    updateInput(): void;
    clearDate(): void;
    confirmDate(): void;
    togglePopover(): void;
    closePopover(): void;
    selectDay(day: number): void;
    selectMonth(monthIndex: number): void;
    selectYear(year: number): void;
    selectToday(): void;
    clear(): void;
    previousMonth(): void;
    nextMonth(): void;
    previousYearRange(): void;
    nextYearRange(): void;
    switchToDaysView(): void;
    switchToMonthsView(): void;
    switchToYearsView(): void;
    isSelectedDate(day: number): boolean;
    isSelectedMonth(monthIndex: number): boolean;
    isSelectedYear(year: number): boolean;
    isToday(day: number): boolean;
    isCurrentMonth(monthIndex: number): boolean;
    isCurrentYear(year: number): boolean;
    isStartDate(day: number): boolean;
    isEndDate(day: number): boolean;
    isInRange(day: number): boolean;
    isInPreviewRange(day: number): boolean;
    calculateDays(): void;
    calculateYearRange(): void;
    formatDate(date: Date): string;
    dispatchChangeEvent?(): void;
}

export function datepicker(Alpine: Alpine): void {
    Alpine.data('pegboardDatePicker', (opts: DatePickerOptions = {}): AlpineData<DatePickerState> => ({
        format: opts.format ?? 'Y-m-d',
        name: opts.name ?? null,
        range: opts.range ?? false,
        isOpen: false,
        view: 'days',
        value: '',
        startDate: '',
        endDate: '',
        selectingStart: true,
        hoveredDate: null,
        month: 0,
        year: 0,
        day: 0,
        daysInMonth: [],
        blankDaysInMonth: [],
        yearRange: [],
        yearRangeStart: 0,
        monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        dayNames: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],

        get dateRangeValue() {
            return {
                start: this.startDate,
                end: this.endDate
            };
        },

        init() {
            if (this.range && opts.value && typeof opts.value === 'object') {
                const startValue = opts.value.start;
                const endValue = opts.value.end;

                if (startValue) {
                    const startDateObj = new Date(startValue);
                    this.startDate = this.formatDate(startDateObj);
                    this.month = startDateObj.getMonth();
                    this.year = startDateObj.getFullYear();
                }
                if (endValue) {
                    this.endDate = this.formatDate(new Date(endValue));
                }
                this.selectingStart = !startValue;
            } else if (!this.range && opts.value && typeof opts.value === 'string') {
                const currentDate = new Date(opts.value);
                this.month = currentDate.getMonth();
                this.year = currentDate.getFullYear();
                this.day = currentDate.getDate();
                this.value = this.formatDate(currentDate);
            } else {
                const currentDate = new Date();
                this.month = currentDate.getMonth();
                this.year = currentDate.getFullYear();
                this.day = currentDate.getDate();
            }

            this.calculateDays();
            this.calculateYearRange();
            this.updateInput();

            this.$watch?.('isOpen', (open: boolean) => {
                const popover = this.$refs?.popover as HTMLElement;
                if (!popover) return;

                try {
                    if (open) {
                        popover.showPopover();
                        this.view = 'days';
                    } else {
                        popover.hidePopover();
                    }
                } catch (error) {
                    console.error('[Pegboard DatePicker] Popover error:', error);
                }
            });
        },

        getMask(): string {
            if (this.range) {
                if (this.format === 'Y-m-d') return '9999-99-99 - 9999-99-99';
                if (this.format === 'm/d/Y') return '99/99/9999 - 99/99/9999';
                if (this.format === 'd/m/Y') return '99/99/9999 - 99/99/9999';
            } else {
                if (this.format === 'Y-m-d') return '9999-99-99';
                if (this.format === 'm/d/Y') return '99/99/9999';
                if (this.format === 'd/m/Y') return '99/99/9999';
            }
            return '9999-99-99';
        },

        onInput() {
        },

        onBlur() {
            this.parseInputValue();
            this.normalizeInput();
        },

        parseInputValue() {
            const input = this.$refs?.input as HTMLInputElement;
            if (!input || !input.value) {
                this.clearDate();
                return;
            }

            const value = input.value.trim();

            if (this.range) {
                const parts = value.split(' - ');
                if (parts.length === 2) {
                    const startDate = this.parseDate(parts[0]);
                    const endDate = this.parseDate(parts[1]);

                    if (startDate && endDate) {
                        this.startDate = this.formatDate(startDate);
                        this.endDate = this.formatDate(endDate);
                        this.month = startDate.getMonth();
                        this.year = startDate.getFullYear();
                        this.calculateDays();
                    }
                }
            } else {
                const date = this.parseDate(value);
                if (date) {
                    this.value = this.formatDate(date);
                    this.month = date.getMonth();
                    this.year = date.getFullYear();
                    this.day = date.getDate();
                    this.calculateDays();
                }
            }
        },

        parseDate(dateStr: string): Date | null {
            if (!dateStr) return null;

            if (this.format === 'Y-m-d') {
                const match = dateStr.match(/^(\d{4})-(\d{2})-(\d{2})$/);
                if (match) {
                    const date = new Date(+match[1], +match[2] - 1, +match[3]);
                    return isNaN(date.getTime()) ? null : date;
                }
            }
            if (this.format === 'm/d/Y') {
                const match = dateStr.match(/^(\d{2})\/(\d{2})\/(\d{4})$/);
                if (match) {
                    const date = new Date(+match[3], +match[1] - 1, +match[2]);
                    return isNaN(date.getTime()) ? null : date;
                }
            }
            if (this.format === 'd/m/Y') {
                const match = dateStr.match(/^(\d{2})\/(\d{2})\/(\d{4})$/);
                if (match) {
                    const date = new Date(+match[3], +match[2] - 1, +match[1]);
                    return isNaN(date.getTime()) ? null : date;
                }
            }
            return null;
        },

        normalizeInput() {
            const input = this.$refs?.input as HTMLInputElement;
            if (!input) return;

            if (this.range && this.startDate && this.endDate) {
                input.value = `${this.startDate} - ${this.endDate}`;
            } else if (!this.range && this.value) {
                input.value = this.value;
            }
        },

        updateInput() {
            const input = this.$refs?.input as HTMLInputElement;
            if (!input) return;

            if (this.range) {
                if (this.startDate && this.endDate) {
                    input.value = `${this.startDate} - ${this.endDate}`;
                } else if (this.startDate) {
                    input.value = this.startDate;
                } else {
                    input.value = '';
                }
            } else {
                input.value = this.value || '';
            }

            input.dispatchEvent(new Event('input', { bubbles: true }));
            input.dispatchEvent(new Event('change', { bubbles: true }));
        },

        clearDate() {
            if (this.range) {
                this.startDate = '';
                this.endDate = '';
                this.selectingStart = true;
            } else {
                this.value = '';
            }
        },

        confirmDate() {
            this.closePopover();
        },

        togglePopover() {
            this.isOpen = !this.isOpen;
        },

        closePopover() {
            this.isOpen = false;
        },

        selectDay(day: number) {
            const selectedDate = new Date(this.year, this.month, day);

            if (this.range) {
                if (this.selectingStart || (this.startDate && this.endDate)) {
                    this.startDate = this.formatDate(selectedDate);
                    this.endDate = '';
                    this.selectingStart = false;
                    this.updateInput();
                } else if (this.startDate && !this.endDate) {
                    const endDateStr = this.formatDate(selectedDate);
                    const startDateObj = new Date(this.startDate);

                    if (selectedDate < startDateObj) {
                        this.endDate = this.startDate;
                        this.startDate = endDateStr;
                    } else {
                        this.endDate = endDateStr;
                    }

                    this.updateInput();
                    this.closePopover();
                }
            } else {
                this.day = day;
                this.value = this.formatDate(selectedDate);
                this.updateInput();
                this.closePopover();
            }
        },

        previousMonth() {
            if (this.month === 0) {
                this.year--;
                this.month = 11;
            } else {
                this.month--;
            }
            this.calculateDays();
        },

        nextMonth() {
            if (this.month === 11) {
                this.year++;
                this.month = 0;
            } else {
                this.month++;
            }
            this.calculateDays();
        },

        isSelectedDate(day: number): boolean {
            const d = new Date(this.year, this.month, day);
            return this.value === this.formatDate(d);
        },

        selectMonth(monthIndex: number) {
            this.month = monthIndex;
            this.calculateDays();
            this.view = 'days';
        },

        selectYear(year: number) {
            this.year = year;
            this.calculateDays();
            this.view = 'days';
        },

        selectToday() {
            const today = new Date();
            this.month = today.getMonth();
            this.year = today.getFullYear();
            this.day = today.getDate();

            if (this.range) {
                if (this.startDate && !this.endDate) {
                    this.endDate = this.formatDate(today);
                    this.updateInput();
                    this.closePopover();
                } else {
                    this.startDate = this.formatDate(today);
                    this.endDate = '';
                    this.selectingStart = false;
                    this.updateInput();
                }
            } else {
                this.value = this.formatDate(today);
                this.updateInput();
                this.closePopover();
            }

            this.calculateDays();
        },

        clear() {
            this.clearDate();
            this.updateInput();
            this.closePopover();
        },

        previousYearRange() {
            this.yearRangeStart -= 12;
            this.calculateYearRange();
        },

        nextYearRange() {
            this.yearRangeStart += 12;
            this.calculateYearRange();
        },

        switchToDaysView() {
            this.view = 'days';
        },

        switchToMonthsView() {
            this.view = 'months';
        },

        switchToYearsView() {
            this.view = 'years';
        },

        isSelectedMonth(monthIndex: number): boolean {
            if (!this.value) return false;
            const d = new Date(this.year, monthIndex, this.day);
            return this.value === this.formatDate(d);
        },

        isSelectedYear(year: number): boolean {
            if (!this.value) return false;
            const d = new Date(year, this.month, this.day);
            return this.value === this.formatDate(d);
        },

        isToday(day: number): boolean {
            const today = new Date();
            const d = new Date(this.year, this.month, day);
            return today.toDateString() === d.toDateString();
        },

        isCurrentMonth(monthIndex: number): boolean {
            const today = new Date();
            return today.getFullYear() === this.year && today.getMonth() === monthIndex;
        },

        isCurrentYear(year: number): boolean {
            const today = new Date();
            return today.getFullYear() === year;
        },

        isStartDate(day: number): boolean {
            if (!this.range || !this.startDate) return false;
            const d = new Date(this.year, this.month, day);
            return this.startDate === this.formatDate(d);
        },

        isEndDate(day: number): boolean {
            if (!this.range || !this.endDate) return false;
            const d = new Date(this.year, this.month, day);
            return this.endDate === this.formatDate(d);
        },

        isInRange(day: number): boolean {
            if (!this.range || !this.startDate || !this.endDate) return false;
            const d = new Date(this.year, this.month, day);
            const startDateObj = new Date(this.startDate);
            const endDateObj = new Date(this.endDate);
            return d > startDateObj && d < endDateObj;
        },

        isInPreviewRange(day: number): boolean {
            if (!this.range || !this.startDate || this.endDate || !this.hoveredDate) return false;
            const d = new Date(this.year, this.month, day);
            const startDateObj = new Date(this.startDate);

            if (this.hoveredDate > startDateObj) {
                return d > startDateObj && d < this.hoveredDate;
            } else {
                return d > this.hoveredDate && d < startDateObj;
            }
        },

        calculateDays() {
            const daysInMonth = new Date(this.year, this.month + 1, 0).getDate();
            const dayOfWeek = new Date(this.year, this.month).getDay();

            const blankDays: number[] = [];
            for (let i = 0; i < dayOfWeek; i++) {
                blankDays.push(i);
            }

            const days: number[] = [];
            for (let i = 1; i <= daysInMonth; i++) {
                days.push(i);
            }

            this.blankDaysInMonth = blankDays;
            this.daysInMonth = days;
        },

        calculateYearRange() {
            if (this.yearRangeStart === 0) {
                this.yearRangeStart = this.year - 6;
            }

            const years: number[] = [];
            for (let i = 0; i < 12; i++) {
                years.push(this.yearRangeStart + i);
            }

            this.yearRange = years;
        },

        formatDate(date: Date): string {
            const day = ('0' + date.getDate()).slice(-2);
            const month = ('0' + (date.getMonth() + 1)).slice(-2);
            const year = date.getFullYear();

            if (this.format === 'Y-m-d') {
                return `${year}-${month}-${day}`;
            }
            if (this.format === 'm/d/Y') {
                return `${month}/${day}/${year}`;
            }
            if (this.format === 'd/m/Y') {
                return `${day}/${month}/${year}`;
            }
            if (this.format === 'M d, Y') {
                const monthName = this.monthNames[date.getMonth()].substring(0, 3);
                return `${monthName} ${day}, ${year}`;
            }
            if (this.format === 'F d, Y') {
                const monthName = this.monthNames[date.getMonth()];
                return `${monthName} ${day}, ${year}`;
            }

            return `${year}-${month}-${day}`;
        }
    }));
}
