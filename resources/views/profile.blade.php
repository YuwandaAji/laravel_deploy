<style>
    /* ... CSS lama kamu tetap ada ... */
    .account-container {
        max-width: 900px;
        margin: 50px auto;
        padding: 40px;
        background-color: #fff;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        font-family: 'Poppins', sans-serif;
        color: #4b3832;
    }

    h1 { font-weight: 700; color: #3c2f2f; margin-bottom: 10px; }
    hr { border: 0; height: 2px; background: #be9b7b; margin-bottom: 40px; width: 50px; margin-left: 0; }

    .profile-card {
        background: #fdfaf5;
        padding: 30px;
        border-radius: 12px;
        border-left: 5px solid #854442;
        display: flex;
        gap: 30px;
        align-items: center;
        margin-bottom: 40px; /* Tambah jarak ke bawah */
    }

    .profile-image img, .no-photo {
        width: 120px; height: 120px; border-radius: 50%;
        object-fit: cover; border: 4px solid #fff; box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    .no-photo { background: #e7d8c9; display: flex; align-items: center; justify-content: center; color: #854442; font-weight: bold; }
    .edit-link { display: inline-block; margin-top: 10px; font-size: 13px; color: #be9b7b; text-decoration: none; font-weight: 600; }
    .info-label { font-size: 12px; text-transform: uppercase; letter-spacing: 1px; color: #be9b7b; margin-bottom: 2px; font-weight: bold; }
    .info-value { font-size: 18px; margin-bottom: 15px; font-weight: 500; }

    .logout-btn {
        background: #3c2f2f; color: #fff; padding: 10px 25px; border: none;
        border-radius: 8px; font-weight: 600; cursor: pointer; transition: 0.3s;
    }
    .logout-btn:hover { background: #854442; }

    /* ===== TAMBAHAN CSS RIWAYAT ORDER ===== */
    .history-title {
        font-size: 20px;
        font-weight: 700;
        color: #3c2f2f;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .order-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 10px;
    }

    .order-table th {
        text-align: left;
        padding: 10px 15px;
        color: #be9b7b;
        font-size: 12px;
        text-transform: uppercase;
    }

    .order-table td {
        padding: 15px;
        background: #fdfaf5;
        color: #4b3832;
    }

    /* Membuat lengkungan di ujung baris tabel */
    .order-table tr td:first-child { border-radius: 10px 0 0 10px; font-weight: bold; }
    .order-table tr td:last-child { border-radius: 0 10px 10px 0; }

    .status-badge {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: bold;
        text-transform: uppercase;
    }

    /* Warna status ala kafe */
    .status-completed { background: #e7d8c9; color: #854442; }
    .status-pending { background: #eee; color: #999; }
</style>

<div class="account-container">
<script src="https://unpkg.com/feather-icons"></script>
<script>
  feather.replace()
</script>
    <h1>Account Details</h1>
    <hr>

    <div class="profile-card">
        <div class="profile-image-wrapper">
            <div class="profile-image">
                @if($customer->customer_img)
                    <img src="{{ asset('storage/'. $customer->customer_img) }}" alt="Profile">
                @else
                    <div class="no-photo"><span>No Photo</span></div>
                @endif
            </div>
            <a href="{{ url('profile/edit') }}" class="edit-link">Edit Profile</a>
        </div>

        <div class="profile-details">
            <div class="info-label">Full Name</div>
            <div class="info-value" style="text-transform: capitalize;">{{ $customer->customer_name }}</div>

            <div class="info-label">Email Address</div>
            <div class="info-value">{{ $customer->customer_email }}</div>

            <div class="info-label">Primary Address</div>
            <div class="info-value">
                {{ $customer->customer_address ?? 'Address not set' }}<br>
                <span style="font-size: 14px; color: #999;">Indonesia</span>
            </div>

            <form action="{{ url('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        </div>
    </div>

    <div class="order-history-section">
        <h3 class="history-title">Order History</h3>
        
        @if($history->isEmpty())
            <div style="text-align: center; padding: 20px; background: #fdfaf5; border-radius: 10px; color: #be9b7b;">
                Belum ada pesanan. Yuk, pesan kopi pertamamu!
            </div>
        @else
            <table class="order-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Date</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($history as $item)
                    <tr>
                        <td>#{{ $item->sales_id }}</td>
                        <td>{{ $item->created_at->format('d M Y') }}</td>
                        <td>Rp {{ number_format($item->total_belanja, 0, ',', '.') }}</td>
                        <td>
                            <span class="status-badge {{ $item->sales_status == 'completed' ? 'status-completed' : 'status-pending' }}">
                                {{ $item->sales_status }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>