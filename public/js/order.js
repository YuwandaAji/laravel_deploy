// 1. Inisialisasi State
let cart = {};
window.currentTotal = 0;

// 2. Fungsi Format Rupiah
function formatRupiah(num) {
    return 'Rp ' + parseInt(num).toLocaleString('id-ID');
}

// 3. Tambah ke Keranjang (Dipanggil dari tombol di Blade)
window.addToCart = function(id, name, price) {
    if (cart[id]) {
        cart[id].quantity++;
    } else {
        cart[id] = {
            name: name,
            price: price,
            quantity: 1
        };
    }
    renderCart();
};

// 4. Update Quantity (Tambah/Kurang)
window.updateCart = function(id, qty) {
    qty = parseInt(qty);
    if (qty > 0) {
        cart[id].quantity = qty;
    } else {
        delete cart[id];
    }
    renderCart();
};

// 5. Hapus Item
window.removeFromCart = function(id) {
    delete cart[id];
    renderCart();
};

// 6. Render Tampilan Keranjang
function renderCart() {
    const cartDiv = document.getElementById('cart');
    if(!cartDiv) return;

    cartDiv.innerHTML = '';
    let subtotal = 0, count = 0;

    Object.entries(cart).forEach(([id, item]) => {
        subtotal += item.price * item.quantity;
        count += item.quantity;
        
        const div = document.createElement('div');
        div.className = 'cart-item';
        div.innerHTML = `
            <div class="cart-item-header">
                <div style="flex:1;">
                    <div class="cart-item-name">${item.name}</div>
                    <div class="cart-item-price">${formatRupiah(item.price)} × ${item.quantity}</div>
                </div>
            </div>
            <div class="cart-controls">
                <button onclick="updateCart(${id}, ${cart[id].quantity - 1})">−</button>
                <input type="number" value="${item.quantity}" class="quantity-input" readonly>
                <button onclick="updateCart(${id}, ${cart[id].quantity + 1})">+</button>
            </div>
            <button class="remove-btn" onclick="removeFromCart(${id})">REMOVE</button>
        `;
        cartDiv.appendChild(div);
    });

    document.getElementById('subtotal').textContent = formatRupiah(subtotal);
    document.getElementById('total').textContent = 'TOTAL: ' + formatRupiah(subtotal);
    
    const badge = document.getElementById('cartBadge');
    if(badge) badge.textContent = count > 0 ? count : '';

    // Simpan subtotal ke global variable untuk modal
    window.currentTotal = subtotal;
}

// 7. Logika Modal Pembayaran
// Muncul saat klik tombol "PLACE ORDER"
window.processCheckout = async function() {
    if (Object.keys(cart).length === 0) {
        alert('Keranjang masih kosong!');
        return;
    }

    // Ambil nilai dari input hidden/dropdown yang baru
    const orderMethod = document.getElementById('order_method').value;
    const payMethod = document.getElementById('pay_method').value;

    // Validasi sederhana jika user belum memilih
    if (!orderMethod || !payMethod) {
        alert('Silakan pilih metode pesan dan metode pembayaran terlebih dahulu!');
        return;
    }

    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    const orderData = {
        order_type: orderMethod,    // Mengirim 0 (Online) atau 1 (Cafe)
        payment_type: payMethod,    // Mengirim Cash, Ovo, dll
        total_price: window.currentTotal,
        items: Object.entries(cart).map(([id, item]) => ({
            id: id,
            price: item.price,
            qty: item.quantity
        }))
    };

    try {
        const response = await fetch('/order_post', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify(orderData)
        });

        const result = await response.json();

        if (response.ok) {
            alert('Pesanan Berhasil Dibuat!');
            cart = {};
            renderCart();
            window.location.reload(); // Reload untuk reset tampilan
        } else {
            alert('Gagal: ' + (result.message || 'Terjadi kesalahan'));
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Terjadi kesalahan koneksi ke server.');
    }
};


function closeAllSelectOptions() {
  document.querySelectorAll('.select-options').forEach(opt => {
    opt.style.display = 'none';
  });
}

document.addEventListener('click', function (e) {

  if (
    e.target.classList.contains('input-order-method') ||
    e.target.classList.contains('input-pay-method') ||
    e.target.classList.contains('input-shift')
  ) {
    closeAllSelectOptions();

    const box = e.target.closest('.select-box');
    box.querySelector('.select-options').style.display = 'block';
    return;
  }

  // PILIH OPTION
  if (e.target.closest('.select-options li')) {
    const li = e.target;
    const box = li.closest('.select-box');

    const input = box.querySelector('input[type="text"]');
    const hidden = box.querySelector('input[type="hidden"]');

    input.value = li.textContent.trim();
    hidden.value = li.dataset.value;

    closeAllSelectOptions();
    return;
  }

  // KLIK DI LUAR
  closeAllSelectOptions();
});


document.addEventListener('input', function (e) {
  if (
    e.target.classList.contains('input-order-method') ||
    e.target.classList.contains('input-pay-method') ||
    e.target.classList.contains('input-shift')
  ) {
    const search = e.target.value.toLowerCase();
    const box = e.target.closest('.select-box');

    box.querySelectorAll('.select-options li').forEach(li => {
      li.style.display = li.textContent.toLowerCase().includes(search)
        ? 'block'
        : 'none';
    });
  }
});