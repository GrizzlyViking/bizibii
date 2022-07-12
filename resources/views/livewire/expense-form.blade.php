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
                        The {{ $expense->category->value }} attempts to emulate daily food/cloths/leisure/and similar consumption during a month. These costs
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
                                <select wire:model="expense.account_id" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" @if($submit === 'Update')'disabled'@endif>
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
                                <select wire:model="expense.category" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    @foreach(\App\Enums\Category::all() as $option)
                                        <option value="{{ $option->value }}">{{ ucwords($option->value) }}</option>
                                    @endforeach
                                </select>
                                @error('expense.category') <span class="error text-sm text-red-400">{{ $message }}</span> @enderror
                            </div>

                            @if(\App\Enums\Category::Transfer->equals($expense->category))
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="transfer_to_account_id" class="block text-sm font-medium text-gray-700">Transfer to account</label>
                                    <select wire:model="expense.transfer_to_account_id" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" @if($submit === 'Update')'disabled'@endif>
                                    @forelse(Auth::user()->accounts as $option)
                                        <option value="{{ $option->id }}">{{ ucwords($option->name) }}</option>
                                    @empty
                                        <option>No bank account(s)</option>
                                        @endforelse
                                        </select>
                                        @error('expense.transfer_to_account_id') <span class="error text-sm text-red-400">{{ $message }}</span> @enderror
                                </div>
                            @endif

                            <div class="col-span-6">
                                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                <input type="text" wire:model.debounce.500ms="expense.description" autocomplete="description-name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                @error('expense.description') <span class="error text-sm text-red-400">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-span-6 sm:col-span-4">
                                <label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
                                <input type="text" wire:model.debounce.500ms="expense.amount" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                @error('expense.amount') <span class="error text-sm text-red-400">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="frequency" class="block text-sm font-medium text-gray-700">Frequency</label>
                                <select  wire:model="frequency" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    @foreach(\App\Enums\Frequency::all() as $frequency)
                                        <option value="{{ $frequency->value }}">{{ ucfirst($frequency->value) }}</option>
                                    @endforeach
                                </select>
                                @error('expense.frequency') <span class="error text-sm text-red-400">{{ $message }}, {{ $frequency->value }}</span> @enderror
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="due_date" class="block text-sm font-medium text-gray-700">Due date</label>
                                <select wire:model="expense.due_date" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    @foreach(\App\Enums\DueDate::all() as $option)
                                    <option value="{{ $option->value }}">{{ ucfirst($option->value) }}</option>
                                    @endforeach
                                </select>
                                @error('due_date') <span class="error text-sm text-red-400">{{ $message }}</span> @enderror
                            </div>

                            @if(\App\Enums\DueDate::DateInMonth->equals($expense->due_date))
                            <div class="col-span-6 sm:col-span-4">
                                <label for="due_date_meta" class="block text-sm font-medium text-gray-700">When in the month is the expense due</label>
                                <input type="text"  wire:model="expense.due_date_meta" autocomplete="due_date_meta" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>
                            @endif
                            @error('expense.due_date_meta') <span class="error text-sm text-red-400">{{ $message }}</span> @enderror

                            <div class="col-span-6 sm:col-span-3">
                                <label for="start" class="block text-sm font-medium text-gray-700">Start date</label>
                                <input type="date"  wire:model="expense.start" autocomplete="start" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md h-10">
                                @error('expense.start') <span class="error text-sm text-red-400">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="end" class="block text-sm font-medium text-gray-700">End (optional)</label>
                                <input type="date"  wire:model="end" autocomplete="expense.end" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md h-10">
                                @error('expense.end') <span class="error text-sm text-red-400">{{ $message }}</span> @enderror
                            </div>

                        </div>
                    </div>
                    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                        <x-button class="focus:ring-red-500 bg-red-600 hover:bg-red-700" wire:click="delete({{ $expense->id }})">Delete</x-button>
                        <x-button class="focus:ring-indigo-500 bg-indigo-600 hover:bg-indigo-700" wire:click="submit">{{ $submit }}</x-button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
