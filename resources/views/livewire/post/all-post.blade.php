<div>
    <div class="px-4 py-8 mx-auto sm:max-w-xl md:max-w-full lg:max-w-screen-xl md:px-24 lg:px-8 lg:py-10">
        <div
            class="flex flex-row mb-1 sm:mb-0 justify-between items-center  w-full sm:max-w-sm sm:mx-auto lg:max-w-full">
            <div class="leading-tight">
                <div class="flex w-full max-w-sm mr-4">
                    <input type="text" wire:model.debounce.500ms="searchTerm"
                        class="rounded-l-lg border-t mr-0 border-b text-gray-800 border-gray-200 bg-white"
                        placeholder="Search Post..." />
                    <select wire:model="sortDirection"
                        class="px-8 rounded-r-lg bg-white border-purple-600 text-gray-800  border-t border-b border-r"
                        name="sort">
                        <option value="asc">Older post</option>
                        <option value="desc" selected>Recent post</option>
                    </select>
                </div>
            </div>
            <div class="text-end">
                <a href="{{ route('post.create') }}"
                    class="flex-shrink-0 px-4 py-2 text-base font-semibold text-white bg-purple-600 rounded-lg shadow-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 focus:ring-offset-purple-200"
                    type="submit">
                    New Post
                </a>
            </div>
        </div>
        <div class="grid gap-8 lg:grid-cols-3 sm:max-w-sm sm:mx-auto lg:max-w-full mt-5">
            @if (count($posts))
                @foreach ($posts as $post)
                    <div class="overflow-hidden transition-shadow duration-300 bg-white rounded shadow-sm">
                        <img src="{{ empty($post->featured_image) ? "https://picsum.photos/id/$post->id/600/300" : $post->featured_image_url }}"
                            alt="{{ empty($post->featured_image_caption) ? $post->title : $post->featured_image_caption }}" />
                        <div class="p-5 border border-t-0 border-b-0">
                            <p class="mb-3 text-xs font-semibold tracking-wide uppercase">
                                @foreach ($post->topic as $item)
                                    <a href="/"
                                        class="transition-colors duration-200 text-blue-gray-900 hover:text-purple-700"
                                        aria-label="Category" title="{{ $item->name }}">
                                        {{ $item->name }} -
                                    </a>
                                @endforeach
                                <span class="text-gray-600">{{ $post->created_at }}</span>
                            </p>
                            <a href="{{ route('post.view', $post->slug) }}" aria-label="Category"
                                title="{{ $post->title }}"
                                class="inline-block mb-3 text-2xl font-bold leading-5 transition-colors duration-200 hover:text-purple-700">
                                {{ $post->title }}
                            </a>
                            <p class="mb-2 text-gray-700">
                                {!! Str::limit($post->body, 300) !!}
                            </p>
                            @if (Str::length($post->body) >= 300)
                                <a href="/" aria-label=""
                                    class="inline-flex items-center font-semibold transition-colors duration-200 text-purple-400 hover:text-800">Read
                                    more</a>
                            @endif

                        </div>

                    </div>

                @endforeach

            @else
                <h2>No Post Yet!</h2>
            @endif

        </div>
    </div>
    <div>
        {{ $posts->links() }}
    </div>
</div>
