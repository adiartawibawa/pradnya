<div>
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __($post->title) }}
                </h2>
                <div class="hidden sm:flex sm:items-center sm:ml-6">
                    <!-- Settings Dropdown -->
                    <div class="ml-3 relative">
                        <x-jet-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <span class="inline-flex rounded-md">
                                    <button type="button"
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z">
                                            </path>
                                        </svg>
                                    </button>
                                </span>
                            </x-slot>

                            <x-slot name="content">
                                <x-jet-dropdown-link wire:click="$emit('showGeneralSetting')">
                                    {{ __('General Settings') }}
                                </x-jet-dropdown-link>
                                <x-jet-dropdown-link wire:click="$emit('showFeatureImage')">
                                    {{ __('Featured Image') }}
                                </x-jet-dropdown-link>
                                <x-jet-dropdown-link wire:click="$emit('showPublish')">
                                    {{ __('Publish Post') }}
                                </x-jet-dropdown-link>
                            </x-slot>
                        </x-jet-dropdown>

                    </div>
                </div>

            </div>
        </div>
    </header>

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden">
                @livewire('post.form', ['post' => $post])
            </div>
        </div>
    </div>

</div>
