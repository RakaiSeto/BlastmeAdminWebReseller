<div class="sidebar__menu-group">
    <ul class="sidebar_nav">
        <li class="">
            <a href="/dashboard" class="{{ Request::is(app()->getLocale().'/applications/user/*') ? 'active':'' }}">
                <span class="nav-icon bi bi-speedometer"></span>
                <span class="menu-text">Dashboard</span>
            </a>
        </li>
        <li class="">
            <a href="/nodes" class="{{ Request::is(app()->getLocale().'/applications/user/*') ? 'active':'' }}">
                <span class="nav-icon bi bi-hdd-rack"></span>
                <span class="menu-text">Nodes</span>
            </a>
        </li>

        @if(Request::is(app()->getLocale().'/dashboards/demo-five'))
            <div class="card sidebar__feature shadow-none bg-transparent border-0 py-sm-50 px-sm-35 text-center">
                <div class="px-15 mb-sm-35 mb-20">
                    <img src="{{ asset('assets/img/sidebar-feature.png') }}" alt="book">
                </div>
                <h3>Get More Feature by Upgrading</h3>
                <button type="button" class="btn btn-primary inline-flex mt-sm-35 mt-20">
                    Go Premium
                </button>
            </div>
        @endif
    </ul>
</div>
