@php
    use App\Enums\DueDate;
    use App\Enums\Frequency;
    /** @var \App\Models\Expense $expense */
@endphp

<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="my-6 px-6 p-8 bg-white shadow-xl sm:rounded-lg">

        <form class="space-y-8 divide-y divide-gray-200">
            <div class="space-y-8 divide-y divide-gray-200 sm:space-y-5">
                <div class="space-y-6 sm:space-y-5">

                    <div class="space-y-6 pt-8 sm:space-y-5 sm:pt-10">
                        <div>
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Expenses</h3>
                        </div>
                        <div class="space-y-6 sm:space-y-5">
                            <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                                <label for="account" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Account</label>
                                <div class="mt-1 sm:col-span-2 sm:mt-0">
                                    <select wire:model="expense.account_id" id="account" name="account" autocomplete="account-id"
                                            class="block w-full max-w-lg rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:max-w-xs sm:text-sm">
                                        @forelse(Auth::user()->accounts as $option)
                                            <option value="{{ $option->id }}">{{ ucwords($option->name) }}</option>
                                        @empty
                                            <option>No bank account(s)</option>
                                        @endforelse
                                    </select>
                                    @error('expense.account_id') <span class="error text-sm text-red-400">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                                <label for="country" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Category</label>
                                <div class="mt-1 sm:col-span-2 sm:mt-0">
                                    <select wire:model="expense.category"
                                            wire:change="changeCategory"
                                            id="category"
                                            name="category"
                                            autocomplete="category-id"
                                            class="block w-full max-w-lg rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:max-w-xs sm:text-sm">
                                        @foreach(\App\Enums\Category::all() as $option)
                                            <option value="{{ $option->value }}">{{ ucwords($option->value) }}</option>
                                        @endforeach
                                    </select>
                                    @error('expense.category') <span class="error text-sm text-red-400">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            @if(\App\Enums\Category::Transfer->equals($expense->category))
                                <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                                    <label for="country" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Transfer to
                                        account</label>
                                    <div class="mt-1 sm:col-span-2 sm:mt-0">
                                        <!--suppress XmlUnboundNsPrefix -->
                                        <select wire:model="expense.transfer_to_account_id" id="transfer_to_account"
                                                name="transfer_to_account" autocomplete="transfer-to-account-id"
                                                class="block w-full max-w-lg rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:max-w-xs sm:text-sm">
                                            @forelse(Auth::user()->accounts as $option)
                                                <option value="{{ $option->id }}">{{ ucwords($option->name) }}</option>
                                            @empty
                                                <option>No bank account(s)</option>
                                            @endforelse
                                        </select>
                                        @error('expense.account_id') <span
                                            class="error text-sm text-red-400">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            @endif

                            <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                                <label for="first-name" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Description</label>
                                <div class="mt-1 sm:col-span-2 sm:mt-0">
                                    <input type="text"
                                           wire:model.debounce.500ms="expense.description"
                                           name="description" id="description"
                                           autocomplete="given-name"
                                           class="block w-full max-w-lg rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:max-w-xs sm:text-sm">
                                    @error('expense.description') <span class="error text-sm text-red-400">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                                <label for="amount" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Amount</label>
                                <div class="mt-1 sm:col-span-2 sm:mt-0">
                                    <input wire:model.debounce.500ms="expense.amount" type="text" name="amount" id="amount"
                                           autocomplete="family-name"
                                           class="block w-full max-w-lg rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:max-w-xs sm:text-sm">
                                </div>
                                @error('expense.amount') <span class="error text-sm text-red-400">{{ $message }}</span> @enderror
                            </div>

                            <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                                <label for="country" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Frequency</label>
                                <div class="mt-1 sm:col-span-2 sm:mt-0">
                                    <select wire:model="expense.frequency"
                                            wire:change="changeFrequency"
                                            id="frequency"
                                            name="frequency"
                                            autocomplete="frequency-id"
                                            class="block w-full max-w-lg rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:max-w-xs sm:text-sm">
                                        @foreach(Frequency::all() as $option)
                                            <option value="{{ $option->value }}">{{ ucfirst($option->value) }}</option>
                                        @endforeach
                                    </select>
                                    @error('expense.frequency') <span class="error text-sm text-red-400">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                                <label for="country" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Due date</label>
                                <div class="mt-1 sm:col-span-2 sm:mt-0">
                                    <select wire:model="expense.due_date"
                                            id="due_date"
                                            name="due_date"
                                            autocomplete="due-date-id"
                                            class="block w-full max-w-lg rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:max-w-xs sm:text-sm">
                                        @foreach(DueDate::all() as $option)
                                            <option value="{{ $option->value }}">{{ ucfirst($option->value) }}</option>
                                        @endforeach
                                    </select>
                                    @error('expense.due_date') <span class="error text-sm text-red-400">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            @if(DueDate::DateInMonth->equals($expense->due_date) || Frequency::Single->equals($expense->frequency))
                                <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                                    <label for="email" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                        Which date?</label>
                                    <div class="mt-1 sm:col-span-2 sm:mt-0">
                                        <input wire:model="expense.due_date_meta"
                                               type="{{ Frequency::Single->equals($expense->frequency) ? 'date' : 'text' }}"
                                               autocomplete="due_date_meta"
                                               class="block w-full max-w-lg rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                        >
                                    </div>
                                </div>
                            @endif
                            @error('expense.due_date_meta') <span class="error text-sm text-red-400">{{ $message }}</span> @enderror

                            @if(!$expense->due_date->equals(DueDate::Date))
                            <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                                <label for="start_date" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Start date</label>
                                <div class="mt-1 sm:col-span-2 sm:mt-0">
                                    <input wire:model="start_date" type="date" name="start_date" id="start_date"
                                           autocomplete="address-level2"
                                           class="block w-full max-w-lg rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:max-w-xs sm:text-sm">
                                    @error('start_date') <span class="error text-sm text-red-400">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                                <label for="end_date" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">End date</label>
                                <div class="mt-1 sm:col-span-2 sm:mt-0">
                                    <input wire:model="end_date" type="date" name="end_date" id="end_date" autocomplete="address-level2"
                                           class="block w-full max-w-lg rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:max-w-xs sm:text-sm">
                                    @error('end_date') <span class="error text-sm text-red-400">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            @endif

                        </div>
                    </div>

                </div>

                <div class="pt-5">
                    <div class="flex justify-end">
                        @if($expense->id)
                            <x-button class="focus:ring-gray-500 bg-gray-600 hover:bg-gray-700" wire:click="$set('show_modal', true)">Add
                                Checkpoint
                            </x-button>
                            <x-button class="focus:ring-red-500 bg-red-600 hover:bg-red-700" wire:click="delete({{ $expense->id }})">
                                Delete
                            </x-button>
                        @endif
                        <x-button class="focus:ring-indigo-500 bg-indigo-600 hover:bg-indigo-700"
                                  wire:click="submit">{{ $submit }}</x-button>
                    </div>
                </div>
        </form>

        @if($expense?->checkpoints->count() > 0)
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                <tr>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Registered on Date
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Amount
                    </th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                @foreach($expense->checkpoints as $item)
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
                            <x-button class="focus:ring-red-500 text-sm bg-red-600 hover:bg-red-700"
                                      wire:click="deleteCheckpoint({{ $item->id }})">Delete
                            </x-button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif

        <div class="h-96 pt-4">
            <livewire:livewire-column-chart :column-chart-model="$barChart"/>
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
                <x-button class="focus:ring-indigo-500 bg-indigo-600 hover:bg-indigo-700"
                          wire:click="addCheckpoint">{{ $submit }}</x-button>
            </div>
        </x-slot>
    </x-checkpoint-modal>
</div>
