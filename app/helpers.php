<?php

if (!function_exists('tailwind_colour_to_hex')) {
    function tailwind_colour_to_hex(string $class): string
    {
        $tailwind_colours = [
            'red'            => '#f44336',
            'red-50'         => '#ffebee',
            'red-100'        => '#ffcdd2',
            'red-200'        => '#ef9a9a',
            'red-300'        => '#e57373',
            'red-400'        => '#ef5350',
            'red-500'        => '#f44336',
            'red-600'        => '#e53935',
            'red-700'        => '#d32f2f',
            'red-800'        => '#c62828',
            'red-900'        => '#b71c1c',
            'red-100-accent' => '#ff8a80',
            'red-200-accent' => '#ff5252',
            'red-400-accent' => '#ff1744',
            'red-700-accent' => '#d50000',

            'pink'            => '#e91e63',
            'pink-50'         => '#fce4ec',
            'pink-100'        => '#f8bbd0',
            'pink-200'        => '#f48fb1',
            'pink-300'        => '#f06292',
            'pink-400'        => '#ec407a',
            'pink-500'        => '#e91e63',
            'pink-600'        => '#d81b60',
            'pink-700'        => '#c2185b',
            'pink-800'        => '#ad1457',
            'pink-900'        => '#880e4f',
            'pink-100-accent' => '#ff80ab',
            'pink-200-accent' => '#ff4081',
            'pink-400-accent' => '#f50057',
            'pink-700-accent' => '#c51162',

            'green'            => '#4caf50',
            'green-50'         => '#e8f5e9',
            'green-100'        => '#c8e6c9',
            'green-200'        => '#a5d6a7',
            'green-300'        => '#81c784',
            'green-400'        => '#66bb6a',
            'green-500'        => '#4caf50',
            'green-600'        => '#43a047',
            'green-700'        => '#388e3c',
            'green-800'        => '#2e7d32',
            'green-900'        => '#1b5e20',
            'green-100-accent' => '#b9f6ca',
            'green-200-accent' => '#69f0ae',
            'green-400-accent' => '#00e676',
            'green-700-accent' => '#00c853',

            'blue'            => '#2196f3',
            'blue-50'         => '#e3f2fd',
            'blue-100'        => '#bbdefb',
            'blue-200'        => '#90caf9',
            'blue-300'        => '#64b5f6',
            'blue-400'        => '#42a5f5',
            'blue-500'        => '#2196f3',
            'blue-600'        => '#1e88e5',
            'blue-700'        => '#1976d2',
            'blue-800'        => '#1565c0',
            'blue-900'        => '#0d47a1',
            'blue-100-accent' => '#82b1ff',
            'blue-200-accent' => '#448aff',
            'blue-400-accent' => '#2979ff',
            'blue-700-accent' => '#2962ff',

        ];

        if (isset($tailwind_colours[$class])) {
            return $tailwind_colours[$class];
        }

        return $class;
    }
}
