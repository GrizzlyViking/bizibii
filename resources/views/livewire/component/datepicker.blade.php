<div>
    <div class="active block">
        <div class="inline-block rounded-lg bg-green-50 shadow-lg p-4">
            <div class="datepicker-header">
                <div class="bg-white px-2 py-3 text-center font-semibold" style="display: none;"></div>
                <div class="flex justify-between mb-2">
                    <button type="button"
                            class="bg-white rounded-lg text-gray-500 hover:bg-gray-100:bg-gray-600 hover:text-gray-900:text-white text-lg p-2.5 focus:outline-none focus:ring-2 focus:ring-gray-200 prev-btn">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                    <button type="button"
                            class="text-sm rounded-lg text-gray-900 bg-white font-semibold py-2.5 px-5 hover:bg-gray-100:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-200 view-switch">
                        {{ $date->format('m') }}
                    </button>
                    <button type="button"
                            class="bg-white rounded-lg text-gray-500 hover:bg-gray-100:bg-gray-600 hover:text-gray-900:text-white text-lg p-2.5 focus:outline-none focus:ring-2 focus:ring-gray-200 next-btn">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                  d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z"
                                  clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="datepicker-main p-1">
                <div class="datepicker-view flex">
                    <div class="days">
                        <div class="days-of-week grid grid-cols-7 mb-1"><span
                                class="dow text-center h-6 leading-6 text-sm font-medium text-gray-500">Su</span><span
                                class="dow text-center h-6 leading-6 text-sm font-medium text-gray-500">Mo</span><span
                                class="dow text-center h-6 leading-6 text-sm font-medium text-gray-500">Tu</span><span
                                class="dow text-center h-6 leading-6 text-sm font-medium text-gray-500">We</span><span
                                class="dow text-center h-6 leading-6 text-sm font-medium text-gray-500">Th</span><span
                                class="dow text-center h-6 leading-6 text-sm font-medium text-gray-500">Fr</span><span
                                class="dow text-center h-6 leading-6 text-sm font-medium text-gray-500">Sa</span>
                        </div>
                        <div class="datepicker-grid w-64 grid grid-cols-7">
                            @foreach($grid as $week)
                                @foreach($week as $day)
                                <span
                                    class="hover:bg-gray-100 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 font-semibold text-sm"
                                >{{ $day->day }}</span>
                                @endforeach
                            @endforeach
                    </div>
                </div>
            </div>
            </div>
            <div class="datepicker-footer">
                <div class="datepicker-controls flex space-x-2 mt-2">
                    <button type="button"
                            class="button today-btn text-white bg-blue-700 hover:bg-blue-800:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2 text-center w-1/2"
                            style="display: none;">Today
                    </button>
                    <button type="button"
                            class="button clear-btn text-gray-900 bg-white border border-gray-300 hover:bg-gray-100:bg-gray-600 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2 text-center w-1/2"
                            style="display: none;">Clear
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

