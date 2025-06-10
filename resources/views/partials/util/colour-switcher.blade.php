{{-- Theme Switcher Blade Template --}}
@php
    // Get the theme parameter from URL, but don't set a default
    $theme = request()->query('theme');

    // Define color themes based on your JSON files
    $themes = [
        'sivoplava' => [
            '--clr-background' => 'rgba(255, 255, 255, 1)',
            '--clr-accent-light' => 'rgba(55, 134, 195, 1)',
            '--clr-accent-dark' => 'rgba(21, 5, 23, 1)',
            '--clr-accent-lighter' => 'rgba(0, 122, 255, 1)',
            '--clr-text-primary' => 'rgba(51, 51, 51, 1)',
            '--clr-text-accent' => 'rgba(32, 96, 126, 1)',
            '--clr-accent-form' => 'rgba(33, 119, 130, 1)',
            '--clr-accent-form-2' => 'rgba(21, 5, 23, 0.25)',
            '--clr-cta-background' => 'rgba(28, 99, 130, 1)',
            '--clr-header-bar' => 'rgba(34, 45, 56, 0.8)',
            '--clr-hero-gradient-2' => 'rgba(245, 245, 245, 0.8)',
            '--clr-hero-gradient-3' => 'rgba(32, 89, 101, 1)'
        ],
        'sivonarandzasta' => [
            '--clr-background' => 'rgba(255, 255, 255, 1)',
            '--clr-accent-light' => 'rgba(55, 134, 195, 1)',
            '--clr-accent-dark' => 'rgba(21, 5, 23, 1)',
            '--clr-accent-lighter' => 'rgba(255, 102, 0, 1)',
            '--clr-text-primary' => 'rgba(51, 51, 51, 1)',
            '--clr-text-accent' => 'rgba(32, 96, 126, 1)',
            '--clr-accent-form' => 'rgba(33, 119, 130, 1)',
            '--clr-accent-form-2' => 'rgba(21, 5, 23, 0.25)',
            '--clr-cta-background' => 'rgba(28, 99, 130, 1)',
            '--clr-header-bar' => 'rgba(34, 45, 56, 0.8)',
            '--clr-hero-gradient-2' => 'rgba(245, 245, 245, 0.8)',
            '--clr-hero-gradient-3' => 'rgba(32, 89, 101, 1)'
        ],
        'plavonarandzasta' => [
            '--clr-background' => 'rgba(255, 255, 255, 1)',
            '--clr-accent-light' => 'rgba(55, 134, 195, 1)',
            '--clr-accent-dark' => 'rgba(21, 5, 23, 1)',
            '--clr-accent-lighter' => 'rgba(255, 102, 0, 1)',
            '--clr-text-primary' => 'rgba(51, 51, 51, 1)',
            '--clr-text-accent' => 'rgba(32, 96, 126, 1)',
            '--clr-accent-form' => 'rgba(33, 119, 130, 1)',
            '--clr-accent-form-2' => 'rgba(21, 5, 23, 0.25)',
            '--clr-cta-background' => 'rgba(28, 99, 130, 1)',
            '--clr-header-bar' => 'rgba(0, 48, 97, 0.8)',
            '--clr-hero-gradient-2' => 'rgba(245, 245, 245, 0.8)',
            '--clr-hero-gradient-3' => 'rgba(32, 89, 101, 1)'
        ]
    ];

    // Get the current theme colors only if theme parameter exists and is valid
    $currentTheme = ($theme && isset($themes[$theme])) ? $themes[$theme] : null;
@endphp

{{-- Add theme selector CSS variables to document only if a theme is selected --}}
@if($currentTheme)
    <style>
        :root {
        @foreach($currentTheme as $variable => $value)
            {{ $variable }}: {{ $value }};
        @endforeach
    }
    </style>
@endif
