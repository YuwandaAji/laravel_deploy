<div class="edit-account" style="padding: 50px; max-width: 600px; font-family: sans-serif;">
    <h1>Edit Account Details</h1>
    <hr>

    <form action="{{ url('profile/edit/update') }}" method="POST" enctype="multipart/form-data" style="margin-top: 20px;">
        @csrf
        @method('PUT')

        <div style="margin-bottom: 15px;">
            <label>Full Name</label><br>
            <input type="text" name="customer_name" value="{{ $customer->customer_name }}" style="width: 100%; padding: 8px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label>Address</label><br>
            <textarea name="customer_address" style="width: 100%; padding: 8px;">{{ $customer->customer_address }}</textarea>
        </div>

        <div style="margin-bottom: 15px;">
            <label>Profile Image</label><br>
            <input type="file" name="customer_img">
            @if($customer->customer_img)
                <p>Current image: {{ $customer->customer_img }}</p>
            @endif
        </div>

        <button type="submit" style="background: #333; color: #fff; padding: 10px 25px; border: none; cursor: pointer;">
            Save Changes
        </button>
        <a href="{{ url('profile') }}" style="margin-left: 10px; color: #666; text-decoration: none;">Cancel</a>
    </form>
</div>