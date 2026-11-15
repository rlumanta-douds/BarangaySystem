<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Barangay Management System</title>
    <!-- Google Fonts & FontAwesome -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Inter', sans-serif; }
        body { 
            background: linear-gradient(135deg, #064e3b 0%, #022c22 100%); 
            color: #1e293b; 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            min-height: 100vh; 
        }
        .login-card { 
            background: white; 
            padding: 35px 40px; 
            border-radius: 16px; 
            width: 100%; 
            max-width: 440px; 
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.2); 
            border: 1px solid #dcfce7;
        }
        .role-switch { 
            display: flex; 
            background: #f0fdf4; 
            padding: 4px; 
            border-radius: 10px; 
            margin-bottom: 25px; 
            border: 1px solid #bbf7d0; 
        }
        .role-btn { 
            flex: 1; 
            background: transparent; 
            border: none; 
            padding: 10px; 
            font-size: 0.85rem; 
            font-weight: 600; 
            color: #047857; 
            border-radius: 8px; 
            cursor: pointer; 
            transition: all 0.2s; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            gap: 6px; 
        }
        .role-btn.active { 
            background: #059669; 
            color: white; 
            box-shadow: 0 2px 4px rgba(0,0,0,0.1); 
        }
        .login-brand { 
            text-align: center; 
            margin-bottom: 20px; 
        }
        .login-brand i { 
            font-size: 2.2rem; 
            color: #059669; 
            margin-bottom: 8px; 
        }
        .login-brand h2 { 
            font-size: 1.4rem; 
            font-weight: 700; 
            color: #064e3b; 
        }
        .login-brand p { 
            font-size: 0.8rem; 
            color: #64748b; 
            margin-top: 3px; 
        }
        .alert-error {
            background-color: #fee2e2;
            color: #b91c1c;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 0.82rem;
            margin-bottom: 20px;
            border: 1px solid #fca5a5;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .form-group { margin-bottom: 18px; }
        .form-group label { 
            display: block; 
            font-size: 0.82rem; 
            font-weight: 600; 
            margin-bottom: 5px; 
            color: #334155; 
        }
        .input-with-icon { position: relative; }
        .input-with-icon i { 
            position: absolute; 
            left: 14px; 
            top: 50%; 
            transform: translateY(-50%); 
            color: #94a3b8; 
            font-size: 0.9rem; 
        }
        .form-group input { 
            width: 100%; 
            padding: 11px 14px 11px 40px; 
            border-radius: 8px; 
            border: 1px solid #cbd5e1; 
            outline: none; 
            font-size: 0.9rem; 
            transition: all 0.2s; 
        }
        .form-group input:focus { 
            border-color: #34d399; 
            box-shadow: 0 0 0 3px rgba(52, 211, 153, 0.25); 
        }
        .btn-login { 
            width: 100%; 
            background-color: #059669; 
            color: white; 
            border: none; 
            padding: 11px; 
            border-radius: 8px; 
            font-weight: 600; 
            font-size: 0.95rem; 
            cursor: pointer; 
            transition: background 0.2s; 
            margin-top: 8px; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            gap: 8px; 
        }
        .btn-login:hover { background-color: #047857; }
        .signup-prompt {
            text-align: center;
            margin-top: 15px;
            font-size: 0.85rem;
            color: #64748b;
        }
        .signup-prompt a {
            color: #059669;
            font-weight: 600;
            text-decoration: none;
        }
        .signup-prompt a:hover { text-decoration: underline; }
        .login-footer { 
            text-align: center; 
            margin-top: 20px; 
            font-size: 0.78rem; 
            color: #94a3b8; 
        }
    </style>
</head>
<body>

    <div class="login-card">
        <!-- Role Switcher Buttons -->
        <div class="role-switch">
            <button type="button" class="role-btn active" id="adminTab" onclick="switchRole('admin')">
                <i class="fa-solid fa-user-shield"></i> Admin Portal
            </button>
            <button type="button" class="role-btn" id="userTab" onclick="switchRole('resident')">
                <i class="fa-solid fa-users"></i> Resident Portal
            </button>
        </div>

        <div class="login-brand">
            <i class="fa-solid fa-building-shield" id="brandIcon"></i>
            <h2 id="brandTitle">Barangay System</h2>
            <p id="brandSubtitle">Sign in to your administrator account</p>
        </div>

        <!-- Validation / Authentication Error Feedbacks -->
        @if ($errors->any())
            <div class="alert-error">
                <i class="fa-solid fa-circle-exclamation"></i>
                <div>
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            </div>
        @endif

        <form action="{{ url('/login') }}" method="POST">
            @csrf
            
            <!-- Hidden input to track intended portal role -->
            <input type="hidden" name="intended_role" id="intendedRole" value="admin">

            <div class="form-group">
                <label id="emailLabel">Email Address</label>
                <div class="input-with-icon">
                    <i class="fa-solid fa-envelope"></i>
                    <input type="email" name="email" id="emailInput" placeholder="admin@barangay.gov.ph" required autofocus>
                </div>
            </div>

            <div class="form-group">
                <label>Password</label>
                <div class="input-with-icon">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" name="password" placeholder="••••••••" required>
                </div>
            </div>

            <button type="submit" class="btn-login" id="submitBtn">
                <span>Log In as Administrator</span> <i class="fa-solid fa-arrow-right-to-bracket"></i>
            </button>
        </form>

        <div class="signup-prompt">
            Don't have a resident account? <a href="{{ route('register') }}">Sign Up Here</a>
        </div>

        <div class="login-footer">
            &copy; 2026 Barangay Management System. All rights reserved.
        </div>
    </div>

    <script>
        function switchRole(role) {
            const adminTab = document.getElementById('adminTab');
            const userTab = document.getElementById('userTab');
            const brandTitle = document.getElementById('brandTitle');
            const brandSubtitle = document.getElementById('brandSubtitle');
            const emailLabel = document.getElementById('emailLabel');
            const emailInput = document.getElementById('emailInput');
            const submitBtn = document.getElementById('submitBtn');
            const intendedRole = document.getElementById('intendedRole');

            intendedRole.value = role; // Updates hidden input value automatically

            if (role === 'admin') {
                adminTab.classList.add('active');
                userTab.classList.remove('active');
                brandTitle.innerText = "Barangay System";
                brandSubtitle.innerText = "Sign in to your administrator account";
                emailLabel.innerText = "Email Address";
                emailInput.placeholder = "admin@barangay.gov.ph";
                emailInput.value = ""; // Clear out text if needed
                submitBtn.innerHTML = '<span>Log In as Administrator</span> <i class="fa-solid fa-arrow-right-to-bracket"></i>';
            } else {
                userTab.classList.add('active');
                adminTab.classList.remove('active');
                brandTitle.innerText = "Resident Portal";
                brandSubtitle.innerText = "Sign in to view your requests & profile";
                emailLabel.innerText = "Resident Email Address";
                emailInput.placeholder = "resident@barangay.com"; 
                emailInput.value = ""; // Clear out text so they type the correct one
                submitBtn.innerHTML = '<span>Log In as Resident</span> <i class="fa-solid fa-arrow-right-to-bracket"></i>';
            }
        }
    </script>
</body>
</html>