@php
    use App\Models\Category;

    $categories = Category::all();

    // 为了代码清晰和避免在循环中重复调用，可以先获取当前分类ID (如果存在)
    // 假设你的分类路由参数名为 'category' (例如 categories/{category})
    // 如果路由模型绑定生效，request()->route('category') 会是 Category 模型实例
    // 如果没有，它会是 ID
    $currentCategoryParam = request()->route('category');
    $currentCategoryId = null;
    if ($currentCategoryParam) {
        $currentCategoryId = $currentCategoryParam instanceof Category ? $currentCategoryParam->id : $currentCategoryParam;
    }
@endphp
<nav class="navbar navbar-expand-lg navbar-light bg-light navbar-static-top">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', '纯阳宫') }}
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>


        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('topics.index') ? 'active' : '' }}" href="{{ route('topics.index') }}">トピック</a></li>
                @if($categories->count())
                    @foreach($categories as $category)
                        <li class="nav-item">
                            <a class="nav-link {{ (request()->routeIs('categories.show') && $currentCategoryId == $category->id) ? 'active' : '' }}"
                               href="{{ route('categories.show', $category->id) }}">{{ __($category->name) }}</a>
                        </li>
                    @endforeach
                @endif
            </ul>

            <a class="navbar-brand mx-auto d-none d-lg-block" href="{{ url('/') }}">
                {{-- 请将 'images/logo.png' 替换为您的Logo图片路径，并根据需要调整 height --}}
                <img src="{{ asset('images/JX3_Online_logo.png') }}" alt="{{ config('app.name', '纯阳宫') }} Logo" style="height: 35px;">
            </a>


            <ul class="navbar-nav ms-auto">
                @guest
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                    </li>
                @else
                    <li class="nav-item">

                        <a class="nav-link mt-1 me-lg-2 fw-bold" href="{{ route('topics.create') }}">
                            <i class="fa-solid fa-plus"></i>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                           data-bs-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false">
                            <img src="{{ auth()->user()->avatar }}"
                                 class="img-responsive img-circle" width="30px" height="30px" alt="{{ auth()->user()->name }}'s avatar">
                            {{ auth()->user()->name }}
                        </a>
                        {{-- Bootstrap 5 下拉菜单对齐 --}}
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item"
                               href="{{ route('users.show', auth()->user()) }}">
                                <i class="far fa-user me-2"></i>&nbsp;
                                {{ __('Profile') }}
                            </a>
                            <a class="dropdown-item"
                               href="{{ route('users.edit', auth()->user()) }}">
                                <i class="far fa-edit me-2"></i>&nbsp;
                                {{ __('Edit Profile') }}
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" id="logout" href="#">
                                {{-- 对于 onsubmit confirm, 如果需要本地化: confirm('{{ __("Are you sure you want to log out?") }}') --}}
                                <form action="{{ route('logout') }}" method="POST" onsubmit="return confirm('Are you sure you want to log out?');">
                                    @csrf
                                    {{-- btn-block 是 Bootstrap 4 的类, Bootstrap 5 使用 w-100 --}}
                                    <button class="btn btn-danger w-100" type="submit"
                                            name="button">{{ __('Logout') }}</button>
                                </form>
                            </a>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
