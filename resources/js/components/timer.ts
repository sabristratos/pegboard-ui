import type { Alpine, AlpineData } from '../types/alpine';
import type { TimerOptions, TimerState } from '../types/components';

export function timer(Alpine: Alpine): void {
    Alpine.data('timer', (options: TimerOptions = {}): AlpineData<TimerState> => ({
        timeRemaining: options.mode === 'stopwatch' ? 0 : (options.duration ?? 60),
        isRunning: false,
        isPaused: false,
        mode: options.mode ?? 'countdown',
        initialDuration: options.duration ?? 60,
        disabled: options.disabled ?? false,
        showHours: options.showHours ?? true,
        intervalId: null,

        get formattedTime(): string {
            return this.formatTime(this.timeRemaining);
        },

        init() {
            if (options.autostart && !this.disabled) {
                this.$nextTick?.(() => {
                    this.start();
                });
            }

            this.$watch?.('$el', (value: any) => {
                if (!value) {
                    this.destroy();
                }
            });
        },

        start() {
            if (this.disabled || this.isRunning) {
                return;
            }

            this.isRunning = true;
            this.isPaused = false;

            this.$dispatch?.('timer:start', {
                mode: this.mode,
                time: this.timeRemaining,
            });

            this.intervalId = setInterval(() => {
                this.tick();
            }, 1000);
        },

        pause() {
            if (!this.isRunning || this.isPaused) {
                return;
            }

            this.isPaused = true;
            this.isRunning = false;

            if (this.intervalId !== null) {
                clearInterval(this.intervalId);
                this.intervalId = null;
            }

            this.$dispatch?.('timer:pause', {
                mode: this.mode,
                time: this.timeRemaining,
            });
        },

        resume() {
            if (!this.isPaused || this.disabled) {
                return;
            }

            this.isRunning = true;
            this.isPaused = false;

            this.$dispatch?.('timer:resume', {
                mode: this.mode,
                time: this.timeRemaining,
            });

            this.intervalId = setInterval(() => {
                this.tick();
            }, 1000);
        },

        reset() {
            this.stop();

            if (this.mode === 'countdown') {
                this.timeRemaining = this.initialDuration;
            } else {
                this.timeRemaining = 0;
            }

            this.isRunning = false;
            this.isPaused = false;

            this.$dispatch?.('timer:reset', {
                mode: this.mode,
                time: this.timeRemaining,
            });
        },

        stop() {
            if (this.intervalId !== null) {
                clearInterval(this.intervalId);
                this.intervalId = null;
            }
            this.isRunning = false;
            this.isPaused = false;
        },

        tick() {
            if (this.mode === 'countdown') {
                this.timeRemaining -= 1;

                this.$dispatch?.('timer:tick', {
                    mode: this.mode,
                    time: this.timeRemaining,
                });

                if (this.timeRemaining <= 0) {
                    this.timeRemaining = 0;
                    this.stop();

                    this.$dispatch?.('timer:complete', {
                        mode: this.mode,
                    });
                }
            } else {
                this.timeRemaining += 1;

                this.$dispatch?.('timer:tick', {
                    mode: this.mode,
                    time: this.timeRemaining,
                });
            }
        },

        formatTime(seconds: number): string {
            const hours = Math.floor(seconds / 3600);
            const minutes = Math.floor((seconds % 3600) / 60);
            const secs = seconds % 60;

            const displayHours = this.showHours && (hours > 0 || this.initialDuration >= 3600);

            const pad = (num: number): string => num.toString().padStart(2, '0');

            if (displayHours) {
                return `${pad(hours)}:${pad(minutes)}:${pad(secs)}`;
            }

            return `${pad(minutes)}:${pad(secs)}`;
        },

        destroy() {
            if (this.intervalId !== null) {
                clearInterval(this.intervalId);
                this.intervalId = null;
            }
        },
    }));
}
