@props([
    'error' => null,
    'name' => 'date_input',
])

<div
    x-data="{ value: @entangle($attributes->wire('model')) }"
    x-on:change="value = $event.target.value"
    x-init="
        new Pikaday({ field: $refs.input, 'format': 'DD/MM/YYYY', yearRange: [1940, 2010],firstDay: 1 });"
>
    <input 
        {{ $attributes->whereDoesntStartWith('wire:model') }} 
        x-ref="input"
        x-bind:value="value" 
        type="text" 
        name="{{$name}}"
        class="form-control form-control-solid"
        class="pl-10 block w-full shadow-sm sm:text-lg bg-gray-50 border-gray-300 @if($error) focus:ring-danger-500 focus:border-danger-500 border-danger-500 text-danger-500 pr-10 @else focus:ring-primary-500 focus:border-primary-500 @endif rounded-md" 
    />
</div>