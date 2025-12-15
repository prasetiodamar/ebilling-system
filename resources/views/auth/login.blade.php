<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - E-Billing System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            overflow: hidden;
            max-width: 400px;
            width: 100%;
        }
        .login-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px 30px;
            text-align: center;
        }
        .login-body {
            padding: 40px 30px;
        }
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 12px;
            font-weight: 600;
            letter-spacing: 0.5px;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-card mx-auto">
            <div class="login-header">
                <i class="bi bi-receipt fs-1 mb-3 d-block"></i>
                <h2 class="mb-0">E-Billing System</h2>
                <p class="mb-0 mt-2 opacity-75">Silakan login untuk melanjutkan</p>
            </div>
            
            <div class="login-body">
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        {{ $errors->first() }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form method="POST" action="{{ route('login.post') }}">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            <i class="bi bi-person-fill text-primary me-2"></i>Username
                        </label>
                        <input type="text" name="username" class="form-control form-control-lg" 
                               placeholder="Masukkan username" value="{{ old('username') }}" required autofocus>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">
                            <i class="bi bi-lock-fill text-primary me-2"></i>Password
                        </label>
                        <input type="password" name="password" class="form-control form-control-lg" 
                               placeholder="Masukkan password" required>
                    </div>

                    <button type="submit" class="btn btn-primary btn-login w-100 btn-lg">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Masuk Sekarang
                    </button>
                </form>

                <div class="text-center mt-4">
                    <small class="text-muted">
                        Demo: <strong>superadmin</strong> / <strong>admin123</strong>
                    </small>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
