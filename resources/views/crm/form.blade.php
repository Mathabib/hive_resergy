<style>
    body {
        background: linear-gradient(135deg, #ff4b5c, #ff6b81);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 15px;
        margin: 0;
    }

    .crm-card {
        background: #fff;
        border-radius: 14px;
        padding: 32px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
        width: 100%;
        max-width: 500px;
        animation: fadeInUp 0.6s ease;
    }

    .crm-card h4 {
        text-align: center;
        font-weight: 700;
        font-size: 1.4rem;
        margin-bottom: 6px;
        color: #ff4b5c;
    }

    .crm-card p {
        text-align: center;
        color: #6c757d;
        font-size: 0.92rem;
        margin-bottom: 25px;
    }

    .form-group {
        margin-bottom: 18px;
    }

    label {
        font-weight: 600;
        font-size: 0.9rem;
        margin-bottom: 6px;
        display: block;
        color: #333;
    }

    .form-control, .form-select {
        width: 100%;
        border-radius: 8px;
        padding: 10px 14px;
        border: 1px solid #ced4da;
        transition: all 0.25s ease;
        font-size: 0.92rem;
        box-sizing: border-box;
    }

    .form-control:focus, .form-select:focus {
        border-color: #ff4b5c;
        box-shadow: 0 0 0 0.2rem rgba(255, 75, 92, 0.2);
        outline: none;
    }

    textarea {
        resize: none;
    }

    .btn-primary {
        background-color: #ff4b5c;
        border: none;
        padding: 10px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.95rem;
        transition: background-color 0.3s ease;
        color: #fff;
        cursor: pointer;
        width: 100%;
    }

    .btn-primary:hover {
        background-color: #e84351;
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="crm-card">
    <h4>Create CRM</h4>
    <p>Please fill in the details below</p>

    <form action="{{ route('crm.sumbitForm') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="name">Full Name</label>
            <input type="text" name="name" id="name" class="form-control"
                   placeholder="Enter full name" value="{{ old('name') }}" required>
        </div>

        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" name="email" id="email" class="form-control"
                   placeholder="Enter email" value="{{ old('email') }}" required>
        </div>

        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="text" name="phone" id="phone" class="form-control"
                   placeholder="Enter phone number" value="{{ old('phone') }}">
        </div>

        <div class="form-group">
            <label for="company">Company Name</label>
            <input type="text" name="company" id="company" class="form-control"
                   placeholder="Enter company name" value="{{ old('company') }}" required>
        </div>

        <div class="form-group">
            <label for="category">Category</label>
            <select name="category" id="category" class="form-select" required>
                <option value="">-- Select Category --</option>
                <option value="Clients" {{ old('category') == 'Clients' ? 'selected' : '' }}>Clients</option>
                <option value="Vendor" {{ old('category') == 'Vendor' ? 'selected' : '' }}>Vendor</option>
                <option value="Others" {{ old('category') == 'Others' ? 'selected' : '' }}>Others</option>
            </select>
        </div>

        <div class="form-group">
            <label for="website">Website</label>
            <input type="url" name="website" id="website" class="form-control"
                   placeholder="Enter website URL" value="{{ old('website') }}">
        </div>

        <div class="form-group">
            <label for="address">Address</label>
            <input type="text" name="address" id="address" class="form-control"
                   placeholder="Enter address" value="{{ old('address') }}" required>
        </div>

        <div class="form-group">
            <label for="notes">Notes</label>
            <textarea name="notes" id="notes" class="form-control" rows="3"
                      placeholder="Additional notes">{{ old('notes') }}</textarea>
        </div>

        <button type="submit" class="btn-primary">
            <i class="bi bi-check-lg me-1"></i> Save
        </button>
    </form>
</div>


@push('scripts')
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>
document.getElementById('crmForm').addEventListener('submit', function(e) {
    e.preventDefault(); // cegah submit biasa

    let form = this;
    let formData = new FormData(form);

    fetch(form.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest' // penting untuk Laravel deteksi AJAX
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: data.message,
                confirmButtonColor: '#ff4b5c',
                timer: 2500,
                showConfirmButton: false
            });
            form.reset();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Something went wrong!'
        });
    });
});
</script>
@endpush
