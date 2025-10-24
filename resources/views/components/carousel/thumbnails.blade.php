<div class="flex items-center justify-center gap-2 mt-4 py-2 overflow-x-auto scrollbar-thin">
    <template x-for="(item, index) in totalSlides" :key="index">
        <button
            x-on:click="goTo(index)"
            :class="{
                'ring-2 ring-primary': currentIndex === index,
                'opacity-60 hover:opacity-100': currentIndex !== index
            }"
            class="flex-shrink-0 h-16 w-20 rounded-lg overflow-hidden border border-border transition-all duration-fast focus-visible:outline-2 focus-visible:outline-ring"
            :aria-label="'Go to slide ' + (index + 1)"
            :aria-current="currentIndex === index ? 'true' : 'false'"
        >
            <div class="h-full w-full bg-muted flex items-center justify-center text-muted-foreground text-xs" x-text="index + 1"></div>
        </button>
    </template>
</div>
