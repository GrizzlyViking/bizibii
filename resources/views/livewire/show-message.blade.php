<div class="bg-white shadow overflow-hidden sm:rounded-lg">
    <div class="flex content-start">
        <div class="px-4 py-5 sm:px-6 w-full">
            <h3 class="w-11/12 text-lg leading-6 font-medium text-gray-900">
                Message
            </h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                Message posted on form at the bottom of landing page
            </p>
        </div>
        <div class="w-1/12 px-4 py-5 sm:px-6">
            <a href="{{ route('message.list') }}" class="text-indigo-600 hover:text-indigo-900">< back</a>
        </div>
    </div>
    <div class="border-t border-gray-200">
        <dl>
            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">
                    Full name
                </dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                    {{ $message->name }}
                </dd>
            </div>
            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">
                    Email address
                </dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                    {{ $message->email }}
                </dd>
            </div>
            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">
                    Date
                </dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                    {{ $message->created_at->format('Y-m-d H:i:s') }}
                </dd>
            </div>
            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">
                    Message content
                </dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                    {{ $message->message }}
                </dd>
            </div>
            <div class="flex content-evenly bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <button
                    type='submit'
                    wire:click="deleteMessage"
                    class='inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs
                    text-white uppercase tracking-widest bg-red-300 hover:bg-red-400 active:bg-red-600 focus:outline-none focus:border-red-600
                    focus:shadow-outline-gray disabled:opacity-25 transition'>
                    Delete
                </button>
                <button
                    type='submit'
                    wire:click="toggleRead"
                    class='inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs
                    text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900
                    focus:shadow-outline-gray disabled:opacity-25 transition'>
                    Mark {{ $message->read ? 'unread' : 'read' }}
                </button>
            </div>
        </dl>
    </div>
</div>
