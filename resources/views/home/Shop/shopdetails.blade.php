<!DOCTYPE html>
<html lang="zxx">

<head>
    @include('home.css')
</head>

<body>
   @include('home.offcanvas')
   @include('home.header')

    <!-- Shop Details Section Begin -->
    <section class="shop-details">
        <div class="product__details__pic">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="product__details__breadcrumb">
                            <a href="{{ route('index') }}">Home</a>
                            <a href="{{ route('home.shop') }}">Shop</a>
                            <span>{{ $product->title }}</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- Product Image Display -->
                    <div class="col-lg-12 text-center">
                        <div class="product__details__pic__item">
                            <img src="{{ asset('storage/' . ($product->image ?? 'img/default-product.jpg')) }}" 
                                 alt="{{ $product->title }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Details Content -->
        <div class="product__details__content">
            <div class="container">
                <div class="row d-flex justify-content-center">
                    <div class="col-lg-8">
                        <div class="product__details__text">
                            <h4>{{ $product->title }}</h4>

                           <!-- Generate a random rating between 3 and 5 -->
            @php
              $randomRating = rand(3, 5); // Random value between 3 and 5
            @endphp

<!-- Rating -->
                <div class="rating">
                   @for ($i = 1; $i <= 5; $i++)
                       <i class="fa {{ $i <= $randomRating ? 'fa-star' : 'fa-star-o' }}"></i>
                   @endfor
               <span> - {{ rand(5, 100) }} Reviews</span> <!-- Random review count -->
               </div>


                            <h3>${{ number_format($product->price, 2) }} 
                                @if($product->discount_price)
                                    <span>${{ number_format($product->discount_price, 2) }}</span>
                                @endif
                            </h3>

                            <p>{{ $product->description }}</p>

                            <!-- Quantity & Add to Cart -->
                            <div class="product__details__cart__option">
                            <form action="{{ route('cart.add') }}" method="POST">
                                    @csrf
                                   <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="number" name="quantity" value="1" min="1" max="{{ $product->quantity }}">
                                    <button type="submit" class="primary-btn">Add to Cart</button>
                            </form>
                                  </div>

                            <!-- Wishlist & Compare -->
                            <div class="product__details__btns__option">
                                <a href="#"><i class="fa fa-heart"></i> Add to Wishlist</a>
                                <a href="#"><i class="fa fa-exchange"></i> Add To Compare</a>
                            </div>

                            <!-- Additional Details -->
                            <div class="product__details__last__option">
                                <h5><span>Guaranteed Safe Checkout</span></h5>
                                <img src="{{ asset('img/shop-details/details-payment.png') }}" alt="Payment Methods">
                                <ul>
                                   
                                    <li><span>Categories:</span> {{ $product->category->name ?? 'Uncategorized' }}</li>
                                   <li><b>Best Seller:</b> <span>{{ $product->is_best_seller ? 'Yes' : 'No' }}</span></li>
                                    <li><b>New Arrival:</b> <span>{{ $product->is_new_arrival ? 'Yes' : 'No' }}</span></li>
                                    <li><b>Hot Sale:</b> <span>{{ $product->is_hot_sale ? 'Yes' : 'No' }}</span></li>
                                    <li><b>Availability:</b> <span>{{ $product->quantity > 0 ? 'In Stock' : 'Out of Stock' }}</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
    <div class="col-lg-12">
        <div class="product__details__tab">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#tabs-5" role="tab">Description</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#tabs-7" role="tab">Additional Information</a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tabs-5" role="tabpanel">
                    <div class="product__details__tab__content">
                        <p class="note">Experience next-level confidence with BossUp – crafted for individuals who demand both style and functionality in their everyday essentials.</p>
                        <div class="product__details__tab__content__item">
                            <h5>Product Information</h5>
                            <p>BossUp is designed for go-getters who refuse to compromise on quality. Whether you're heading to a business meeting or a casual outing, this product blends sophistication with durability. Featuring a sleek and modern design, BossUp ensures you stay ahead in style while enjoying optimal comfort.</p>
                            <p>Made with precision engineering and high-grade materials, this product offers unparalleled performance. Its ergonomic design enhances usability, making it a must-have for professionals and trendsetters alike. Say goodbye to ordinary and embrace excellence with BossUp.</p>
                        </div>
                        <div class="product__details__tab__content__item">
                            <h5>Material Used</h5>
                            <p>BossUp is crafted from a premium blend of high-quality synthetic fabrics and natural fibers, ensuring a perfect balance between durability and breathability. Unlike standard materials, the innovative fabric technology minimizes creases, making it ideal for daily use.</p>
                            <p>The outer layer boasts a matte finish, giving it a sophisticated, professional look, while the inner lining is made with a soft, moisture-wicking material that enhances comfort. Whether it's summer or winter, BossUp adapts to every climate, providing a lightweight yet sturdy feel.</p>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="tabs-7" role="tabpanel">
                    <div class="product__details__tab__content">
                        <p class="note">BossUp isn't just a product – it's a statement of confidence and refinement, tailored for those who aim higher.</p>
                        <div class="product__details__tab__content__item">
                            <h5>Additional Information</h5>
                            <p>Designed with both aesthetics and functionality in mind, BossUp features cutting-edge craftsmanship that sets it apart. Its sleek contours and lightweight construction make it an effortless choice for any occasion. Whether you're in a formal setting or exploring the city, this product adapts seamlessly to your lifestyle.</p>
                            <p>With advanced resistance to wear and tear, BossUp maintains its pristine look even after prolonged use. The superior stitching and reinforced edges add to its longevity, making it a long-term investment for those who value quality.</p>
                        </div>
                        <div class="product__details__tab__content__item">
                            <h5>Care Instructions</h5>
                            <p>To ensure longevity, avoid exposure to excessive moisture and direct heat. Clean with a soft, damp cloth and store in a cool, dry place when not in use. Regular maintenance will keep BossUp looking brand new for years to come.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</section>
 <!-- Related Section Begin -->
 <section class="related spad">
      <!-- Related Products Section Begin -->
@if($relatedProducts->count())
    <section class="related spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="related-title">Related Products</h3>
                </div>
            </div>
            <div class="row">
                @foreach($relatedProducts as $related)
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="product__item">
                            <div class="product__item__pic set-bg"> <img src="{{ asset('storage/' . $related->image) }}" alt="{{ $related->title }}" class="product-image">

                                @if($related->is_new)
                                    <span class="label">New</span>
                                @endif
                                <ul class="product__hover">
                                    <li><a href="#"><img src="{{ asset('img/icon/heart.png') }}" alt=""></a></li>
                                    <li><a href="#"><img src="{{ asset('img/icon/compare.png') }}" alt=""> <span>Compare</span></a></li>
                                    <li><a href="#"><img src="{{ asset('img/icon/search.png') }}" alt=""></a></li>
                                </ul>
                            </div>
                            <div class="product__item__text">
                                <h6>{{ $related->title }}</h6>
                                <a href="{{route('home.shopdetail', ['id' => $product->id])}}" class="add-cart">View Details</a>
                                
                                <h5>${{ number_format($related->price, 2) }}</h5>
                                <div class="product__color__select">
                                    <label for="pc-{{ $related->id }}-1">
                                        <input type="radio" id="pc-{{ $related->id }}-1">
                                    </label>
                                    <label class="active black" for="pc-{{ $related->id }}-2">
                                        <input type="radio" id="pc-{{ $related->id }}-2">
                                    </label>
                                    <label class="grey" for="pc-{{ $related->id }}-3">
                                        <input type="radio" id="pc-{{ $related->id }}-3">
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif
<!-- Related Products Section End -->

    </section>
    <!-- Related Section End -->

@include('home.footer')
@include('home.javascript')

</body>
</html>