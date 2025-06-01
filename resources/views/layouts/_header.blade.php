
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
        <!-- Branding Image 左边 -->
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', '纯阳宫') }}
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-between" id="navbarSupportedContent">

            <!-- 左侧空ul（或者你之前的菜单） -->
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item "><a class="nav-link {{ request()->routeIs('topics.index') ? 'active' : '' }}" href="{{ route('topics.index') }}">トピック</a></li>
                    @if($categories->count())
                        @foreach($categories as $category)
                            <li class="nav-item">
                                <a class="nav-link {{ (request()->routeIs('categories.show') && $currentCategoryId == $category->id) ? 'active' : '' }}"
                                   href="{{ route('categories.show', $category->id) }}">{{ __($category->name) }}</a>
                            </li>
                        @endforeach
                    @endif
                </ul>


                <!-- 中间图标 -->
            <div class="d-flex justify-content-center flex-grow-1">
                <img src="{{ asset('images/JX3_Online_logo.jpg') }}" alt="Logo" style="height:40px;">

            </div>

            <!-- 右侧用户信息 -->
            <ul class="navbar-nav navbar-right">
                <!-- 认证相关链接 -->
                @guest
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                           data-bs-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false">
                            <img src="{{ auth()->user()->avatar }}"
                                 class="img-responsive img-circle" width="30px" height="30px" alt="">
                            {{ auth()->user()->name }}
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item"
                               href="{{ route('users.show', auth()->user()) }}">{{ __('Profile') }}</a>
                            <a class="dropdown-item"
                               href="{{ route('users.edit', auth()->user()) }}">{{ __('Edit Profile') }}</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" id="logout" href="#">
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button class="btn btn-block btn-danger" type="submit"
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
