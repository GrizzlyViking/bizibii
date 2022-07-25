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
                        <div class="grid grid-cols-4 gap-6">

                            <div class="col-span-6">
                                <label for="name" class="block text-sm font-medium text-gray-700">Name of account</label>
                                <input type="text" wire:model.debounce.500ms="account.name"
                                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                @error('account.name') <span class="error text-sm text-red-400">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-span-6">
                                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                <input type="text" wire:model.debounce.500ms="account.description"
                                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                @error('account.description') <span class="error text-sm text-red-400">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-span-6 sm:col-span-4">
                                <label for="amount" class="block text-sm font-medium text-gray-700">Balance</label>
                                <input type="text" wire:model.debounce.500ms="account.balance"
                                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                @error('account.balance') <span class="error text-sm text-red-400">{{ $message }}</span> @enderror
                            </div>

                        </div>
                    </div>
                    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                        @if(isset($account->id))
                        <x-button class="focus:ring-gray-500 bg-gray-600 hover:bg-gray-700" wire:click="$set('show_modal', true)">Add Checkpoint</x-button>
                        <x-button class="focus:ring-red-500 bg-red-600 hover:bg-red-700" wire:click="delete({{ $account?->id }})">Delete</x-button>
                        @endif
                        <x-button class="focus:ring-indigo-500 bg-indigo-600 hover:bg-indigo-700"
                                  wire:click="submit">{{ isset($account->id) ? 'update' : 'save' }}</x-button>
                    </div>
                </div>
            </form>
            @if($account?->checkpoints->count() > 0)
                <div class="mt-5 md:mt-0 md:col-span-2">
                    <div class="mt-6 bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <div class="flex flex-col">
                            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Registered on Date
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Balance
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach($account->checkpoints as $item)
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm font-medium text-gray-500">
                                                            {{ $item->registered_date->format('Y-m-d') }}
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm font-medium text-gray-500">
                                                            {{ number_format($item->amount) }}
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 text-right whitespace-nowrap">
                                                        <x-button class="focus:ring-red-500 text-sm bg-red-600 hover:bg-red-700" wire:click="deleteCheckpoint({{ $item->id }})">Delete</x-button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <x-checkpoint-modal :show="$show_modal" class="h-80">
        <x-slot name="title">
            Add checkpoint
        </x-slot>

        <x-slot name="body">
            <form action="#" method="POST">

                <div class="col-span-6">
                    <label for="checkpoint_date" class="block text-sm font-medium text-gray-700">Date</label>
                    <input type="date" wire:model.debounce.500ms="checkpoint_date"
                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    @error('checkpoint_date') <span class="error text-sm text-red-400">{{ $message }}</span> @enderror
                </div>

                <div class="col-span-6 mt-2">
                    <label for="checkpoint_amount" class="block text-sm font-medium text-gray-700">Balance</label>
                    <input type="text" wire:model.debounce.500ms="checkpoint_amount"
                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    @error('checkpoint_amount') <span class="error text-sm text-red-400">{{ $message }}</span> @enderror
                </div>
            </form>
        </x-slot>

        <x-slot name="footer">
            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                <x-button class="focus:ring-gray-500 bg-gray-600 hover:bg-gray-700" wire:click="$set('show_modal', false)">Cancel</x-button>
                <x-button class="focus:ring-indigo-500 bg-indigo-600 hover:bg-indigo-700" wire:click="addCheckpoint">{{ $submit }}</x-button>
            </div>
        </x-slot>
    </x-checkpoint-modal>
</div>
