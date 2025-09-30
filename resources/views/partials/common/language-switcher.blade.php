@php
    $currentLocale = App::getLocale();
    $locales = [
        'sr' => ['name' => 'SR', 'flag' => 'sr'],
        'en' => ['name' => 'EN', 'flag' => 'en'],
        'ru' => ['name' => 'RU', 'flag' => 'ru']
    ];
@endphp

<div class="language-switcher">
    <!-- Current language (always shown) -->
    <div class="current-lang">
        <img src="{{ asset('img/flags/' . $locales[$currentLocale]['flag'] . '.svg') }}"
             alt="{{ $locales[$currentLocale]['name'] }}"
             class="flag-icon">
        <span class="lang-code">{{ $locales[$currentLocale]['name'] }}</span>
    </div>

    <!-- Other languages -->
    <div class="lang-dropdown">
        @foreach($locales as $code => $locale)
            @if($code !== $currentLocale)
                <a href="{{ App\Helpers\LocalizationHelper::getLocalizedUrl($code) }}"
                   class="lang-link"
                   hreflang="{{ $code }}"
                   title="{{ $locale['name'] }}">
                    <img src="{{ asset('img/flags/' . $locale['flag'] . '.svg') }}"
                         alt="{{ $locale['name'] }}"
                         class="flag-icon">
                    <span class="lang-code">{{ $locale['name'] }}</span>
                </a>
            @endif
        @endforeach
    </div>
</div>
