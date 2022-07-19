@php
    /** @var \App\Models\Expense $expense */
@endphp
<div class="mt-10 sm:mt-0">
    <div class="md:grid md:grid-cols-3 md:gap-6">
        <div class="md:col-span-1">
            <div class="px-4 sm:px-0">
                @if(\App\Enums\Category::DayToDayConsumption->equals($expense->category))
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Expenses - {{ $expense->category->value }}</h3>
                    <p class="mt-3 text-sm text-gray-600">
                        The {{ $expense->category->value }} attempts to emulate daily food/cloths/leisure/and similar consumption during a
                        month. These costs
                        exclude fixed expenses. "Fixed" in the sense that the bills are regular, not that the amount can't change ex. a
                        phone bill might fluctuate in amount, but you still have to pay it on the 1st every month
                    </p>
                    <p class="mt-3 text-sm text-gray-600">
                        The figure is based on what a bank requires you to show that you have available for these sorts of expenses, to
                        prove to them that you can afford to pay the mortgage. They recommend that you have 5000kr per grown up, and 2500
                        per child.
                    </p>
                    <p class="mt-3 text-sm text-gray-600">
                        To allow some flexibility, in the calculation, if needed, then this amount will be able to be adjusted downwards
                        till half to represent a month when "we tighten the belt" due to bills.
                    </p>
                    <p class="mt-3 text-sm text-gray-600">
                        The frequency is set to {{ $expense->frequency?->value }} and the due date to {{ $expense->due_date?->value }}. But
                        the calculation is base on what is left over at the end of the month, and as much of the requested amount will be
                        used divided over the month. Ex. if it's a little under then there be a little less per day.
                    </p>
                @else
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Expense</h3>
                    <p class="mt-1 text-sm text-gray-600">Something</p>
                @endif
            </div>
        </div>
        <div class="mt-5 md:mt-0 md:col-span-2">
            <form action="#" method="POST">
                <div class="shadow overflow-hidden sm:rounded-md">
                    <div class="px-4 py-5 bg-white sm:p-6">
                        <div class="grid grid-cols-6 gap-6">

                            <div class="col-span-6 sm:col-span-3">
                                <label for="account" class="block text-sm font-medium text-gray-700">Account</label>
                                <select wire:model="expense.account_id"
                                        class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" @if($submit === 'Update')
                                    'disabled'
                                @endif>
                                @forelse(Auth::user()->accounts as $option)
                                    <option value="{{ $option->id }}">{{ ucwords($option->name) }}</option>
                                @empty
                                    <option>No bank account(s)</option>
                                    @endforelse
                                    </select>
                                    @error('expense.account_id') <span class="error text-sm text-red-400">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                                <select wire:model="expense.category"
                                        wire:change="changeCategory"
                                        class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    @foreach(\App\Enums\Category::all() as $option)
                                        <option value="{{ $option->value }}">{{ ucwords($option->value) }}</option>
                                    @endforeach
                                </select>
                                @error('expense.category') <span class="error text-sm text-red-400">{{ $message }}</span> @enderror
                            </div>

                            @if(\App\Enums\Category::Transfer->equals($expense->category))
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="transfer_to_account_id" class="block text-sm font-medium text-gray-700">Transfer to account</label>
                                    <select wire:model="expense.transfer_to_account_id"
                                            class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" @if($submit === 'Update')
                                        'disabled'
                                    @endif>
                                    @forelse(Auth::user()->accounts as $option)
                                        <option value="{{ $option->id }}">{{ ucwords($option->name) }}</option>
                                    @empty
                                        <option>No bank account(s)</option>
                                        @endforelse
                                        </select>
                                        @error('expense.transfer_to_account_id') <span
                                            class="error text-sm text-red-400">{{ $message }}</span> @enderror
                                </div>
                            @endif

                            <div class="col-span-6">
                                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                <input type="text" wire:model.debounce.500ms="expense.description" autocomplete="description-name"
                                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                @error('expense.description') <span class="error text-sm text-red-400">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-span-6 sm:col-span-4">
                                <label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
                                <input type="text" wire:model.debounce.500ms="expense.amount"
                                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                @error('expense.amount') <span class="error text-sm text-red-400">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="frequency" class="block text-sm font-medium text-gray-700">Frequency</label>
                                <select wire:model="expense.frequency"
                                        class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    @foreach(\App\Enums\Frequency::all() as $option)
                                        <option value="{{ $option->value }}">{{ ucfirst($option->value) }}</option>
                                    @endforeach
                                </select>
                                @error('expense.frequency') <span class="error text-sm text-red-400">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="due_date" class="block text-sm font-medium text-gray-700">Due date</label>
                                <select wire:model="expense.due_date"
                                        class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    @foreach(\App\Enums\DueDate::all() as $option)
                                        <option value="{{ $option->value }}">{{ ucfirst($option->value) }}</option>
                                    @endforeach
                                </select>
                                @error('due_date') <span class="error text-sm text-red-400">{{ $message }}</span> @enderror
                            </div>

                            @if(\App\Enums\DueDate::DateInMonth->equals($expense->due_date) || \App\Enums\Frequency::Single->equals($expense->frequency))
                                <div class="col-span-6 sm:col-span-4">
                                    <label for="due_date_meta" class="block text-sm font-medium text-gray-700">When in the month is the expense due</label>
                                    <input type="{{ \App\Enums\Frequency::Single->equals($expense->frequency) ? 'date' : 'text' }}" wire:model="expense.due_date_meta" autocomplete="due_date_meta"
                                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                            @endif
                            @error('expense.due_date_meta') <span class="error text-sm text-red-400">{{ $message }}</span> @enderror

                            <div class="col-span-6 sm:col-span-3">
                                <label for="start_date" class="block text-sm font-medium text-gray-700">Start date</label>
                                <input type="date" wire:model="start_date"
                                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md h-10">
                                @error('start_date') <span class="error text-sm text-red-400">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="end_date" class="block text-sm font-medium text-gray-700">End (optional)</label>
                                <input type="date" wire:model="end_date"
                                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md h-10">
                                @error('end_date') <span class="error text-sm text-red-400">{{ $message }}</span> @enderror
                            </div>

                        </div>
                    </div>
                    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
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
                <x-button class="focus:ring-indigo-500 bg-indigo-600 hover:bg-indigo-700"
                          wire:click="addCheckpoint">{{ $submit }}</x-button>
            </div>
        </x-slot>
    </x-checkpoint-modal>
</div>
