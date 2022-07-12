@if($show)
<div>
    <div class="fixed inset-0 bg-gray-500 opacity-75">
       &nbsp;
    </div>
    <div {{ $attributes->merge(['class' => 'bg-white shadow-md max-w-sm m-auto rounded-md fixed inset-0']) }}>
        <div class="flex flex-col h-full justify-between">
            <header class="p-4 bg-gray-200 rounded-t-md">
                <h3 class="font-bold text-lg">{{ $title }}</h3>
            </header>

            <main class="p-4">
                {{ $body }}
            </main>

            <footer class="p-4">
                {{ $footer }}
            </footer>
        </div>
    </div>
</div>
@endif
