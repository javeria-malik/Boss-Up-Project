<!-- Header Section Begin -->
<header class="header">
    <div class="header__top">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-7">
                    <div class="header__top__left">
                        @if(Auth::check())
                            <p style="font-size: 25px; font-weight: bold;">Welcome, {{ Auth::user()->name }}!</p>
                        @else
                            <p>Free shipping, 30-day return or refund guarantee.</p>
                        @endif
                    </div>
                </div>
                <div class="col-lg-6 col-md-5">
                    <div class="header__top__right">
                        <div class="header__top__links">
                            @if(Auth::check())
                                <div class="dropdown">
                                    <a href="#" class="dropdown-toggle" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                        <img src="{{ asset('admin/img/avatar5.png') }}" class="img-circle elevation-2" width="40" height="40" alt="">
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                        <li><h6 class="dropdown-header">{{ Auth::user()->name }}</h6></li>
                                        <li><a class="dropdown-item" href="#"><i class="fas fa-user-cog mr-2"></i>Profile</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="fas fa-user-cog mr-2"></i>Change Password</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <a class="dropdown-item text-danger" href="{{ route('logout') }}" 
                                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                            </a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                @csrf
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            @else
                                <a href="{{ route('login') }}" class="text-blue-500">Sign in</a>
                                <a href="#">FAQs</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-3">
                <div class="header__logo">
                    <a href="{{ route('index') }}"><img src="img/logo.png" alt=""></a>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <nav class="header__menu mobile-menu">
                    <ul>
                        <li class="active"><a href="{{ route('index') }}">Home</a></li>
                        <li><a href="{{ route('home.about') }}">About</a>
                            <ul class="dropdown">
                                <li><a href="{{ route('home.about') }}">About Us</a></li>
                            </ul>
                        </li>
                        <li>Shop
                            <ul class="dropdown">
                                <li><a href="{{ route('home.shop') }}">Shop Products</a></li>
                                <li><a href="./shop-details.html">Shop Details</a></li>
                                <li><a href="{{ route('cart.index') }}">Shopping Cart</a></li>
                            </ul>
                        </li>
                        <li><a href="{{ route('home.contact') }}">Contacts</a></li>
                    </ul>
                </nav>
            </div>
            @if(Auth::check())
    <div class="col-lg-3 col-md-3">
        <div class="header__nav__option d-flex align-items-center justify-content-end">
            <a href="#" class="search-switch me-2">
                <img src="{{ asset('img/icon/search.png') }}" alt="">
            </a>
            <a href="#" class="me-2">
                <img src="{{ asset('img/icon/heart.png') }}" alt="">
            </a>
            <a href="{{ route('checkout') }}" id="cart-link" class="cart-container d-flex align-items-center me-2">
                <img src="{{ asset('img/icon/cart.png') }}" alt="">
                <span id="cart-count" class="cart-count">0</span>
            </a>
            <div class="price">$<span id="cart-total">0.00</span></div>
        </div>
    </div>
@endif


        <div class="canvas__open"><i class="fa fa-bars"></i></div>
    </div>
</header>
<!-- Header Section End -->

<!-- Bootstrap & jQuery -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Ensure Dropdown Works -->
<script>
    $(document).ready(function(){
        $('.dropdown-toggle').dropdown();
    });
</script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    fetchCartTotal();

    function fetchCartTotal() {
        fetch("{{ route('cart.total') }}") // Adjust the route if necessary
            .then(response => response.json())
            .then(data => {
                document.getElementById("cart-total").textContent = data.total;
                document.getElementById("cart-count").textContent = data.items;
            })
            .catch(error => console.error("Error fetching cart total:", error));
    }
});
</script>


