<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden mx-auto w-6/12 bg-white shadow-xl sm:rounded-lg relative">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">


                    <div class="col-span-6 mt-3">
                        <label for="email_address" class="block text-sm font-medium text-gray-700">Title</label>
                        <input type="text" name="title" id="title" wire:model.debounce.500ms="section.title"
                               class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        @if($errors->has('section.title'))
                            <p class="mt-1 pl-1 text-xs text-red-400">{{ $errors->first('section.title') }}</p>
                        @else
                            <p class="mt-1 pl-1 text-xs text-gray-500">Title is shown behind text vertically</p>
                        @endif
                    </div>

                    <div class="col-span-6 mt-3">
                        <label for="email_address" class="block text-sm font-medium text-gray-700">Sub Title</label>
                        <input type="text" name="subtitle" id="subtitle" wire:model="section.subtitle"
                               class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        @error('section.subtitle')
                            <p class="mt-1 pl-1 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-6 mt-3">
                        <label for="about" class="block text-sm font-medium text-gray-700">Content</label>
                        <div class="mt-1">
                            <textarea id="about" name="about" rows="6" wire:model="section.content"
                                      class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border-gray-300 rounded-md"
                                      placeholder="you@example.com"></textarea>
                        </div>
                        @error('section.content')
                            <p class="mt-1 pl-1 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-start mt-3">
                        <div class="flex items-center h-5">
                            <input wire:model="section.published" id="published" name="published" type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="published" class="font-medium text-gray-700">Published</label>
                            <p class="text-gray-500">Whether section is shown on page.</p>
                        </div>
                    </div>

                </div>
                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                    <button type="button" wire:click="saveSection" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Save
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden mx-auto w-6/12 bg-white shadow-xl sm:rounded-lg relative">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <div class="absolute top-4 left-15 m-2 w-20 transform rotate-90">
                        <h1 class="text-8xl text-gray-500 m-2 text-opacity-50">{{ $section->title }}</h1>
                    </div>
                    <div class="text-2xl">{{ $section->subtitle }}</div>
                    <div>{!! $section->content !!}</div>
                </div>
            </div>
        </div>
    </div>
</div>
