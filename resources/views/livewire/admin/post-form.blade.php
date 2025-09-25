<div x-data="{ 
    showValidationModal: false,
    validateBeforeSubmit() {
        const errors = @js($this->quickValidate());
        if (errors.length > 0) {
            this.showValidationModal = true;
            return false;
        }
        return true;
    }
}">
    <!-- Validation Modal -->
    <div x-show="showValidationModal" 
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 overflow-y-auto" 
         style="display: none;">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Validation Required</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">Please complete the required fields before saving your post.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button @click="showValidationModal = false" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                        Got it
                    </button>
                </div>
            </div>
        </div>
    </div>

    <form wire:submit="save" class="space-y-6" @submit.prevent="validateBeforeSubmit() && $wire.save()"
        <!-- Header with Actions -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-medium text-gray-900">
                        {{ $isEditing ? 'Edit Post' : 'Create New Post' }}
                    </h3>
                    <div class="flex items-center space-x-3">
                        @if (!$isEditing && ($title || $content))
                            <button type="button" 
                                @click="if(confirm('Are you sure you want to start fresh? This will clear all current content.')) { $wire.startFresh(); }"
                                class="inline-flex items-center px-3 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2M3 12l6.414 6.414a2 2 0 001.414.586H19a2 2 0 002-2V7a2 2 0 00-2-2h-8.172a2 2 0 00-1.414.586L3 12z">
                                    </path>
                                </svg>
                                Start Fresh
                            </button>
                        @endif
                        <button type="button" wire:click="togglePreview"
                            class="inline-flex items-center px-3 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                </path>
                            </svg>
                            {{ $showPreview ? 'Hide Preview' : 'Show Preview' }}
                        </button>
                        @if ($title)
                            <span class="text-sm text-gray-500">
                                Words: {{ $wordCount }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="px-6 py-4 space-y-6">
                <!-- Validation Alert -->
                @if ($showValidationAlert && !empty($validationErrors))
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4" x-data="{ show: true }" x-show="show">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-3 flex-1">
                                <h3 class="text-sm font-medium text-red-800">
                                    Please fix the following errors before saving:
                                </h3>
                                <div class="mt-2">
                                    <ul class="text-sm text-red-700 space-y-1">
                                        @foreach ($validationErrors as $field => $error)
                                            <li class="flex items-center">
                                                <svg class="w-3 h-3 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                                </svg>
                                                <strong class="capitalize">{{ str_replace('_', ' ', $field) }}:</strong> {{ $error }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="ml-auto pl-3">
                                <button type="button" wire:click="dismissValidationAlert" 
                                    class="inline-flex text-red-400 hover:text-red-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                @endif

                @if (!$showPreview)
                    <!-- Draft Recovery -->
                    @if (!$isEditing && session()->has('post_draft'))
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-yellow-600 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z">
                                        </path>
                                    </svg>
                                    <span class="text-sm font-medium text-yellow-800">
                                        @if (!$title && !$content)
                                            Draft found! You have unsaved changes from a previous session.
                                        @else
                                            You're currently working on a draft.
                                        @endif
                                    </span>
                                </div>
                                <div class="flex space-x-2">
                                    @if (!$title && !$content)
                                        <button type="button" wire:click="loadDraft"
                                            class="text-sm text-yellow-800 hover:text-yellow-900 font-medium">
                                            Restore Draft
                                        </button>
                                    @endif
                                    <button type="button" 
                                        @click="if(confirm('Are you sure you want to start fresh? This will clear all current content.')) { $wire.startFresh(); }"
                                        class="text-sm text-yellow-600 hover:text-yellow-700 font-medium">
                                        Start Fresh
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Auto-save Status -->
                    @if ($lastSaved && !$isEditing)
                        <div class="text-right">
                            <span class="text-xs text-gray-500">
                                <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                Auto-saved at {{ $lastSaved }}
                            </span>
                        </div>
                    @endif

                    <!-- Quick Templates -->
                    @if (!$isEditing && !$title && !$content)
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <h4 class="text-sm font-medium text-blue-900 mb-3">Quick Start Templates</h4>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                <button type="button" wire:click="loadTemplate('tutorial')"
                                    class="p-3 text-left border border-blue-300 rounded-md hover:bg-blue-100 transition-colors">
                                    <div class="font-medium text-blue-900">Tutorial</div>
                                    <div class="text-sm text-blue-700">Step-by-step guide</div>
                                </button>
                                <button type="button" wire:click="loadTemplate('review')"
                                    class="p-3 text-left border border-blue-300 rounded-md hover:bg-blue-100 transition-colors">
                                    <div class="font-medium text-blue-900">Review</div>
                                    <div class="text-sm text-blue-700">Product/service review</div>
                                </button>
                                <button type="button" wire:click="loadTemplate('listicle')"
                                    class="p-3 text-left border border-blue-300 rounded-md hover:bg-blue-100 transition-colors">
                                    <div class="font-medium text-blue-900">List Article</div>
                                    <div class="text-sm text-blue-700">Top X items list</div>
                                </button>
                            </div>
                        </div>
                    @endif

                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                            Title <span class="text-red-500">*</span>
                            @if ($title && strlen($title) >= 3)
                                <span class="text-green-600 text-xs ml-2">✓</span>
                            @endif
                        </label>
                        <input type="text" id="title" wire:model.live="title"
                            class="w-full px-4 py-3 text-lg border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 
                            @if(isset($validationErrors['title'])) border-red-500 @elseif($title && strlen($title) >= 3) border-green-500 @else border-gray-300 @endif"
                            placeholder="Enter an engaging post title...">
                        @if(isset($validationErrors['title']))
                            <p class="mt-1 text-sm text-red-600 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $validationErrors['title'] }}
                            </p>
                        @elseif($title && strlen($title) >= 3)
                            <p class="mt-1 text-sm text-green-600 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                Good title length ({{ strlen($title) }} characters)
                            </p>
                        @endif
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Slug -->
                    <div>
                        <label for="slug" class="block text-sm font-medium text-gray-700 mb-2">
                            URL Slug <span class="text-red-500">*</span>
                            @if ($slug && strlen($slug) >= 3 && preg_match('/^[a-z0-9-]+$/', $slug))
                                <span class="text-green-600 text-xs ml-2">✓</span>
                            @endif
                        </label>
                        <div class="flex">
                            <input type="text" id="slug" wire:model.live="slug"
                                class="flex-1 px-3 py-2 border rounded-l-md shadow-sm focus:ring-blue-500 focus:border-blue-500
                                @if(isset($validationErrors['slug'])) border-red-500 @elseif($slug && strlen($slug) >= 3 && preg_match('/^[a-z0-9-]+$/', $slug)) border-green-500 @else border-gray-300 @endif"
                                placeholder="post-url-slug">
                            <button type="button" wire:click="generateSlug"
                                class="px-4 py-2 bg-gray-100 border border-l-0 border-gray-300 rounded-r-md hover:bg-gray-200 text-sm font-medium">
                                Generate
                            </button>
                        </div>
                        @if(isset($validationErrors['slug']))
                            <p class="mt-1 text-sm text-red-600 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $validationErrors['slug'] }}
                            </p>
                        @elseif($slug && strlen($slug) >= 3 && preg_match('/^[a-z0-9-]+$/', $slug))
                            <p class="mt-1 text-sm text-green-600 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                Valid URL slug format
                            </p>
                        @endif
                        @error('slug')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">
                            Preview: <span
                                class="font-mono text-blue-600">{{ url('/post/' . ($slug ?: 'your-post-slug')) }}</span>
                        </p>
                    </div>

                    <!-- Excerpt -->
                    <div>
                        <label for="excerpt" class="block text-sm font-medium text-gray-700 mb-2">
                            Excerpt
                        </label>
                        <textarea id="excerpt" wire:model="excerpt" rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('excerpt') border-red-500 @enderror"
                            placeholder="Write a compelling summary that will appear in post previews..."></textarea>
                        @error('excerpt')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">
                            <span class="inline-flex items-center">
                                <svg class="w-4 h-4 mr-1 text-blue-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Leave empty to auto-generate from content
                            </span>
                        </p>
                    </div>

                    <!-- Featured Image -->
                    <div>
                        <label for="featured_image" class="block text-sm font-medium text-gray-700 mb-2">
                            Featured Image
                        </label>
                        <div class="space-y-3">
                            <input type="url" id="featured_image" wire:model="featured_image"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('featured_image') border-red-500 @enderror"
                                placeholder="https://images.unsplash.com/photo-...">
                            @if ($featured_image)
                                <div class="mt-2">
                                    <img src="{{ $featured_image }}" alt="Featured image preview"
                                        class="w-32 h-20 object-cover rounded-md border">
                                </div>
                            @endif
                        </div>
                        @error('featured_image')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">
                            Recommended: 1200x630px for best social media sharing
                        </p>
                    </div>

                    <!-- Content -->
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label for="content" class="block text-sm font-medium text-gray-700">
                                Content <span class="text-red-500">*</span>
                                @if ($content && strlen($content) >= 10)
                                    <span class="text-green-600 text-xs ml-2">✓</span>
                                @endif
                            </label>
                            <div class="flex items-center space-x-4 text-sm">
                                <span class="@if($wordCount >= 300) text-green-600 @else text-gray-500 @endif">
                                    Words: {{ $wordCount }}
                                </span>
                                <span class="@if(strlen($content) >= 10) text-green-600 @else text-gray-500 @endif">
                                    Characters: {{ strlen($content) }}
                                </span>
                            </div>
                        </div>
                        <div class="border rounded-md overflow-hidden 
                            @if(isset($validationErrors['content'])) border-red-500 @elseif($content && strlen($content) >= 10) border-green-500 @else border-gray-300 @endif">
                            <textarea id="content" wire:model.live="content" rows="15"
                                class="w-full px-3 py-3 border-0 focus:ring-0 resize-none"
                                placeholder="Start writing your amazing post..."></textarea>
                        </div>
                        @if(isset($validationErrors['content']))
                            <p class="mt-1 text-sm text-red-600 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $validationErrors['content'] }}
                            </p>
                        @elseif($content && strlen($content) >= 10)
                            <p class="mt-1 text-sm text-green-600 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                Content length looks good
                            </p>
                        @endif
                        @error('content')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <div class="mt-2 flex items-center justify-between text-sm text-gray-500">
                            <span>Tip: Use Markdown for formatting</span>
                            <span class="text-xs">
                                Minimum 10 characters required
                            </span>
                        </div>
                    </div>
                @else
                    <!-- Preview Mode -->
                    <div class="space-y-6">
                        <div class="text-center">
                            <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $title ?: 'Your Post Title' }}</h1>
                            @if ($excerpt)
                                <p class="text-lg text-gray-600 mb-6">{{ $excerpt }}</p>
                            @endif
                        </div>

                        @if ($featured_image)
                            <div class="text-center">
                                <img src="{{ $featured_image }}" alt="Featured image"
                                    class="max-w-full h-64 object-cover rounded-lg mx-auto">
                            </div>
                        @endif

                        <div class="prose prose-lg max-w-none">
                            {!! nl2br(e($content)) !!}
                        </div>

                        @if (!$title && !$content)
                            <div class="text-center py-12 text-gray-500">
                                <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                <p class="text-lg">Start writing to see your preview</p>
                            </div>
                        @endif
                    </div>
                @endif

                <!-- Publishing Options -->
                <div class="border-t border-gray-200 pt-6">
                    <h4 class="text-md font-medium text-gray-900 mb-4">Publishing Options</h4>

                    <div class="space-y-4">
                        <!-- Published Checkbox -->
                        <div class="flex items-center">
                            <input type="checkbox" id="published" wire:model.live="published"
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="published" class="ml-2 block text-sm text-gray-900">
                                Publish this post
                            </label>
                        </div>

                        <!-- Published Date -->
                        @if ($published)
                            <div>
                                <label for="published_at" class="block text-sm font-medium text-gray-700 mb-2">
                                    Publish Date & Time
                                </label>
                                <input type="datetime-local" id="published_at" wire:model="published_at"
                                    class="px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('published_at') border-red-500 @enderror">
                                @error('published_at')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-3 sm:space-y-0">
                    <a wire:navigate href="{{ route('admin.dashboard') }}"
                        class="inline-flex items-center text-gray-600 hover:text-gray-900 font-medium">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Dashboard
                    </a>

                    <div
                        class="flex flex-col sm:flex-row items-stretch sm:items-center space-y-2 sm:space-y-0 sm:space-x-3">
                        <!-- Save as Draft -->
                        <button type="button" wire:click="saveAsDraft"
                            class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 font-medium"
                            @if(!$title || !$content) disabled title="Title and content are required" @endif>
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3-3m0 0l-3 3m3-3v12">
                                </path>
                            </svg>
                            Save as Draft
                        </button>

                        <!-- Publish Now -->
                        <button type="button" wire:click="publishNow"
                            class="inline-flex items-center justify-center px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 font-medium disabled:opacity-50 disabled:cursor-not-allowed"
                            @if(!$title || !$content || !$slug) disabled title="All required fields must be filled" @endif>
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                            </svg>
                            Publish Now
                        </button>

                        <!-- Custom Save -->
                        <button type="submit"
                            class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 font-medium disabled:opacity-50 disabled:cursor-not-allowed"
                            @if(!$title || !$content || !$slug) disabled title="All required fields must be filled" @endif>
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3-3m0 0l-3 3m3-3v12">
                                </path>
                            </svg>
                            {{ $isEditing ? 'Update Post' : 'Save Post' }}
                        </button>
                    </div>
                </div>

                <!-- Publishing Status Info -->
                @if ($published || $published_at)
                    <div class="mt-3 p-3 bg-blue-50 border border-blue-200 rounded-md">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-sm text-blue-800">
                                @if ($published && $published_at)
                                    This post will be published on
                                    {{ \Carbon\Carbon::parse($published_at)->format('M j, Y \a\t g:i A') }}
                                @elseif($published)
                                    This post will be published immediately
                                @else
                                    This post will be saved as a draft
                                @endif
                            </span>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Writing Tips Sidebar -->
        @if (!$showPreview)
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Writing Tips</h3>
                </div>
                <div class="px-6 py-4 space-y-4">
                    <!-- Validation Status -->
                    <div>
                        <h4 class="text-sm font-medium text-gray-900 mb-2">Validation Status</h4>
                        <ul class="text-sm space-y-1">
                            <li class="flex items-start">
                                <span class="inline-block w-2 h-2 bg-{{ $title && strlen($title) >= 3 ? 'green' : 'red' }}-400 rounded-full mt-2 mr-2 flex-shrink-0"></span>
                                <span class="@if($title && strlen($title) >= 3) text-green-700 @else text-red-700 @endif">
                                    Title ({{ $title ? strlen($title) : 0 }}/3+ chars)
                                </span>
                            </li>
                            <li class="flex items-start">
                                <span class="inline-block w-2 h-2 bg-{{ $slug && strlen($slug) >= 3 && preg_match('/^[a-z0-9-]+$/', $slug) ? 'green' : 'red' }}-400 rounded-full mt-2 mr-2 flex-shrink-0"></span>
                                <span class="@if($slug && strlen($slug) >= 3 && preg_match('/^[a-z0-9-]+$/', $slug)) text-green-700 @else text-red-700 @endif">
                                    URL Slug (valid format)
                                </span>
                            </li>
                            <li class="flex items-start">
                                <span class="inline-block w-2 h-2 bg-{{ $content && strlen($content) >= 10 ? 'green' : 'red' }}-400 rounded-full mt-2 mr-2 flex-shrink-0"></span>
                                <span class="@if($content && strlen($content) >= 10) text-green-700 @else text-red-700 @endif">
                                    Content ({{ $content ? strlen($content) : 0 }}/10+ chars)
                                </span>
                            </li>
                            <li class="flex items-start">
                                <span class="inline-block w-2 h-2 bg-{{ !$featured_image || filter_var($featured_image, FILTER_VALIDATE_URL) ? 'green' : 'red' }}-400 rounded-full mt-2 mr-2 flex-shrink-0"></span>
                                <span class="@if(!$featured_image || filter_var($featured_image, FILTER_VALIDATE_URL)) text-green-700 @else text-red-700 @endif">
                                    Featured Image (valid URL)
                                </span>
                            </li>
                        </ul>
                        @php
                            $validationScore = 0;
                            if ($title && strlen($title) >= 3) $validationScore++;
                            if ($slug && strlen($slug) >= 3 && preg_match('/^[a-z0-9-]+$/', $slug)) $validationScore++;
                            if ($content && strlen($content) >= 10) $validationScore++;
                            if (!$featured_image || filter_var($featured_image, FILTER_VALIDATE_URL)) $validationScore++;
                            $validationPercentage = ($validationScore / 4) * 100;
                        @endphp
                        <div class="mt-3">
                            <div class="flex items-center justify-between text-xs text-gray-600 mb-1">
                                <span>Validation Progress</span>
                                <span>{{ $validationScore }}/4</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-{{ $validationPercentage == 100 ? 'green' : ($validationPercentage >= 75 ? 'yellow' : 'red') }}-500 h-2 rounded-full transition-all duration-300" 
                                     style="width: {{ $validationPercentage }}%"></div>
                            </div>
                        </div>
                    </div>
                    <!-- SEO Tips -->
                    <div>
                        <h4 class="text-sm font-medium text-gray-900 mb-2">SEO Optimization</h4>
                        <ul class="text-sm text-gray-600 space-y-1">
                            <li class="flex items-start">
                                <span
                                    class="inline-block w-2 h-2 bg-green-400 rounded-full mt-2 mr-2 flex-shrink-0"></span>
                                Title should be 50-60 characters
                            </li>
                            <li class="flex items-start">
                                <span
                                    class="inline-block w-2 h-2 bg-{{ strlen($title) >= 50 && strlen($title) <= 60 ? 'green' : 'gray' }}-400 rounded-full mt-2 mr-2 flex-shrink-0"></span>
                                Current title: {{ strlen($title) }} characters
                            </li>
                            <li class="flex items-start">
                                <span
                                    class="inline-block w-2 h-2 bg-{{ $excerpt && strlen($excerpt) >= 120 && strlen($excerpt) <= 160 ? 'green' : 'gray' }}-400 rounded-full mt-2 mr-2 flex-shrink-0"></span>
                                Excerpt should be 120-160 characters
                            </li>
                        </ul>
                    </div>

                    <!-- Content Tips -->
                    <div>
                        <h4 class="text-sm font-medium text-gray-900 mb-2">Content Quality</h4>
                        <ul class="text-sm text-gray-600 space-y-1">
                            <li class="flex items-start">
                                <span
                                    class="inline-block w-2 h-2 bg-{{ $wordCount >= 300 ? 'green' : 'gray' }}-400 rounded-full mt-2 mr-2 flex-shrink-0"></span>
                                Aim for 300+ words (current: {{ $wordCount }})
                            </li>
                            <li class="flex items-start">
                                <span
                                    class="inline-block w-2 h-2 bg-{{ $featured_image ? 'green' : 'gray' }}-400 rounded-full mt-2 mr-2 flex-shrink-0"></span>
                                Add a featured image for better engagement
                            </li>
                            <li class="flex items-start">
                                <span
                                    class="inline-block w-2 h-2 bg-green-400 rounded-full mt-2 mr-2 flex-shrink-0"></span>
                                Use headings to structure your content
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        @endif
    </form>
</div>
