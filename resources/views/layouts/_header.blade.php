<nav class="navbar navbar-expand-lg navbar-light bg-light navbar-static-top">
    <div class="container">
        {{--brand image--}}
        <a href="{{ route('root') }}" class="navbar-brand">
            Kara Shop
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggle-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportContent">
            {{--left side bar--}}
            <ul class="navbar-nav mr-auto">

            </ul>

            {{--right side bar --}}
            <ul class="navbar-nav navbar-right">
                {{--登录注册链接开始--}}
                @guest
                    <li class="nav-item"><a href="{{ route('login') }}" class="nav-link">登录</a></li>
                    <li class="nav-item"><a href="{{ route('register') }}" class="nav-link">注册</a></li>
                @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="navbarDropdown" role="button" href="#"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanld="false">
                            <img
                                src="https://cdn.learnku.com/uploads/images/201709/20/1/PtDKbASVcz.png?imageView2/1/w/60/h/60"
                                class="img-responsive img-circle" width="30px" height="30px">
                            {{Auth::user()->name}}
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('user_address.index') }}">收货地址</a>
                            <a class="dropdown-item" href="{{ route('products.favorites') }}">我的收藏</a>
                            <a class="dropdown-item" id="logout" href="#"
                               onclick="event.preventDefault();document.getElementById('logout-form').submit();">退出登录</a>
                            <form action="{{route('logout')}}" method="post" id="logout-form" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </div>

                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
