<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - GBJ</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #e63946;
            --primary-hover: #d62828;
            --bg-color: #0f172a;
        }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, var(--bg-color) 0%, #1e293b 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #334155;
            margin: 0;
            overflow: hidden;
        }
        /* Abstract Background Elements */
        .bg-shape-1 {
            position: absolute;
            top: -100px;
            left: -100px;
            width: 400px;
            height: 400px;
            background: rgba(230, 57, 70, 0.15);
            border-radius: 50%;
            filter: blur(80px);
            z-index: 0;
        }
        .bg-shape-2 {
            position: absolute;
            bottom: -150px;
            right: -100px;
            width: 500px;
            height: 500px;
            background: rgba(56, 189, 248, 0.1);
            border-radius: 50%;
            filter: blur(100px);
            z-index: 0;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 20px;
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5);
            overflow: hidden;
            width: 100%;
            max-width: 420px;
            z-index: 10;
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 40px;
        }
        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .login-header h2 {
            font-weight: 800;
            margin: 0;
            font-size: 32px;
            color: var(--bg-color);
            letter-spacing: -0.5px;
        }
        .login-header h2 span {
            color: var(--primary-color);
        }
        .login-header p {
            color: #64748b;
            font-weight: 500;
            margin-top: 5px;
        }
        
        .form-control {
            border-radius: 10px;
            padding: 12px 15px;
            border: 1px solid #cbd5e1;
            font-size: 0.95rem;
            transition: all 0.3s;
        }
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(230, 57, 70, 0.15);
        }
        .form-label {
            font-weight: 700;
            color: #475569;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .btn-custom {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-hover) 100%);
            color: #fff;
            font-weight: 700;
            padding: 12px;
            border-radius: 10px;
            border: none;
            letter-spacing: 1px;
            transition: all 0.3s;
            box-shadow: 0 10px 20px -5px rgba(230, 57, 70, 0.4);
        }
        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 25px -5px rgba(230, 57, 70, 0.5);
            color: #fff;
        }
    </style>
</head>
<body>

<div class="bg-shape-1"></div>
<div class="bg-shape-2"></div>

<div class="login-card">
    <div class="login-header">
        <h2>GBJ<span>ADMIN</span></h2>
        <p>Masuk ke sistem kontrol pusat</p>
    </div>
    
    @if($errors->any())
        <div class="alert alert-danger p-3 rounded-3 small border-0 shadow-sm" style="background-color: #fef2f2; color: #b91c1c;">
            <div class="d-flex align-items-center mb-2 fw-bold">
                <i class="fas fa-exclamation-circle me-2"></i> Autentikasi Gagal
            </div>
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="post" action="{{ route('admin.login.post') }}">
        @csrf
        <div class="mb-4 position-relative">
            <label class="form-label">Email Address</label>
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0" style="border-radius: 10px 0 0 10px;"><i class="fas fa-envelope text-muted"></i></span>
                <input name="email" type="email" class="form-control border-start-0 ps-0" value="{{ old('email') }}" required autofocus placeholder="admin@example.com">
            </div>
        </div>
        <div class="mb-4 position-relative">
            <label class="form-label">Password</label>
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0" style="border-radius: 10px 0 0 10px;"><i class="fas fa-lock text-muted"></i></span>
                <input name="password" type="password" class="form-control border-start-0 ps-0" required placeholder="••••••••">
            </div>
        </div>
        <div class="d-grid mt-5">
            <button type="submit" class="btn btn-custom"><i class="fas fa-sign-in-alt me-2"></i> MASUK SEKARANG</button>
        </div>
    </form>
</div>

</body>
</html>
