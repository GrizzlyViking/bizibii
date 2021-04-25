<div class="flex justify-between items-center shadow-xl" wire:click="changeSwitch">
    <div class="mr-2 text-sm text-gray-600">{{ $label }}</div>
    <div
        class="w-16 h-10 flex items-center bg-gray-300 rounded-full p-1 duration-300 ease-in-out {{ $active ? $bg_colour : '' }}">
        <div
            class="bg-white w-8 h-8 rounded-full shadow-md transform duration-300 ease-in-out {{ $active ? $animation : '' }}"></div>
    </div>
</div>

