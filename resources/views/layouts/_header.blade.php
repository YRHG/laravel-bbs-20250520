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

        {{-- 移除了 justify-content-between --}}
        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            {{-- 使用 me-auto (margin-end: auto) 替代 mr-auto for BS5 --}}
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('topics.index') ? 'active' : '' }}" href="{{ route('topics.index') }}">话题</a></li>
                @if($categories->count())
                    @foreach($categories as $category)
                        <li class="nav-item">
                            <a class="nav-link {{ (request()->routeIs('categories.show') && $currentCategoryId == $category->id) ? 'active' : '' }}"
                               href="{{ route('categories.show', $category->id) }}">{{ __($category->name) }}</a>
                        </li>
                    @endforeach
                @endif
            </ul>

            {{-- 使用 mx-auto 使这个div在其兄弟元素me-auto和ms-auto之间居中 --}}
            {{-- 移除了 d-flex justify-content-center flex-grow-1 --}}
            <div class="mx-auto">
                <img src="{{ asset('images/JX3_Online_logo.jpg') }}" alt="Logo" style="height:40px;">
            </div>

            {{-- 使用 ms-auto (margin-start: auto) 替代 navbar-right for BS5 --}}
            <ul class="navbar-nav ms-auto">
                @guest
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">{{ __('登录') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">{{ __('注册') }}</a></li>
                @else
                    <li class="nav-item dropdown">
                        <button class="nav-link dropdown-toggle btn btn-link"
                                id="navbarDropdown"
                                type="button"
                                data-bs-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false">
                            <img src="{{ auth()->user()->avatar }}"
                                 class="img-responsive img-circle" width="30px" height="30px" alt="头像">
                            {{ auth()->user()->name }}
                        </button>
                        {{-- 添加了 dropdown-menu-end 使菜单在右侧时正确对齐 --}}
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item"
                               href="{{ route('users.show', auth()->user()) }}">{{ __('个人资料') }}</a>
                            <a class="dropdown-item"
                               href="{{ route('users.edit', auth()->user()) }}">{{ __('编辑资料') }}</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" id="logout" href="#">
                                <form action="{{ route('logout') }}" method="POST" style="display: block;"> {{-- display: block or inline-block might be better for full width clickable area --}}
                                    @csrf
                                    <button class="btn btn-block btn-danger w-100" type="submit" name="button">{{ __('退出登录') }}</button>
                                </form>
                            </a>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
