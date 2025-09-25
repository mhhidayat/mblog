<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Back Button -->
    <div class="mb-8">
        <a wire:navigate href="{{ route('blog.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Blog
        </a>
    </div>

    <!-- Article Header -->
    <article class="bg-white rounded-lg shadow-lg overflow-hidden">
        @if($post->featured_image)
            <img src="{{ $post->featured_image }}" alt="{{ $post->title }}" class="w-full h-64 md:h-96 object-cover">
        @else
            <div class="w-full h-64 md:h-96 bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center">
                <span class="text-white text-6xl font-bold">{{ substr($post->title, 0, 1) }}</span>
            </div>
        @endif

        <div class="p-8">
            <!-- Title and Meta -->
            <header class="mb-8">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">{{ $post->title }}</h1>
                
                <div class="flex items-center text-gray-600 text-sm">
                    <time datetime="{{ $post->published_at->toISOString() }}">
                        Published on {{ $post->published_at->format('F j, Y') }}
                    </time>
                </div>
                
                @if($post->excerpt)
                    <div class="mt-4 text-lg text-gray-700 font-medium">
                        {{ $post->excerpt }}
                    </div>
                @endif
            </header>

            <!-- Content -->
            <div class="prose prose-lg max-w-none">
                {!! nl2br(e($post->content)) !!}
            </div>
        </div>
    </article>

    <!-- Navigation -->
    <div class="mt-12 text-center">
        <a wire:navigate href="{{ route('blog.index') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            View All Posts
        </a>
    </div>
</div>
