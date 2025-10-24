# File Upload Component

A flexible, accessible file upload component with drag-and-drop support, client-side preview, real-time file type validation, progress tracking, and seamless Livewire integration.

## Table of Contents

- [Overview](#overview)
- [Basic Usage](#basic-usage)
- [Component Structure](#component-structure)
- [Props Reference](#props-reference)
- [Features](#features)
  - [Drag and Drop](#drag-and-drop)
  - [Client-Side Previews](#client-side-previews)
  - [File Type Validation](#file-type-validation)
  - [Progress Tracking](#progress-tracking)
  - [Multiple Files](#multiple-files)
  - [Error States](#error-states)
- [Dropzone Variants](#dropzone-variants)
- [Avatar Upload Component](#avatar-upload-component)
- [Livewire Integration](#livewire-integration)
- [Examples](#examples)
- [Best Practices](#best-practices)
- [Accessibility](#accessibility)

## Overview

The Pegboard file upload component provides an intuitive, user-friendly interface for file uploads with comprehensive drag-and-drop support. Built with Alpine.js, Tailwind CSS v4, and Livewire, it features real-time validation, progress tracking, and elegant visual feedback.

**Key Features:**
- Full drag-and-drop support with visual feedback
- Client-side image previews using FileReader API
- Real-time file type validation with warning indicators
- Livewire upload progress tracking
- Multiple file uploads
- Single and multiple file modes
- Customizable dropzone layouts (block, inline, with progress bar)
- Specialized avatar upload component with inline preview
- Error state handling with visual feedback
- Click-to-browse fallback
- Loading animations with pulse effect
- Keyboard accessibility
- Composable architecture (base + dropzone)
- Server-side validation integration

## Basic Usage

### Simple File Upload

```blade
{{-- Single file upload with default dropzone --}}
<x-pegboard::file-upload wire:model="avatar">
    <x-pegboard::file-upload-dropzone
        heading="Drop your avatar here"
        text="JPG, PNG, or GIF up to 10MB"
    />
</x-pegboard::file-upload>
```

### Multiple File Upload

```blade
{{-- Multiple files upload --}}
<x-pegboard::file-upload wire:model="photos" multiple>
    <x-pegboard::file-upload-dropzone
        heading="Drop photos here"
        text="JPG, PNG up to 10MB each (Max 5 files)"
        inline
    />
</x-pegboard::file-upload>
```

### With Progress Bar

```blade
{{-- Upload with progress tracking --}}
<x-pegboard::file-upload wire:model="documents" multiple>
    <x-pegboard::file-upload-dropzone
        heading="Upload documents"
        text="PDF, DOC, DOCX up to 50MB"
        with-progress
        inline
    />
</x-pegboard::file-upload>
```

### In a Form Field

```blade
{{-- Complete form field example --}}
<x-pegboard::field>
    <x-pegboard::label for="resume">Resume</x-pegboard::label>
    <x-pegboard::file-upload
        wire:model="resume"
        accept=".pdf,.doc,.docx"
    >
        <x-pegboard::file-upload-dropzone
            heading="Drop your resume here"
            text="PDF, DOC, or DOCX up to 5MB"
        />
    </x-pegboard::file-upload>
    <x-pegboard::description>
        We accept PDF, DOC, and DOCX formats only.
    </x-pegboard::description>
    <x-pegboard::error name="resume" />
</x-pegboard::field>
```

## Component Structure

The file upload system uses two main components:

- `<x-pegboard::file-upload>` - Base component with drag/drop functionality
- `<x-pegboard::file-upload-dropzone>` - Visual dropzone with icon, heading, and text

## Props Reference

### FileUpload (Base Component)

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `name` | string | `null` | Name attribute for the input (auto-detected from `wire:model` if not provided) |
| `multiple` | boolean | `false` | Allow multiple file selection |
| `label` | string | `null` | Label text displayed above the dropzone |
| `description` | string | `null` | Helper text displayed below the dropzone |
| `error` | string | `null` | Error message displayed below the dropzone |
| `disabled` | boolean | `false` | Disable the file upload |
| `accept` | string | `null` | File type filter (MIME types or extensions, e.g., `"image/*"` or `".pdf,.doc"`) |

**Additional attributes:**
- `wire:model` - Livewire property binding (automatically detected)
- `class` - Additional CSS classes for the wrapper
- `id` - Custom ID for the file input

### FileUploadDropzone (Presentation Component)

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `heading` | string | `null` | Main heading text displayed in the dropzone |
| `text` | string | `null` | Description text displayed below the heading |
| `icon` | string | `'cloud-arrow-up'` | Heroicon name for the upload icon |
| `inline` | boolean | `false` | Use inline horizontal layout instead of vertical |
| `with-progress` | boolean | `false` | Show upload progress bar with percentage |

## Features

### Drag and Drop

The component provides seamless drag-and-drop functionality with visual feedback:

**Visual States:**
- **Default** - Normal border and background
- **Dragging** - Blue border (`border-primary`) with light blue background (`bg-primary/5`)
- **Invalid Type** - Orange/warning border (`border-warning`) with warning background (`bg-warning/5`)
- **Loading** - Pulsing animation (`animate-pulse`) with reduced opacity
- **Error** - Red border (`border-destructive`) with error background (`bg-destructive/5`)

**Drag Behavior:**
```blade
{{-- Drag a file over the dropzone --}}
1. Border changes to blue (valid file)
2. Background tints blue
3. Cursor shows "copy" effect

{{-- Drop the file --}}
4. File is assigned to input
5. Livewire picks up the file
6. Progress tracking begins (if wire:model present)
```


### Client-Side Previews

The file upload component automatically generates instant client-side previews for image files using the FileReader API. This provides immediate visual feedback before uploading to the server.

**How It Works:**

When users select or drop image files, the component automatically generates instant previews without any server request.

**Usage:**

```blade
{{-- Previews are automatically generated for images --}}
<x-pegboard::file-upload wire:model="photos" multiple accept="image/*">
    <x-pegboard::file-upload-dropzone heading="Drop photos" />
</x-pegboard::file-upload>

{{-- Default preview list shows below dropzone:
     - Image thumbnail (10x10, rounded, object-cover)
     - File name (truncated)
     - File size (formatted KB/MB)
     - Remove button (X icon)
--}}
```


**Default Preview Layout:**

The default preview list appears below the dropzone and displays:

```blade
{{-- Auto-generated preview card --}}
<div class="flex items-center gap-3 p-3 rounded-lg border border-border bg-card">
    {{-- Image preview or document icon --}}
    <img src="data:image/jpeg;base64,..." class="h-10 w-10 rounded object-cover">

    {{-- File info --}}
    <div class="flex-1 min-w-0">
        <p class="text-sm font-medium truncate">photo.jpg</p>
        <p class="text-xs text-muted-foreground">2.4 MB</p>
    </div>

    {{-- Remove button --}}
    <button @click="removeFile(0)">
        <x-pegboard::icon name="x-mark" variant="mini" />
    </button>
</div>
```

**Custom Preview Templates:**

You can override the default preview list using the `previews` slot:

```blade
<x-pegboard::file-upload wire:model="photos" multiple>
    <x-pegboard::file-upload-dropzone heading="Drop photos" />

    <x-slot:previews>
        <template x-if="selectedFiles.length > 0">
            <div class="mt-4 grid grid-cols-3 gap-4">
                <template x-for="(file, index) in selectedFiles" :key="index">
                    <div class="relative group">
                        {{-- Custom preview card --}}
                        <img
                            x-bind:src="file.previewUrl"
                            x-bind:alt="file.name"
                            class="w-full aspect-square object-cover rounded-lg"
                        />
                        <button
                            x-on:click="removeFile(index)"
                            class="absolute top-2 right-2 bg-destructive text-white p-2 rounded-full"
                        >
                            Remove
                        </button>
                    </div>
                </template>
            </div>
        </template>
    </x-slot:previews>
</x-pegboard::file-upload>
```

**Hiding Preview List:**

To completely hide the preview list (useful for avatar component):

```blade
<x-pegboard::file-upload wire:model="avatar">
    <x-pegboard::file-upload-dropzone heading="Upload avatar" />

    {{-- Empty previews slot hides default preview list --}}
    <x-slot:previews></x-slot:previews>
</x-pegboard::file-upload>
```

**Alpine.js Access:**

Access selected files and previews in Alpine expressions:

```blade
<x-pegboard::file-upload wire:model="photos">
    <x-pegboard::file-upload-dropzone heading="Drop photos" />

    {{-- Show count of selected files --}}
    <p x-show="selectedFiles.length > 0" x-text="`${selectedFiles.length} files selected`"></p>

    {{-- Custom action button --}}
    <button x-show="selectedFiles.length > 0" @click="selectedFiles = []">
        Clear All
    </button>
</x-pegboard::file-upload>
```


### File Type Validation

Real-time client-side validation provides immediate feedback during drag:

**Accept Attribute Support:**
```blade
{{-- MIME type wildcards --}}
<x-pegboard::file-upload accept="image/*">
    <!-- Accepts any image: image/jpeg, image/png, image/gif, etc. -->
</x-pegboard::file-upload>

{{-- Specific MIME types --}}
<x-pegboard::file-upload accept="image/jpeg,image/png,application/pdf">
    <!-- Only JPEG, PNG, and PDF files -->
</x-pegboard::file-upload>

{{-- File extensions --}}
<x-pegboard::file-upload accept=".jpg,.png,.gif">
    <!-- Only .jpg, .png, and .gif files -->
</x-pegboard::file-upload>

{{-- Mixed --}}
<x-pegboard::file-upload accept="image/*,.pdf">
    <!-- Any image or PDF files -->
</x-pegboard::file-upload>
```

The component validates file types in real-time during drag operations. If an invalid file type is detected, the border changes to orange/warning. Server-side validation is the final authority.

**Visual Feedback:**
```blade
{{-- Valid file type dragged --}}
Border: Blue (border-primary)
Background: Light blue (bg-primary/5)
Cursor: Copy

{{-- Invalid file type dragged --}}
Border: Orange (border-warning)
Background: Light orange (bg-warning/5)
Cursor: Not allowed

{{-- Unknown file type (can't determine) --}}
Border: Blue (optimistic - assume valid)
Cursor: Copy
```

### Progress Tracking

Automatic upload progress tracking with Livewire integration:

**Automatic Detection:**
The component automatically detects `wire:model` and listens for Livewire upload events:
- `livewire-upload-start` - Upload begins
- `livewire-upload-progress` - Progress updates
- `livewire-upload-finish` - Upload complete
- `livewire-upload-error` - Upload failed

**Progress Bar Display:**
```blade
{{-- With progress bar --}}
<x-pegboard::file-upload wire:model="file" multiple>
    <x-pegboard::file-upload-dropzone
        heading="Upload files"
        with-progress
        inline
    />
</x-pegboard::file-upload>
```

**Visual Elements:**
- Progress bar fills from 0% to 100%
- Percentage text displays below bar
- Smooth `ease-in-out` animation
- Pulsing effect during upload

**States:**
```javascript
// Not uploading
isLoading: false
progress: 0

// Uploading
isLoading: true
progress: 45 // (0-100)

// Complete
isLoading: false
progress: 100

// Error
isLoading: false
hasError: true
```

### Multiple Files

Support for uploading multiple files simultaneously:

```blade
{{-- Enable multiple file selection --}}
<x-pegboard::file-upload wire:model="photos" multiple>
    <x-pegboard::file-upload-dropzone
        heading="Drop multiple photos"
        text="You can select or drop multiple files at once"
    />
</x-pegboard::file-upload>
```

**Behavior:**
- **Click to browse** - Native file picker allows multi-select
- **Drag and drop** - All dropped files are accepted
- **Single mode override** - If `multiple` is false but multiple files dropped, only first file is accepted

**Livewire Integration:**
```php
namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class PhotoGallery extends Component
{
    use WithFileUploads;

    public $photos = [];

    public function save()
    {
        $this->validate([
            'photos.*' => 'image|max:10240', // 10MB max per file
        ]);

        foreach ($this->photos as $photo) {
            $photo->store('photos');
        }
    }
}
```

### Error States

Comprehensive error handling with visual feedback:

**Error Sources:**
1. **Upload errors** - Caught via `livewire-upload-error` event
2. **Laravel validation errors** - Displayed via `<x-pegboard::error>` component
3. **Manual errors** - Set via `error` prop

**Visual Feedback:**
```blade
{{-- Upload error state --}}
Border: Red (border-destructive)
Background: Light red (bg-destructive/5)
Icon: Alert indicator

{{-- Display validation errors --}}
<x-pegboard::file-upload wire:model="avatar">
    <x-pegboard::file-upload-dropzone heading="Upload avatar" />
</x-pegboard::file-upload>
<x-pegboard::error name="avatar" />
{{-- Shows Laravel validation errors automatically --}}
```

**Livewire Validation Example:**
```php
public function save()
{
    $this->validate([
        'avatar' => 'required|image|max:10240',
    ]);

    // Error automatically displayed via <x-pegboard::error>
}
```

## Dropzone Variants

### Block Layout (Default)

Vertical layout with centered content:

```blade
<x-pegboard::file-upload wire:model="file">
    <x-pegboard::file-upload-dropzone
        heading="Drop files here"
        text="Or click to browse"
    />
</x-pegboard::file-upload>
```

**Visual Characteristics:**
- Centered vertically and horizontally
- Large icon at top
- Heading and text stacked below
- Vertical padding (`py-8`)
- Best for prominent upload areas

### Inline Layout

Horizontal layout with compact design:

```blade
<x-pegboard::file-upload wire:model="file">
    <x-pegboard::file-upload-dropzone
        heading="Drop files here"
        text="Or click to browse"
        inline
    />
</x-pegboard::file-upload>
```

**Visual Characteristics:**
- Icon on left
- Heading and text in center (flex-1)
- Loading spinner on right (if no progress bar)
- Horizontal padding (`gap-4`)
- Best for compact forms

### With Progress Bar

Inline layout with progress tracking:

```blade
<x-pegboard::file-upload wire:model="file">
    <x-pegboard::file-upload-dropzone
        heading="Upload document"
        text="PDF, DOC, or DOCX"
        with-progress
        inline
    />
</x-pegboard::file-upload>
```

**Visual Characteristics:**
- Inline layout automatically applied
- Progress bar displays below text during upload
- Percentage indicator
- Smooth progress animation

### Custom Dropzone

Create fully custom dropzones using the base component:

```blade
<x-pegboard::file-upload wire:model="file">
    <div class="custom-dropzone bg-gradient-to-br from-purple-50 to-pink-50 border-2 border-dashed border-purple-300 rounded-xl p-8 text-center hover:border-purple-500 transition-colors">
        <svg class="w-16 h-16 mx-auto text-purple-500"><!-- Custom icon --></svg>
        <h3 class="mt-4 text-lg font-bold text-purple-900">Drop your files here</h3>
        <p class="mt-2 text-sm text-purple-600">Or click anywhere to browse</p>
    </div>
</x-pegboard::file-upload>
```

**Remember:** The base `<x-pegboard::file-upload>` component handles all drag/drop logic. You only style the presentation!

## Avatar Upload Component

The avatar upload component is a specialized, pre-styled file upload designed specifically for profile pictures and avatars. It features a circular dropzone with inline preview, floating action buttons, and responsive sizing.

### Basic Usage

```blade
{{-- Simple avatar upload --}}
<x-pegboard::file-upload-avatar
    id="avatar"
    label="Profile Picture"
    description="Click the camera icon to upload a new photo"
/>
```

### Props Reference

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `name` | string | `null` | Name attribute for the input (auto-detected from `wire:model` if not provided) |
| `size` | string | `'md'` | Avatar size: `'sm'`, `'md'`, `'lg'`, `'xl'` |
| `label` | string | `null` | Label text displayed above the avatar |
| `description` | string | `null` | Helper text displayed below the avatar |
| `error` | string | `null` | Error message displayed below the avatar |
| `disabled` | boolean | `false` | Disable the avatar upload |
| `accept` | string | `'image/*'` | File type filter (defaults to images only) |

**Additional attributes:**
- `wire:model` - Livewire property binding
- `class` - Additional CSS classes
- `id` - Custom ID for the file input

### Size Variants

The avatar component supports four size variants:

```blade
{{-- Small (96px / 24rem) --}}
<x-pegboard::file-upload-avatar size="sm" />

{{-- Medium (128px / 32rem) - Default --}}
<x-pegboard::file-upload-avatar size="md" />

{{-- Large (160px / 40rem) --}}
<x-pegboard::file-upload-avatar size="lg" />

{{-- Extra Large (192px / 48rem) --}}
<x-pegboard::file-upload-avatar size="xl" />
```

**Responsive Scaling:**

All elements scale proportionally with the avatar size:
- Avatar circle
- User icon placeholder
- Camera badge
- Remove button
- Loading spinner

### Visual Elements

**1. Circular Dropzone:**
- Rounded border with dashed style
- Hover effects (scale, border color)
- Drag feedback (border turns blue)
- Contains preview image or user icon

**2. User Icon Placeholder:**
- Displays when no image is selected
- `user-circle` Heroicon (solid variant)
- Scales with avatar size
- Transitions to primary color on hover

**3. Camera Badge:**
- Always visible (bottom-right corner)
- Blue background (`bg-primary`)
- White camera icon
- Bounces during drag
- Scales on hover

**4. Remove Button:**
- Only visible when image is uploaded
- Red background (`bg-destructive`)
- White X icon
- Top-right corner
- Scales on hover

**5. Loading Spinner:**
- Appears during upload
- Covers entire avatar with backdrop
- Animated spinner icon
- Semi-transparent background

### Behavior

**Default State:**
```blade
{{-- No image selected --}}
- Circular border (dashed)
- User icon placeholder
- Camera badge visible
- No remove button
```

**Image Selected:**
```blade
{{-- Image uploaded --}}
- Preview shows INSIDE circle
- Camera badge still visible
- Remove button appears (top-right)
- Click camera or circle to change
```

**Drag Over:**
```blade
{{-- File dragged over avatar --}}
- Border turns blue
- Background tints blue
- Scale increases (1.1x)
- Camera badge bounces
```

**Uploading:**
```blade
{{-- Upload in progress --}}
- Pulsing opacity animation
- Loading spinner overlay
- Backdrop blur effect
- Disables interactions
```

**Error State:**
```blade
{{-- Upload failed --}}
- Border turns red
- Background tints red
- Error message below avatar
```

### Complete Example

```blade
<x-pegboard::field>
    <x-pegboard::file-upload-avatar
        wire:model="avatar"
        size="lg"
        label="Profile Picture"
        description="JPG, PNG, or GIF up to 10MB"
    />
    <x-pegboard::error name="avatar" />
</x-pegboard::field>
```

### Livewire Integration

```php
namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class UserProfile extends Component
{
    use WithFileUploads;

    public $avatar;

    public function save()
    {
        $this->validate([
            'avatar' => 'required|image|max:10240',
        ]);

        $path = $this->avatar->store('avatars', 'public');

        auth()->user()->update([
            'avatar_path' => $path,
        ]);

        session()->flash('message', 'Avatar updated successfully!');
    }
}
```

### With Livewire Temporary URL

Display the uploaded avatar immediately using Livewire's temporary URL:

```blade
<div class="flex flex-col items-center gap-4">
    <x-pegboard::file-upload-avatar
        wire:model="avatar"
        size="xl"
        label="Profile Picture"
    />

    @if ($avatar)
        <div class="text-center">
            <p class="text-sm font-medium text-foreground">
                {{ $avatar->getClientOriginalName() }}
            </p>
            <p class="text-xs text-muted-foreground">
                {{ number_format($avatar->getSize() / 1024, 2) }} KB
            </p>
        </div>
    @endif
</div>
```

### Client-Side Preview

The avatar component automatically uses client-side previews:

```blade
{{-- Preview appears INSIDE the circle instantly --}}
<x-pegboard::file-upload-avatar wire:model="avatar" />

{{-- No server request needed for preview --}}
{{-- FileReader API generates data: URL --}}
{{-- Image displays immediately --}}
```

**How it works:**
1. User selects/drops image
2. FileReader reads file data
3. Preview URL stored in `selectedFiles[0].previewUrl`
4. Image renders inside circular dropzone
5. Livewire uploads actual file when triggered

### Custom Styling

You can pass additional classes to customize the wrapper:

```blade
<x-pegboard::file-upload-avatar
    class="mx-auto"
    size="lg"
/>
```

### Accessibility

**Keyboard Navigation:**
- `Tab` - Focus the avatar
- `Enter` or `Space` - Open file picker
- `Escape` - Close file picker

**Screen Reader Support:**
- Clear label association
- ARIA attributes for state
- Descriptive button labels

**Visual Feedback:**
- Focus ring on keyboard focus
- Clear hover states
- High contrast colors

### Best Practices

**1. Always provide a label:**

```blade
{{-- ✅ Good --}}
<x-pegboard::file-upload-avatar
    label="Profile Picture"
    description="Upload your profile photo"
/>

{{-- ❌ Bad --}}
<x-pegboard::file-upload-avatar />
```

**2. Match size to context:**

```blade
{{-- ✅ Profile page - use large --}}
<x-pegboard::file-upload-avatar size="xl" />

{{-- ✅ Settings form - use medium --}}
<x-pegboard::file-upload-avatar size="md" />

{{-- ✅ Comment avatar - use small --}}
<x-pegboard::file-upload-avatar size="sm" />
```

**3. Restrict to images only:**

```blade
{{-- ✅ Default accept is "image/*" --}}
<x-pegboard::file-upload-avatar />

{{-- ❌ Don't change accept for avatars --}}
<x-pegboard::file-upload-avatar accept=".pdf" />
```

**4. Validate on server:**

```php
// ✅ Server-side validation
$this->validate([
    'avatar' => 'required|image|mimes:jpg,jpeg,png,gif|max:10240',
]);
```

**5. Show validation errors:**

```blade
<x-pegboard::file-upload-avatar wire:model="avatar" />
<x-pegboard::error name="avatar" />
```

### Comparison with Base Component

**Avatar Component:**
- Pre-styled circular design
- Inline preview INSIDE circle
- Remove button included
- Size variants (sm/md/lg/xl)
- Specialized for profile pictures

**Base File Upload:**
- Unstyled/customizable
- Preview list below dropzone
- No remove button by default
- Flexible layout options
- General purpose file uploads

**When to use Avatar:**
```blade
{{-- ✅ Profile pictures --}}
{{-- ✅ User avatars --}}
{{-- ✅ Team member photos --}}
{{-- ✅ Contact photos --}}
```

**When to use Base:**
```blade
{{-- ✅ Document uploads --}}
{{-- ✅ Multiple files --}}
{{-- ✅ Non-circular designs --}}
{{-- ✅ Custom layouts --}}
```

## Livewire Integration

### Basic Setup

```php
namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class FileUploadDemo extends Component
{
    use WithFileUploads;

    public $avatar;
    public $photos = [];
    public $documents = [];

    public function save()
    {
        $this->validate([
            'avatar' => 'required|image|max:10240',
            'photos.*' => 'image|max:10240',
            'documents.*' => 'mimes:pdf,doc,docx|max:51200',
        ]);

        // Store files
        $this->avatar->store('avatars');
        foreach ($this->photos as $photo) {
            $photo->store('photos');
        }
        foreach ($this->documents as $document) {
            $document->store('documents');
        }
    }

    public function removePhoto($index)
    {
        array_splice($this->photos, $index, 1);
    }
}
```

### Displaying Uploaded Files

```blade
{{-- Upload interface --}}
<x-pegboard::file-upload wire:model="photos" multiple>
    <x-pegboard::file-upload-dropzone
        heading="Drop photos here"
        text="JPG, PNG up to 10MB each"
    />
</x-pegboard::file-upload>

{{-- Display uploaded files --}}
@if (count($photos) > 0)
    <div class="mt-4 space-y-2">
        @foreach ($photos as $index => $photo)
            <div class="flex items-center gap-3 p-3 border border-border rounded-lg">
                {{-- Preview thumbnail --}}
                @if(method_exists($photo, 'temporaryUrl'))
                    <img src="{{ $photo->temporaryUrl() }}" class="w-12 h-12 object-cover rounded">
                @endif

                {{-- File info --}}
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-foreground truncate">
                        {{ $photo->getClientOriginalName() }}
                    </p>
                    <p class="text-xs text-muted-foreground">
                        {{ number_format($photo->getSize() / 1024, 2) }} KB
                    </p>
                </div>

                {{-- Remove button --}}
                <x-pegboard::button
                    variant="outline"
                    size="sm"
                    wire:click="removePhoto({{ $index }})"
                >
                    Remove
                </x-pegboard::button>
            </div>
        @endforeach
    </div>
@endif
```

### Progress Tracking

Progress tracking is **automatic** when using `wire:model`:

```blade
{{-- Progress is tracked automatically --}}
<x-pegboard::file-upload wire:model="file" multiple>
    <x-pegboard::file-upload-dropzone
        heading="Upload files"
        with-progress
        inline
    />
</x-pegboard::file-upload>

{{-- Component automatically listens to:
     - livewire-upload-start
     - livewire-upload-progress
     - livewire-upload-finish
     - livewire-upload-error
--}}
```

**No additional PHP code required!** The component handles all event listeners automatically.

### Temporary URLs

Display preview images using Livewire's temporary URLs:

```blade
@if ($avatar)
    <div class="mt-4">
        <img src="{{ $avatar->temporaryUrl() }}" class="w-32 h-32 object-cover rounded-full">
    </div>
@endif
```

**Note:** `temporaryUrl()` only works for image files and must be called within the same request.

## Examples

### Profile Avatar Upload

```blade
<x-pegboard::field>
    <x-pegboard::label for="avatar">Profile Picture</x-pegboard::label>
    <x-pegboard::file-upload
        wire:model="avatar"
        accept="image/*"
    >
        <x-pegboard::file-upload-dropzone
            heading="Drop image here or click to browse"
            text="JPG, PNG, GIF up to 10MB"
        />
    </x-pegboard::file-upload>
    <x-pegboard::description>
        Upload a profile picture. Max 10MB.
    </x-pegboard::description>
    <x-pegboard::error name="avatar" />
</x-pegboard::field>

@if ($avatar)
    <div class="mt-4 flex items-center gap-4">
        <img src="{{ $avatar->temporaryUrl() }}" class="w-20 h-20 rounded-full object-cover">
        <div>
            <p class="text-sm font-medium">{{ $avatar->getClientOriginalName() }}</p>
            <p class="text-xs text-muted-foreground">{{ number_format($avatar->getSize() / 1024, 2) }} KB</p>
        </div>
        <x-pegboard::button
            variant="outline"
            size="sm"
            wire:click="$set('avatar', null)"
        >
            Remove
        </x-pegboard::button>
    </div>
@endif
```

### Photo Gallery Upload

```blade
<x-pegboard::field>
    <x-pegboard::label for="photos">Photo Gallery</x-pegboard::label>
    <x-pegboard::file-upload
        wire:model="photos"
        multiple
        accept="image/*"
    >
        <x-pegboard::file-upload-dropzone
            heading="Drop photos here or click to browse"
            text="JPG, PNG, GIF up to 10MB each (Max 5 files)"
            inline
        />
    </x-pegboard::file-upload>
    <x-pegboard::description>
        Upload up to 5 photos. Max 10MB each.
    </x-pegboard::description>
    <x-pegboard::error name="photos" />
    <x-pegboard::error name="photos.*" />
</x-pegboard::field>

@if (count($photos) > 0)
    <div class="mt-4 grid grid-cols-3 gap-4">
        @foreach ($photos as $index => $photo)
            <div class="relative group">
                <img src="{{ $photo->temporaryUrl() }}" class="w-full aspect-square object-cover rounded-lg">
                <button
                    wire:click="removePhoto({{ $index }})"
                    class="absolute top-2 right-2 bg-destructive text-white p-2 rounded-full opacity-0 group-hover:opacity-100 transition-opacity"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        @endforeach>
    </div>
@endif
```

### Document Upload with Progress

```blade
<x-pegboard::field>
    <x-pegboard::label for="documents">Documents</x-pegboard::label>
    <x-pegboard::file-upload
        wire:model="documents"
        multiple
        accept=".pdf,.doc,.docx"
    >
        <x-pegboard::file-upload-dropzone
            heading="Upload documents"
            text="PDF, DOC, DOCX up to 50MB each (Max 3 files)"
            with-progress
            inline
        />
    </x-pegboard::file-upload>
    <x-pegboard::description>
        Upload up to 3 documents. PDF, DOC, or DOCX format. Max 50MB each.
    </x-pegboard::description>
    <x-pegboard::error name="documents" />
    <x-pegboard::error name="documents.*" />
</x-pegboard::field>

@if (count($documents) > 0)
    <div class="mt-4 space-y-2">
        @foreach ($documents as $index => $document)
            <div class="flex items-center gap-3 p-4 border border-border rounded-lg bg-card">
                <svg class="w-8 h-8 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                </svg>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-foreground truncate">
                        {{ $document->getClientOriginalName() }}
                    </p>
                    <p class="text-xs text-muted-foreground">
                        {{ number_format($document->getSize() / 1024, 2) }} KB
                    </p>
                </div>
                <x-pegboard::button
                    variant="outline"
                    size="sm"
                    wire:click="removeDocument({{ $index }})"
                >
                    Remove
                </x-pegboard::button>
            </div>
        @endforeach
    </div>
@endif
```

### Resume Upload with Validation

```blade
<form wire:submit="submit">
    <x-pegboard::field>
        <x-pegboard::label for="resume">Resume / CV</x-pegboard::label>
        <x-pegboard::file-upload
            wire:model="resume"
            accept=".pdf,.doc,.docx"
        >
            <x-pegboard::file-upload-dropzone
                heading="Drop your resume here"
                text="PDF, DOC, or DOCX up to 5MB"
            />
        </x-pegboard::file-upload>
        <x-pegboard::description>
            We accept PDF, DOC, and DOCX formats. Max file size: 5MB.
        </x-pegboard::description>
        <x-pegboard::error name="resume" />
    </x-pegboard::field>

    <x-pegboard::button type="submit" class="mt-4">
        Submit Application
    </x-pegboard::button>
</form>
```

```php
namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class JobApplication extends Component
{
    use WithFileUploads;

    public $resume;

    protected $rules = [
        'resume' => 'required|mimes:pdf,doc,docx|max:5120', // 5MB
    ];

    protected $messages = [
        'resume.required' => 'Please upload your resume.',
        'resume.mimes' => 'Resume must be a PDF, DOC, or DOCX file.',
        'resume.max' => 'Resume file size cannot exceed 5MB.',
    ];

    public function submit()
    {
        $this->validate();

        $path = $this->resume->store('resumes');

        // Create application record...

        session()->flash('message', 'Application submitted successfully!');
    }
}
```

## Best Practices

### 1. Always Use Accept Attribute

```blade
{{-- ✅ Good - Restricts file types --}}
<x-pegboard::file-upload accept="image/*" wire:model="photo">
    <x-pegboard::file-upload-dropzone heading="Upload photo" />
</x-pegboard::file-upload>

{{-- ❌ Bad - No file type restriction --}}
<x-pegboard::file-upload wire:model="photo">
    <x-pegboard::file-upload-dropzone heading="Upload photo" />
</x-pegboard::file-upload>
```

**Benefits:**
- Native browser file picker filters files
- Real-time drag feedback for invalid types
- Guides users to select correct files

### 2. Match Accept with Laravel Validation

```blade
<x-pegboard::file-upload
    accept="image/jpeg,image/png,image/gif"
    wire:model="avatar"
>
```

```php
protected $rules = [
    'avatar' => 'required|mimes:jpeg,png,gif|max:10240',
];
```

**Why?** Consistent client and server validation provides better UX.

### 3. Provide Clear File Requirements

```blade
{{-- ✅ Good - Clear expectations --}}
<x-pegboard::file-upload accept=".pdf" wire:model="document">
    <x-pegboard::file-upload-dropzone
        heading="Upload PDF document"
        text="PDF only, max 10MB"
    />
</x-pegboard::file-upload>
<x-pegboard::description>
    Upload a PDF file. Maximum file size: 10MB.
</x-pegboard::description>

{{-- ❌ Bad - Vague requirements --}}
<x-pegboard::file-upload wire:model="file">
    <x-pegboard::file-upload-dropzone heading="Upload file" />
</x-pegboard::file-upload>
```

### 4. Handle Large Files Appropriately

```php
// ✅ Good - Appropriate limits for file type
protected $rules = [
    'avatar' => 'image|max:10240',      // 10MB for images
    'video' => 'mimetypes:video/*|max:102400', // 100MB for videos
    'document' => 'mimes:pdf|max:51200', // 50MB for documents
];
```

### 5. Show Upload Progress for Large Files

```blade
{{-- ✅ Good - Progress bar for large files --}}
<x-pegboard::file-upload wire:model="video">
    <x-pegboard::file-upload-dropzone
        heading="Upload video"
        text="MP4, MOV up to 100MB"
        with-progress
        inline
    />
</x-pegboard::file-upload>

{{-- ❌ Bad - No progress indicator --}}
<x-pegboard::file-upload wire:model="video">
    <x-pegboard::file-upload-dropzone heading="Upload video" />
</x-pegboard::file-upload>
```

### 6. Provide File Previews

```blade
{{-- ✅ Good - Shows what was uploaded --}}
@if ($avatar)
    <div class="mt-4">
        <img src="{{ $avatar->temporaryUrl() }}" class="w-32 h-32 rounded-full">
        <button wire:click="$set('avatar', null)">Remove</button>
    </div>
@endif

{{-- ❌ Bad - No visual feedback --}}
<x-pegboard::file-upload wire:model="avatar">
    <x-pegboard::file-upload-dropzone heading="Upload" />
</x-pegboard::file-upload>
```

### 7. Use Inline Layout for Compact Forms

```blade
{{-- ✅ Good - Inline for tight spaces --}}
<x-pegboard::file-upload wire:model="attachment">
    <x-pegboard::file-upload-dropzone
        heading="Attach file"
        text="PDF, DOC up to 10MB"
        inline
    />
</x-pegboard::file-upload>

{{-- ✅ Also good - Block layout for prominence --}}
<x-pegboard::file-upload wire:model="featured_image">
    <x-pegboard::file-upload-dropzone
        heading="Upload featured image"
        text="JPG, PNG up to 10MB"
    />
</x-pegboard::file-upload>
```

### 8. Validate File Counts

```php
// ✅ Good - Enforce maximum file count
protected $rules = [
    'photos' => 'required|array|max:5',
    'photos.*' => 'image|max:10240',
];

protected $messages = [
    'photos.max' => 'You can upload a maximum of 5 photos.',
];
```

### 9. Handle Upload Errors Gracefully

```php
public function save()
{
    try {
        $this->validate([
            'file' => 'required|file|max:51200',
        ]);

        $this->file->store('uploads');

        session()->flash('message', 'File uploaded successfully!');
    } catch (\Exception $e) {
        $this->addError('file', 'Upload failed. Please try again.');
    }
}
```

### 10. Use Descriptive Error Messages

```php
// ✅ Good - Helpful error messages
protected $messages = [
    'avatar.required' => 'Please upload a profile picture.',
    'avatar.image' => 'The file must be an image (JPG, PNG, GIF).',
    'avatar.max' => 'Image size cannot exceed 10MB.',
];

// ❌ Bad - Generic error messages
protected $messages = [
    'avatar.required' => 'Required.',
    'avatar.max' => 'Too large.',
];
```

## Accessibility

The file upload component follows WCAG 2.1 guidelines and ARIA best practices:

### Keyboard Accessibility

**Full keyboard navigation:**
- `Tab` - Focus the dropzone
- `Enter` or `Space` - Open file browser dialog
- `Escape` - Cancel file selection (native browser behavior)

**Focus indicators:**
- Visible focus ring when dropzone is focused
- Clear visual indication of interactive area

### Screen Reader Support

**ARIA Attributes:**
```html
<div role="button"
     tabindex="0"
     aria-label="Upload files"
     aria-busy="false"
     aria-disabled="false">
```

**Screen reader announcements:**
- "Upload files, button" when focused
- "Uploading" during upload (via `aria-busy="true"`)
- "Disabled" when disabled (via `aria-disabled="true"`)

### Visual Accessibility

**Color contrast:**
- All text meets WCAG AA standards (4.5:1 minimum)
- Border colors have 3:1 contrast for non-text elements
- Focus ring has 3:1 contrast against background

**State indicators:**
- Don't rely solely on color (text + icons reinforce meaning)
- Loading states use animation + text
- Error states use color + icon + text

### Reduced Motion

Respects `prefers-reduced-motion` settings:

```css
@media (prefers-reduced-motion: reduce) {
    .file-upload {
        transition: none;
        animation: none;
    }
}
```

Users who prefer reduced motion will see:
- No pulsing animations
- Instant state transitions
- Full functionality maintained

### Best Practices for Accessibility

**1. Always provide labels:**

```blade
{{-- ✅ Good - Has label --}}
<x-pegboard::field>
    <x-pegboard::label for="resume">Resume</x-pegboard::label>
    <x-pegboard::file-upload wire:model="resume">
        <x-pegboard::file-upload-dropzone heading="Upload resume" />
    </x-pegboard::file-upload>
</x-pegboard::field>

{{-- ❌ Bad - No label --}}
<x-pegboard::file-upload wire:model="file">
    <x-pegboard::file-upload-dropzone heading="Upload" />
</x-pegboard::file-upload>
```

**2. Provide clear instructions:**

```blade
{{-- ✅ Good - Clear instructions --}}
<x-pegboard::description>
    Upload a PDF file. Maximum size: 10MB.
    Supported formats: PDF, DOC, DOCX.
</x-pegboard::description>
```

**3. Announce errors clearly:**

```blade
{{-- ✅ Good - Error clearly associated --}}
<x-pegboard::error name="file" />
```

**4. Use semantic HTML:**

The component automatically uses semantic HTML:
- `<input type="file">` for native file input
- `role="button"` for clickable dropzone
- Proper `tabindex` for keyboard navigation

---

## Additional Resources

- [Tailwind CSS v4 Documentation](https://tailwindcss.com/docs)
- [Alpine.js Documentation](https://alpinejs.dev)
- [Livewire File Uploads](https://livewire.laravel.com/docs/uploads)
- [MDN: File Input](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/file)
- [WCAG 2.1 Guidelines](https://www.w3.org/WAI/WCAG21/quickref/)

## Support

For issues, questions, or feature requests, please open an issue in the Pegboard UI repository.
