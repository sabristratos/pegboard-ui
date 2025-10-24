import type { Alpine, AlpineData } from '../types/alpine';
import type { ChartOptions, ChartState, ChartSeries, ChartPoint } from '../types/components';

export function chart(Alpine: Alpine): void {
    Alpine.data('chart', (options: ChartOptions = {}): AlpineData<ChartState> => {
        const {
            type = 'bar',
            series = [],
            labels = [],
            colors = ['var(--color-chart-1)'],
            animated = true,
            interactive = true,
            showGrid = true,
            showAxes = true,
            chartId = 'chart',
            barSize = 70,
        } = options;

        return {
            type,
            labels,
            colors,
            animated,
            interactive,
            showGrid,
            showAxes,
            chartId,
            barSize,

            hoveredDataIndex: null,
            crosshairX: 0,
            tooltipPosition: { x: 0, y: 0 },

            viewBox: '0 0 800 500',
            width: 800,
            height: 500,
            padding: {
                top: 20,
                right: 20,
                bottom: 80,
                left: 60,
            },

            get chartWidth(): number {
                return this.width - this.padding.right;
            },

            get chartHeight(): number {
                return this.height - this.padding.bottom;
            },

            get plotWidth(): number {
                return this.chartWidth - this.padding.left;
            },

            get plotHeight(): number {
                return this.chartHeight - this.padding.top;
            },

            get chartSeries(): ChartSeries[] {
                if (!series || !Array.isArray(series) || series.length === 0) {
                    return [];
                }

                return series.map((s, index) => {
                    const color = colors[index % colors.length] || 'var(--color-chart-1)';
                    const values = Array.isArray(s.values) ? s.values : [];
                    const points = this.calculatePoints(values, index);

                    return {
                        label: s.label || `Series ${index + 1}`,
                        data: values,
                        color,
                        points,
                        linePath: this.generateLinePath(points),
                        areaPath: this.generateAreaPath(points),
                    };
                });
            },

            get dataRange(): { min: number; max: number } {
                if (!series || !Array.isArray(series) || series.length === 0) {
                    return { min: 0, max: 100 };
                }

                const allValues = series
                    .filter((s) => s && Array.isArray(s.values))
                    .flatMap((s) => s.values)
                    .filter((v) => typeof v === 'number' && !isNaN(v));

                if (allValues.length === 0) {
                    return { min: 0, max: 100 };
                }

                const min = Math.min(...allValues, 0);
                const max = Math.max(...allValues);

                const padding = (max - min) * 0.1;

                return {
                    min: min < 0 ? min : 0,
                    max: max + padding,
                };
            },

            scaleX(index: number, total: number): number {
                const barCount = total || 1;
                const spacing = this.plotWidth / barCount;

                if (this.type === 'bar') {
                    return this.padding.left + spacing * index + spacing / 2;
                }

                return this.padding.left + (this.plotWidth / Math.max(barCount - 1, 1)) * index;
            },

            scaleY(value: number): number {
                if (typeof value !== 'number' || isNaN(value)) {
                    return this.chartHeight;
                }

                const { min, max } = this.dataRange;
                const range = max - min || 1;
                const normalized = (value - min) / range;
                const y = this.chartHeight - normalized * this.plotHeight;

                return isNaN(y) ? this.chartHeight : y;
            },

            calculatePoints(values: number[], seriesIndex: number): ChartPoint[] {
                if (!Array.isArray(values) || values.length === 0) {
                    return [];
                }

                return values
                    .map((value, index) => ({
                        x: this.scaleX(index, values.length),
                        y: this.scaleY(value),
                        value,
                        index,
                        seriesIndex,
                    }))
                    .filter((point) => !isNaN(point.x) && !isNaN(point.y));
            },

            generateLinePath(points: ChartPoint[]): string {
                if (points.length === 0) {
                    return '';
                }

                const pathSegments = points.map((point, index) => {
                    const command = index === 0 ? 'M' : 'L';
                    return `${command} ${point.x} ${point.y}`;
                });

                return pathSegments.join(' ');
            },

            generateAreaPath(points: ChartPoint[]): string {
                if (points.length === 0) {
                    return '';
                }

                const linePath = this.generateLinePath(points);
                const lastPoint = points[points.length - 1];
                const firstPoint = points[0];

                return `${linePath} L ${lastPoint.x} ${this.chartHeight} L ${firstPoint.x} ${this.chartHeight} Z`;
            },

            get barWidth(): number {
                const dataPointCount = this.labels.length || 1;
                const availableWidth = this.plotWidth / dataPointCount;
                const seriesCount = series.length;

                const sizeMultiplier = Math.max(0.1, Math.min(1, this.barSize / 100));

                const calculatedWidth = (availableWidth * sizeMultiplier) / seriesCount;

                const maxBarWidth = 60;
                return Math.min(calculatedWidth, maxBarWidth);
            },

            formatValue(value: number): string {
                if (Math.abs(value) >= 1000000) {
                    return `${(value / 1000000).toFixed(1)}M`;
                }

                if (Math.abs(value) >= 1000) {
                    return `${(value / 1000).toFixed(1)}K`;
                }

                return value.toFixed(0);
            },

            get tooltipContent(): { label: string; series: Array<{ name: string; value: string; color: string }> } {
                if (this.hoveredDataIndex !== null) {
                    const index = this.hoveredDataIndex;
                    const label = this.labels[index] || `Point ${index + 1}`;
                    const seriesData = this.chartSeries.map((s: ChartSeries) => ({
                        name: s.label,
                        value: s.data[index]?.toLocaleString() || '0',
                        color: s.color || 'transparent',
                    }));

                    return { label, series: seriesData };
                }

                return { label: '', series: [] };
            },

            get ariaLabel(): string {
                const chartType = this.type.charAt(0).toUpperCase() + this.type.slice(1);
                const seriesCount = this.chartSeries.length;
                const dataPointCount = this.labels.length;

                return `${chartType} chart with ${seriesCount} series and ${dataPointCount} data points`;
            },

            createSVGElement(tag: string, attrs: Record<string, string | number> = {}, classes: string[] = []): SVGElement {
                const el = document.createElementNS('http://www.w3.org/2000/svg', tag);

                this.setAttrs(el, attrs);

                if (classes.length > 0) {
                    el.classList.add(...classes);
                }

                el.setAttribute('data-appended', '');

                return el;
            },

            clearContainer(selector: string): void {
                const container = (this.$el as HTMLElement).querySelector(selector);

                if (container) {
                    const appended = container.querySelectorAll('[data-appended]');
                    appended.forEach((el) => el.remove());
                }
            },

            setAttrs(element: SVGElement, attrs: Record<string, string | number>): void {
                Object.entries(attrs).forEach(([key, value]) => {
                    element.setAttribute(key, String(value));
                });
            },

            renderGradients(): void {
                const container = (this.$el as HTMLElement).querySelector('[data-gradient-container]');

                if (!container) {
                    return;
                }

                this.clearContainer('[data-gradient-container]');

                this.chartSeries.forEach((series: ChartSeries, index: number) => {
                    const gradient = this.createSVGElement('linearGradient', {
                        id: `area-gradient-${index}-${this.chartId}`,
                        x1: '0%',
                        y1: '0%',
                        x2: '0%',
                        y2: '100%',
                    });

                    const stop1 = this.createSVGElement('stop', {
                        offset: '0%',
                        'stop-color': series.color,
                        'stop-opacity': '0.4',
                    });

                    const stop2 = this.createSVGElement('stop', {
                        offset: '100%',
                        'stop-color': series.color,
                        'stop-opacity': '0.05',
                    });

                    gradient.appendChild(stop1);
                    gradient.appendChild(stop2);
                    container.appendChild(gradient);
                });
            },

            renderGrid(): void {
                if (!this.showGrid) {
                    return;
                }

                const container = (this.$el as HTMLElement).querySelector('[data-grid-container]');

                if (!container) {
                    return;
                }

                this.clearContainer('[data-grid-container]');

                const tickCount = 5;
                for (let i = 0; i <= tickCount; i++) {
                    const y = this.padding.top + (this.plotHeight / tickCount) * i;

                    if (!isNaN(y)) {
                        const line = this.createSVGElement('line', {
                            x1: this.padding.left,
                            y1: y,
                            x2: this.chartWidth,
                            y2: y,
                            stroke: 'currentColor',
                            'stroke-width': 1,
                            'data-grid-line': '',
                            'data-axis': 'y',
                        });

                        container.appendChild(line);
                    }
                }

                if (Array.isArray(this.labels) && this.labels.length > 0) {
                    this.labels.forEach((_: string, index: number) => {
                        const x = this.scaleX(index, this.labels.length);

                        if (!isNaN(x)) {
                            const line = this.createSVGElement('line', {
                                x1: x,
                                y1: this.padding.top,
                                x2: x,
                                y2: this.chartHeight,
                                stroke: 'currentColor',
                                'stroke-width': 1,
                                'data-grid-line': '',
                                'data-axis': 'x',
                            });

                            container.appendChild(line);
                        }
                    });
                }
            },

            renderAxes(): void {
                if (!this.showAxes) {
                    return;
                }

                this.renderYAxis();
                this.renderXAxis();
            },

            renderYAxis(): void {
                const container = (this.$el as HTMLElement).querySelector('[data-y-axis-container]');

                if (!container) {
                    return;
                }

                this.clearContainer('[data-y-axis-container]');

                const axisLine = this.createSVGElement('line', {
                    x1: this.padding.left,
                    y1: this.padding.top,
                    x2: this.padding.left,
                    y2: this.chartHeight,
                    stroke: 'currentColor',
                    'stroke-width': 2,
                    'data-axis-line': '',
                    'data-axis': 'y',
                });

                container.appendChild(axisLine);

                const { min, max } = this.dataRange;
                const tickCount = 5;

                for (let i = 0; i <= tickCount; i++) {
                    const value = max - ((max - min) / tickCount) * i;
                    const y = this.padding.top + (this.plotHeight / tickCount) * i;
                    const label = this.formatValue(value);

                    const tickLabel = this.createSVGElement('text', {
                        x: this.padding.left - 8,
                        y: y,
                        'text-anchor': 'end',
                        'dominant-baseline': 'middle',
                        fill: 'currentColor',
                        'data-tick-label': '',
                        'data-axis': 'y',
                    }, ['text-sm', 'fill-muted-foreground']);

                    tickLabel.textContent = label;
                    container.appendChild(tickLabel);
                }
            },

            renderXAxis(): void {
                const container = (this.$el as HTMLElement).querySelector('[data-x-axis-container]');

                if (!container) {
                    return;
                }

                this.clearContainer('[data-x-axis-container]');

                const axisLine = this.createSVGElement('line', {
                    x1: this.padding.left,
                    y1: this.chartHeight,
                    x2: this.chartWidth,
                    y2: this.chartHeight,
                    stroke: 'currentColor',
                    'stroke-width': 2,
                    'data-axis-line': '',
                    'data-axis': 'x',
                });

                container.appendChild(axisLine);

                if (!Array.isArray(this.labels) || this.labels.length === 0) {
                    return;
                }

                this.labels.forEach((label: string, index: number) => {
                    const x = this.scaleX(index, this.labels.length);

                    if (!isNaN(x)) {
                        const tickLabel = this.createSVGElement('text', {
                            x: x,
                            y: this.chartHeight + 10,
                            'text-anchor': 'middle',
                            'dominant-baseline': 'hanging',
                            fill: 'currentColor',
                            'data-tick-label': '',
                            'data-axis': 'x',
                        }, ['text-sm', 'fill-muted-foreground']);

                        tickLabel.textContent = String(label || '');
                        container.appendChild(tickLabel);
                    }
                });
            },

            renderBars(): void {
                const container = (this.$el as HTMLElement).querySelector('[data-chart-container]');

                if (!container) {
                    return;
                }

                this.chartSeries.forEach((series: ChartSeries, seriesIndex: number) => {
                    series.points.forEach((point: ChartPoint, pointIndex: number) => {
                        const classes = ['cursor-pointer', 'origin-bottom'];

                        if (this.animated) {
                            classes.push('transition-[transform,opacity]', 'duration-normal', 'ease-out', 'starting:scale-y-0');
                        }

                        const bar = this.createSVGElement('rect', {
                            x: point.x - this.barWidth / 2,
                            y: point.y,
                            width: this.barWidth,
                            height: this.chartHeight - point.y,
                            fill: series.color,
                            'data-bar': '',
                            'data-series': seriesIndex,
                            'data-point': pointIndex,
                        }, classes);

                        if (this.animated) {
                            bar.style.transitionDelay = `${pointIndex * 50}ms`;
                        }

                        container.appendChild(bar);
                    });
                });
            },

            renderLines(): void {
                const container = (this.$el as HTMLElement).querySelector('[data-chart-container]');

                if (!container) {
                    return;
                }

                this.chartSeries.forEach((series: ChartSeries, seriesIndex: number) => {
                    const lineClasses = this.animated ? ['transition-all', 'duration-slow', 'ease-out'] : [];

                    const linePath = this.createSVGElement('path', {
                        d: series.linePath,
                        stroke: series.color,
                        fill: 'none',
                        'stroke-width': 2,
                        'stroke-linecap': 'round',
                        'stroke-linejoin': 'round',
                        'data-line': '',
                        'data-series': seriesIndex,
                    }, lineClasses);

                    container.appendChild(linePath);

                    series.points.forEach((point: ChartPoint, pointIndex: number) => {
                        const circleClasses = ['origin-center', 'pointer-events-none', 'transition-all', 'duration-fast'];

                        if (this.animated) {
                            circleClasses.push('ease-out', 'starting:opacity-0', 'starting:scale-0');
                        }

                        const circle = this.createSVGElement('circle', {
                            cx: point.x,
                            cy: point.y,
                            r: 3.5,
                            fill: series.color,
                            'data-point': '',
                            'data-series': seriesIndex,
                            'data-index': pointIndex,
                        }, circleClasses);

                        if (this.animated) {
                            circle.style.transitionDelay = `${pointIndex * 50}ms`;
                        }

                        container.appendChild(circle);
                    });
                });
            },

            renderAreas(): void {
                const container = (this.$el as HTMLElement).querySelector('[data-chart-container]');

                if (!container) {
                    return;
                }

                this.chartSeries.forEach((series: ChartSeries, seriesIndex: number) => {
                    const areaClasses = this.animated ? ['transition-all', 'duration-slow', 'ease-out', 'starting:opacity-0'] : [];

                    const areaPath = this.createSVGElement('path', {
                        d: series.areaPath,
                        fill: `url(#area-gradient-${seriesIndex}-${this.chartId})`,
                        'data-area': '',
                        'data-series': seriesIndex,
                    }, areaClasses);

                    container.appendChild(areaPath);

                    const lineClasses = this.animated ? ['transition-all', 'duration-slow', 'ease-out'] : [];

                    const linePath = this.createSVGElement('path', {
                        d: series.linePath,
                        stroke: series.color,
                        fill: 'none',
                        'stroke-width': 2,
                        'stroke-linecap': 'round',
                        'stroke-linejoin': 'round',
                        'data-line': '',
                        'data-series': seriesIndex,
                    }, lineClasses);

                    container.appendChild(linePath);

                    series.points.forEach((point: ChartPoint, pointIndex: number) => {
                        const circleClasses = ['origin-center', 'pointer-events-none', 'transition-all', 'duration-fast'];

                        if (this.animated) {
                            circleClasses.push('ease-out', 'starting:opacity-0', 'starting:scale-0');
                        }

                        const circle = this.createSVGElement('circle', {
                            cx: point.x,
                            cy: point.y,
                            r: 3.5,
                            fill: series.color,
                            'data-point': '',
                            'data-series': seriesIndex,
                            'data-index': pointIndex,
                        }, circleClasses);

                        if (this.animated) {
                            circle.style.transitionDelay = `${pointIndex * 50}ms`;
                        }

                        container.appendChild(circle);
                    });
                });
            },

            renderChart(): void {
                this.clearContainer('[data-chart-container]');
                this.clearContainer('[data-grid-container]');
                this.clearContainer('[data-y-axis-container]');
                this.clearContainer('[data-x-axis-container]');
                this.clearContainer('[data-gradient-container]');

                if (this.chartSeries.length === 0) {
                    return;
                }

                this.renderGradients();
                this.renderGrid();
                this.renderAxes();

                if (this.type === 'bar') {
                    this.renderBars();
                } else if (this.type === 'line') {
                    this.renderLines();
                } else if (this.type === 'area') {
                    this.renderAreas();
                }
            },

            handleChartHover(event: MouseEvent): void {
                if (!this.interactive) {
                    return;
                }

                const svg = (Array.isArray(this.$refs?.chartSvg) ? this.$refs.chartSvg[0] : this.$refs?.chartSvg) as unknown as SVGSVGElement;
                const overlay = (Array.isArray(this.$refs?.chartOverlay) ? this.$refs.chartOverlay[0] : this.$refs?.chartOverlay) as unknown as SVGRectElement;

                if (!svg || !overlay) {
                    return;
                }

                const overlayRect = overlay.getBoundingClientRect();
                const mouseX = event.clientX - overlayRect.left;

                const dataPointCount = this.labels.length;

                if (dataPointCount === 0) {
                    return;
                }

                const percentage = mouseX / overlayRect.width;

                const rawIndex = percentage * (dataPointCount - 1);
                const nearestIndex = Math.round(Math.max(0, Math.min(dataPointCount - 1, rawIndex)));

                this.hoveredDataIndex = nearestIndex;
                this.crosshairX = this.scaleX(nearestIndex, dataPointCount);

                const svgRect = svg.getBoundingClientRect();
                const scaleFactor = svgRect.width / this.width;

                this.tooltipPosition = {
                    x: (this.crosshairX * scaleFactor),
                    y: 20,
                };
            },

            handleChartLeave(): void {
                if (!this.interactive) {
                    return;
                }

                this.hoveredDataIndex = null;
                this.crosshairX = 0;
            },

            init(): void {
                this.$nextTick?.(() => {
                    this.renderChart();

                    this.$watch?.('chartSeries', () => this.renderChart());
                    this.$watch?.('type', () => this.renderChart());
                    this.$watch?.('showGrid', () => this.renderChart());
                    this.$watch?.('showAxes', () => this.renderChart());
                });
            },
        };
    });
}
