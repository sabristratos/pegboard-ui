export interface AlpineMagicProperties {
    $el: HTMLElement;
    $refs: Record<string, HTMLElement | HTMLElement[]>;
    $watch: (property: string, callback: (value: any) => void) => void;
    $nextTick: (callback: () => void) => void;
    $dispatch: (event: string, detail?: any) => void;
}

export type AlpineData<T = any> = T & Partial<AlpineMagicProperties>;

export type PopoverPlacement =
    | 'top'
    | 'top-start'
    | 'top-end'
    | 'bottom'
    | 'bottom-start'
    | 'bottom-end'
    | 'left'
    | 'left-start'
    | 'left-end'
    | 'right'
    | 'right-start'
    | 'right-end';

export type PopoverTrigger = 'click' | 'hover';

export interface PopoverOptions {
    placement?: PopoverPlacement;
    trigger?: PopoverTrigger;
    offset?: number;
}

export interface PopoverState {
    isOpen: boolean;
    trigger: PopoverTrigger;
    placement: PopoverPlacement;
    offset: number;
    closeTimeout: ReturnType<typeof setTimeout> | null;

    init(): void;
    open(): void;
    close(): void;
    toggle(): void;
    keepOpen(): void;
}
export interface InputOptions {
    clearable?: boolean;
    showPassword?: boolean;
    copy?: boolean;
    viewInNewPage?: boolean;
}

export interface InputState {
    inputType: string;
    passwordVisible: boolean;
    copied: boolean;
    clearable: boolean;
    showPassword: boolean;
    copy: boolean;
    viewInNewPage: boolean;

    init(): void;
    clear(): void;
    togglePasswordVisibility(): void;
    copyToClipboard(): Promise<void>;
    isValidUrl(): boolean;
}

export interface AutocompleteItem {
    text: string;
    disabled: boolean;
    element: HTMLElement;
}

export interface AutocompleteState {
    clearable: boolean;
    open: boolean;
    value: string;
    searchValue: string;
    items: AutocompleteItem[];
    filteredItems: AutocompleteItem[];
    activeIndex: number;
    blurTimeout: ReturnType<typeof setTimeout> | null;

    init(): void;
    registerItem(item: AutocompleteItem): void;
    onInput(): void;
    onFocus(): void;
    onBlur(): void;
    close(): void;
    clear(): void;
    filterItems(): void;
    isItemVisible(text: string): boolean;
    getItemIndex(element: HTMLElement): number;
    navigateDown(): void;
    navigateUp(): void;
    selectActive(): void;
    selectItem(element: HTMLElement): void;
    scrollToActive(): void;
}
export type DropdownPosition = 'top' | 'bottom' | 'left' | 'right';

export type DropdownAlign = 'start' | 'center' | 'end';
export interface DropdownOptions {
    position?: DropdownPosition;
    align?: DropdownAlign;
    offset?: number;
    gap?: number;
}

export interface DropdownState {
    open: boolean;
    position: DropdownPosition;
    align: DropdownAlign;
    offset: number;
    gap: number;
    placement: PopoverPlacement;

    init(): void;
    toggle(): void;
    close(): void;
    getPlacement(): PopoverPlacement;
}

export interface MenuItem {
    element: HTMLElement;
    disabled: boolean;
    isSubmenu: boolean;
}

export interface MenuOptions {
    keepOpen?: boolean;
}

export interface MenuState {
    keepOpen: boolean;
    items: MenuItem[];
    activeIndex: number;
    parentMenu: MenuState | null;

    init(): void;
    registerItem(item: MenuItem): void;
    unregisterItem(element: HTMLElement): void;
    close(): void;
    navigateDown(): void;
    navigateUp(): void;
    activateItem(index: number): void;
    selectActive(): void;
    focusItem(index: number): void;
    resetActiveIndex(): void;
}

export interface MenuSubmenuOptions {
    heading?: string;
    keepOpen?: boolean;
}

export interface MenuSubmenuState {
    open: boolean;
    keepOpen: boolean;
    items: MenuItem[];
    activeIndex: number;
    parentMenu: MenuState | null;
    closeTimeout: ReturnType<typeof setTimeout> | null;
    isTouchDevice: boolean;

    init(): void;
    toggle(): void;
    openSubmenu(): void;
    close(): void;
    closeDelayed(): void;
    cancelClose(): void;
    handleTriggerClick(): void;
    registerItem(item: MenuItem): void;
    navigateDown(): void;
    navigateUp(): void;
    navigateRight(): void;
    navigateLeft(): void;
    selectActive(): void;
    focusItem(index: number): void;
}

export type ModalVariant = 'default' | 'flyout';

export type ModalPosition = 'left' | 'right' | 'bottom';

export interface ModalOptions {
    name?: string;
    variant?: ModalVariant;
    position?: ModalPosition;
    dismissible?: boolean;
    closable?: boolean;
}

export interface ModalState {
    isOpen: boolean;
    name: string;
    variant: ModalVariant;
    dismissible: boolean;
    closable: boolean;

    init(): void;
    open(): void;
    close(): void;
    toggle(): void;
}

export interface FileUploadOptions {
    multiple?: boolean;
    disabled?: boolean;
}

export interface SelectedFileMetadata {
    name: string;
    size: number;
    type: string;
    previewUrl?: string;
}

export interface FileUploadState {
    isDragging: boolean;
    isInvalidType: boolean;
    isLoading: boolean;
    progress: number;
    hasError: boolean;
    multiple: boolean;
    disabled: boolean;
    modelName: string | null;
    listeners: Array<{ event: string; handler: (e: Event) => void }>;
    selectedFiles: SelectedFileMetadata[];

    init(): void;
    destroy(): void;
    setupLivewireListeners(input: HTMLInputElement): void;
    getWireModelName(input: HTMLInputElement): string | null;
    isValidFileType(items: DataTransferItemList | null): boolean;
    processFiles(files: FileList): Promise<void>;
    removeFile(index: number): void;
    openFileSelector(): void;
    onChange(): void;
    onDragEnter(event: DragEvent): void;
    onDragLeave(event: DragEvent): void;
    onDragOver(event: DragEvent): void;
    onDrop(event: DragEvent): void;
}

export type TimeFormat = '12' | '24';

export interface TimePickerOptions {
    format?: TimeFormat;
    step?: number;
    disabled?: boolean;
}

export interface TimePickerState {
    format: TimeFormat;
    step: number;
    disabled: boolean;
    isOpen: boolean;
    selectedHour: number | null;
    selectedMinute: number | null;
    period: 'AM' | 'PM';
    hours: number[];
    minutes: number[];
    displayTime: string;

    init(): void;
    generateHours(): void;
    generateMinutes(): void;
    formatHour(hour: number): string;
    formatMinute(minute: number): string;
    parseInputValue(): void;
    roundToStep(minute: number): number;
    selectHour(hour: number): void;
    selectMinute(minute: number): void;
    selectPeriod(period: 'AM' | 'PM'): void;
    updateInput(): void;
    onInput(): void;
    onBlur(): void;
    selectCurrentTime(): void;
    togglePopover(): void;
    openPopover(): void;
    closePopover(): void;
    setNow(): void;
    clearTime(): void;
}

export type ToastVariant = 'default' | 'success' | 'warning' | 'danger';

export type ToastPosition =
    | 'top start'
    | 'top center'
    | 'top end'
    | 'bottom start'
    | 'bottom center'
    | 'bottom end';
export interface ToastAction {
    label: string;
    onClick: () => void;
}

export interface ToastOptions {
    heading?: string;
    text?: string;
    variant?: ToastVariant;
    duration?: number;
    action?: ToastAction;
}

export interface ToastItem extends Required<ToastOptions> {
    id: number;
    visible: boolean;
    createdAt?: number;
    paused?: boolean;
    remainingDuration?: number;
}

export interface RatingOptions {
    maxStars?: number;
    disabled?: boolean;
}

export interface RatingState {
    maxStars: number;
    disabled: boolean;
    stars: number;
    value: number;

    init(): void;
    hoverStar(star: number): void;
    resetHover(): void;
    rate(star: number): void;
    reset(): void;
}

export type TabVariant = 'default' | 'segmented' | 'pills';

export type TabSize = 'sm' | 'base' | 'lg';

export type TabOrientation = 'horizontal' | 'vertical';

export type TabBadgeVariant = 'default' | 'primary' | 'success' | 'warning' | 'danger';

export interface TabsOptions {
    initialTab?: string;
    variant?: TabVariant;
    size?: TabSize;
    orientation?: TabOrientation;
}

export interface TabsState {
    activeTab: string;
    variant: TabVariant;
    size: TabSize;
    orientation: TabOrientation;
    tabButtons: HTMLElement[];
    markerEl: HTMLElement | null;
    markerPositioned: boolean;
    showLeftFade: boolean;
    showRightFade: boolean;

    init(): void;
    selectTab(name: string): void;
    isActive(name: string): boolean;
    registerTab(element: HTMLElement): void;
    updateMarker(): void;
    repositionMarker(tabButton: HTMLElement): void;
    updateScrollFades(): void;
    handleKeydown(event: KeyboardEvent): void;
    navigateNext(): void;
    navigatePrevious(): void;
    focusTab(index: number): void;
}
export type EditorHeadingLevel = 1 | 2 | 3 | 4 | 5 | 6;

export interface EditorOptions {
    content?: string;
    editable?: boolean;
    placeholder?: string;
    name?: string;
}

export interface EditorState {
    updatedAt: number;
    loaded: boolean;

    init(): void;
    isLoaded(): boolean;
    isActive(type: string, attributes?: Record<string, any>): boolean;
    toggleBold(): void;
    toggleItalic(): void;
    toggleCode(): void;
    toggleHeading(level: EditorHeadingLevel): void;
    toggleBulletList(): void;
    toggleOrderedList(): void;
    setLink(url: string): void;
    unsetLink(): void;
    getLinkUrl(): string | null;
    insertImage(): void;
    handleImageUpload(event: Event): void;
    clearFormatting(): void;
    getContent(): string;
    setContent(content: string): void;
    focus(): void;
    syncToTextarea(): void;
    destroy(): void;
}
export type ChartType = 'bar' | 'line' | 'area';

export interface ChartDataSeries {
    label: string;
    values: number[];
    color?: string | number;
}

export interface ChartPoint {
    x: number;
    y: number;
    value: number;
    index: number;
    seriesIndex: number;
}

export interface ChartSeries {
    label: string;
    data: number[];
    color: string;
    points: ChartPoint[];
    linePath: string;
    areaPath: string;
}

export interface ChartOptions {
    type?: ChartType;
    series?: ChartDataSeries[];
    labels?: string[];
    colors?: string[];
    animated?: boolean;
    interactive?: boolean;
    showGrid?: boolean;
    showAxes?: boolean;
    chartId?: string;
    showLegend?: boolean;
    legendPosition?: 'top' | 'bottom';
    barSize?: number;
}

export interface ChartState {
    type: ChartType;
    labels: string[];
    colors: string[];
    animated: boolean;
    interactive: boolean;
    showGrid: boolean;
    showAxes: boolean;
    chartId: string;
    barSize: number;
    hoveredDataIndex: number | null;
    crosshairX: number;
    tooltipPosition: { x: number; y: number };
    viewBox: string;
    width: number;
    height: number;
    padding: {
        top: number;
        right: number;
        bottom: number;
        left: number;
    };
    readonly chartWidth: number;
    readonly chartHeight: number;
    readonly plotWidth: number;
    readonly plotHeight: number;
    readonly chartSeries: ChartSeries[];
    readonly dataRange: { min: number; max: number };
    readonly barWidth: number;
    readonly tooltipContent: {
        label: string;
        series: Array<{ name: string; value: string; color: string }>
    };
    readonly ariaLabel: string;

    scaleX(index: number, total: number): number;
    scaleY(value: number): number;
    calculatePoints(values: number[], seriesIndex: number): ChartPoint[];
    generateLinePath(points: ChartPoint[]): string;
    generateAreaPath(points: ChartPoint[]): string;
    formatValue(value: number): string;
    createSVGElement(tag: string, attrs?: Record<string, string | number>, classes?: string[]): SVGElement;
    clearContainer(selector: string): void;
    setAttrs(element: SVGElement, attrs: Record<string, string | number>): void;
    renderYAxis(): void;
    renderXAxis(): void;
    renderGradients(): void;
    renderGrid(): void;
    renderAxes(): void;
    renderBars(): void;
    renderLines(): void;
    renderAreas(): void;
    renderChart(): void;
    init(): void;
}

export interface RangeThumb {
    value: number;
    percentage: number;
    dragging: boolean;
}

export interface RangeOptions {
    min?: number;
    max?: number;
    step?: number;
    orientation?: 'horizontal' | 'vertical';
    isRange?: boolean;
    thumbs?: Array<{ value: number; percentage: number }>;
    formatOptions?: Intl.NumberFormatOptions | null;
    rangeId?: string;
    initialValue?: number | number[];
    disabled?: boolean;
}

export interface RangeState {
    min: number;
    max: number;
    step: number;
    orientation: 'horizontal' | 'vertical';
    isRange: boolean;
    formatOptions: Intl.NumberFormatOptions | null;
    value: number | number[];
    thumbsState: RangeThumb[];
    draggingThumbIndex: number | null;
    isDragging: boolean;
    _pendingValue: number | undefined;
    rangeId: string;
    thumbInputIds: string[];
    tooltipValue: string;
    tooltipVisible: boolean;
    readonly formattedValue: string;
    readonly fillerStyle: string;

    init(): void;
    formatValue(value: number): string;
    thumbStyle(index: number): string;
    stepStyle(stepIndex: number): string;
    isStepInRange(stepIndex: number): boolean;
    getThumbMin(index: number): number;
    getThumbMax(index: number): number;
    startDrag(event: MouseEvent | TouchEvent, index: number): void;
    handleDrag(event: MouseEvent | TouchEvent): void;
    stopDrag(): void;
    handleTrackClick(event: MouseEvent): void;
    handleKeyDown(event: KeyboardEvent, index: number): void;
    updateThumbValue(index: number, value: number, syncToLivewire?: boolean): void;
    valueToPercentage(value: number): number;
    roundToPrecision(value: number): number;
    syncValueToLivewire(): void;
    syncFromValue(newValue: number | number[]): void;
}

export type TimerMode = 'countdown' | 'stopwatch';

export interface TimerOptions {
    duration?: number;
    mode?: TimerMode;
    autostart?: boolean;
    disabled?: boolean;
    showHours?: boolean;
}

export interface TimerState {
    timeRemaining: number;
    isRunning: boolean;
    isPaused: boolean;
    mode: TimerMode;
    initialDuration: number;
    disabled: boolean;
    showHours: boolean;
    intervalId: ReturnType<typeof setInterval> | null;
    readonly formattedTime: string;

    init(): void;
    start(): void;
    pause(): void;
    resume(): void;
    reset(): void;
    stop(): void;
    tick(): void;
    formatTime(seconds: number): string;
    destroy(): void;
}

export interface CarouselOptions {
    autoPlay?: boolean;
    interval?: number;
    pauseOnHover?: boolean;
    loop?: boolean;
}

export interface CarouselState {
    currentIndex: number;
    totalSlides: number;
    isAutoPlaying: boolean;
    isPaused: boolean;
    isDragging: boolean;
    startX: number;
    scrollLeft: number;
    intervalId: number | null;
    canGoPrev: boolean;
    canGoNext: boolean;
    autoPlay: boolean;
    interval: number;
    pauseOnHover: boolean;
    loop: boolean;

    init(): void;
    destroy(): void;
    updateSlideCount(): void;
    updateNavigation(): void;
    next(): void;
    prev(): void;
    goTo(index: number): void;
    onScroll(): void;
    startAutoPlay(): void;
    stopAutoPlay(): void;
    restartAutoPlay(): void;
    pause(): void;
    resume(): void;
    setupGestures(): void;
}
