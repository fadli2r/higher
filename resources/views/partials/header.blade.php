<header class="cs-site_header cs-style1 cs-sticky-header cs-primary_color cs-white_bg">
    <div class="cs-main_header">
        <div class="container">
            <div class="cs-main_header_in">
                <div class="cs-main_header_left">
                    <a class="cs-site_branding cs-accent_color" href="{{ url('/') }}">
                        <img src="{{ asset('assets/img/logo_hitam.webp') }}" alt="Logo">
                    </a>
                </div>
                <div class="cs-main_header_center">
                    <div class="cs-nav">
                        <ul class="cs-nav_list">
                            @if(auth()->check())
                <li><a href="/my-orders" class="cs-smoth_scroll">My Orders</a></li>
                <li><a href="/transactions" class="cs-smoth_scroll">Transactions</a></li>
            @endif
                            <li><a href="{{ route('custom-design.index') }}" class="cs-smoth_scroll">Custom Design</a></li>
                            <li><a href="/products" class="cs-smoth_scroll">Service</a></li>
                            @if(auth()->check() && auth()->user()->membership_status === 'member')
                                <li><a href="{{ route('promos.index') }}" class="cs-smoth_scroll">Promo</a></li>
                            @endif
                            <li><a href="/tickets" class="cs-smoth_scroll">Bantuan</a></li>
                        </ul>
                    </div>
                </div>
                <div class="cs-main_header_right">
                    <div class="cs-toolbox">
                        @if(auth()->check())
                            <a href="/admin/edit-profile">
                                <button type="button" class="btn btn-link" style="text-decoration: none; color: inherit;">
                                    Profile
                                </button>
                            </a>
                            <form action="{{ route('filament.admin.auth.logout') }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-link" style="text-decoration: none; color: inherit;">
                                    Logout
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}">
                                <button type="button" class="btn btn-link" style="text-decoration: none; color: inherit;">
                                    Login
                                </button>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
