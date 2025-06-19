<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" type="image/x-icon"
          href="{{ asset('images/favicon.png') }}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php$settings = \App\Models\Setting::getSettingsFromCache();@endphp

    <title>@yield('title', $settings['site_name']->value ?? '')</title>

    <meta name="description" content="{{ $settings['seo_description']->value ?? 'JX-Online-3 bbs' }}"/>
    <meta name="description" content="@yield('description', 'JX-Online-3 bbs')"/>

    <meta name="keywords" content="{{ $settings['seo_keywords']->value ?? 'JX-Online-3 bbs' }}"/>

    <!-- Use vite include styles and scripts. -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    @yield('styles')

</head>

<body>
<div id="app" class="{{ route_class() }}-page">

    @include('layouts._header')

    <div class="container">

        @include('shared._messages')

        @yield('content')

    </div>

    @include('layouts._footer')
</div>

@includeWhen((auth()->check() && app()->isLocal()), 'layouts._impersonate')

@yield('scripts')
</body>
</html>
