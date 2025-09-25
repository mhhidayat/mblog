<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="text-center mb-6">
        <h1 class="text-4xl font-bold text-gray-900 mb-4">Welcome to M-Blog</h1>
        <p class="text-xl text-gray-600 max-w-2xl mx-auto">
            Discover amazing stories, insights, and ideas from our community of writers.
        </p>
    </div>

    <div class="mb-8 max-w-md mx-auto">
        <div class="relative">
            <input 
                type="text" 
                wire:model.live="search"
                placeholder="Search posts..." 
                class="w-full px-4 py-2 pl-10 pr-4 text-gray-700 bg-white border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
            >
            <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    @if($posts->count() > 0)
        <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3 mb-8">
            @foreach($posts as $post)
                <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                    @if($post->featured_image)
                        <img src="{{ $post->featured_image }}" alt="{{ $post->title }}" class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center">
                            <span class="text-white text-2xl font-bold">{{ substr($post->title, 0, 1) }}</span>
                        </div>
                    @endif
                    
                    <div class="p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-2 line-clamp-2">
                            <a wire:navigate href="{{ route('blog.post', $post->slug) }}" class="hover:text-blue-600 transition-colors">
                                {{ $post->title }}
                            </a>
                        </h2>
                        
                        <p class="text-gray-600 mb-4 line-clamp-3">{{ $post->excerpt }}</p>
                        
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">
                                {{ $post->published_at->format('M d, Y') }}
                            </span>
                            <a wire:navigate href="{{ route('blog.post', $post->slug) }}" class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                                Read More →
                            </a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $posts->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <div class="text-gray-400 mb-4">
                <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-medium text-gray-900 mb-2">No posts found</h3>
            <p class="text-gray-600">
                @if($search)
                    No posts match your search criteria. Try different keywords.
                @else
                    There are no published posts yet. Check back later!
                @endif
            </p>
        </div>
    @endif
</div>
