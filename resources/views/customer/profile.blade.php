<style>
    /* Google Fonts */
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

    body {
        background-color: #f8f9fa;
    }

    .account-container {
        max-width: 900px;
        margin: 30px auto 50px;
        padding: 40px;
        background-color: #fff;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        font-family: 'Poppins', sans-serif;
        color: #4b3832;
    }

    .back-nav {
        max-width: 900px;
        margin: 20px auto 0;
        display: flex;
        align-items: center;
    }

    .back-link {
        text-decoration: none;
        color: #854442;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: 0.3s;
    }

    .back-link:hover {
        color: #3c2f2f;
        transform: translateX(-5px);
    }

    h1 { font-weight: 700; color: #3c2f2f; margin-bottom: 10px; }
    .title-line { border: 0; height: 3px; background: #be9b7b; margin-bottom: 40px; width: 60px; }

    /* Profile Card */
    .profile-card {
        background: #fdfaf5;
        padding: 30px;
        border-radius: 12px;
        border-left: 6px solid #854442;
        display: flex;
        gap: 40px;
        align-items: flex-start;
        margin-bottom: 50px;
    }

    .profile-image-wrapper {
        text-align: center;
    }

    .profile-image img, .no-photo {
        width: 130px; 
        height: 130px; 
        border-radius: 50%;
        object-fit: cover; 
        border: 4px solid #fff; 
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .no-photo { 
        background: #e7d8c9; 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        color: #854442; 
        font-weight: 600;
        font-size: 14px;
    }

    .edit-link { 
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        margin-top: 15px; 
        font-size: 14px; 
        color: #be9b7b; 
        text-decoration: none; 
        font-weight: 600; 
        transition: 0.3s;
    }
    .edit-link:hover { color: #854442; }

    .info-label { font-size: 11px; text-transform: uppercase; letter-spacing: 1.5px; color: #be9b7b; margin-bottom: 2px; font-weight: 700; }
    .info-value { font-size: 17px; margin-bottom: 20px; font-weight: 500; color: #3c2f2f; }

    .logout-btn {
        background: #3c2f2f; 
        color: #fff; 
        padding: 12px 25px; 
        border: none;
        border-radius: 10px; 
        font-weight: 600; 
        cursor: pointer; 
        transition: 0.3s;
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: 10px;
    }
    .logout-btn:hover { background: #854442; transform: translateY(-2px); }

    /* Order History Table */
    .history-title {
        font-size: 22px;
        font-weight: 700;
        color: #3c2f2f;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .order-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 12px;
    }

    .order-table th {
        text-align: left;
        padding: 0 20px;
        color: #be9b7b;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .order-table td {
        padding: 20px;
        background: #fdfaf5;
        color: #4b3832;
        transition: 0.3s;
    }

    .order-table tr:hover td {
        background: #f5eee6;
    }

    .order-table tr td:first-child { border-radius: 12px 0 0 12px; font-weight: 700; color: #854442; }
    .order-table tr td:last-child { border-radius: 0 12px 12px 0; }

    .status-badge {
        padding: 6px 14px;
        border-radius: 30px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
    }

    .status-completed { background: #d4edda; color: #155724; }
    .status-new { background: #e7d8c9; color: #854442; }
    .status-pending { background: #fff3cd; color: #856404; }

    @media (max-width: 768px) {
        .profile-card { flex-direction: column; text-align: center; border-left: none; border-top: 6px solid #854442; }
        .info-label { margin-top: 10px; }
        .back-nav { padding-left: 20px; }
    }
</style>

<nav class="back-nav">
    <a href="{{ route('home') }}" class="back-link">
        <i data-feather="arrow-left"></i> Back to Home
    </a>
</nav>

<div class="account-container">
    <h1>Account Details</h1>
    <div class="title-line"></div>

    <div class="profile-card">
        <div class="profile-image-wrapper">
            <div class="profile-image">
                @if($customer->customer_img && file_exists(public_path('storage/'.$customer->customer_img)))
                    <img src="{{ asset('storage/'. $customer->customer_img) }}" alt="Profile">
                @else
                    <div class="no-photo">
                        <i data-feather="user" style="width: 40px; height: 40px;"></i>
                    </div>
                @endif
            </div>
            <a href="{{ url('profile/edit') }}" class="edit-link">
                <i data-feather="edit-3" style="width: 14px;"></i> Edit Profile
            </a>
        </div>

        <div class="profile-details">
            <div class="info-label">Full Name</div>
            <div class="info-value" style="text-transform: capitalize;">{{ $customer->customer_name }}</div>

            <div class="info-label">Email Address</div>
            <div class="info-value">{{ $customer->customer_email }}</div>

            <div class="info-label">Primary Address</div>
            <div class="info-value">
                {{ $customer->customer_address ?? 'Address not set' }}<br>
                <span style="font-size: 13px; color: #be9b7b; font-weight: 600;">Indonesia</span>
            </div>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn">
                    <i data-feather="log-out" style="width: 18px;"></i> Logout Account
                </button>
            </form>
        </div>
    </div>

    <div class="order-history-section">
        <h3 class="history-title">
            <i data-feather="shopping-bag" style="color: #be9b7b;"></i> Order History
        </h3>
        
        @if($history->isEmpty())
            <div style="text-align: center; padding: 40px; background: #fdfaf5; border-radius: 15px; color: #be9b7b; border: 2px dashed #e7d8c9;">
                <i data-feather="coffee" style="width: 40px; height: 40px; margin-bottom: 15px; opacity: 0.5;"></i>
                <p style="font-weight: 500;">Belum ada pesanan. Yuk, pesan kopi pertamamu!</p>
                <a href="{{ route('home') }}" class="btn btn-sm btn-outline-brown" style="color: #854442; text-decoration: none; font-weight: 700; font-size: 13px;">ORDER NOW</a>
            </div>
        @else
            <table class="order-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($history as $item)
                    <tr>
                        <td>#{{ $item->sales_id }}</td>
                        <td>{{ $item->created_at->format('d M Y') }}</td>
                        <td>
                            <span class="status-badge status-{{ strtolower($item->sales_status) }}">
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

<script src="https://unpkg.com/feather-icons"></script>
<script>
    // Memastikan icon ter-render setelah DOM siap
    document.addEventListener("DOMContentLoaded", function() {
        feather.replace();
    });
</script>