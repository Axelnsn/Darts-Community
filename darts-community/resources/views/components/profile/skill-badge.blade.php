@props(['level'])

@php
    $colors = [
        'gray' => 'bg-gray-100 text-gray-800 border-gray-200',
        'green' => 'bg-green-100 text-green-800 border-green-200',
        'blue' => 'bg-blue-100 text-blue-800 border-blue-200',
        'purple' => 'bg-purple-100 text-purple-800 border-purple-200',
        'yellow' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
    ];
    $colorClass = $colors[$level->color()] ?? $colors['gray'];
@endphp

<span {{ $attributes->merge(['class' => "skill-badge inline-flex items-center px-3 py-1 rounded-full text-sm font-medium border {$colorClass}"]) }}>
    {{ $level->label() }}
</span>
