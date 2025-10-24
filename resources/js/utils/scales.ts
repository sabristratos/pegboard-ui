export type ScaleType = 'linear' | 'time' | 'categorical';

export interface Scale {
    (value: any): number;
    domain: [any, any];
    range: [number, number];
    type: ScaleType;
    ticks: (count?: number) => any[];
    invert: (pixel: number) => any;
}

export function createLinearScale(domain: [number, number], range: [number, number]): Scale {
    const [d0, d1] = domain;
    const [r0, r1] = range;
    const domainSpan = d1 - d0;
    const rangeSpan = r1 - r0;

    const scale = ((value: number): number => {
        const normalized = (value - d0) / domainSpan;
        return r0 + normalized * rangeSpan;
    }) as Scale;

    scale.domain = domain;
    scale.range = range;
    scale.type = 'linear';

    scale.ticks = (count: number = 5): number[] => {
        const step = niceNum(domainSpan / (count - 1), true);
        const niceMin = Math.floor(d0 / step) * step;
        const niceMax = Math.ceil(d1 / step) * step;
        const ticks: number[] = [];

        for (let i = niceMin; i <= niceMax; i += step) {
            if (i >= d0 && i <= d1) {
                ticks.push(i);
            }
        }

        return ticks;
    };

    scale.invert = (pixel: number): number => {
        const normalized = (pixel - r0) / rangeSpan;
        return d0 + normalized * domainSpan;
    };

    return scale;
}

export function createTimeScale(domain: [Date, Date], range: [number, number]): Scale {
    const [d0, d1] = domain;
    const [r0, r1] = range;
    const d0Time = d0.getTime();
    const d1Time = d1.getTime();
    const domainSpan = d1Time - d0Time;
    const rangeSpan = r1 - r0;

    const scale = ((value: Date | string | number): number => {
        const time = value instanceof Date ? value.getTime() : new Date(value).getTime();
        const normalized = (time - d0Time) / domainSpan;
        return r0 + normalized * rangeSpan;
    }) as Scale;

    scale.domain = [d0, d1];
    scale.range = range;
    scale.type = 'time';

    scale.ticks = (count: number = 5): Date[] => {
        const span = domainSpan;
        const step = span / (count - 1);
        const ticks: Date[] = [];

        for (let i = 0; i < count; i++) {
            ticks.push(new Date(d0Time + i * step));
        }

        return ticks;
    };

    scale.invert = (pixel: number): Date => {
        const normalized = (pixel - r0) / rangeSpan;
        return new Date(d0Time + normalized * domainSpan);
    };

    return scale;
}

export function createCategoricalScale(domain: string[], range: [number, number]): Scale {
    const [r0, r1] = range;
    const rangeSpan = r1 - r0;
    const bandwidth = rangeSpan / domain.length;

    const scale = ((value: string): number => {
        const index = domain.indexOf(value);
        if (index === -1) return r0;
        return r0 + index * bandwidth + bandwidth / 2; // Center of band
    }) as Scale;

    scale.domain = [domain[0], domain[domain.length - 1]];
    scale.range = range;
    scale.type = 'categorical';

    scale.ticks = (): string[] => {
        return domain;
    };

    scale.invert = (pixel: number): string => {
        const index = Math.floor((pixel - r0) / bandwidth);
        return domain[Math.max(0, Math.min(index, domain.length - 1))];
    };

    return scale;
}

export function detectScaleType(values: any[]): ScaleType {
    if (values.length === 0) return 'linear';

    const firstValue = values[0];

    if (firstValue instanceof Date || isDateString(firstValue)) {
        return 'time';
    }

    if (typeof firstValue === 'number') {
        return 'linear';
    }

    return 'categorical';
}

export function createAutoScale(
    values: any[],
    range: [number, number],
    padding: number = 0.1
): Scale {
    const scaleType = detectScaleType(values);

    if (scaleType === 'time') {
        const dates = values.map((v) => (v instanceof Date ? v : new Date(v)));
        const min = new Date(Math.min(...dates.map((d) => d.getTime())));
        const max = new Date(Math.max(...dates.map((d) => d.getTime())));
        return createTimeScale([min, max], range);
    }

    if (scaleType === 'linear') {
        const numbers = values.map(Number).filter((n) => !isNaN(n));
        const min = Math.min(...numbers);
        const max = Math.max(...numbers);
        const span = max - min;
        const paddedMin = min - span * padding;
        const paddedMax = max + span * padding;
        return createLinearScale([paddedMin, paddedMax], range);
    }

    const categories = [...new Set(values.map(String))];
    return createCategoricalScale(categories, range);
}

function niceNum(range: number, round: boolean): number {
    const exponent = Math.floor(Math.log10(range));
    const fraction = range / Math.pow(10, exponent);
    let niceFraction: number;

    if (round) {
        if (fraction < 1.5) niceFraction = 1;
        else if (fraction < 3) niceFraction = 2;
        else if (fraction < 7) niceFraction = 5;
        else niceFraction = 10;
    } else {
        if (fraction <= 1) niceFraction = 1;
        else if (fraction <= 2) niceFraction = 2;
        else if (fraction <= 5) niceFraction = 5;
        else niceFraction = 10;
    }

    return niceFraction * Math.pow(10, exponent);
}

function isDateString(value: any): boolean {
    if (typeof value !== 'string') return false;
    const date = new Date(value);
    return !isNaN(date.getTime());
}

export function extent(values: number[]): [number, number] {
    if (values.length === 0) return [0, 0];
    return [Math.min(...values), Math.max(...values)];
}

export function extentDate(values: Date[]): [Date, Date] {
    if (values.length === 0) {
        const now = new Date();
        return [now, now];
    }
    const times = values.map((d) => d.getTime());
    return [new Date(Math.min(...times)), new Date(Math.max(...times))];
}
