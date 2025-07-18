<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Reset Password</title>

  <!-- Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />

  <style>
    body, html {
      height: 100%;
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background: url("{{ asset('assets/image/1.png') }}") no-repeat center center fixed;
      background-size: cover;
    }

    .overlay {
      background-color: rgba(0, 0, 0, 0.5);
      width: 100%;
      height: 100%;
      position: absolute;
      z-index: 0;
    }

    .form-box {
      background-color: rgba(255, 255, 255, 0.74);
      padding: 3rem;
      border-radius: 20px;
      width: 100%;
      max-width: 450px;
      color: white;
      box-shadow: 0 0 30px rgba(0, 0, 0, 0.5);
      text-align: center;
      z-index: 1;
    }

    .form-box img.logo {
      width: 250px;
      margin-bottom: 1.5rem;
    }

    .form-control {
      background-color: rgba(255, 255, 255, 0.1);
      color: #fff;
      border: none;
      border-radius: 10px;
    }

    .form-control:focus {
      background-color: rgba(255, 255, 255, 0.2);
      color: white;
      box-shadow: none;
    }

    .btn-primary {
      background-color: #fff;
      color: #b30000;
      font-weight: bold;
      border: none;
      border-radius: 10px;
    }

    .btn-primary:hover {
      background-color: #f1f1f1;
      color: #a00000;
    }

    .form-label, .form-text, .text-muted {
      color: #800000 !important;
    }

    a {
      color: #800000;
      text-decoration: underline;
    }

    a:hover {
      color: #f5c6cb;
    }

    .login-wrapper {
      position: relative;
      z-index: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100%;
    }

    @media (max-width: 768px) {
      .form-box {
        padding: 2rem;
      }
    }
  </style>
</head>
<body>
  <div class="overlay"></div>

  <div class="login-wrapper">
    <form method="POST" action="{{ route('password.store') }}" class="form-box">
      @csrf
      <input type="hidden" name="token" value="{{ request()->route('token') }}">

      <!-- Logo -->
      <img src="{{ asset('assets/image/logo-isol.png') }}" alt="Isol Logo" class="logo">

      <!-- Info Text -->
      <p class="mb-4 text-sm text-light">
        Reset your password below and get back to your account.
      </p>

      <!-- Email -->
      <div class="mb-3 text-start">
        <label for="email" class="form-label">Email address</label>
        <input
          type="email"
          id="email"
          name="email"
          class="form-control"
          required
          value="{{ old('email', request()->email) }}"
          placeholder="Enter your email"
        />
        @error('email')
          <small class="text-danger">{{ $message }}</small>
        @enderror
      </div>

      <!-- New Password -->
      <div class="mb-3 text-start">
        <label for="password" class="form-label">New Password</label>
        <input
          type="password"
          id="password"
          name="password"
          class="form-control"
          required
          placeholder="New password"
        />
        @error('password')
          <small class="text-danger">{{ $message }}</small>
        @enderror
      </div>

      <!-- Confirm Password -->
      <div class="mb-3 text-start">
        <label for="password_confirmation" class="form-label">Confirm New Password</label>
        <input
          type="password"
          id="password_confirmation"
          name="password_confirmation"
          class="form-control"
          required
          placeholder="Confirm new password"
        />
        @error('password_confirmation')
          <small class="text-danger">{{ $message }}</small>
        @enderror
      </div>

      <!-- Submit Button -->
      <div class="d-grid mt-4">
        <button type="submit" class="btn btn-primary">
          Reset Password
        </button>
      </div>

      <!-- Back to login -->
      <p class="mt-3 mb-0 text-center">
        <a href="{{ route('login') }}">Back to login</a>
      </p>
    </form>
  </div>
</body>
</html>
