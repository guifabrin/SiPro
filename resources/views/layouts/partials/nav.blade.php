<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#siproNavbarSidebar"
            aria-controls="siproNavbarSidebar" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="{{ url('/') }}">
        <img src="{{ asset('images/logo.png') }}" class="sipro-navbar-logo-img" alt="{{__('app.logo_sipro')}}"/>
        <div class="sipro-navbar-title">Si<b class="base-color">PRO</b></div>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#siproNavbarSupportedContent"
            aria-controls="siproNavbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="siproNavbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            @php(App\Helpers\Boostrap\NavItem::build('home', url('/'), 'fa fa-home'))
            @php(App\Helpers\Boostrap\NavItem::build('policy', url('policy'), 'fas fa-user-secret'))
        </ul>
        <ul class="nav navbar-nav ml-auto">
            @if (Auth::guest())
                @php(App\Helpers\Boostrap\NavItem::build('login', url('login'), 'fa fa-sign-in'))
                @php(App\Helpers\Boostrap\NavItem::build('register', url('register'), 'fas fa-user-plus'))
            @else
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="siproMainNavbarDropdown" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img class="sipro-navbar-avatar-img rounded" src="{{ Auth::user()->avatar() }}"
                             alt="{{Auth::user()->name}}" onerror="$(this).hide();">
                        {{ Auth::user()->name }}
                    </a>
                    <div class="dropdown-menu" aria-labelledby="siproMainNavbarDropdown">
                        @php(App\Helpers\Boostrap\NavItemDropdownItem::build('logout', 'logout'))
                    </div>
                </li>
            @endif
        </ul>
    </div>
</nav>