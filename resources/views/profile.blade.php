<div class="account-container" style="padding: 50px; font-family: sans-serif;">
    <h1>Account Details</h1>
    <hr>

    <div style="display: flex; justify-content: space-between; margin-top: 30px;">
        <div class="profile-info">
    <div class="profile-image" style="margin-bottom: 20px;">
        @if($customer->customer_img)
            <img src="{{ asset('storage/'. $customer->customer_img) }}" 
                 style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; border: 1px solid #ddd;">
        @else
            <div style="width: 100px; height: 100px; border-radius: 50%; background: #eee; display: flex; align-items: center; justify-content: center; border: 1px solid #ddd;">
                <span style="font-size: 12px; color: #999;">No Photo</span>
            </div>
        @endif
        <br>
        <a href="{{ url('profile/edit') }}" style="font-size: 12px; color: #555; text-decoration: underline;">Edit Profile</a>
    </div>
    <h3 style="text-transform: lowercase; margin-top: 0;">{{ $customer->customer_name }}</h3>
    <p>{{ $customer->customer_email }}</p>
    
    <p style="margin-top: 20px;"><strong>Primary Address</strong></p>
    <p>{{ $customer->customer_address }}</p>
    <p>Indonesia</p>
    
    <form action="{{ url('logout') }}" method="POST" style="margin-top: 20px;">
        @csrf
        <button type="submit" style="background: #333; color: #fff; padding: 10px 25px; border: none; cursor: pointer;">
            Logout
        </button>
    </form>
</div>

        {{-- <div class="order-history" style="flex: 1; margin-left: 100px;">
            <h3>Order History</h3>
            @if($history->isEmpty())
                <p>You haven't placed any orders yet.</p>
            @else
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="border-bottom: 1px solid #ddd;">
                            <th style="text-align: left; padding: 10px;">Order ID</th>
                            <th style="text-align: left; padding: 10px;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($history as $item)
                        <tr style="border-bottom: 1px solid #eee;">
                            <td style="padding: 10px;">#{{ $item->sales_id }}</td>
                            <td style="padding: 10px;">{{ $item->sales_status }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div> --}}
    </div>
</div>