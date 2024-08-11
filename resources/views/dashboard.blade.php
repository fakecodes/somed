<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Feeds') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Content -->
                        <div>
                            <x-input-label for="content" :value="__('Tell bapack2 jokes...')" />
                            <x-text-input id="content" class="block mt-1 w-full" type="content" name="content" :value="old('content')" required autofocus />
                            <x-input-error :messages="$errors->get('content')" class="mt-2" />
                        </div>

                        <!-- Image -->
                        <div class="mt-4">
                            <!-- <x-input-label for="image" :value="__('Image')" /> -->
                            <div class="relative">
                                <!-- File Input -->
                                <input
                                    id="image"
                                    type="file"
                                    name="image"
                                    class="absolute inset-0 opacity-0 cursor-pointer"
                                    @change="handleFileChange"
                                />
                                    📷 Upload Image
                                </button>
                            </div>
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                        </div>


                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button>
                                {{ __('Post') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Posts View -->
    @include('posts', ['posts' => $posts])
    
</x-app-layout>
