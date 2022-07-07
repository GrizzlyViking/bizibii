<div class="mt-10 sm:mt-0">
    <div class="md:grid md:grid-cols-3 md:gap-6">
        <div class="md:col-span-1">
            <div class="px-4 sm:px-0">
                <h3 class="text-lg font-medium leading-6 text-gray-900">Create an account</h3>
                <p class="mt-1 text-sm text-gray-600">Create an account.</p>
            </div>
        </div>
        <div class="mt-5 md:mt-0 md:col-span-2">
            <form action="#" method="POST">
                <div class="shadow overflow-hidden sm:rounded-md">
                    <div class="px-4 py-5 bg-white sm:p-6">
                        <div class="grid grid-cols-6 gap-6">

                            <div class="col-span-6">
                                <label for="description" class="block text-sm font-medium text-gray-700">Name of account</label>
                                <input type="text" wire:model.debounce.500ms="name" autocomplete="name-account" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                @error('name') <span class="error text-sm text-red-400">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-span-6">
                                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                <input type="text" wire:model.debounce.500ms="description" autocomplete="description-account" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                @error('description') <span class="error text-sm text-red-400">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-span-6 sm:col-span-4">
                                <label for="amount" class="block text-sm font-medium text-gray-700">Balance</label>
                                <input type="text" wire:model.debounce.500ms="balance" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                @error('balance') <span class="error text-sm text-red-400">{{ $message }}</span> @enderror
                            </div>


                        </div>
                    </div>
                    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                        <button type="button" wire:click="delete({{ $account_id }})" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-500 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Delete</button>
                        <button type="button" wire:click="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">{{ $submit }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
