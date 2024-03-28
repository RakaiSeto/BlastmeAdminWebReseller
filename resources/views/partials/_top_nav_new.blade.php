<nav class="navbar navbar-light">
    <div class="navbar-left">
        <div class="logo-area">
            <a href="#" class="sidebar-toggle">
                <img class="svg" src="{{ asset('assets/img/svg/align-center-alt.svg') }}" alt="img"></a>
        </div>
    </div>
    <div class="navbar-right">
        <ul class="navbar-right__menu">
            <li class="nav-author">
                    <span class="nav-item__title">{{ session('sessionName') }}<a href="/logout"><i class="bi bi-power ps-1"></i></a></span>
            </li>
        </ul>
        <div class="navbar-right__mobileAction d-md-none">
            <a href="#" class="btn-author-action">
                <img src="{{ asset('assets/img/svg/more-vertical.svg') }}" alt="more-vertical" class="svg"></a>
        </div>
    </div>
</nav>
