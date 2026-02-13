<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

    body { background-color: #f8f9fa; }

    .edit-container {
        max-width: 600px;
        margin: 50px auto;
        padding: 40px;
        background-color: #fff;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        font-family: 'Poppins', sans-serif;
        color: #4b3832;
    }

    .back-nav {
        max-width: 600px;
        margin: 20px auto 0;
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

    .back-link:hover { transform: translateX(-5px); color: #3c2f2f; }

    h1 { font-weight: 700; color: #3c2f2f; margin-bottom: 10px; }
    .title-line { border: 0; height: 3px; background: #be9b7b; margin-bottom: 30px; width: 50px; }

    .form-group { margin-bottom: 25px; }

    label {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 12px;
        font-weight: 700;
        color: #be9b7b;
        margin-bottom: 10px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    input[type="text"], textarea, input[type="file"] {
        width: 100%;
        padding: 12px 15px;
        border: 1.5px solid #e7d8c9;
        border-radius: 10px;
        font-family: inherit;
        font-size: 15px;
        transition: 0.3s;
        background-color: #fdfaf5;
    }

    input:focus, textarea:focus {
        outline: none;
        border-color: #854442;
        background-color: #fff;
        box-shadow: 0 0 0 4px rgba(133, 68, 66, 0.1);
    }

    .current-img-preview {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-top: 10px;
        padding: 10px;
        background: #f8f9fa;
        border-radius: 8px;
        font-size: 13px;
        color: #999;
    }

    .current-img-preview img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
    }

    .btn-group {
        display: flex;
        gap: 20px;
        margin-top: 40px;
        align-items: center;
    }

    .save-btn {
        background: #3c2f2f;
        color: #fff;
        padding: 12px 30px;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        transition: 0.3s;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .save-btn:hover {
        background: #854442;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(133, 68, 66, 0.3);
    }

    .cancel-link {
        color: #999;
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        transition: 0.3s;
    }

    .cancel-link:hover { color: #333; }
</style>

<div class="back-nav">
    <a href="{{ url('profile') }}" class="back-link">
        <i data-feather="arrow-left"></i> Back to Profile
    </a>
</div>

<div class="edit-container">
    <h1>Edit Account</h1>
    <div class="title-line"></div>

    <form action="{{ url('profile/edit/update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label><i data-feather="user" style="width: 14px;"></i> Full Name</label>
            <input type="text" name="customer_name" value="{{ $customer->customer_name }}" placeholder="Enter your full name" required>
        </div>

        <div class="form-group">
            <label><i data-feather="map-pin" style="width: 14px;"></i> Address</label>
            <textarea name="customer_address" rows="3" placeholder="Enter your delivery address">{{ $customer->customer_address }}</textarea>
        </div>

        <div class="form-group">
            <label><i data-feather="image" style="width: 14px;"></i> Profile Image</label>
            <input type="file" name="customer_img">
            <div class="current-img-preview">
                @if($customer->customer_img)
                    <img src="{{ asset('storage/'. $customer->customer_img) }}" alt="Current">
                @endif
                <span>Current: {{ basename($customer->customer_img ?? 'default_profile.png') }}</span>
            </div>
        </div>

        <div class="btn-group">
            <button type="submit" class="save-btn">
                <i data-feather="check-circle" style="width: 18px;"></i> Save Changes
            </button>
            <a href="{{ url('profile') }}" class="cancel-link">Cancel</a>
        </div>
    </form>
</div>

<script src="https://unpkg.com/feather-icons"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        feather.replace();
    });
</script>