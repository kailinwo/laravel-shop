<nav class="navbar navbar-expand-lg navbar-light bg-light navbar-static-top">
    <div class="container">
        {{--brand image--}}
        <a href="{{ route('home') }}" class="navbar-brand">
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
                {{--Authentication links--}}
                <li class="nav-item"><a href="#" class="nav-link">登录</a></li>
                <li class="nav-item"><a href="#" class="nav-link">注册</a></li>
            </ul>
        </div>
    </div>
</nav>
