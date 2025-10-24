export function cn(...classes: (string | undefined | null | false)[]): string {
  return classes.filter(Boolean).join(' ');
}

export function clamp(value: number, min: number, max: number): number {
  return Math.min(Math.max(value, min), max);
}

export function debounce<T extends (...args: unknown[]) => unknown>(
  func: T,
  wait: number
): (...args: Parameters<T>) => void {
  let timeout: ReturnType<typeof setTimeout> | null = null;

  return function (this: unknown, ...args: Parameters<T>) {
    if (timeout) {
      clearTimeout(timeout);
    }

    timeout = setTimeout(() => {
      func.apply(this, args);
    }, wait);
  };
}

export function generateId(prefix: string = 'pegboard'): string {
  return `${prefix}-${Math.random().toString(36).substring(2, 9)}`;
}

export function prefersReducedMotion(): boolean {
  return window.matchMedia('(prefers-reduced-motion: reduce)').matches;
}

export function isDarkMode(): boolean {
  return window.matchMedia('(prefers-color-scheme: dark)').matches;
}

export function getCSSVariable(variable: string, element: HTMLElement = document.documentElement): string {
  return getComputedStyle(element).getPropertyValue(variable).trim();
}

export function setCSSVariable(variable: string, value: string, element: HTMLElement = document.documentElement): void {
  element.style.setProperty(variable, value);
}
