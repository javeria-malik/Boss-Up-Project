<!-- Product Section Begin -->
<section class="product spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <ul class="filter__controls">
                    <li class="active" data-filter=".best-seller">Best Sellers</li>
                    <li data-filter=".new-arrivals">New Arrivals</li>
                    <li data-filter=".hot-sales">Hot Sales</li>
                </ul>
            </div>
        </div>
        <div class="row product__filter">
            @if (!isset($products) || $products->isEmpty())
                <p>No products available.</p>
            @else
                @foreach ($products as $product)
                @php
    if ($product->is_best_seller == 1) {
        $categoryClass = 'best-seller';
    } elseif ($product->is_new_arrival == 1) {
        $categoryClass = 'new-arrivals';
    } elseif ($product->is_hot_sale == 1) {
        $categoryClass = 'hot-sales';
    } else {
        $categoryClass = ''; // Default case (if none of the conditions match)
    }
@endphp

                    <div class="col-lg-3 col-md-6 col-sm-6 mix {{ $categoryClass }}">
                        <div class="product__item">
                            <div class="product__item__pic">
                                <ul class="product__hover">
                                    <li><a href="#"><img src="{{ asset('img/icon/heart.png') }}" alt=""></a></li>
                                    <li><a href="#"><img src="{{ asset('img/icon/compare.png') }}" alt=""> <span>Compare</span></a></li>
                                    <li><a href="#"><img src="{{ asset('img/icon/search.png') }}" alt=""></a></li>
                                </ul>
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->title }}" class="product-image">
                            </div>

                            <div class="product__item__text">
                                <h6>{{ $product->title }}</h6>
                                <a href="#" class="add-cart">+ Add To Cart</a>
                               
                                <h5>${{ $product->price ?? 'N/A' }}</h5>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</section>
<!-- Product Section End -->
