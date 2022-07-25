<div>
    <div class="pt-1 px-12 pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mt-6 bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="flex flex-col">
                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Expenses
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Due
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Amount
                                        </th>
                                        <th scope="col" class="relative px-6 py-3">
                                            <a href="{{ route('expenses.create') }}" class="inline-flex justify-right py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white focus:outline-none focus:ring-2 focus:ring-offset-2 bg-green-600 hover:bg-green-700 focus:ring-green-500">Add</a>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($items as $item)
                                        <tr @if($item->highlight)class="bg-red-200"@endif>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            {{ $item->description }}
                                                        </div>
                                                        <div class="text-sm text-gray-500">
                                                            {{ $item->category->value }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            {{ $item->due_date->value }}
                                                        </div>
                                                        <div class="text-sm text-gray-500">
                                                            {{ $item->frequency->value }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-{{ $item->category->colour() }}-500">
                                                    {{ number_format($item->amount) }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <a href="{{ route('expenses.edit', $item->id) }}" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Edit</a>
                                                <x-button class="focus:ring-red-500 bg-red-600 hover:bg-red-700" wire:click="delete({{ $item->id }})">Delete</x-button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <!-- More people... -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
