<style>
    .edit-container {
        max-width: 600px; /* Lebih ramping untuk form */
        margin: 50px auto;
        padding: 40px;
        background-color: #fff;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        font-family: 'Poppins', sans-serif;
        color: #4b3832;
    }

    h1 { font-weight: 700; color: #3c2f2f; margin-bottom: 10px; }
    
    hr {
        border: 0; height: 2px; background: #be9b7b;
        margin-bottom: 30px; width: 50px; margin-left: 0;
    }

    .form-group { margin-bottom: 20px; }

    label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: #be9b7b;
        margin-bottom: 8px;
        text-transform: uppercase;
    }

    input[type="text"],
    input[type="email"],
    textarea,
    input[type="file"] {
        width: 100%;
        padding: 12px;
        border: 1.5px solid #e7d8c9;
        border-radius: 8px;
        font-family: inherit;
        transition: 0.3s;
    }

    input:focus, textarea:focus {
        outline: none;
        border-color: #854442;
        box-shadow: 0 0 0 3px rgba(133, 68, 66, 0.1);
    }

    .current-img-info {
        font-size: 12px;
        color: #999;
        margin-top: 5px;
        font-style: italic;
    }

    .btn-group {
        display: flex;
        gap: 15px;
        margin-top: 30px;
        align-items: center;
    }

    .save-btn {
        background: #3c2f2f;
        color: #fff;
        padding: 12px 25px;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: 0.3s;
    }

    .save-btn:hover { background: #854442; }

    .cancel-link {
        color: #999;
        text-decoration: none;
        font-size: 14px;
        transition: 0.3s;
    }

    .cancel-link:hover { color: #333; }
</style>

<div class="edit-container">
    <h1>Edit Account</h1>
    <hr>

    <form action="{{ url('profile/update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT') <div class="form-group">
            <label>Full Name</label>
            <input type="text" name="customer_name" value="{{ $customer->customer_name }}" required>
        </div>

        <div class="form-group">
            <label>Address</label>
            <textarea name="customer_address" rows="3">{{ $customer->customer_address }}</textarea>
        </div>

        <div class="form-group">
            <label>Profile Image</label>
            <input type="file" name="customer_img">
            <div class="current-img-info">
                Current: {{ $customer->customer_img ?? 'default_profile.png' }}
            </div>
        </div>

        <div class="btn-group">
            <button type="submit" class="save-btn">Save Changes</button>
            <a href="{{ url('account') }}" class="cancel-link">Cancel</a>
        </div>
    </form>
</div>