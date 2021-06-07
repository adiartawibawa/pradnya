<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('All Post') }}
        </h2>
    </x-slot>

    <div class="py-2">
        <div class="max-w-full mx-auto sm:px-3">
            <div>
                @livewire('post.all-post')
            </div>
        </div>
    </div>
</x-app-layout>
