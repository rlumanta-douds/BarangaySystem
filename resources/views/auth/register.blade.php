<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resident Sign Up - Barangay System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Inter', sans-serif; }
        body { background-color: #064e3b; display: flex; justify-content: center; align-items: center; height: 100vh; }
        
        .card { background: white; width: 100%; max-width: 440px; padding: 35px; border-radius: 16px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); }
        .brand { text-align: center; margin-bottom: 25px; }
        .brand h2 { font-size: 1.5rem; font-weight: 700; color: #1e293b; margin-top: 8px; }
        .brand p { color: #64748b; font-size: 0.85rem; }

        .form-group { margin-bottom: 16px; }
        .form-group label { display: block; font-size: 0.85rem; font-weight: 600; color: #475569; margin-bottom: 6px; }
        .input-with-icon { position: relative; }
        .input-with-icon i { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #94a3b8; }
        .input-with-icon input { width: 100%; padding: 12px 12px 12px 40px; border-radius: 8px; border: 1px solid #cbd5e1; outline: none; font-size: 0.9rem; }
        .input-with-icon input:focus { border-color: #16a34a; box-shadow: 0 0 0 3px rgba(22, 163, 74, 0.15); }

        .btn-submit { width: 100%; background-color: #16a34a; color: white; border: none; padding: 12px; border-radius: 8px; font-weight: 600; font-size: 0.95rem; cursor: pointer; transition: background 0.2s; margin-top: 10px; }
        .btn-submit:hover { background-color: #15803d; }

        .footer-link { text-align: center; margin-top: 20px; font-size: 0.85rem; color: #64748b; }
        .footer-link a { color: #16a34a; text-decoration: none; font-weight: 600; }
        .footer-link a:hover { text-decoration: underline; }

        .alert-error { background-color: #fee2e2; color: #dc2626; padding: 10px; border-radius: 8px; font-size: 0.85rem; margin-bottom: 15px; }
    </style>
</head>
<body>

    <div class="card">
        <div class="brand">
            <i class="fa-solid fa-building-shield" style="font-size: 2rem; color: #16a34a;"></i>
            <h2>Resident Sign Up</h2>
            <p>Create your account to access the Resident Portal</p>
        </div>

        @if ($errors->any())
            <div class="alert-error">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="{{ route('register.submit') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Full Name</label>
                <div class="input-with-icon">
                    <i class="fa-solid fa-user"></i>
                    <input type="text" name="name" placeholder="Enter your full name" value="{{ old('name') }}" required>
                </div>
            </div>

            <div class="form-group">
                <label>Email Address</label>
                <div class="input-with-icon">
                    <i class="fa-solid fa-envelope"></i>
                    <input type="email" name="email" placeholder="name@example.com" value="{{ old('email') }}" required>
                </div>
            </div>

            <div class="form-group">
                <label>Password</label>
                <div class="input-with-icon">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" name="password" placeholder="At least 6 characters" required>
                </div>
            </div>

            <div class="form-group">
                <label>Confirm Password</label>
                <div class="input-with-icon">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" name="password_confirmation" placeholder="Re-enter your password" required>
                </div>
            </div>

            <button type="submit" class="btn-submit">Create Resident Account</button>
        </form>

        <div class="footer-link">
            Already have an account? <a href="{{ route('login') }}">Log In</a>
        </div>
    </div>

</body>
</html>