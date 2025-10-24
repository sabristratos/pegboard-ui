<div class="flex items-center justify-center gap-2 mt-4">
    <template x-for="(item, index) in totalSlides" :key="index">
        <button
            x-on:click="goTo(index)"
            :class="{
                'bg-primary w-6': currentIndex === index,
                'bg-muted hover:bg-muted-foreground/30': currentIndex !== index
            }"
            class="h-2 w-2 rounded-full transition-all duration-fast focus-visible:outline-2 focus-visible:outline-ring"
            :aria-label="'Go to slide ' + (index + 1)"
            :aria-current="currentIndex === index ? 'true' : 'false'"
        ></button>
    </template>
</div>
