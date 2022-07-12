@php /** @var \Symfony\Component\HttpFoundation\Session\Attribute\AttributeBagInterface $attributes */@endphp
<button
    type="button"
    @if($attributes->has('wire:click')){{ $attributes->get('wire:click') }}@endif
    @if($attributes->has('wire:model')){{ $attributes->get('wire:model') }}@endif
    {{ $attributes->merge([
        'class' => 'inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white focus:outline-none focus:ring-2 focus:ring-offset-2 uppercase'
    ]) }}>{{ $slot }}</button>
