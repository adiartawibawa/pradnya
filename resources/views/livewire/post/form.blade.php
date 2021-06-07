@push('style')
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/medium-editor@latest/dist/css/medium-editor.min.css" type="text/css"
        media="screen" charset="utf-8">
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/medium-editor@latest/dist/css/themes/default.css" type="text/css"
        media="screen" charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

<div>
    <div class="container mx-auto px-4 py-8">
        <div class="space-y-8 w-full">

            @if ($saveSuccess)
                <div class="rounded-md bg-green-100 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            @if ($modelId)
                                <h3 class="text-sm font-medium text-green-800">Successfully Updated Post</h3>
                                <div class="mt-2 text-sm text-green-700">
                                    <p>Your new post has been updated.</p>
                                </div>
                            @else
                                <h3 class="text-sm font-medium text-green-800">Successfully Saved Post</h3>
                                <div class="mt-2 text-sm text-green-700">
                                    <p>Your new post has been saved.</p>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            @endif

            <div class="sm:col-span-6">
                <div class="mt-1">
                    <input id="title" wire:model="title" name="title" placeholder="Post Title"
                        class="w-full font-semibold text-4xl italic transition appearance-none duration-150 ease-in-out py-2 px-3 bg-gray-100">
                </div>
            </div>
            <div class="sm:col-span-6 pt-5" wire:ignore>
                <div class="mt-1">
                    <textarea wire:model="body" class="editable font-normal text-gray-600 text-lg">
                        {!! $body !!}
                    </textarea>
                </div>
            </div>

            @if ($modelId)
                <div wire:click="submit" wire:loading.attr="disabled"
                    class="inline-flex justify-center px-4 py-2 text-sm font-medium leading-5 text-white transition duration-150 ease-in-out bg-indigo-500 border border-transparent rounded-md hover:bg-indigo-600 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 cursor-pointer">
                    Update Post</div>
            @else
                <div wire:click="submit" wire:loading.attr="disabled"
                    class="inline-flex justify-center px-4 py-2 text-sm font-medium leading-5 text-white transition duration-150 ease-in-out bg-indigo-500 border border-transparent rounded-md hover:bg-indigo-600 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 cursor-pointer">
                    Save Post</div>
            @endif

            <a href="{{ route('post') }}"
                class="inline-flex justify-center px-4 py-2 text-sm font-medium leading-5 text-gray-800 transition duration-150 ease-in-out bg-white border border-transparent rounded-md hover:bg-gray-200 focus:outline-none focus:border-gray-700 focus:shadow-outline-gray active:bg-gray-700 cursor-pointer">Back</a>
        </div>

    </div>

    @if ($modelId)
        {{-- The General Post Setting Modal --}}
        <x-jet-dialog-modal wire:model="modalPostSettingVisible">
            <x-slot name="title">
                General Settings
            </x-slot>

            <x-slot name="content">
                <div class="grid">
                    <div wire:ignore class="grid grid-cols-1  mt-5">
                        <label class=" md:text-sm text-xs text-gray-500 text-light font-semibold">Topics</label>
                        <select
                            class="rounded-lg border-2 border-purple-300 mt-1 focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent"
                            id="topic">
                            <option value="">Select or create a option</option>
                            @foreach ($topics as $item)
                                <option value="{{ $item }}">{{ $item }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div wire:ignore class="grid grid-cols-1 mt-5">
                        <label class=" md:text-sm text-xs text-gray-500 text-light font-semibold">Tags</label>
                        <select
                            class="py-2 px-3 rounded-lg border-2 border-purple-300 mt-1 focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent"
                            id="tag" wire:model="newTags" multiple="multiple">
                            <option value="">Select or create a tags</option>
                            @foreach ($tags as $item)
                                <option value="{{ $item }}">{{ $item }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$toggle('modalPostSettingVisible')" wire:loading.attr="disabled">
                    {{ __('Cancel') }}
                </x-jet-secondary-button>

                <x-jet-button class="ml-2 bg-purple-600 hover:bg-purple-800" wire:click="saveGeneralSettings()"
                    wire:loading.attr="disabled">
                    {{ __('Save') }}
                </x-jet-button>
            </x-slot>
        </x-jet-dialog-modal>

        {{-- The Feature Image Modal --}}
        <x-jet-dialog-modal wire:model="modalFeatureImageVisible">
            <x-slot name="title">
                Featured Image
            </x-slot>
            <x-slot name="content">
                @empty($photo)
                    <div class='flex items-center justify-center w-full'>
                        <label
                            class='flex flex-col border-4 border-dashed w-full h-32 hover:bg-gray-100 hover:border-purple-300 group'>
                            <div class='flex flex-col items-center justify-center pt-7'>
                                <svg class="w-10 h-10 text-purple-400 group-hover:text-purple-600" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                                <p class='lowercase text-sm text-gray-400 group-hover:text-purple-600 pt-1 tracking-wider'>
                                    Select a photo</p>
                            </div>
                            <input type="file" wire:model="photo" class="hidden" />
                        </label>
                    </div>
                @endempty

                @if ($photo)
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">
                            Image Caption
                        </label>
                        <input type="text" wire:model="featured_image_caption"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
                    </div>
                    <div class="mt-2">
                        <img src="{{ $photo->temporaryUrl() }}">
                    </div>
                @endif

                @error('photo') <span class="error">{{ $message }}</span> @enderror

            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$toggle('modalFeatureImageVisible')" wire:loading.attr="disabled">
                    {{ __('Nevermind') }}
                </x-jet-secondary-button>

                <x-jet-button wire:click="saveImageFeatured()" class="ml-2 bg-purple-600 hover:bg-purple-800"
                    wire:loading.attr="disabled">
                    {{ __('Save Image') }}
                </x-jet-button>
            </x-slot>
        </x-jet-dialog-modal>

        {{-- The Publish Modal --}}
        <x-jet-dialog-modal wire:model="modalPublishVisible">
            <x-slot name="title">
                Publish Post
            </x-slot>

            <x-slot name="content">
                <div>
                    <label class="block text-gray-700 text-sm mb-2">
                        The post will be published at :
                    </label>
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$toggle('modalPublishVisible')" wire:loading.attr="disabled">
                    {{ __('Nevermind') }}
                </x-jet-secondary-button>

                <x-jet-button class="ml-2 bg-purple-600 hover:bg-purple-800" wire:click="" wire:loading.attr="disabled">
                    {{ __('Publish Post') }}
                </x-jet-button>
            </x-slot>
        </x-jet-dialog-modal>
    @endif

</div>

@push('script')
    <script src="//cdn.jsdelivr.net/npm/medium-editor@latest/dist/js/medium-editor.min.js"></script>
    <script>
        var editor = new MediumEditor('.editable');
        editor.subscribe('blur', function(event, editable) {
            @this.set('body', editor.getContent());
        });

    </script>

    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#topic').select2({
                tags: true,
                tokenSeparators: [','],
            });
            $('#topic').on('change', function(e) {
                var data = $('#topic').select2("val");
                @this.set('newTopic', data);
            });


            $('#tag').select2({
                tags: true,
                data: [],
                tokenSeparators: [',', ' '],
                placeholder: "Add your tags here",
                /* the next 2 lines make sure the user can click away after typing and not lose the new tag */
                selectOnClose: true,
                closeOnSelect: false,
            });
            $('#tag').on('change', function(e) {
                var data = $('#tag').select2("val");
                @this.set('newTags', data);
            });
        });

    </script>
@endpush
