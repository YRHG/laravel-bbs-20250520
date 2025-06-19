<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- 保留第二个文件原有的本地图标 --}}
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- 从第一个文件引入：从缓存或数据库加载网站设置 --}}
    @php$settings = \App\Models\Setting::getSettingsFromCache();@endphp

    {{-- 保留第二个文件原有的标题逻辑，从 config('app.name') 获取默认值 --}}
    <title>@yield('title', config('app.name'))</title>

    {{-- 从第一个文件引入：SEO meta 标签，并优化了 description 的逻辑 --}}
    {{-- 优先使用页面独立的 description，如果没有，则使用后台设置的全局 description --}}
    <meta name="description" content="@yield('description', $settings['seo_description']->value ?? config('app.name'))"/>
    <meta name="keywords" content="{{ $settings['seo_keywords']->value ?? '' }}"/>

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
