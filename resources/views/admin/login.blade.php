<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="hold-transition login-page dark-mode">
<div class="login-box">
    <div class="login-logo">
        <a href="#">
            <i class="fas fa-briefcase"></i>
            <b>Portfolio</b> Admin
        </a>
    </div>
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <i class="fas fa-sign-in-alt"></i>
            <span class="h4 ml-2">Sign In</span>
        </div>
        <div class="card-body">
            <p class="login-box-msg">
                <i class="fas fa-lock-open"></i>
                Login to manage your portfolio content
            </p>
            <div class="alert alert-info">
                <strong><i class="fas fa-user-circle"></i> Email:</strong> admin@demo.com<br>
                <strong><i class="fas fa-key"></i> Password:</strong> 123456
            </div>

            <form action="{{ route('admin.login.submit') }}" method="post">
                @csrf
                <div class="input-group mb-3">
                    <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" required>
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fas fa-envelope"></span></div>
                    </div>
                </div>
                @error('email') <small class="text-danger d-block mb-2">{{ $message }}</small> @enderror

                <div class="input-group mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fas fa-lock"></span></div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fas fa-login"></i> Sign In
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>
</html>
