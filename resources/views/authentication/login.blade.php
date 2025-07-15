<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login</title>

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

/* HAPUS blur jika ada overlay */
.overlay {
  background-color: rgba(0, 0, 0, 0.5); /* hanya gelapkan, tanpa blur */
  width: 100%;
  height: 100%;
  position: absolute;
  z-index: 0;
}

/* HAPUS backdrop-filter di form-box */
.form-box {
  background-color: rgba(255, 255, 255, 0.74); /* transparan */
  /* backdrop-filter: blur(15px); */ /* HAPUS ini! */
  padding: 3rem;
  border-radius: 20px;
  width: 100%;
  max-width: 450px;
  color: white;
  box-shadow: 0 0 30px rgba(0, 0, 0, 0.5);
  text-align: center;
}


    .login-wrapper {
      position: relative;
      z-index: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100%;
    }

    /* .form-box {
      background-color: rgba(255, 255, 255, 0.66);
      backdrop-filter: blur(15px);
      padding: 3rem;
      border-radius: 20px;
      width: 100%;
      max-width: 450px;
      color: white;
      box-shadow: 0 0 30px rgba(0,0,0,0.5);
      text-align: center;
    } */
/* 
    .form-box h2 {
      font-weight: bold;
      margin-bottom: 1.5rem;
      color: #fff;
    } */

    .form-box img.logo {
      width: 250px;
      margin-bottom: 1.5rem;
    }

    .input-group .form-control {
      border-radius: 10px 0 0 10px;
      background-color: rgba(255, 255, 255, 0.1);
      color: #fff;
      border: none;
    }

    .input-group-text {
      background-color: rgba(255, 255, 255, 0.1);
      color: #fff;
      border: none;
      border-radius: 0 10px 10px 0;
    }

    .form-floating > label {
      color: #800000;
    }

    .form-check-label {
      color: #800000;
    }

    .form-control::placeholder {
      color: #ddd;
    }

    .form-control:focus {
      background-color: rgba(255, 255, 255, 0.2);
      color: white;
      outline: none;
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

    a {
      color: #800000;
      text-decoration: underline;
    }

    a:hover {
      color: #f5c6cb;
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
    <form method="POST" action="{{ route('login') }}" class="form-box">
      @csrf

      <!-- Logo -->
      <img src="{{ asset('assets/image/logo-isol.png') }}" alt="Isol Logo" class="logo">

      <!-- <h2>Login</h2> -->

      <!-- Email -->
      <div class="mb-3">
        <div class="input-group">
          <div class="form-floating flex-grow-1">
            <input id="loginEmail" name="email" type="email" class="form-control" placeholder="Email" required />
            <label for="loginEmail">Email</label>
          </div>
          <span class="input-group-text"><i class="bi bi-envelope"></i></span>
        </div>
      </div>

      <!-- Password -->
      <div class="mb-3">
        <div class="input-group">
          <div class="form-floating flex-grow-1">
            <input id="loginPassword" name="password" type="password" class="form-control" placeholder="Password" required />
            <label for="loginPassword">Password</label>
          </div>
          <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
        </div>
      </div>

      <!-- Remember + Submit -->
      <div class="row mb-3">
        <div class="col-7 d-flex align-items-center">
          <div class="form-check text-start">
            <input class="form-check-input" type="checkbox" id="remember" name="remember" />
            <label class="form-check-label" for="remember"> Remember Me </label>
          </div>
        </div>
        <div class="col-5 text-end">
          <button type="submit" class="btn btn-primary w-100">Sign In</button>
        </div>
      </div>

      <!-- Forgot Password -->
      <p class="text-center mb-0">
        <a href="{{ route('password.request') }}">I forgot my password</a>
      </p>
    </form>
  </div>
</body>
</html>
