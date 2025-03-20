<!DOCTYPE html>
<html lang="en">
<head>
    @include('home.css')
    <title>Shopping Cart</title>
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
                        <h4>Shopping Cart</h4>
                        <div class="breadcrumb__links">
                            <a href="{{ route('index') }}">Home</a>
                            <a href="{{ route('home.shop') }}">Shop</a>
                            <span>Shopping Cart</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End --> 

    <section class="shopping-cart spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="cart-table">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th>Remove</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cart as $key => $item)
                                <tr>
                                    <td class="d-flex align-items-center">
                                        <img src="{{ asset('storage/' . ($item['image'] ?? 'img/default-product.jpg')) }}" 
                                             alt="{{ $item['name'] ?? 'Unnamed Product' }}" 
                                             class="cart-img me-3" width="50">
                                        <div style="margin-left: 10px;">
                                            <h6 class="mb-0">{{ $item['name'] ?? 'Unnamed Product' }}</h6>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="unit-price">${{ number_format($item['price'] ?? 0, 2) }}</span>
                                    </td>
                                    <td>
                                        <form action="{{ route('cart.update') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $key }}">
                                            <div class="input-group d-flex flex-column align-items-center">
                                                <div class="d-flex">
                                                    <button type="button" class="btn btn-outline-dark btn-sm decrease">-</button>
                                                    <input type="number" name="quantity" 
                                                           value="{{ $item['quantity'] ?? 1 }}" 
                                                           min="1" class="form-control text-center quantity-input" 
                                                           style="max-width: 50px;">
                                                    <button type="button" class="btn btn-outline-dark btn-sm increase">+</button>
                                                </div>
                                                <button type="submit" class="btn btn-dark btn-sm mt-2 w-100">Update</button>
                                            </div>
                                        </form>
                                    </td>
                                    <td class="total-price">
                                        ${{ number_format(($item['price'] ?? 0) * ($item['quantity'] ?? 1), 2) }}
                                    </td>
                                    <td>
                                        <form action="{{ route('cart.remove') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $key }}">
                                            <button type="submit" class="btn btn-dark btn-sm"><i class="fa fa-times"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('home.shop') }}" class="btn btn-secondary">Continue Shopping</a>
                        <a href="{{ route('cart.clear') }}" class="btn btn-dark">Clear Cart</a>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="cart-summary p-3 border rounded">
                        <h5 class="text-center">Cart Total</h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between">
                                Subtotal <span id="cart-subtotal">${{ number_format($subtotal ?? 0, 2) }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                Total <span id="cart-total">${{ number_format($total ?? 0, 2) }}</span>
                            </li>
                        </ul>
                        <a href="{{ route('checkout') }}" class="btn btn-dark w-100 mt-3">Proceed to Checkout</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('home.footer')
    @include('home.search')
    @include('home.javascript')
    <script>
    document.querySelectorAll(".increase, .decrease").forEach(button => {
        button.addEventListener("click", function() {
            let input = this.closest("td").querySelector("input[name='quantity']");
            let row = this.closest("tr");
            let pricePerUnit = parseFloat(row.querySelector(".unit-price").innerText.replace("$", ""));
            let totalCell = row.querySelector(".total-price");
            let productId = row.querySelector("input[name='product_id']").value; // Get product ID

            let quantity = parseInt(input.value) || 1;

            if (this.classList.contains("increase")) {
                quantity++;
            } else if (this.classList.contains("decrease") && quantity > 1) {
                quantity--;
            }

            input.value = quantity;

            let newTotal = (pricePerUnit * quantity).toFixed(2);
            totalCell.innerText = `$${newTotal}`;

            updateCartTotal();

            // Send AJAX request to update the backend
            fetch("{{ route('cart.update') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: quantity
                })
            }).then(response => response.json())
              .then(data => console.log(data));
        });
    });

    function updateCartTotal() {
        let subtotal = 0;
        document.querySelectorAll(".total-price").forEach(item => {
            subtotal += parseFloat(item.innerText.replace("$", ""));
        });

        document.querySelector("#cart-subtotal").innerText = `$${subtotal.toFixed(2)}`;
        document.querySelector("#cart-total").innerText = `$${subtotal.toFixed(2)}`;
    }
</script>

</body>
</html>
