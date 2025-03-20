<!DOCTYPE html>
<html lang="zxx">

<head>
    @include('home.css')
</head>

<body>
    @include('home.offcanvas')
    @include('home.header')

    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__text">
                        <h4>Shop</h4>
                        <div class="breadcrumb__links">
                            <a href="{{route('index')}}">Home</a>
                            <span>Shop</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Shop Section Begin -->
    <section class="shop spad">
        <div class="container">
            <div class="row">
                <!-- Sidebar Section -->
                <div class="col-lg-3">
                    <div class="shop__sidebar">
                        <div class="shop__sidebar__search">
                            <form action="#">
                                <input type="text" placeholder="Search...">
                                <button type="submit"><span class="icon_search"></span></button>
                            </form>
                        </div>
                        <div class="shop__sidebar__accordion">
                            <div class="accordion" id="accordionExample">
                                <!-- Categories Filter Section -->
                                <div class="card">
                                    <div class="card-heading">
                                        <a data-toggle="collapse" data-target="#collapseCategories">Collection</a>
                                    </div>
                                    <div id="collapseCategories" class="collapse show" data-parent="#accordionExample">
                                        <div class="card-body">
                                            <div class="shop__sidebar__categories">
                                                <ul class="nice-scroll">
                                                    <li><a href="{{ route('home.shop') }}">Show All</a></li>
                                                    @foreach($categories as $category)
                                                        <li><a href="{{ route('home.shop', ['category' => $category->id]) }}">{{ $category->name }}</a></li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Price Filter Section -->
                                <div class="card">
                                    <div class="card-heading">
                                        <a data-toggle="collapse" data-target="#collapsePrice">Filter Price</a>
                                    </div>
                                    <div id="collapsePrice" class="collapse show" data-parent="#accordionExample">
                                        <div class="card-body">
                                            <div class="shop__sidebar__price">
                                                <ul>
                                                    <li><a href="{{ route('home.shop') }}">Show All</a></li>
                                                    @foreach($priceRanges as $range)
                                                        <li>
                                                            <a href="{{ route('home.shop', ['min_price' => $range['min'], 'max_price' => $range['max']]) }}">
                                                                ${{ number_format($range['min'], 2) }} - ${{ number_format($range['max'], 2) }}
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- End of Accordion -->
                            <div class="card">
                                    <div class="card-heading">
                                        <a data-toggle="collapse" data-target="#collapseSix">Tags</a>
                                    </div>
                                    <div id="collapseSix" class="collapse show" data-parent="#accordionExample">
                                        <div class="card-body">
                                            <div class="shop__sidebar__tags">
                                                <a href="#">Best-Seller</a>
                                                <a href="#">New Arrival</a>
                                                <a href="#">Hot Sales</a>
                                              
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div> <!-- End of Sidebar -->
                    </div> 
                </div> <!-- End of Sidebar Column -->

                <!-- Shop Products Section -->
                <div class="col-lg-9">
                    <div class="shop__product__option">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="shop__product__option__left">
                                    @php
                                        $totalProducts = $products->total();
                                        $perPage = $products->perPage();
                                        $currentPage = $products->currentPage();
                                        $start = (($currentPage - 1) * $perPage) + 1;
                                        $end = min($totalProducts, $currentPage * $perPage);
                                    @endphp
                                    <p>Showing {{ $start }}–{{ $end }} of {{ $totalProducts }} results</p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="shop__product__option__right">
                                    <p>Sort by Price:</p>
                                    <form method="GET" action="{{route('home.shop')}}" id="sortForm">
                                        <select name="sort" id="sortSelect" onchange="document.getElementById('sortForm').submit();">
                                            <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Low to High</option>
                                            <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>High to Low</option>
                                        </select>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="container mt-5">
                        @if(isset($products) && $products->count() > 0)
                            <div class="row">
                                @foreach ($products as $product)
                                    <div class="col-lg-4 col-md-6 col-sm-6">
                                        <div class="product__item">
                                            <div class="product__item__pic">
                                                <ul class="product__hover">
                                                    <li><a href="#"><img src="{{ asset('img/icon/heart.png') }}" alt=""></a></li>
                                                    <li><a href="#"><img src="{{ asset('img/icon/compare.png') }}" alt=""> <span>Compare</span></a></li>
                                                    <li><a href="{{route('home.shopdetail', ['id' => $product->id])}}"><img src="{{ asset('img/icon/search.png') }}" alt=""><span>Show Details</span></a></li>
                                                </ul>
                                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->title }}" class="product-image">
                                            </div>
                                            <div class="product__item__text">
                                                <h6>{{ $product->title }}</h6>
                                                <a href="{{route('home.shopdetail', ['id' => $product->id])}}" class="add-cart">+ Add To Cart</a>
                                                <h5>${{ number_format($product->price, 2) }}</h5>
                                            </div>
                                        </div>
                                    </div> 
                                @endforeach
                            </div>
                        @else
                            <p class="text-center">No products available at the moment.</p>
                        @endif
                    </div>                
                </div> <!-- End of Products Column -->
            </div> <!-- End of Row -->
        </div> <!-- End of Container --> 
    </section>
    <!-- Shop Section End -->

    @include('home.footer')
    @include('home.javascript')
</body>
</html>
