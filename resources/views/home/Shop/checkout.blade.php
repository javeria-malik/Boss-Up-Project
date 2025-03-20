<!DOCTYPE html>
<html lang="zxx">

<head>
   @include('home.css')
</head>

<body>
   @include('home.offcanvas')
   @include('home.header')

   <!-- Success Message -->
   @if(session('success'))
       <div class="alert alert-success text-center">
           {{ session('success') }}
       </div>
   @endif

  <!-- Breadcrumb Section Begin -->
<section class="breadcrumb-option">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 d-flex justify-content-between align-items-center">
                <div class="breadcrumb__text">
                    <h4>Check Out</h4>
                    <div class="breadcrumb__links">
                        <a href="{{ route('index') }}">Home</a>
                        <a href="{{ route('home.shop') }}">Shop</a>
                        <span>Check Out</span>
                    </div>
                </div>
                <!-- Logout Button Positioned on Left Side -->
                <a href="{{ route('logout') }}" class="btn btn-black">Logout</a>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

   <!-- Checkout Section Begin -->
   <section class="checkout spad">
       <div class="container">
           <div class="checkout__form">
               <form action="{{ route('checkout.placeOrder') }}" method="POST">
                   @csrf
                   <div class="row">
                       <div class="col-lg-8 col-md-6">
                           <h6 class="coupon__code"><span class="icon_tag_alt"></span> Have a coupon? <a href="#">Click here</a> to enter your code</h6>
                           <h6 class="checkout__title">Billing Details</h6>
                           <div class="row">
                               <div class="col-lg-6">
                                   <div class="checkout__input">
                                       <p>First Name<span>*</span></p>
                                       <input type="text" name="first_name" required>
                                   </div>
                               </div>
                               <div class="col-lg-6">
                                   <div class="checkout__input">
                                       <p>Last Name<span>*</span></p>
                                       <input type="text" name="last_name" required>
                                   </div>
                               </div>
                           </div>
                           <div class="checkout__input">
                               <p>Country<span>*</span></p>
                               <input type="text" name="country" required>
                           </div>
                           <div class="checkout__input">
                               <p>Address<span>*</span></p>
                               <input type="text" name="address" placeholder="Street Address" class="checkout__input__add" required>
                               <input type="text" name="address2" placeholder="Apartment, suite, unit, etc. (optional)">
                           </div>
                           <div class="checkout__input">
                               <p>City<span>*</span></p>
                               <input type="text" name="city" required>
                           </div>
                           <div class="checkout__input">
                               <p>State<span>*</span></p>
                               <input type="text" name="state" required>
                           </div>
                           <div class="checkout__input">
                               <p>Postcode / ZIP<span>*</span></p>
                               <input type="text" name="zip" required>
                           </div>
                           <div class="row">
                               <div class="col-lg-6">
                                   <div class="checkout__input">
                                       <p>Phone<span>*</span></p>
                                       <input type="text" name="phone" required>
                                   </div>
                               </div>
                               <div class="col-lg-6">
                                   <div class="checkout__input">
                                       <p>Email<span>*</span></p>
                                       <input type="email" name="email" required>
                                   </div>
                               </div>
                           </div>
                           <div class="checkout__input__checkbox">
                               <label for="create_account">
                                   Create an account?
                                   <input type="checkbox" id="create_account" name="create_account">
                                   <span class="checkmark"></span>
                               </label>
                           </div>
                           <div class="checkout__input">
                               <p>Order Notes</p>
                               <input type="text" name="order_notes" placeholder="Notes about your order (optional)">
                           </div>
                       </div>
                       <div class="col-lg-4 col-md-6">
                           <div class="checkout__order">
                               <h4 class="order__title">Your Order</h4>
                               <div class="checkout__order__products">Product <span>Total</span></div>
                               
                               @php 
                                   $cart = session('cart', []);
                                   $subtotal = session('cart_total', 0);
                               @endphp
                               
                               @if (!empty($cart))
                                   <ul class="checkout__total__products">
                                       @foreach($cart as $item)
                                           @php 
                                               $price = $item['price'] ?? 0;
                                               $quantity = $item['quantity'] ?? 1;
                                               $totalPrice = $price * $quantity;
                                               $subtotal += $totalPrice;
                                           @endphp
                                           <li>{{ $item['name'] ?? 'Unknown' }} (x{{ $quantity }}) 
                                               <span>${{ number_format($totalPrice, 2) }}</span>
                                           </li>
                                       @endforeach
                                   </ul>
                                   <ul class="checkout__total__all">
                                       <li>Subtotal <span id="subtotal">${{ number_format($subtotal, 2) }}</span></li>
                                       <li>Total <span>${{ number_format(session('cart_total', 0), 2) }}</span></li>

                                   </ul>
                               @else
                                   <p>Your cart is empty.</p>
                               @endif

                               <div class="checkout__input__checkbox">
                                   <label for="payment">
                                       Check Payment
                                       <input type="radio" id="payment" name="payment_method" value="check" required>
                                       <span class="checkmark"></span>
                                   </label>
                               </div>
                               <div class="checkout__input__checkbox">
                                   <label for="paypal">
                                       Paypal
                                       <input type="radio" id="paypal" name="payment_method" value="paypal" required>
                                       <span class="checkmark"></span>
                                   </label>
                               </div>
                               <button type="submit" class="site-btn">PLACE ORDER</button>
                           </div>
                       </div>
                   </div>
               </form>
           </div>
       </div>
   </section>
   <!-- Checkout Section End -->

   @include('home.footer')
   @include('home.search')
   @include('home.javascript')

   <!-- JavaScript to Update Total Dynamically -->
   <script>
       function updateTotal() {
           let subtotal = 0;
           document.querySelectorAll('.checkout__total__products li').forEach(item => {
               let priceText = item.querySelector('span').innerText.replace('$', '');
               let price = parseFloat(priceText);
               subtotal += price;
           });

           document.getElementById('subtotal').innerText = '$' + subtotal.toFixed(2);
           document.getElementById('total').innerText = '$' + subtotal.toFixed(2);
       }

       document.addEventListener('DOMContentLoaded', updateTotal);
   </script>

</body>
</html>

