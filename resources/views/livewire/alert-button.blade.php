<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest bg-red-300 hover:bg-red-400 active:bg-red-500 focus:border-red-900 focus:outline-none focus:shadow-outline-red disabled:opacity-25 transition']) }}>
    {{ $slot }}
</button>
