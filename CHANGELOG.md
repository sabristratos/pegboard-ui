# Changelog

All notable changes to `Pegboard` will be documented in this file.

## [Unreleased]

### Added
- Nothing yet

### Changed
- Nothing yet

### Deprecated
- Nothing yet

### Removed
- Nothing yet

### Fixed
- Nothing yet

### Security
- Nothing yet

## [0.1.3] - 2025-10-25

### Fixed
- Select component now properly updates display text when Livewire changes the value
- Fixed wire: attribute handling on select component for better Livewire compatibility
- Improved checkbox and radio component attribute handling

### Changed
- Toast component code cleanup

## [0.1.2] - 2025-10-24

### Fixed
- Include built assets (`dist/`) in Composer distribution to fix 500 error when loading JavaScript
- Assets are now committed to repository instead of being gitignored
- Source maps (`.map` files) excluded from distribution via `.gitattributes`

## [0.1.1] - 2025-10-24

### Fixed
- GitHub Actions CI workflows for proper Laravel 11/12 testing
- Orchestra Testbench version compatibility (v9 for Laravel 11, v10 for Laravel 12)
- NPM dependency installation in CI (removed cache requirement, use `npm install`)
- Composer dependency resolution with `--with-all-dependencies` flag

## [0.1.0] - 2025-10-24

### Added
- Initial package structure
- Laravel service provider with auto-discovery
- TypeScript support and type definitions
- Alpine.js component system
- Comprehensive component library:
  - Form components: Button, Input, Textarea, Select, Radio, Checkbox, Range, Rating
  - Layout components: Card, Modal, Dropdown, Popover, Tooltip, Accordion, Tabs
  - Navigation components: Sidebar, Breadcrumbs, NavMenu
  - Display components: Alert, Badge, Avatar, Status, Spinner, Icon, Table
  - Interactive components: Carousel, Toast, Timer, File Upload, Date Picker, Time Picker
  - Editor component with TipTap integration
- Utility helper functions (classNames, uniqueId, debounce, throttle)
- PHPUnit testing setup
- Tailwind CSS v4 theme tokens
- Dark mode support
- Comprehensive documentation (28 component docs)
- Vite build configuration
- Auto-component registration system
