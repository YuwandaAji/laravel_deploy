<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Order Menu</title>
    <link rel="stylesheet" href="{{ asset('css/order.css') }}" />
</head>
<body>
    <div class="container">
        <header>
            <h1>☕ Nonchalant Coffee</h1>
            <p class="tagline">Where Every Sip Tells a Story</p>
        </header>

        <div class="content">
            <div class="menu-section" id="menu">
                @foreach(['Coffe' => '☕ Coffee Selection', 'Snack' => '🥐 Snacks', 'Signature' => '🌟 Signature Menu'] as $key => $title)
                    <div class="category-group">
                        <h2 class="category-title">{{ $title }}</h2>
                        <div class="menu-grid">
                            @foreach($products->where('product_category', $key) as $p)
                                <div class="menu-item">
                                    <div class="image">
                                        @if($key == 'Coffe') ☕ @elseif($key == 'Snack') 🥐 @else ✨ @endif
                                    </div>
                                    <h3>{{ $p->product_name }}</h3>
                                    <p class="menu-desc">{{ $p->product_description }}</p>
                                    <div class="price">Rp {{ number_format($p->product_price, 0, ',', '.') }}</div>
                                    <button onclick="addToCart({{ $p->product_id }}, '{{ $p->product_name }}', {{ $p->product_price }})">
                                        ADD TO CART
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="cart-section">
                <h2>🛒 CART <span id="cartBadge"></span></h2>
                <div id="cart">
                    </div>
                <div class="total-section">
                    <div class="total-row">
                        <span>Subtotal:</span>
                        <span id="subtotal">Rp 0</span>
                    </div>
                    <div class="total" id="total">TOTAL: Rp 0</div>


                    <div class="order-options" style="margin-top: 15px; text-align: left;">
                        <div style="margin-bottom: 10px;">
                            <label>Metode Pesan:</label>
                            <div class="select-box">
                                <input type="text" class="input-order-method" placeholder="" autocomplete="off">
                                <input type="hidden" name="role" id="order_method">
                                <ul class="select-options">
                                    <li data-value="0">Online</li>
                                    <li data-value="1">Cafe</li>
                                </ul>
                            </div>
                        </div>

                        <div style="margin-bottom: 10px;">
                            <label>Metode Pembayaran:</label>
                            <div class="select-box">
                                <input type="text" class="input-pay-method" placeholder="" autocomplete="off">
                                <input type="hidden" name="role" id="pay_method">
                                <ul class="select-options">
                                    <li data-value="2">Cash</li>
                                    <li data-value="1">Gopay</li>
                                    <li data-value="3">Cod</li>
                                    <li data-value="4">Bank Mandiri</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <button class="checkout-btn" onclick="processCheckout()" style="width: 100%; margin-top: 10px;">
                        Konfirmasi Pesanan
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>
    
    <script src="{{ asset('js/order.js') }}"></script>
</body>
</html>