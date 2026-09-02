@props([
    'variant' => 'default', // 'default', 'white'
    'class' => 'h-10 w-auto'
])

<img src="{{ asset('images/logo.png') }}" alt="Dishub Kominfo Kab. Tasikmalaya - Pelayanan Terpadu Satu Pintu" {{ $attributes->merge(['class' => "{$class} object-contain max-w-full shrink-0"]) }}>
