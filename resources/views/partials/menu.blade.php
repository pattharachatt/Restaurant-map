<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
                <li class="nav-item">
                    <a href="{{ route("admin.categories.index") }}" class="nav-link {{ request()->is('admin/categories') || request()->is('admin/categories/*') ? 'active' : '' }}">
                        <i class="fa-fw fas fa-tags nav-icon">

                        </i>
                        {{ 'Category' }}
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route("admin.restaurants.index") }}" class="nav-link {{ request()->is('admin/restaurants') || request()->is('admin/restaurants/*') ? 'active' : '' }}">
                        <i class="fa-fw fas fa-shopping-basket nav-icon">

                        </i>
                        {{ 'Restaurants' }}
                    </a>
                </li>
            <li class="nav-item">
                <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                    <i class="nav-icon fas fa-fw fa-sign-out-alt">

                    </i>
                    {{ 'Logout' }}
                </a>
            </li>
        </ul>
    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>