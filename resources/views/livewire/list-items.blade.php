@php /** @var \Illuminate\Support\Collection $items **/ @endphp
<div>
    <div class="pt-1 md:px-12 pb-12">
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
                                            {{ __($columnHeaders[0] ?? 'Title') }}
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __($columnHeaders[1] ?? 'Name') }}
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __($columnHeaders[2] ?? 'Status') }}
                                        </th>
                                        @if($items->isNotEmpty() && !empty($items->first()->getColumn4()))
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __($columnHeaders[3] ?? 'Content') }}
                                        </th>
                                        @endif
                                        @if($items->isNotEmpty() && !empty($items->first()->getColumn4()))
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __($columnHeaders[4] ?? 'Column 4') }}
                                        </th>
                                        @endif
                                        <th scope="col" class="relative px-6 py-3">
                                            <span class="sr-only">Edit</span>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($items as $item)
                                        <tr>
                                            <td class="md:px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            {{ $item->getColumn1() }}
                                                        </div>
                                                        <div class="text-sm text-gray-500">
                                                            {{ $item->getColumn1Sub() }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ Str::limit($item->getColumn2(), 30) }}
                                                </div>
                                            </td>
                                            @if($item->getColumn3())
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $item->getColumn3() }}
                                            </td>
                                            @endif
                                            @if($item->getColumn4() && !empty($columnHeaders[3]))
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $item->getColumn4() }}
                                            </td>
                                            @endif
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <a href="{{ $item->getRouteShow() }}"
                                                   class="text-indigo-600 hover:text-indigo-900">{{ $columnHeaders[4] ?? 'View' }}</a>
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
