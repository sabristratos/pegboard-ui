<div class="flex items-center justify-between mb-3 pb-3 bg-accent/10 -mx-3 -mt-3 px-3 pt-3 rounded-t-lg border-b border-border">
    <div class="flex items-center gap-2">
        <button
            type="button"
            @click="switchToMonthsView"
            x-show="view === 'days'"
            x-text="monthNames[month]"
            class="text-base font-semibold text-foreground hover:text-accent-foreground transition-colors duration-fast"
        ></button>
        <span x-show="view === 'months'" x-text="year" class="text-base font-semibold text-foreground"></span>
        <span x-show="view === 'years'" class="text-base font-semibold text-foreground">Select Year</span>

        <button
            type="button"
            @click="switchToYearsView"
            x-show="view === 'days' || view === 'months'"
            x-text="year"
            class="ml-1 text-base text-muted-foreground hover:text-accent-foreground transition-colors duration-fast"
        ></button>
    </div>
    <div class="flex items-center gap-1">
        <template x-if="view === 'days'">
            <div class="flex items-center gap-1">
                <button
                    type="button"
                    @click="previousMonth"
                    class="inline-flex items-center justify-center h-8 w-8 rounded-md text-muted-foreground hover:bg-popover-hover hover:text-popover-hover-foreground transition-colors duration-fast"
                    aria-label="Previous month"
                >
                    <x-pegboard::icon name="chevron-left" class="h-4 w-4" />
                </button>
                <button
                    type="button"
                    @click="nextMonth"
                    class="inline-flex items-center justify-center h-8 w-8 rounded-md text-muted-foreground hover:bg-popover-hover hover:text-popover-hover-foreground transition-colors duration-fast"
                    aria-label="Next month"
                >
                    <x-pegboard::icon name="chevron-right" class="h-4 w-4" />
                </button>
            </div>
        </template>

        <template x-if="view === 'years'">
            <div class="flex items-center gap-1">
                <button
                    type="button"
                    @click="previousYearRange"
                    class="inline-flex items-center justify-center h-8 w-8 rounded-md text-muted-foreground hover:bg-popover-hover hover:text-popover-hover-foreground transition-colors duration-fast"
                    aria-label="Previous years"
                >
                    <x-pegboard::icon name="chevron-left" class="h-4 w-4" />
                </button>
                <button
                    type="button"
                    @click="nextYearRange"
                    class="inline-flex items-center justify-center h-8 w-8 rounded-md text-muted-foreground hover:bg-popover-hover hover:text-popover-hover-foreground transition-colors duration-fast"
                    aria-label="Next years"
                >
                    <x-pegboard::icon name="chevron-right" class="h-4 w-4" />
                </button>
            </div>
        </template>
    </div>
</div>

<template x-if="view === 'days'">
    <div>
        <div class="grid grid-cols-7 mb-2">
            <template x-for="(dayName, index) in dayNames" :key="index">
                <div class="flex items-center justify-center h-8">
                    <span x-text="dayName" class="text-xs font-medium text-muted-foreground"></span>
                </div>
            </template>
        </div>

        <div class="grid grid-cols-7 gap-0.5 sm:gap-1">
            <template x-for="blankDay in blankDaysInMonth" :key="'blank-' + blankDay">
                <div class="aspect-square"></div>
            </template>

            <template x-for="(dayNum, dayIndex) in daysInMonth" :key="dayIndex">
                <div class="aspect-square">
                    <button
                        type="button"
                        x-text="dayNum"
                        @click="selectDay(dayNum)"
                        @mouseenter="range && (hoveredDate = new Date(year, month, dayNum))"
                        @mouseleave="range && (hoveredDate = null)"
                        :class="{
                            'bg-primary text-primary-foreground rounded-l-md hover:bg-primary/90': isStartDate(dayNum),
                            'bg-primary text-primary-foreground rounded-r-md hover:bg-primary/90': isEndDate(dayNum),
                            'bg-popover-hover/50 text-foreground rounded-none': isInRange(dayNum) && !isStartDate(dayNum) && !isEndDate(dayNum),
                            'bg-popover-hover/25 text-foreground rounded-none': isInPreviewRange(dayNum),

                            'bg-popover-hover/30 text-foreground': !range && isToday(dayNum) && !isSelectedDate(dayNum),
                            'bg-primary text-primary-foreground hover:bg-primary/90': !range && isSelectedDate(dayNum),
                            'text-foreground hover:bg-popover-hover hover:text-popover-hover-foreground': !range && !isToday(dayNum) && !isSelectedDate(dayNum) || (range && !isStartDate(dayNum) && !isEndDate(dayNum) && !isInRange(dayNum) && !isInPreviewRange(dayNum))
                        }"
                        class="flex items-center justify-center w-full h-full text-sm transition-colors duration-fast focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2"
                    ></button>
                </div>
            </template>
        </div>
    </div>
</template>

<template x-if="view === 'months'">
    <div class="grid grid-cols-3 gap-2">
        <template x-for="(monthName, monthIndex) in monthNames" :key="monthIndex">
            <button
                type="button"
                x-text="monthName.substring(0, 3)"
                @click="selectMonth(monthIndex)"
                :class="{
                    'bg-popover-hover/30 text-foreground': isCurrentMonth(monthIndex) && !isSelectedMonth(monthIndex),
                    'bg-primary text-primary-foreground hover:bg-primary/90': isSelectedMonth(monthIndex),
                    'text-foreground hover:bg-popover-hover hover:text-popover-hover-foreground': !isCurrentMonth(monthIndex) && !isSelectedMonth(monthIndex)
                }"
                class="px-3 py-2 text-sm font-medium rounded-md transition-colors duration-fast focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2"
            ></button>
        </template>
    </div>
</template>

<template x-if="view === 'years'">
    <div class="grid grid-cols-3 gap-2">
        <template x-for="(yearNum, yearIndex) in yearRange" :key="yearIndex">
            <button
                type="button"
                x-text="yearNum"
                @click="selectYear(yearNum)"
                :class="{
                    'bg-popover-hover/30 text-foreground': isCurrentYear(yearNum) && !isSelectedYear(yearNum),
                    'bg-primary text-primary-foreground hover:bg-primary/90': isSelectedYear(yearNum),
                    'text-foreground hover:bg-popover-hover hover:text-popover-hover-foreground': !isCurrentYear(yearNum) && !isSelectedYear(yearNum)
                }"
                class="px-3 py-2 text-sm font-medium rounded-md transition-colors duration-fast focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2"
            ></button>
        </template>
    </div>
</template>

<div class="flex gap-2 mt-3 pt-3 border-t border-border">
    <button
        type="button"
        @click="selectToday"
        class="flex-1 px-3 py-1.5 text-sm rounded border border-border text-foreground hover:bg-popover-hover hover:text-popover-hover-foreground hover:border-popover-hover transition-colors duration-fast"
    >
        Today
    </button>
    <button
        type="button"
        @click="clear"
        class="flex-1 px-3 py-1.5 text-sm rounded border border-border text-foreground hover:bg-popover-hover hover:text-popover-hover-foreground hover:border-popover-hover transition-colors duration-fast"
    >
        Clear
    </button>
</div>
